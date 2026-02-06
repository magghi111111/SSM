<?php

function getAssemblaggi(){
    $pdo=connect();
    $sql="SELECT * 
    FROM assemblaggi a
    Join componenti c ON a.id_componente = c.id
    join utenti u ON a.id_utente = u.id
    order by a.data_assemblaggio DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>