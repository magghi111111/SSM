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
      <form id="formAssemblaggio" method="post" action="backend/controller/assembleCntrl.php">

        <div class="assembly-actions">
          <button type="button" class="btn-primary" id="openScanner">
            Avvia Scanner QR
          </button>
        </div>

        <!-- Scanner -->
        <div class="camera-box hidden" id="scannerBox">
          <button type="button" id="closeScanner" class="close-btn">✕</button>
          <div id="qr-reader"></div>
        </div>

        <!-- Messaggi -->
        <div id="scanMessage" class="scan-message hidden"></div>

        <!-- Input QR -->
        <div class="form-group qr-input-group">
          <label for="assembly_qr">Componente (QR)</label>
          <input type="text" id="assembly_qr" name="assembly_qr" readonly required placeholder="Scansiona un QR">
        </div>

        <!-- Quantità -->
        <div class="form-group">
          <label for="qty">Quantità assemblata</label>
          <input type="number" id="qty" name="qty" min="1" required>
        </div>

        <div class="form-group">
          <label for="note">Note</label>
          <input type="text" id="note" name="note" required>
        </div>

        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']); ?>">

        <button type="submit" class="btn-primary">
          Registra assemblaggio
        </button>

      </form>

      <?php include 'frontend/assemblaggi/messaggi.php';  ?>

      <h2 class="section-title">Seleziona Assembly</h2>
        <div class="assembly-selector">
          <label class="assembly-option">
            <input type="radio" name="assembly_type" value="cambio" required>
            <span>Cambio Elettronico</span>
          </label>

          <label class="assembly-option">
            <input type="radio" name="assembly_type" value="pedalina">
            <span>Pedalina</span>
          </label>

          <label class="assembly-option">
            <input type="radio" name="assembly_type" value="centralina">
            <span>Centralina</span>
          </label>
        </div>

        <div id="requiredComponents" class="required-components hidden">
          <h3>Componenti necessari</h3>
          <ul id="componentList"></ul>
        </div>

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
              <td><?= htmlspecialchars($assemblaggio['quantita']) . ' ' . htmlspecialchars($assemblaggio['unita_misura']); ?></td>
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
  <script src="frontend/js_assemblaggi/assembly.js"></script>
  <script>
    function handleQr(qrText) {

      console.log("QR scansionato:", qrText);

      // scrive il valore nel campo input
      const input = document.getElementById('assembly_qr');
      input.value = qrText;

      // messaggio visivo
      const msg = document.getElementById('scanMessage');
      msg.textContent = "QR acquisito correttamente";
      msg.classList.remove('hidden');

      // chiudi scanner
      document.getElementById('scannerBox').classList.add('hidden');
    }
  </script>
</body>

</html>