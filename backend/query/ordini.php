<?php

function getOrdiniRecenti(){
    $pdo=connect();
    $sql = "SELECT o.id,o.id_shopify, DATE_FORMAT(o.data_creazione, '%d/%m/%Y') AS data_creazione,o.stato, c.nome, c.cognome
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
    JOIN cliente c ON o.id_cliente = c.codice
    ORDER BY o.data_creazione DESC;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDettagliOrdine($id){
    $pdo=connect();
    $sql = "SELECT c.nome,r.quantita, c.unita_misura,r.id_componente
            FROM ordini o
            JOIN righe_ordini r ON o.id = r.id_ordine
            JOIN componenti c ON r.id_componente = c.id
            WHERE o.id = :id;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getOrdineById($id){
    $pdo=connect();
    $sql = "SELECT o.id_shopify, DATE_FORMAT(o.data_creazione, '%d/%m/%Y') AS data_creazione,o.stato, c.nome, c.cognome
    FROM ordini o
    JOIN cliente c ON o.id_cliente = c.codice
    WHERE o.id = :id and o.stato <> 'PREPARED';";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getOrdiniMese(){
    $pdo=connect();
    $sql = "SELECT COUNT(*) AS totale
    FROM ordini
    WHERE month(data_creazione) = month(CURDATE()) AND year(data_creazione) = year(CURDATE());";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['totale'];
}

function getOrdiniDaProcessare(){
    $pdo=connect();
    $sql = "SELECT count(*) AS totale
    FROM ordini o
    WHERE o.stato <> 'PREPARED';";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['totale'];
}   

function setStatoOrdine($id_ordine,$stato){
    $pdo=connect();
    $sql = "UPDATE ordini SET stato =:stato WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id_ordine, ':stato' => $stato]);
}

function checkDisponibilitaComponenti($id_ordine){
    $dettagli = getDettagliOrdine($id_ordine);
    $stock = [];
    foreach ($dettagli as $componente){
        for($i = 0; $i < $componente['quantita']; $i++){
            if(!verificaComponente($componente['id_componente'], $stock)){
                return false;
            }
        }
    }
    return true;
}

function verificaComponente($id_componente,&$stock){
    if(!isset($stock[$id_componente])){
        $stock[$id_componente] = getStock($id_componente);
    }
    if($stock[$id_componente] > 0){
        $stock[$id_componente]--;
        return true;
    }
    $children = getPartiComponente($id_componente);
    if(empty($children)){
        return false;
    }
    foreach($children as $child){
        for($i = 0; $i < $child['quantita']; $i++){
            if(!verificaComponente($child['id'], $stock)){
                return false;
            }
        }
    }
    return true;
}

?>