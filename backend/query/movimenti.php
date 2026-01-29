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
    $sql = "SELECT delta, tipo, note, data_movimento
        from movimenti
        ORDER BY data_movimento DESC;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setMovimento($idComponente, $delta, $note){
    $pdo=connect();
    $sql = "INSERT INTO movimenti ( id_componente, delta, tipo, note) 
            VALUES (:id_componente, :delta,'MANUAL', :note);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $idComponente,
        ':delta'         => $delta,
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