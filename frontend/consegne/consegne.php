<!-- CONSEGNE: consegne.html -->
<!DOCTYPE html>
<html lang="it">
<script>
  function toggleNuovoFornitore() {
    const select = document.getElementById('fornitore');
    const box = document.getElementById('nuovo-fornitore');

    if (select.value === 'new') {
      box.classList.remove('hidden');
    } else {
      box.classList.add('hidden');
    }
  }

  function addDeliveryRow() {
    const container = document.getElementById('componenti-consegna');
    const row = container.children[0].cloneNode(true);

    row.querySelector('select').value = '';
    row.querySelector('input').value = 1;

    container.appendChild(row);
  }

  function removeRow(btn) {
    const container = document.getElementById('componenti-consegna');
    if (container.children.length > 1) {
      btn.closest('.delivery-row').remove();
    }
  }
</script>
<body>
<div class="main">
  <div class="card full">
    <h3 class="card-title">Registra nuova consegna</h3>
    <form class="form-grid" method="post" action="save_consegna.php">

      <div class="form-group">
        <label for="fornitore">Fornitore</label>
        <select name="id_fornitore" id="fornitore" required onchange="toggleNuovoFornitore()">
          <option value="">Seleziona fornitore</option>
          <!-- PHP: fornitori esistenti -->
          <option value="1">ElectroSupply SRL</option>
          <option value="2">Componenti Italia</option>

          <option value="new">Nuovo fornitore</option>
        </select>
      </div>
      <div id="nuovo-fornitore" class="form-group full-width hidden">
        <div class="form-grid nested">

          <div class="form-group">
            <label for="nome_fornitore">Nome fornitore</label>
            <input type="text" name="nome_fornitore" id="nome_fornitore">
          </div>

          <div class="form-group">
            <label for="email_fornitore">Email</label>
            <input type="email" name="email_fornitore" id="email_fornitore">
          </div>

          <div class="form-group">
            <label for="telefono_fornitore">Telefono</label>
            <input type="text" name="telefono_fornitore" id="telefono_fornitore">
          </div>

        </div>
      </div>

      <div class="form-group">
        <label for="data_ordine">Data ordine</label>
        <input type="datetime-local" name="data_ordine" id="data_ordine" required>
      </div>

      <div class="form-group">
        <label for="data_ricezione">Data ricezione</label>
        <input type="datetime-local" name="data_ricezione" id="data_ricezione">
      </div>

      <div class="form-group full-width">
        <label>Componenti ricevuti</label>

        <div id="componenti-consegna" class="delivery-components">
          
          <!-- RIGA COMPONENTE -->
          <div class="delivery-row">
            <select name="componenti[id][]" required>
              <option value="">Seleziona componente</option>
              <!-- PHP: SOLO componenti ROW -->
              <option value="1">Resistenza 10kΩ</option>
              <option value="2">Condensatore 100nF</option>
            </select>

            <input type="number" name="componenti[qta][]" min="1" value="1" required>

            <button type="button" class="btn-icon" onclick="removeRow(this)">✕</button>
          </div>

        </div>

        <button type="button"class="btn-secondary"onclick="addDeliveryRow()"style="margin-top:8px">+ Aggiungi componente</button>
      </div>

      <div class="form-group full-width">
        <label for="note">Note</label>
        <textarea name="note" id="note" rows="3"></textarea>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-primary" style="color: white; text-decoration: none;">Salva consegna</button>
      </div>

    </form>

  </div>

  <div class="card full">
    <table class="orders-table">
      <thead>
        <tr>
          <th>Ordine</th>
          <th>Cliente</th>
          <th>Corriere</th>
          <th>Tracking</th>
          <th>Stato</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#1024</td>
          <td>Cliente Demo</td>
          <td>DHL</td>
          <td>TRK123456</td>
          <td><span class="status waiting">In transito</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
