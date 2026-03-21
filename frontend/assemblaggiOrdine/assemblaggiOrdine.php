<?php
require_once 'backend/query/ordini.php';
require_once 'backend/query/componenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_ordine'])) {
  $id_ordine = (int)$_GET['id_ordine'];
  $ordine    = getOrdineById($id_ordine);
  $dettagli  = getDettagliOrdine($id_ordine);
}

require_once 'frontend/assemblaggiOrdine/tabellaOrdine.php';

?>


<main class="content">

  <section class="assembly-card">

    <h2 class="section-title">Assemblaggio ordine</h2>

    <div class="order-info">
      <p><strong>Cliente:</strong> <?= htmlspecialchars($ordine['nome'] . ' ' . $ordine['cognome']) ?></p>
      <p><strong>Data ordine:</strong> <?= htmlspecialchars($ordine['data_creazione']) ?></p>
    </div>

    <div id="scannerError" class="hidden error-box"></div>

    <div id="scannerBox" class="camera-box hidden">
      <button type="button" id="closeScanner" class="close-btn">✕</button>
      <div id="qr-reader"></div>
    </div>

    <form id="assemblaggioOrdineForm" method="POST" action="backend/controller/assemblaggiOrdineCntrl.php">
      <input type="hidden" name="id_ordine" value="<?= $id_ordine ?>">

      <h3 class="section-subtitle">Componenti ordine</h3>

      <table class="assembly-table">
        <thead>
          <tr>
            <th>Componente</th>
            <th>Quantità</th>
            <th>QR</th>
            <th>Stato</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dettagli as $componenteOrdine): ?>
            <?php renderComponenteOrdine($componenteOrdine); ?>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php include 'frontend/assemblaggiOrdine/messaggi.php'; ?>
      <div class="assembly-footer">
        <button type="button" id="openScanner" class="btn-primary">
        <i class="bi bi-qr-code-scan"></i> Scansiona componente
        </button>

      
        <button type="submit" class="btn-primary">Completa ordine</button>
      </div>

    </form>

  </section>
</main>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="frontend/js_assemblaggi/scanner.js"></script>
<script src="frontend/js_assemblaggi/assemblaggiOrdine.js"></script>