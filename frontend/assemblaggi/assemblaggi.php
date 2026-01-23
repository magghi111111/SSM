<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Assemblaggio Libero</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="assembly-card">
      <div class="assembly-actions">
        <button class="btn-primary">Avvia Scanner QR</button>
      </div>

      <div class="camera-box">
        <p>Area fotocamera (scanner QR)</p>
      </div>

      <h2 class="section-title">Componenti prelevati</h2>

      <table class="assembly-table">
        <thead>
          <tr>
            <th>Codice</th>
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
            <td class="status-ok">OK</td>
          </tr>
          <tr>
            <td>COMP-014</td>
            <td>Cavo sensore</td>
            <td>2</td>
            <td class="status-pending">In attesa</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

  <!-- FOOTER già esistente -->

</body>
</html>