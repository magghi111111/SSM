<?php


function getComponentiRaw(){
    $pdo=connect();
    $sql = "SELECT * FROM componenti WHERE tipo = 'RAW';";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkComponenteExists($sku, $nome, $qrcode){
    $pdo=connect();
    $sql = "SELECT COUNT(*) as count FROM componenti 
            WHERE sku = :sku OR nome = :nome OR qrcode = :qrcode;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':sku'     => $sku,
        ':nome'    => $nome,
        ':qrcode'  => $qrcode
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

function getComponenti(){
    $pdo=connect();
    $sql = "SELECT * 
    FROM componenti c
    JOIN stock s ON c.id = s.id_componente
    ORDER BY c.tipo;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPartiComponente($idAssembly){
    $pdo=connect();
    $sql = "SELECT c.*, p.quantita
    FROM parti_componente p
    join componenti c on p.id_raw = c.id
    WHERE id_assembly = :id_assembly;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_assembly' => $idAssembly]);
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