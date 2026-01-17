<?php

function getUltimiMovimenti(){
    $pdo=connect();
    $sql = "SELECT delta, tipo, note
        from movimenti
        ORDER BY data_movimento
        LIMIT 3;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>