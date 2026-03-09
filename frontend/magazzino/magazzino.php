<!-- MAGAZZINO: magazzino.html -->

<?php

require_once 'backend/query/componenti.php';
$componenti = getComponenti();

?>

<script>
  let currentQrValue = null;
  let currentQrTargetInput = null;

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
    console.log('Toggling assembly builder');
    console.log(document.getElementById('assembly-builder'));
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

  document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".assembly_component").forEach(row => {

      row.addEventListener("click", function() {

        const details = this.nextElementSibling;

        if (!details || !details.classList.contains("assembly-details")) {
          return;
        }

        details.classList.toggle("hidden");
        this.classList.toggle("open");

      });

    });
    
    document.querySelectorAll(".qr-download").forEach(link => {
      link.addEventListener("click", function(e) {
        e.stopPropagation();
      });
    });

  });

  

  function openQrModal(tipo, targetInputId) {
    currentQrTargetInput = targetInputId;

    document.getElementById('qr-modal').classList.remove('hidden');

    // reset
    const canvas = document.getElementById('qr-canvas');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    document.getElementById('qr-value-text').textContent = 'Generazione in corso…';
    const url = `backend/api/genera_qr.php?tipo=${encodeURIComponent(tipo)}`;
    fetch(url)
      .then(async response => {
        const text = await response.text();

        try {
          return JSON.parse(text);
        } catch (e) {
          console.error("Risposta NON JSON dal server:", text);
          throw new Error("Risposta server non valida");
        }
      })
      .then(data => {
        if (!data.success) {
          throw new Error("QR non generato");
        }

        gestisciQR(data.qr);
      })
      .catch(err => {
        console.error(err);
        mostraErroreQR();
      });
  }

  function confirmQr() {
    if (!currentQrValue || !currentQrTargetInput) return;

    const input = document.getElementById(currentQrTargetInput);
    if (!input) return;

    input.value = currentQrValue;
    closeQrModal();
  }

  function downloadQr() {
    if (!currentQrValue) return;

    const canvas = document.getElementById('qr-canvas');
    const link = document.createElement('a');
    link.download = `${currentQrValue}.png`;
    link.href = canvas.toDataURL('image/png');
    link.click();
  }

  function printQr() {
    if (!currentQrValue) return;

    const canvas = document.getElementById('qr-canvas');
    const dataUrl = canvas.toDataURL('image/png');

    const win = window.open('', '_blank');

    win.document.open();

    win.document.write(`
    <html>
      <head>
        <title>${currentQrValue}</title>

        <style>
          body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
          }

          img {
            width: 300px;
            height: 300px;
          }

          @media print {
            img {
            width: 5cm;
            height: 5cm;
            }
          }
        </style>
      </head>

      <body>

        <img id="qrImg">

        <script>
          const img = document.getElementById('qrImg');

          img.src = "${dataUrl}";

          img.onload = function () {
            window.print();
            window.onafterprint = window.close;
          };
        <\/script>

      </body>
    </html>
  `);

    win.document.close();
  }


  function gestisciQR(qrValue) {
    currentQrValue = qrValue;

    const canvas = document.getElementById('qr-canvas');
    const text = document.getElementById('qr-value-text');

    text.textContent = qrValue;

    QRCode.toCanvas(canvas, qrValue, {
      width: 220,
      margin: 2
    });
  }

  function closeQrModal() {
    document.getElementById('qr-modal').classList.add('hidden');
    currentQrValue = null;
    currentQrTargetInput = null;
  }

  function mostraErroreQR(msg = "Errore durante la generazione del QR") {
    const text = document.getElementById('qr-value-text');
    text.textContent = msg;
  }
</script>

