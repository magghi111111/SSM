<!-- MAGAZZINO: magazzino.html -->

<?php

require_once 'backend/query/componenti.php';
$componentiRaw = getComponentiRaw();
$componenti = getComponenti();

?>


<script>
  function toggleNuovoComponente() {
    const select = document.getElementById('componente');
    const box = document.getElementById('nuovo-componente');

    if (select.value === 'new') {
      box.classList.remove('hidden');
    } else {
      box.classList.add('hidden');
    }
  }

  function toggleAssemblyBuilder() {
    document
      .getElementById('assembly-builder')
      .classList.toggle('hidden');
  }

  function addAssemblyRow() {
    const container = document.getElementById('assembly-rows');
    const row = container.children[0].cloneNode(true);

    row.querySelector('select').value = '';
    row.querySelector('input').value = 1;

    container.appendChild(row);
  }

  function removeRow(btn) {
    const container = document.getElementById('assembly-rows');
    if (container.children.length > 1) {
      btn.closest('.assembly-row').remove();
    }
  }
</script>

<body>
  <div class="main">
    <div class="card full">
      <h3 class="card-title">Aggiunta manuale a magazzino</h3>

    <?php if (isset($_GET['aggiunta'])): ?>
      <?php if ($_GET['aggiunta'] == 'success'): ?>
        <div style="color:green;">Movimento registrato con successo!</div>
      <?php elseif ($_GET['aggiunta'] == 'error'): ?>
        <div style="color:red;">Errore durante la registrazione del movimento.</div>
      <?php endif; ?>
    <?php endif; ?>

      <form class="form-grid" method="post" action="backend/controller/movimentoCntrl.php">

        <div class="form-group">
          <label for="componente">Componente</label>
          <select name="id_componente" id="componente" required onchange="toggleNuovoComponente()">
            <option value="">Seleziona componente</option>
            <!-- PHP: componenti esistenti -->
            <?php foreach($componenti as $componente): ?>
              <option value="<?= $componente['id']; ?>"><?= $componente['nome']; ?></option>
            <?php endforeach; ?>
            <option value="new">Nuovo componente</option>
          </select>
        </div>
        <div id="nuovo-componente" class="form-group full-width hidden">
          <div class="component-type-badge">
            Creazione componente <strong>RAW</strong>
          </div>

          <div class="form-grid nested">

            <div class="form-group">
              <label for="sku">SKU</label>
              <input type="text" name="sku" id="sku">
            </div>

            <div class="form-group">
              <label for="nome_componente">Nome componente</label>
              <input type="text" name="nome_componente" id="nome_componente">
            </div>

            <div class="form-group">
              <label for="unita_misura">Unità di misura</label>
              <input type="text" name="unita_misura" id="unita_misura" placeholder="pz, m, kg…">
            </div>

            <div class="form-group">
              <label>QR Code</label>

              <div class="qr-input-group">
                <input type="text" name="qrcode" id="qrcode" placeholder="QR code letto" readonly>
                <button type="button" class="btn-secondary">
                  Scansiona QR
                </button>
              </div>
            </div>
          </div>

          <!-- tipo RAW forzato -->
          <input type="hidden" name="tipo" value="RAW">

        </div>

        <div class="form-group">
          <label for="delta">Variazione quantità</label>
          <input type="number" name="delta" id="delta" required>
          <small class="hint">Usa valori negativi per scarico</small>
        </div>

        <div class="form-group full-width">
          <label for="note">Motivo / Note</label>
          <textarea name="note" id="note" rows="3" required></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary" style="color: white; text-decoration: none;">Registra movimento</button>
        </div>
      </form>
    </div>

    <div class="card full">
      <button type="button" class="btn-secondary btn-assembly" onclick="toggleAssemblyBuilder()">➕ Crea nuovo assembly</button>
    </div>
    <div id="assembly-builder" class="card full hidden">

      <h3 class="card-title">Creazione assembly</h3>

      <div class="component-type-badge">
        Componente di tipo <strong>ASSEMBLY</strong>
      </div>

      <?php if (isset($_GET['assembly'])): ?>
      <?php if ($_GET['assembly'] == 'success'): ?>
        <div style="color:green;">Assembly creato con successo!</div>
      <?php elseif ($_GET['assembly'] == 'error'): ?>
        <div style="color:red;">Errore durante la creazione dell'assembly.</div>
      <?php endif; ?>
    <?php endif; ?>

      <form class="assembly-form" method="post" action="backend/controller/assemblyCntrl.php">
        <div class="form-grid">

          <div class="form-group">
            <label for="assembly_sku">SKU assembly</label>
            <input type="text" id="assembly_sku" name="assembly_sku">
          </div>

          <div class="form-group">
            <label for="assembly_nome">Nome assembly</label>
            <input type="text" id="assembly_nome" name="assembly_nome">
          </div>

          <div class="form-group">
            <label for="assembly_unita">Unità di misura</label>
            <input type="text" id="assembly_unita" name="assembly_unita" value="pz">
          </div>

          <div class="assembly-section">
            <div class="form-group">
              <label>QR code assembly</label>

              <div class="qr-input-group">
                <input type="text" placeholder="QR code letto" id="assembly_qrcode" name="assembly_qrcode" value="" disabled>
                <button type="button" class="btn-secondary">Scansiona QR</button>
              </div>
            </div>
          </div>
        </div>

        <hr>

        <h4>Componenti RAW</h4>

        <div id="assembly-rows">

          <div class="assembly-row">
            <select name="componenti[id][]" required>
              <option value="">Seleziona componente</option>
              <!-- PHP: SOLO componenti ROW -->
              <?php foreach ($componentiRaw as $raw): ?>
                <option value="<?= $raw['id']; ?>"><?= $raw['nome']; ?></option>
              <?php endforeach; ?>
            </select>

            <input type="number" name="componenti[qta][]" min="1" value="1" required>

            <button type="button" class="btn-icon" onclick="removeRow(this)">✕</button>

          </div>
        </div>

        <button type="button" class="btn small" onclick="addAssemblyRow()">+ Aggiungi componente</button>

        <div class="form-actions">
          <button type="submit" class="btn-primary">Crea assembly</button>
        </div>
      </form>
    </div>

    <div class="card full">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Codice</th>
            <th>Descrizione</th>
            <th>Quantità</th>
            <th>Posizione</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>RES-001</td>
            <td>Resistenza 10kΩ</td>
            <td>250</td>
            <td>Scaffale A1</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>