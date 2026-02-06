<?php
require_once 'backend/query/assemblaggi.php';
$assemblaggi = getAssemblaggi();
?>

<!DOCTYPE html>
<html lang="it">

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
            <th>SKU</th>
            <th>Nome</th>
            <th>Quantità</th>
            <th>Note</th>
            <th>Operatore</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($assemblaggi as $assemblaggio): ?>
            <tr>
              <td><?= htmlspecialchars($assemblaggio['sku']); ?></td>
              <td><?= htmlspecialchars($assemblaggio['nome']); ?></td>
              <td><?= htmlspecialchars($assemblaggio['quantita']).' '.htmlspecialchars($assemblaggio['unita_misura']); ?></td>
              <td><?= htmlspecialchars($assemblaggio['note']); ?></td>
              <td><?= htmlspecialchars($assemblaggio['email']); ?></td>
            </tr>
          <?php endforeach; ?>
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