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
          <th>Prodotto</th>
          <th>Q.tà</th>
          <th>Data</th>
          <th>Stato</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#1024</td>
          <td>Cliente Demo</td>
          <td>Centralina v1</td>
          <td>10</td>
          <td>10/01/2026</td>
          <td>
            <span class="status waiting">Attesa</span>
          </td>
          <td class="order-action text-center">
              <button class="btn-primary">
                <a href="index.php?page=assemblaggiOrdine" style="color: white; text-decoration: none;">Assembla ordine</a>
              </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="footer">© 2025 - PWA</div>

</body>
</html>
