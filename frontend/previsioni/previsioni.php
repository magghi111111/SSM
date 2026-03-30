<?php
require_once 'backend/query/componenti.php';
$componenti = getComponentiAssembly();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<main class="main">
    <div id="widget-previsione">
        <h2>Previsione Domanda (AI)</h2>

        <form id="form-previsione" novalidate>
            <div class="controls">
                <div>
                    <label for="inp-id-comp">Componente</label>
                    <select id="inp-id-comp" name="id_componente" required>
                        <?php foreach ($componenti as $comp): ?>
                            <option value="<?= $comp['id'] ?>" <?= $comp['id'] == 18 ? 'selected' : '' ?>>
                                <?= htmlspecialchars($comp['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="inp-giorni">Giorni da prevedere</label>
                    <input type="number" id="inp-giorni" name="giorni" value="30" min="1" max="365" required>
                </div>
                <div style="align-self: flex-end;">
                    <button id="btn-calcola-previsione" type="submit">Calcola previsione</button>
                </div>
            </div>
        </form>

        <div id="risultati-previsione">
            <p class="info">Caricamento previsione in corso...</p>
        </div>

        <!-- 1. Prima il grafico -->
        <div id="contenitore-grafico">
            <canvas id="grafico-previsione" height="120"></canvas>
        </div>

        <!-- 2. Poi la tabella picchi -->
        <div id="contenitore-tabella"></div>

    </div>
</main>

<script src="frontend/previsioni/script_grafico.js"></script>