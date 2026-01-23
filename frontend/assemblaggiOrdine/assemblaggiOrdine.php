<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Assemblaggio Ordine</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="card assembly-card">

      <div class="order-info">
        <p><strong>Cliente:</strong> Mario Rossi</p>
        <p><strong>Data ordine:</strong> 12/01/2026</p>
      </div>

      <div class="assembly-actions">
        <button class="btn-primary">Scansiona componente</button>
      </div>

      <div class="camera-box">
        <p>Area fotocamera (scanner QR)</p>
      </div>

      <h2 class="section-title">Componenti richiesti</h2>

      <table class="assembly-table">
        <thead>
          <tr>
            <th>Codice richiesto</th>
            <th>Descrizione</th>
            <th>Quantità</th>
            <th>Stato</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>COMP-001</td>
            <td>Centralina</td>
            <td>1</td>
            <td class="status-ok">Verificato</td>
          </tr>
          <tr>
            <td>COMP-014</td>
            <td>Cavo sensore</td>
            <td>2</td>
            <td class="status-error">Errato / non scansionato</td>
          </tr>
        </tbody>
      </table>

      <div class="assembly-footer">
        <button class="btn-secondary">Annulla</button>
        <button class="btn-primary">Completa Assemblaggio</button>
      </div>

    </section>
  </main>

</body>
</html>