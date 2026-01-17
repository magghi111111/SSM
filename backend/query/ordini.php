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
    $sql = "SELECT o.id,o.id_shopify, DATE_FORMAT(o.data_creazione, '%d/%m/%Y') AS data_creazione,o.stato, c.nome, c.cognome
    FROM ordini o
    JOIN cliente c ON o.id_cliente = c.codice;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRigheOrdine($id_ordine){
    $pdo=connect();
    $sql = "SELECT p.nome, ro.quantita
    FROM righe_ordine ro
    JOIN prodotto p ON ro.id_prodotto = p.codice
    WHERE ro.id_ordine = :id_ordine;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_ordine' => $id_ordine]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>