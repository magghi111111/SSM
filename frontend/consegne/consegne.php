<?php

require_once 'backend/query/fornitori.php';
require_once 'backend/query/componenti.php';
require_once 'backend/query/consegna.php';
require_once 'frontend/consegne/consegneSubTable.php'; 

$fornitori = getFornitori();
$componenti = getComponentiRaw();
$consegne = getConsegne();

?>
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

  });
</script>

<body>
  <div class="main">
    <div class="card full">
      <h3 class="card-title">Registra nuova consegna</h3>

      <?php if (isset($_COOKIE['consegna'])): ?>
        <?php if ($_COOKIE['consegna'] == 'success'): ?>
          <div class="auto-hide" style="color:green;">Consegna registrata con successo!</div>
        <?php elseif ($_COOKIE['consegna'] == 'error'): ?>
          <div class="auto-hide" style="color:red;">Errore durante la registrazione della consegna.</div>
        <?php elseif ($_COOKIE['consegna'] == 'fornitore_exists'): ?>
          <div class="auto-hide" style="color:red;">Fornitore già esistente.</div>
        <?php elseif ($_COOKIE['consegna'] == 'date_error'): ?>
          <div class="auto-hide" style="color:red;">La data di ricezione non può essere precedente alla data di ordine.</div></form>
        <?php endif; ?>
      <?php endif; ?>

      <form class="form-grid" method="post" action="backend/controller/consegnaCntrl.php">

        <div class="form-group">
          <label for="fornitore">Fornitore</label>
          <select name="id_fornitore" id="fornitore" required onchange="toggleNuovoFornitore()">
            <option value="">Seleziona fornitore</option>
            <!-- PHP: fornitori esistenti -->

            <?php foreach ($fornitori as $fornitore): ?>
              <option value="<?= $fornitore['id']; ?>"><?= $fornitore['nome']; ?></option>
            <?php endforeach; ?>
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
                <?php foreach ($componenti as $componente): ?>
                  <option value="<?= $componente['id']; ?>"><?= $componente['nome']; ?></option>
                <?php endforeach; ?>
              </select>

              <input type="number" name="componenti[qta][]" min="1" value="1" required>

              <button type="button" class="btn-icon" onclick="removeRow(this)">✕</button>
            </div>

          </div>

          <button type="button" class="btn-secondary" onclick="addDeliveryRow()" style="margin-top:8px">+ Aggiungi componente</button>
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
            <th>Fornitore</th>
            <th>Data ordine</th>
            <th>Data ricezione</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($consegne as $consegna): ?>
            <tr class='assembly_component'>
              <td><?= htmlspecialchars($consegna['fornitore']) ?></td>
              <td><?= htmlspecialchars($consegna['data_ordine']) ?></td>
              <td><?= htmlspecialchars($consegna['data_ricezione']) ?></td>
              <td><?= htmlspecialchars($consegna['note']) ?></td>
            </tr>
            <?php righeConsegna($consegna['id']); ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>