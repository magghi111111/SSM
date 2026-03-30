<?php
session_start();
require_once '../../backend/model/database.php';
require_once '../../backend/query/componenti.php';
$componenti = getComponentiAssembly();

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="../stile/layout.css?V=1">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: transparent;
        }

        /* Rimuovi padding e bordo del widget nell'embed */
        #widget-previsione {
            padding: 0;
            border: none;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
        }

        /* Il grafico occupa tutto lo spazio disponibile */
        #contenitore-grafico {
            margin-top: 0;
            border: none;
            border-radius: 0;
            padding: 8px;
        }
    </style>
</head>

    <form id="form-previsione" style="display:none;">
        <select id="inp-id-comp" style="display:none;">
            <?php foreach ($componenti as $comp): ?>
                <option value="<?= $comp['id'] ?>" <?= $comp['id'] == 18 ? 'selected' : '' ?>>
                    <?= htmlspecialchars($comp['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" id="inp-giorni" value="30" style="display:none;">
    </form>

    <div id="risultati-previsione" style="display:none;"></div>
    <div id="contenitore-grafico">
        <canvas id="grafico-previsione" height="120"></canvas>
    </div>
    <div id="contenitore-tabella" style="display:none;"></div>

<script src="script_grafico.js"></script>
<script src="iframe.js"></script>

</html>