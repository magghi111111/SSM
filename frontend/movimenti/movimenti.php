<?php

require_once 'backend/query/movimenti.php';
require_once 'frontend/consegne/consegneSubTable.php';
require_once 'frontend/ordini/ordiniSubTable.php';
require_once 'backend/query/ordini.php';
require_once 'backend/query/consegna.php';
$movimenti = getAllMovimenti();

?>

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

  });
</script>
<!DOCTYPE html>
<html lang="it">


<body>
  <div class="main">
    <div class="card full">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Delta</th>
            <th>Data</th>
            <th>Componente</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($movimenti as $movimento): ?>
            <tr <?= $movimento['tipo'] == 'ORDER' || $movimento['tipo'] == 'DELIVERY' ? 'class="assembly_component"' : '' ?>>
              <td><?= htmlspecialchars($movimento['tipo']) ?></td>
              <td><?= htmlspecialchars($movimento['delta']) ?></td>
              <td><?= htmlspecialchars($movimento['data_movimento']) ?></td>
              <td><?= htmlspecialchars($movimento['nome']) ?></td>
              <td><?= htmlspecialchars($movimento['note']) ?></td>
            </tr>
            <?php if ($movimento['tipo'] == 'DELIVERY')
               righeConsegna($movimento['id_consegna']); 
              elseif($movimento['tipo'] == 'ORDER') 
               righeOrdini($movimento['id_ordine']);?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>