from fastapi import FastAPI, HTTPException, Query
from fastapi.middleware.cors import CORSMiddleware
from contextlib import contextmanager
from cachetools import TTLCache
import pandas as pd
from prophet import Prophet
import pymysql
import logging
import warnings
import json
import os

# --- SETUP ---
warnings.filterwarnings('ignore')

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# --- CARICA config.json ---
config_path = os.path.join(os.path.dirname(__file__), 'config.json')

with open(config_path, 'r') as f:
    config = json.load(f)

DB_CONFIG = {
    'host':     config['db_host'],
    'user':     config['db_user'],
    'password': config['db_password'],
    'database': config['db_name'],
}

ALLOWED_ORIGINS = config.get('allowed_origins', ['*'])

# --- FASTAPI ---
app = FastAPI(title="API Previsione Vendite Magazzino", version="2.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=ALLOWED_ORIGINS,
    allow_credentials=True,
    allow_methods=["GET"],
    allow_headers=["*"],
)

# --- CACHE: max 100 previsioni, valide 1 ora ---
_cache = TTLCache(maxsize=100, ttl=3600)


@contextmanager
def get_db_connection():
    """Connessione al DB con chiusura garantita anche in caso di errore."""
    con = None
    try:
        con = pymysql.connect(**DB_CONFIG)
        yield con
    except pymysql.Error as e:
        logger.error(f"Errore connessione DB: {e}")
        raise HTTPException(status_code=503, detail="Database non raggiungibile.")
    finally:
        if con:
            con.close()


def ottieni_dati_storici(id_componente: int) -> pd.DataFrame:
    """Estrae lo storico vendite dal database MariaDB."""
    query = """
        SELECT DATE(o.data_creazione) AS ds, SUM(ro.quantita) AS y
        FROM ordini o
        JOIN righe_ordini ro ON o.id = ro.id_ordine
        WHERE ro.id_componente = %s
        GROUP BY DATE(o.data_creazione)
        ORDER BY ds ASC
    """
    with get_db_connection() as con:
        df = pd.read_sql(query, con, params=(id_componente,))

    if df.empty:
        raise HTTPException(
            status_code=404,
            detail=f"Nessun dato trovato per il componente {id_componente}."
        )
    return df


@app.get("/previsione/{id_componente}")
def calcola_previsione(
    id_componente: int,
    giorni: int = Query(default=30, ge=1, le=365, description="Giorni da prevedere (1-365)")
):
    """Calcola la previsione delle vendite per i prossimi X giorni."""

    cache_key = f"{id_componente}_{giorni}"
    if cache_key in _cache:
        logger.info(f"Cache HIT — componente {id_componente}, {giorni} giorni")
        return _cache[cache_key]

    logger.info(f"Calcolo previsione — componente {id_componente}, {giorni} giorni")

    df = ottieni_dati_storici(id_componente)

    if len(df) < 2:
        raise HTTPException(
            status_code=400,
            detail="Dati storici insufficienti (servono almeno 2 giorni di vendite)."
        )

    # Addestramento modello
    m = Prophet(
        daily_seasonality=False,
        yearly_seasonality='auto',
        weekly_seasonality=True
    )
    m.add_country_holidays(country_name='IT')
    m.fit(df)

    # Previsione
    future   = m.make_future_dataframe(periods=giorni)
    forecast = m.predict(future)

    previsioni_future = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(giorni)

    risultato = []
    for _, row in previsioni_future.iterrows():
        risultato.append({
            "data":               row['ds'].strftime('%Y-%m-%d'),
            "quantita_prevista":  round(max(0, row['yhat'])),
            "forchetta_minima":   round(max(0, row['yhat_lower'])),
            "forchetta_massima":  round(max(0, row['yhat_upper']))
        })

    risposta = {
        "id_componente":  id_componente,
        "giorni_previsti": giorni,
        "dati":           risultato
    }

    _cache[cache_key] = risposta
    return risposta


@app.get("/health")
def health_check():
    """Verifica che il server sia attivo."""
    return {"status": "ok"}