<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Assemblaggio Ordine</title>
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
        <button class="btn-primary" id="openScanner">Scansiona componente</button>
      </div>

      <div class="camera-box hidden" id="scannerBox">
        <button id="closeScanner" class="close-btn">✕</button>
        <div id="qr-reader"></div>
      </div>
      
      <div id="scanMessage" class="scan-message hidden"></div>

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
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="frontend/js_assemblaggi/scanner.js"></script>
  <script>
    function handleQr(qrText) {
      console.log("QR scansionato (ordine):", qrText);

      // prossimo step:
      // 1. verifica DB
      // 2. confronto con componenti richiesti
      // 3. aggiorna stato riga
    }
  </script>
</body>
</html>