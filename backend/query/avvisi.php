<?php

function getAllAvvisi() {
    $conn = connect();
    $sql = "SELECT a.titolo,a.descrizione,a.data_pubblicazione,a.grado_urgenza,o.id as id_ordine,c.nome as nome_componente
            FROM avvisi a
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

function setAvviso($titolo, $descrizione, $grado_urgenza, $id_ordine, $id_componente, $ruoli) {
    $conn = connect();
    $sql = "INSERT INTO avvisi (titolo, descrizione, grado_urgenza, id_ordini, id_componente) 
    VALUES (:titolo, :descrizione, :grado_urgenza, :id_ordine, :id_componente)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':titolo' => $titolo,
        ':descrizione' => $descrizione,
        ':grado_urgenza' => $grado_urgenza,
        ':id_ordine' => $id_ordine,
        ':id_componente' => $id_componente
    ]);
    $avviso_id = $conn->lastInsertId();

    foreach ($ruoli as $ruolo) {
        $sql = "INSERT INTO ruoli_avvisi (id_avviso, id_ruolo) VALUES (:id_avviso, :id_ruolo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_avviso' => $avviso_id,
            ':id_ruolo' => $ruolo
        ]);
    }
}

function deleteAvvisoByOrderId($id_ordine) {
    $conn = connect();
    $sql = "DELETE FROM avvisi WHERE id_ordini = :id_ordine";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_ordine' => $id_ordine]);
}

function countAvvisiByRuolo($ruolo) {
    $conn = connect();
    $sql = "SELECT COUNT(*) FROM avvisi a";


    if($ruolo !== 'ADMIN'){
        $sql .= " JOIN ruoli_avvisi ar ON a.id = ar.id_avviso
                  JOIN ruoli r ON ar.id_ruolo = r.id
                  WHERE r.nome = :ruolo";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':ruolo' => $ruolo]);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    return $stmt->fetchColumn();
}


function getAvvisoByTitolo($titolo) {
    $conn = connect();
    $sql = "SELECT * FROM avvisi WHERE titolo = :titolo";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':titolo' => $titolo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteAvvisoByTitolo($titolo) {
    $conn = connect();
    $sql = "DELETE FROM avvisi WHERE titolo = :titolo";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':titolo' => $titolo]);
}

?>