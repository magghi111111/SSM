<?php


function getComponentiRaw(){
    $pdo=connect();
    $sql = "SELECT * FROM componenti WHERE tipo = 'RAW';";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getComponenti(){
    $pdo=connect();
    $sql = "SELECT * FROM componenti;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setComponente($sku, $nome, $unita_misura, $qrcode, $tipo){
    $pdo=connect();
    $sql = "INSERT INTO componenti (sku, nome, unita_misura, qrcode, tipo) 
            VALUES (:sku, :nome, :unita_misura, :qrcode, :tipo);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':sku'          => $sku,
        ':nome'         => $nome,
        ':unita_misura' => $unita_misura,
        ':qrcode'      => $qrcode,
        ':tipo'         => $tipo
    ]);
    return $pdo->lastInsertId();
}

function setAssemblyComponente($idAssembly, $idRaw, $quantita){
    $pdo=connect();
    $sql = "INSERT INTO parti_componente (id_assembly, id_raw, quantita) 
            VALUES (:id_assembly, :id_raw, :quantita);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_assembly'  => $idAssembly,
        ':id_raw'  => $idRaw,
        ':quantita'             => $quantita
    ]);
    return $pdo->lastInsertId();
}


?>