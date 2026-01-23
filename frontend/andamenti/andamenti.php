<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Andamento</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <!-- KPI rapidi -->
    <section class="kpi-grid">
      <div class="kpi-card">
        <span class="kpi-title">Ordini Oggi</span>
        <span class="kpi-value">128</span>
      </div>
      <div class="kpi-card">
        <span class="kpi-title">In Preparazione</span>
        <span class="kpi-value">42</span>
      </div>
      <div class="kpi-card">
        <span class="kpi-title">Tempo Medio</span>
        <span class="kpi-value">18 min</span>
      </div>
      <div class="kpi-card">
        <span class="kpi-title">Errori</span>
        <span class="kpi-value">3</span>
      </div>
    </section>

    <!-- Grafici principali -->
    <section class="charts-grid">

      <div class="chart-card">
        <h3>Ordini nel tempo</h3>
        <div id="ordersTrendChart" class="chart-placeholder"></div>
      </div>

      <div class="chart-card">
        <h3>Stato ordini</h3>
        <div id="ordersStatusChart" class="chart-placeholder"></div>
      </div>

      <div class="chart-card">
        <h3>Tempo di preparazione</h3>
        <div id="prepTimeChart" class="chart-placeholder"></div>
      </div>

      <div class="chart-card">
        <h3>Errori per tipologia</h3>
        <div id="errorsChart" class="chart-placeholder"></div>
      </div>

    </section>
  </main>

</body>
</html>