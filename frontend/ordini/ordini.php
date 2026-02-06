<!-- ORDINI: ordini.html -->

<?php

require_once 'backend/query/ordini.php';
require_once 'frontend/ordini/ordiniSubTable.php';

$ordini = getAllOrdini();

?>


<!DOCTYPE html>
<html lang="it">

<script>
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

    document.querySelectorAll(".order-action a").forEach(link => {
      link.addEventListener("click", function(e) {
        e.stopPropagation();
      });
    });

  });
</script>

<body>

  <div class="main">

    <div class="card full">
      <table class="orders-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Stato</th>
            <th>Importo</th>
            <th>Assemblaggio</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ordini as $ordine): ?>
            <tr class="assembly_component">
              <td>#<?= $ordine['id_shopify']; ?></td>
              <td><?= $ordine['data_creazione']; ?></td>
              <td><?= $ordine['cognome']; ?> <?= $ordine['nome']; ?></td>
              <td><span class="status <?= strtolower($ordine['stato']); ?>"><?= $ordine['stato']; ?></span></td>
              <td>€ 250,00</td>
              <td class="order-action text-center">
                <button class="btn-primary">
                  <a href="index.php?page=assemblaggiOrdine&id_ordine=<?= $ordine['id']; ?>" style="color: white; text-decoration: none;">Assembla ordine</a>
                </button>
              </td>
            </tr>
            <?php righeOrdini($ordine['id']); ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="footer">© 2025 - PWA</div>

</body>

</html>