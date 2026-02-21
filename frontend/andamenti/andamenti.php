<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Andamento</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="frontend/andamenti/grafici.js"></script>
</head>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <!-- Grafici principali -->
    <section class="charts-grid">

      <div class="card andamento-ordini">
        <h3>Andamento ordini</h3>
        <canvas id="graficoOrdini"></canvas>
      </div>

      <div class="card andamento-ordini">
        <h3>Consegne annuali</h3>
        <canvas id="graficoConsegne"></canvas>
      </div>

      <div class="chart-card">
        <h3>Tempo di preparazione</h3>
        <canvas id="graficoPrepTime"></canvas>
      </div>

      <div class="chart-card">
        <h3>Errori per tipologia</h3>
        <div id="errorsChart" class="chart-placeholder"></div>
      </div>

    </section>
  </main>

</body>
</html>