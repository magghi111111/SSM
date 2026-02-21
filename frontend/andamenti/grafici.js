document.addEventListener('DOMContentLoaded', () => {
  caricaGrafico('ordini', 'graficoOrdini', 'Ordini');
  caricaGrafico('consegne', 'graficoConsegne', 'Consegne');
  caricaGrafico('tempo_assemblaggio', 'graficoPrepTime', 'Tempo medio assemblaggio (min)');
});

const mesi = [
  'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
  'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'
];

function formattaMese(yyyyMm) {
  const [, mese] = yyyyMm.split('-');
  return mesi[parseInt(mese, 10) - 1];
}

function caricaGrafico(tipo, canvasId, label) {
  fetch(`backend/api/api_grafici.php?tipo=${tipo}`)
    .then(r => {
      if (!r.ok) throw new Error(`Errore API ${tipo}`);
      return r.json();
    })
    .then(dati => generaGrafico(canvasId, label, dati))
    .catch(err => console.error(err));
}

function generaGrafico(canvasId, label, dati) {
  const canvas = document.getElementById(canvasId);
  if (!canvas) {
    console.error(`Canvas ${canvasId} non trovato`);
    return;
  }

  const labels = dati.map(d => formattaMese(d.mese));
  const values = dati.map(d => parseInt(d.totale, 10));

  new Chart(canvas.getContext('2d'), {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label,
        data: values,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            precision: 0
          }
        }
      }
    }
  });
}