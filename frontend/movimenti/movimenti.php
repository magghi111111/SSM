<?php

require_once 'backend/query/movimenti.php';

$filters = [
    'tipo'        => $_GET['tipo'] ?? [],
    'componenti'  => $_GET['componenti'] ?? [],
    'order'       => $_GET['order'] ?? null
];

$movimenti = getAllMovimenti($filters);
$componenti = getDistinctComponenti();


?>

<!DOCTYPE html>
<html lang="it">


<body>
  <div class="main">
    <div class="card full">
      <form method="GET" class="filters" action="">
        <input type="hidden" name="page" value="movimenti">

        <!-- ORDINAMENTO -->
        <div class="filter-block">
          <label>Ordina per</label>
          <select name="order">
            <option value="">Data (default)</option>
            <option value="tipo" <?= ($_GET['order'] ?? '') === 'tipo' ? 'selected' : '' ?>>Tipo</option>
            <option value="data_movimento" <?= ($_GET['order'] ?? '') === 'data_movimento' ? 'selected' : '' ?>>Data</option>
            <option value="nome" <?= ($_GET['order'] ?? '') === 'nome' ? 'selected' : '' ?>>Componente</option>
          </select>
        </div>

        <!-- FILTRO TIPO -->
        <div class="filter-block">
          <label>Tipo</label>
          <div class="checkbox-group">
            <?php foreach (['MANUAL', 'ASSEMBLY', 'ORDER', 'DELIVERY'] as $t): ?>
              <label class="checkbox-item">
                <input
                  type="checkbox"
                  name="tipo[]"
                  value="<?= $t ?>"
                  <?= in_array($t, $_GET['tipo'] ?? []) ? 'checked' : '' ?>>
                <?= $t ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- FILTRO COMPONENTI -->
        <div class="filter-block">
          <label>Componente</label>
          <div class="checkbox-group">
            <?php foreach ($componenti as $c): ?>
              <label class="checkbox-item">
                <input
                  type="checkbox"
                  name="componenti[]"
                  value="<?= $c['id'] ?>"
                  <?= in_array($c['id'], $_GET['componenti'] ?? []) ? 'checked' : '' ?>>
                <?= htmlspecialchars($c['nome']) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- BOTTONI -->
        <div class="filter-actions">
          <button type="submit" class="btn-primary">Applica</button>
          <a href="index.php?page=movimenti" class="btn-secondary">Reset</a>
        </div>

      </form>

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
            <tr>
              <td><?= htmlspecialchars($movimento['tipo']) ?></td>
              <td><?= htmlspecialchars($movimento['delta']) ?></td>
              <td><?= htmlspecialchars($movimento['data_movimento']) ?></td>
              <td><?= htmlspecialchars($movimento['nome']) ?></td>
              <td><?= htmlspecialchars($movimento['note']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>