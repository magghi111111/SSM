
(function () {
    const API_BASE = 'http://127.0.0.1:8000';
    let graficoInstance = null;

    const form = document.getElementById('form-previsione');
    const btnCalcola = document.getElementById('btn-calcola-previsione');
    const container = document.getElementById('risultati-previsione');
    const contenitoreGrafico = document.getElementById('contenitore-grafico');
    const contenitoreTabella = document.getElementById('contenitore-tabella');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        avviaPrevisione();
    });

    async function avviaPrevisione() {
        const selectEl = document.getElementById('inp-id-comp');
        const giorniEl = document.getElementById('inp-giorni');

        const idComponente = parseInt(selectEl.value, 10);
        const giorni = parseInt(giorniEl.value, 10);

        if (!idComponente || idComponente < 1) {
            mostraErrore('Seleziona un componente valido.');
            return;
        }
        if (!giorni || giorni < 1 || giorni > 365) {
            mostraErrore('I giorni devono essere tra 1 e 365.');
            return;
        }

        if (btnCalcola) {
            btnCalcola.disabled = true;
        }
        if (container) {
            container.innerHTML = '<p class="info">Elaborazione in corso... l\'AI sta analizzando lo storico vendite...</p>';
        }
        contenitoreGrafico.style.display = 'none';
        if (contenitoreTabella) {
            contenitoreTabella.innerHTML = '';
        }

        try {
            const response = await fetch(`${API_BASE}/previsione/${idComponente}?giorni=${giorni}`);

            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.detail || `Errore server (HTTP ${response.status})`);
            }

            const previsioni = await response.json();
            renderRisultati(previsioni);

        } catch (error) {
            mostraErrore(
                error.message,
                'Assicurati che il server Python sia attivo sulla porta 8000.'
            );
        } finally {
            if (btnCalcola) {
                btnCalcola.disabled = false;
            }
        }
    }

    function renderRisultati(previsioni) {
        const dati = previsioni.dati;
        const selectEl = document.getElementById('inp-id-comp');
        const nomeComp = selectEl.options[selectEl.selectedIndex].text;

        if (container) {
            container.innerHTML = `<strong>${nomeComp} — prossimi ${previsioni.giorni_previsti} giorni</strong>`;
        }

        // Prima renderizza il grafico con tutti i dati
        renderGrafico(dati);

        // Poi trova i picchi e renderizza la tabella sotto
        const picchi = trovaPicchi(dati);
        if (contenitoreTabella) {
            renderTabellaPicchi(picchi, nomeComp);
        }
    }

    /*
     * trovaPicchi — rileva i massimi locali nell'array dei dati.
     *
     * Un giorno è un picco se la sua quantita_prevista è STRETTAMENTE
     * maggiore di quella del giorno precedente E di quella del giorno
     * successivo (massimo locale). Il primo e l'ultimo giorno vengono
     * confrontati solo con il vicino disponibile.
     *
     * In più, per evitare picchi insignificanti dovuti a oscillazioni
     * minime, viene applicata una soglia minima: un picco viene
     * incluso solo se supera la media generale di almeno il 10%.
     */
    function trovaPicchi(dati) {
        if (dati.length === 0) return [];

        // Calcola media per la soglia minima
        const media = dati.reduce((acc, g) => acc + g.quantita_prevista, 0) / dati.length;
        const soglia = media * 1.10; // almeno 10% sopra la media

        const picchi = [];

        for (let i = 0; i < dati.length; i++) {
            const corrente = dati[i].quantita_prevista;
            const precedente = i > 0 ? dati[i - 1].quantita_prevista : -Infinity;
            const successivo = i < dati.length - 1 ? dati[i + 1].quantita_prevista : -Infinity;

            const èMassimoLocale = corrente > precedente && corrente > successivo;
            const superaSoglia = corrente >= soglia;

            if (èMassimoLocale && superaSoglia) {
                picchi.push(dati[i]);
            }
        }

        // Ordina per quantità decrescente così i picchi più alti sono in cima
        return picchi.sort((a, b) => b.quantita_prevista - a.quantita_prevista);
    }

    function renderTabellaPicchi(picchi, nomeComp) {
        if (picchi.length === 0) {
            contenitoreTabella.innerHTML = `
                <p class="info" style="margin-top:20px;">
                    Nessun picco rilevante rilevato nel periodo selezionato.
                </p>`;
            return;
        }

        let html = `
            <div style="margin-top: 24px;">
                <strong style="color: var(--highlight-color); font-size: 14px;">
                    Picchi di domanda rilevati — ${nomeComp}
                </strong>
                <p style="font-size: 12px; color: var(--text-muted); margin: 4px 0 12px;">
                    Giorni con domanda significativamente superiore alla media del periodo
                </p>
                <table id="tabella-previsione">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Quantità prevista</th>
                            <th>Min</th>
                            <th>Max</th>
                        </tr>
                    </thead>
                    <tbody>`;

        picchi.forEach((g, index) => {
            const [anno, mese, giorno] = g.data.split('-');
            const dataIt = `${giorno}/${mese}/${anno}`;
            html += `
                <tr>
                    <td style="color: var(--text-muted); font-size: 12px;">${index + 1}</td>
                    <td>${dataIt}</td>
                    <td><strong>${g.quantita_prevista} pz</strong></td>
                    <td class="forchetta">${g.forchetta_minima}</td>
                    <td class="forchetta">${g.forchetta_massima}</td>
                </tr>`;
        });

        html += `</tbody></table></div>`;
        contenitoreTabella.innerHTML = html;
    }

    function renderGrafico(dati) {
        contenitoreGrafico.style.display = 'block';

        const labels = dati.map(g => g.data.slice(5));
        const valori = dati.map(g => g.quantita_prevista);
        const minimi = dati.map(g => g.forchetta_minima);
        const massimi = dati.map(g => g.forchetta_massima);

        // Prepara i punti picco evidenziati sul grafico
        const picchi = trovaPicchi(dati);
        const datePicchi = new Set(picchi.map(p => p.data.slice(5)));
        const colorePunti = valori.map((_, i) => datePicchi.has(labels[i]) ? '#F19B23' : 'rgba(130,192,204,0.8)');
        const raggioPunti = valori.map((_, i) => datePicchi.has(labels[i]) ? 7 : 3);

        if (graficoInstance) graficoInstance.destroy();

        const style = getComputedStyle(document.documentElement);
        const ciano = style.getPropertyValue('--highlight-color').trim();
        const testogrey = style.getPropertyValue('--text-muted').trim();
        const bordoCol = style.getPropertyValue('--border-color').trim();

        graficoInstance = new Chart(document.getElementById('grafico-previsione'), {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Quantità prevista',
                        data: valori,
                        borderColor: ciano,
                        backgroundColor: 'rgba(130,192,204,0.08)',
                        borderWidth: 2,
                        pointRadius: raggioPunti,        // punti picco più grandi
                        pointBackgroundColor: colorePunti, // punti picco arancioni
                        fill: false,
                        tension: 0.35
                    },
                    {
                        label: 'Massimo stimato',
                        data: massimi,
                        borderColor: 'rgba(130,192,204,0.25)',
                        borderDash: [5, 5],
                        borderWidth: 1,
                        pointRadius: 0,
                        fill: '+1',
                        backgroundColor: 'rgba(130,192,204,0.06)',
                        tension: 0.35
                    },
                    {
                        label: 'Minimo stimato',
                        data: minimi,
                        borderColor: 'rgba(130,192,204,0.25)',
                        borderDash: [5, 5],
                        borderWidth: 1,
                        pointRadius: 0,
                        fill: false,
                        tension: 0.35
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: testogrey,
                            font: { family: 'Sora', size: 12 },
                            boxWidth: 16,
                            padding: 16
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1E222A',
                        borderColor: bordoCol,
                        borderWidth: 1,
                        titleColor: ciano,
                        bodyColor: '#EDE7E3',
                        padding: 10,
                        callbacks: {
                            label: ctx => {
                                const label = `${ctx.dataset.label}: ${ctx.parsed.y} pz`;
                                const isPeak = ctx.datasetIndex === 0 && datePicchi.has(ctx.label);
                                return isPeak ? `${label}  ▲ picco` : label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: testogrey, font: { family: 'Sora', size: 12 } },
                        grid: { color: 'rgba(42,47,56,0.6)' },
                        title: { display: true, text: 'Data (MM-GG)', color: testogrey }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: testogrey, font: { family: 'Sora', size: 12 } },
                        grid: { color: 'rgba(42,47,56,0.6)' },
                        title: { display: true, text: 'Pezzi', color: testogrey }
                    }
                }
            }
        });
    }

    function mostraErrore(messaggio, suggerimento = '') {
        container.innerHTML = `
            <p class="errore">${messaggio}</p>
            ${suggerimento ? `<p style="font-size:0.88em;color:var(--text-muted)">${suggerimento}</p>` : ''}
        `;
        contenitoreGrafico.style.display = 'none';
        contenitoreTabella.innerHTML = '';
    }

    avviaPrevisione();

})();