<body>
  <div class="main">
    <div class="card full">
      <h3 class="card-title">Aggiunta manuale a magazzino</h3>

      <?php if (isset($_COOKIE['aggiunta_componente'])): ?>
        <?php if ($_COOKIE['aggiunta_componente'] == 'success'): ?>
          <div class="auto-hide" style="color:green;">Movimento registrato con successo!</div>
        <?php elseif ($_COOKIE['aggiunta_componente'] == 'error'): ?>
          <div class="auto-hide" style="color:red;">Errore durante la registrazione del movimento.</div>
        <?php elseif ($_COOKIE['aggiunta_componente'] == 'exists'): ?>
          <div class="auto-hide" style="color:red;">Componente già esistente!</div>
        <?php endif; ?>
      <?php endif; ?>

      <form class="form-grid" method="post" action="backend/controller/movimentoCntrl.php">

        <div class="form-group">
          <label for="componente">Componente</label>
          <select name="id_componente" id="componente" required onchange="toggleNuovoComponente()">
            <option value="">Seleziona componente</option>
            <!-- PHP: componenti esistenti -->
            <?php foreach ($componenti as $componente): ?>
              <option value="<?= $componente['id']; ?>"><?= $componente['nome']; ?></option>
            <?php endforeach; ?>
            <?php if($_SESSION['permessi']['inserimenti']):?>
            <option value="new">Nuovo componente</option>
            <?php endif; ?>
          </select>
        </div>
        <?php if($_SESSION['permessi']['inserimenti']):?>
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
              <label>QR Code Raw</label>

              <div class="qr-input-group">
                <input type="text" name="qrcode" id="qrcode" placeholder="QR Code assegnato" readonly>
                <button type="button" class="btn-secondary" onclick="openQrModal('RAW', 'qrcode')">Genera QR</button>
              </div>
            </div>
          </div>

          <!-- tipo RAW forzato -->
          <input type="hidden" name="tipo" value="RAW">

        </div>
        <?php endif; ?>

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

    <?php if($_SESSION['permessi']['inserimenti']):?>
    <div class="card full">
      <button type="button" class="btn-secondary btn-assembly" onclick="toggleAssemblyBuilder()">➕ Crea nuovo assembly</button>
    </div>
    <div id="assembly-builder" class="card full hidden">

      <h3 class="card-title">Creazione assembly</h3>

      <div class="component-type-badge">
        Componente di tipo <strong>ASSEMBLY</strong>
      </div>

      <?php if (isset($_COOKIE['assembly'])): ?>
        <?php if ($_COOKIE['assembly'] == 'success'): ?>
          <div class="auto-hide" style="color:green;">Assembly creato con successo!</div>
        <?php elseif ($_COOKIE['assembly'] == 'error'): ?>
          <div class="auto-hide" style="color:red;">Errore durante la creazione dell'assembly.</div>
        <?php elseif ($_COOKIE['assembly'] == 'exists'): ?>
          <div class="auto-hide" style="color:red;">Assembly già esistente!</div>
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
              <label>QR Code Assembly</label>

              <div class="qr-input-group">
                <input type="text" placeholder="QR Code assegnato" id="assembly_qrcode" name="assembly_qrcode" value="" disabled>
                <button type="button" class="btn-secondary" onclick="openQrModal('ASSEMBLY', 'assembly_qrcode')">Genera QR</button>
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
              <?php foreach ($componenti as $raw): ?>
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

    <?php endif; ?>

    <?php

    include 'frontend/magazzino/showStock.php';

    ?>
  </div>

  <!-- MODALE GENERAZIONE QR -->
  <div id="qr-modal" class="qr-modal hidden">

    <div class="qr-modal-overlay" onclick="closeQrModal()"></div>

    <div class="qr-modal-content">
      <h3>QR Code generato</h3>

      <div class="qr-preview">
        <!-- qui andrà il QR -->
        <canvas id="qr-canvas"></canvas>
      </div>

      <div class="qr-value">
        <code id="qr-value-text">—</code>
      </div>

      <div class="qr-actions">
        <button class="btn-secondary" onclick="downloadQr()">Scarica</button>
        <button class="btn-secondary" onclick="printQr()">Stampa</button>
        <button class="btn-primary" onclick="confirmQr()">Usa questo QR</button>
      </div>

      <button class="qr-close" onclick="closeQrModal()">✕</button>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</body>

</html>