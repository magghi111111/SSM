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

            <div class="kpi-card info">
                <a href="index.php?page=ordini" style="text-decoration: none; color: inherit;">
                    <div class="kpi-header">
                        <h3>Ordini da evadere</h3>
                        <i class="bi bi-receipt kpi-icon"></i>
                    </div>
                    <p class="kpi-value">12</p>
                </a>
            </div>

            <div class="kpi-card warning">
                <a href="index.php?page=andamenti" style="text-decoration: none; color: inherit;">
                    <div class="kpi-header">
                        <h3>Ordini ricevuti mensili</h3>
                        <i class="bi bi-box-seam kpi-icon"></i>
                    </div>
                    <p class="kpi-value">60</p>
                </a>
            </div>

            <div class="kpi-card success">
                <a href="index.php?page=andamenti" style="text-decoration: none; color: inherit;">
                    <div class="kpi-header">
                        <h3>Profitto mensile</h3>
                        <i class="bi bi-cash-stack kpi-icon"></i>
                    </div>
                    <p class="kpi-value">€ 5.230</p>
                </a>
            </div>

            <div class="kpi-card alert">
                <a href="index.php?page=avvisi" style="text-decoration: none; color: inherit;">
                <div class="kpi-header">
                    <h3>Avvisi</h3>
                    <i class="bi bi-exclamation-triangle kpi-icon"></i>
                </div>
                <p class="kpi-value">2</p>
                </a>
            </div>

        </section>


        <!-- CONTENT GRID -->
        <section class="content-grid">

            <!-- PREVISIONI -->
            <div class="card">
                <h2>Previsioni Vendite</h2>
                <p class="subtitle">
                    Stima basata sugli ordini passati e sull’andamento stagionale.
                </p>

                <div class="placeholder">
                    <img src="frontend/img/graficoEsempio.png" class="grafico-dashboard">
                </div>
            </div>

            <!-- MOVIMENTI -->
            <div class="card">
                <a href="index.php?page=movimenti" style="text-decoration: none; color: inherit;">
                    <h2>Ultimi Movimenti</h2>
                    <ul class="list">
                        <?php foreach ($movimenti_recenti as $movimento): ?>
                            <li>
                                <strong><?= htmlspecialchars($movimento['note']) ?></strong> 
                                <div class="info-row">
                                    <span><strong>Tipo:</strong> <?= htmlspecialchars($movimento['tipo']) ?></span>
                                    <span><strong>Data:</strong> <?= htmlspecialchars($movimento['data_movimento']) ?></span>
                                    <span><strong>Delta:</strong> <?= htmlspecialchars($movimento['delta']) ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </a>
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
                        <th>Assemblaggio</th>
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
                            <td class="order-action text-center">
                                <button class="btn-primary">
                                <a href="index.php?page=assemblaggiOrdine" style="color: white; text-decoration: none;">Assembla ordine</a>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    </main>

</body>

</html>