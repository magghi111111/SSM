<?php

require_once 'backend/query/avvisi.php';

if ($_SESSION['role'] === 'ADMIN') {
    $avvisi = getAllAvvisi();
} else {
    $avvisi = getAvvisiByRuolo($_SESSION['role']);
}

?>

<main class="main">
<section class="card full">
    <h2>Avvisi</h2>

    <table class="orders-table">
        <thead>
            <!-- SELECT a.titolo,a.descrizione,a.data_pubblicazione,r.grado_urgenza,o.id as id_ordine,c.nome as nome_componente -->
            <tr>
                <th>Titolo</th>
                <th>Descrizione</th>
                <th>Data Pubblicazione</th>
                <th>Nome Componente</th>
                <th>Grado Urgenza</th>
                <th>Nome Ruolo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($avvisi as $avviso): ?>
                <tr>
                    <td><?= $avviso['titolo']?></td>
                    <td><?= $avviso['descrizione'] ?></td>
                    <td><?= $avviso['data_pubblicazione'] ?></td>
                    <td><?= $avviso['nome_componente']  ?></td>
                    <td><span class="grado <?= strtolower($avviso['grado_urgenza']); ?>"><?= $avviso['grado_urgenza'] ?></span></td>
                    <td><?= $avviso['nome_ruolo'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
</main>