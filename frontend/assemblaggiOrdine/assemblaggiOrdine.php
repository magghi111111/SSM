<?php

require_once 'backend/query/ordini.php';
if(isset($_GET['id_ordine'])){
    $id_ordine = $_GET['id_ordine'];
    $dettagli = getDettagliOrdine($id_ordine);
    $ordine = getOrdineById($id_ordine);
}
?>


<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="card assembly-card">

      <div class="order-info">
        <p><strong>Cliente:</strong> <?= $ordine['nome']; ?> <?= $ordine['cognome']; ?></p>
        <p><strong>Data ordine:</strong> <?= $ordine['data_creazione']; ?></p>
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
            <th>Componente</th>
            <th>Quantità</th>
            <th>Stato</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dettagli as $componente): ?>
            <tr>
              <td><?= $componente['nome']; ?></td>
              <td><?= $componente['quantita']; ?> <?= $componente['unita_misura']; ?></td>
              <td><span class="status pending">In attesa</span></td>
            </tr>
          <?php endforeach; ?>
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