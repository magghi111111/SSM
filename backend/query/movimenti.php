<?php

function getUltimiMovimenti(){
    $pdo=connect();
    $sql = "SELECT delta, tipo, note
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



?>