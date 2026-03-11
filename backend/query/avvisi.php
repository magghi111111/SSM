<?php

function getAllAvvisi() {
    $conn = connect();
    $sql = "SELECT a.titolo,a.descrizione,a.data_pubblicazione,a.grado_urgenza,o.id as id_ordine,c.nome as nome_componente,r.nome as nome_ruolo
            FROM avvisi a
            left join ruoli_avvisi ar on a.id = ar.id_avviso
            left join ruoli r on ar.id_ruolo = r.id
            left join ordini o on a.id_ordini = o.id
            left join componenti c on a.id_componente = c.id
            ORDER BY data_pubblicazione DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAvvisiByRuolo($ruolo) {
    $conn = connect();
    $sql = "SELECT a.titolo,a.descrizione,a.data_pubblicazione,a.grado_urgenza,o.id as id_ordine,c.nome as nome_componente
            FROM avvisi a
            left join ruoli_avvisi ar on a.id = ar.id_avviso
            left join ruoli r on ar.id_ruolo = r.id
            left join ordini o on a.id_ordini = o.id
            left join componenti c on a.id_componente = c.id
            WHERE r.nome = :ruolo
            ORDER BY data_pubblicazione DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ruolo' => $ruolo]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>