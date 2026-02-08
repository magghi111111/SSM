<?php

function getUltimiMovimenti(){
    $pdo=connect();
    $sql = "SELECT delta, data_movimento, tipo, note
        from movimenti
        ORDER BY data_movimento DESC
        LIMIT 3;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMovimenti(){
    $pdo=connect();
    $sql = "SELECT c.nome, m.delta, m.tipo, m.note, m.data_movimento,m.id_consegna, m.id_ordine
            FROM movimenti m
            left JOIN componenti c ON m.id_componente = c.id
            ORDER BY m.data_movimento DESC;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setMovimento($idComponente, $delta, $tipo, $note){
    $pdo=connect();
    $sql = "INSERT INTO movimenti ( id_componente, delta, tipo, note) 
            VALUES (:id_componente, :delta,:tipo, :note);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $idComponente,
        ':delta'         => $delta,
        ':tipo'          => $tipo,
        ':note'          => $note
    ]);
    return $pdo->lastInsertId();
}

function setStock($idComponente, $delta){
    $pdo=connect();
    $sql = "UPDATE stock 
            SET quantita = quantita + :qta 
            WHERE id_componente = :id_componente;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $idComponente,
        ':qta'           => $delta
    ]);
}

?>