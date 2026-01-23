<?php

function getOrdiniRecenti(){
    $pdo=connect();
    $sql = "SELECT o.id_shopify, DATE_FORMAT(o.data_creazione, '%d/%m/%Y') AS data_creazione,o.stato, c.nome, c.cognome
    FROM ordini o
    JOIN cliente c ON o.id_cliente = c.codice
    WHERE o.data_creazione >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    LIMIT 5;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllOrdini(){
    $pdo=connect();
    $sql = "SELECT o.id,o.id_shopify, DATE_FORMAT(o.data_creazione, '%d/%m/%Y') AS data_creazione,o.stato, c.nome, c.cognome,p.nome,ro.quantita
    FROM ordini o
    JOIN cliente c ON o.id_cliente = c.codice
    JOIN righe_ordini ro ON o.id = ro.id_ordine
    join componenti p ON ro.id_prodotto = p.id
    ORDER BY o.data_creazione DESC;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>