<?php
require_once 'backend/query/assemblaggi.php';
require_once 'backend/query/componenti.php';
$assemblaggi = getAssemblaggi();
$componentiAssembly = getComponentiAssembly();

?>

<!DOCTYPE html>
<html lang="it">

<body>

  <!-- HEADER / SIDEBAR già esistenti -->

  <main class="content">

    <section class="assembly-card">

      <form id="formAssemblaggio" method="post" action="backend/controller/assembleCntrl.php">

        <h2 class="section-title">Seleziona componente da assemblare</h2>

        <?php include 'frontend/assemblaggi/messaggi.php';  ?>
        <!-- Scanner -->
        <div class="camera-box hidden" id="scannerBox">
          <button type="button" id="closeScanner" class="close-btn">✕</button>
          <div id="qr-reader"></div>
        </div>

        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']); ?>">

        <!-- Selezione assembly -->
        <div class="assembly-selector">
          <?php foreach ($componentiAssembly as $assembly): ?>
            <label class="assembly-option">
              <input type="radio" name="assembly_type" value="<?= $assembly['id']; ?>" required>
              <span><?= htmlspecialchars($assembly['nome']); ?></span>
            </label>
          <?php endforeach; ?>
        </div>

        <!-- Componenti dei vari assembly -->
        <div class="assembly-components-wrapper">
          <?php foreach ($componentiAssembly as $assembly): ?>
            <div class="required-components hidden" data-assembly-id="<?= $assembly['id']; ?>">
              <ul class="required-components-list">
                <?php foreach (getPartiComponente($assembly['id']) as $componente): ?>
                  <li class="required-component">
                    <span class="component-name">
                      <?= htmlspecialchars($componente['nome']); ?> (<?= $componente['quantita'] . ' ' . $componente['unita_misura']; ?>)
                    </span>
                    <input type="text"
                      class="component-qr"
                      name="componenti_qr[<?= $componente['id']; ?>]"
                      data-componente-id="<?= $componente['id']; ?>"
                      readonly
                      disabled
                      placeholder="Non scannerizzato">

                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>

        <div id="scannerError" class="hidden" style="color:red;"></div>

        <button type="button" id="openScanner" class="btn-primary">
          <i class="bi bi-qr-code-scan"></i> Scansiona componente
        </button>


        <div class="form-group">
          <label for="note">Note</label>
          <input type="text" id="note" name="note" placeholder="Eventuali note">
        </div>

        <button type="submit" class="btn-primary">Registra assemblaggio</button>
      </form>

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
</body>

</html>