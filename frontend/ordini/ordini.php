<!-- ORDINI: ordini.html -->

<?php

require 'backend/query/ordini.php';
$ordini = getAllOrdini();

?>


<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ordini</title>
  <link rel="stylesheet" href="styles/app.css">
</head>

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
            <th>Azioni</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ordini as $ordine): ?>
            <tr>
              <td>#<?= $ordine['id_shopify']; ?></td>
              <td><?= $ordine['data_creazione']; ?></td>
              <td><?= $ordine['cognome']; ?> <?= $ordine['nome']; ?></td>
              <td><span class="status <?= strtolower($ordine['stato']); ?>"><?= $ordine['stato']; ?></span></td>
              <td>€ 250,00</td>
              <td class="order-action text-center">
                <button class="btn-primary">
                  <a href="index.php?page=assemblaggiOrdine" style="color: white; text-decoration: none;">Assembla ordine</a>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="footer">© 2025 - PWA</div>

</body>

</html>