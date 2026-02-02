<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Assemblaggio Libero</title>
</head>
<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="assembly-card">
      <div class="assembly-actions">
        <button class="btn-primary" id="openScanner">Avvia Scanner QR</button>
      </div>

      <div class="camera-box hidden" id="scannerBox">
        <button id="closeScanner" class="close-btn">✕</button>
        <div id="qr-reader"></div>
      </div>
      
      <div id="scanMessage" class="scan-message hidden"></div>

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

  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="frontend/js_assemblaggi/scanner.js"></script>

  <script>
    function handleQr(qrText) {
      console.log("QR scansionato (libero):", qrText);
    }
  </script>
</body>
</html>