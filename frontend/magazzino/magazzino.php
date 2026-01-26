<!-- MAGAZZINO: magazzino.html -->
<!DOCTYPE html>
<html lang="it">
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

    const row = document.createElement('div');
    row.className = 'assembly-row';

    row.innerHTML = `
      <select>
        <option value="">Seleziona componente RAW</option>
        <option value="1">RAW-RES-10K – Resistenza 10K</option>
        <option value="2">RAW-CAP-100uF – Condensatore 100uF</option>
      </select>
      <input type="number" placeholder="Quantità" min="1">
    `;

    container.appendChild(row);
  }
</script>
<body>
  <div class="main">
    <div class="card full">
      <h3 class="card-title">Aggiunta manuale a magazzino</h3>

      <form class="form-grid" method="post" action="save_movimento_manual.php">

        <div class="form-group">
          <label for="componente">Componente</label>
          <select name="id_componente" id="componente" required onchange="toggleNuovoComponente()">
            <option value="">Seleziona componente</option>
            <!-- PHP: componenti esistenti -->
            <option value="1">RAW-RES-10K – Resistenza 10K</option>
            <option value="2">RAW-CAP-100uF – Condensatore 100uF</option>

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
      <button type="button" class="btn secondary" onclick="toggleAssemblyBuilder()">Crea nuovo assembly</button>
    </div>
    <div id="assembly-builder" class="card full hidden">

      <h3 class="card-title">Creazione assembly</h3>

      <div class="component-type-badge">
        Componente di tipo <strong>ASSEMBLY</strong>
      </div>

      <form class="assembly-form">

        <div class="form-grid">

          <div class="form-group">
            <label for="assembly_sku">SKU assembly</label>
            <input type="text" id="assembly_sku">
          </div>

          <div class="form-group">
            <label for="assembly_nome">Nome assembly</label>
            <input type="text" id="assembly_nome">
          </div>

          <div class="form-group">
            <label for="assembly_unita">Unità di misura</label>
            <input type="text" id="assembly_unita" value="pz">
          </div>

        </div>

        <hr>

        <h4>Componenti RAW</h4>

        <div id="assembly-rows">

          <div class="assembly-row">
            <select>
              <option value="">Seleziona componente RAW</option>
              <option value="1">RAW-RES-10K – Resistenza 10K</option>
              <option value="2">RAW-CAP-100uF – Condensatore 100uF</option>
            </select>

            <input type="number" placeholder="Quantità" min="1">
          </div>

        </div>

        <button type="button"
                class="btn small"
                onclick="addAssemblyRow()">
          + Aggiungi componente
        </button>

        <div class="form-actions">
          <button type="submit" class="btn primary">
            Crea assembly
          </button>
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