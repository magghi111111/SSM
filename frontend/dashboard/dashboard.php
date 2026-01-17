<?php

require 'backend/query/ordini.php';
require 'backend/query/movimenti.php';
$ordini_recenti = getOrdiniRecenti();
$movimenti_recenti = getUltimiMovimenti();

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Simple Store Manager – Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- KPI -->
        <section class="kpi-section">

            <div class="kpi-card">
                <div class="kpi-header">
                    <h3>Ordini da evadere</h3>
                    <i class="bi bi-receipt kpi-icon"></i>
                </div>
                <p class="kpi-value">12</p>
            </div>

            <div class="kpi-card warning">
                <div class="kpi-header">
                    <h3>Prodotti sotto scorta</h3>
                    <i class="bi bi-box-seam kpi-icon"></i>
                </div>
                <p class="kpi-value">6</p>
            </div>

            <div class="kpi-card success">
                <div class="kpi-header">
                    <h3>Flusso di cassa mensile</h3>
                    <i class="bi bi-cash-stack kpi-icon"></i>
                </div>
                <p class="kpi-value">€ 5.230</p>
            </div>

            <div class="kpi-card alert">
                <div class="kpi-header">
                    <h3>Avvisi</h3>
                    <i class="bi bi-exclamation-triangle kpi-icon"></i>
                </div>
                <p class="kpi-value">2</p>
            </div>

        </section>


        <!-- CONTENT GRID -->
        <section class="content-grid">

            <!-- PREVISIONI -->
            <div class="card large">
                <h2>Previsioni Vendite</h2>
                <p class="subtitle">
                    Stima basata sugli ordini passati e sull’andamento stagionale.
                </p>

                <div class="placeholder">
                    <img src="frontend/img/graficoEsempio.png" class="grafico-dashboard">
                </div>
            </div>

            <!-- PRODOTTI CRITICI -->
            <div class="card">
                <h2>Ultimi Movimenti</h2>
                <ul class="list">
                    <?php foreach ($movimenti_recenti as $movimento): ?>
                        <li>
                            <strong><?= htmlspecialchars($movimento['note']) ?></strong> 
                            <div class="info-row">
                                <span><strong>Tipo:</strong> <?= htmlspecialchars($movimento['tipo']) ?></span>
                                <span><strong>Delta:</strong> <?= htmlspecialchars($movimento['delta']) ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- AVVISI -->
            <div class="card">
                <h2>Avvisi e notifiche</h2>

                <ul class="notifications">
                    <li class="warning">
                        Scorte minime in esaurimento
                    </li>
                    <li class="error">
                        Ritardo consegna fornitore
                    </li>
                </ul>
            </div>
        </section>

        <!-- ORDINI RECENTI -->
        <section class="card full">
            <h2>Ordini recenti</h2>

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Ordine</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Stato</th>
                        <th>Importo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordini_recenti as $ordine): ?>
                        <tr>
                            <td>#<?= $ordine['id_shopify']; ?></td>
                            <td><?= $ordine['data_creazione']; ?></td>
                            <td><?= $ordine['cognome']; ?> <?= $ordine['nome']; ?></td>
                            <td><span class="status <?= strtolower($ordine['stato']); ?>"><?= $ordine['stato']; ?></span></td>
                            <td>€ 250,00</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    </main>

</body>

</html>