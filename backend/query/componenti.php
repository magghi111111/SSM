<?php

function getComponentiRaw(){
    $pdo=connect();
    $sql = "SELECT * FROM componenti WHERE tipo = 'RAW';";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getComponentiAssembly(){
    $pdo=connect();
    $sql = "SELECT * FROM componenti WHERE tipo = 'ASSEMBLY';";
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

function getComponenteByQR($qrcode){
    $pdo=connect();
    $sql = "SELECT id FROM componenti WHERE qrcode = :qrcode;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':qrcode' => $qrcode]);
    $componente = $stmt->fetchColumn();
    return $componente ?? null;
}


function updateStockAssemblaggio($id_componente, $delta){
    $pdo = connect();
    $pdo->beginTransaction();//necessario per evitare di lasciare stock incoerenti in caso di errore

    try {
        $sql = "UPDATE stock s
                JOIN parti_componente pc ON s.id_componente = pc.id_raw
                SET s.quantita = s.quantita - (pc.quantita * :delta)
                WHERE pc.id_assembly = :id_componente;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':delta' => $delta,
            ':id_componente' => $id_componente
        ]);

        $sql = "UPDATE stock SET quantita = quantita + :delta WHERE id_componente = :id_componente;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':delta' => $delta,
            ':id_componente' => $id_componente
        ]);

        $pdo->commit();//se tutto va bene, conferma le modifiche
        return true;

    } catch (Exception $e) {
        $pdo->rollBack();//se c'è un errore, annulla tutte le modifiche
        return false;
    }
}


function checkStocks($id_componente,$qta){
    $pdo=connect();
    $sql = "SELECT *
    FROM componenti c
    JOIN stock s ON s.id_componente = c.id
    WHERE c.id = :id_componente
      AND s.quantita < :qty;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $id_componente,
        ':qty' => $qta
    ]);
    $row_count = $stmt->rowCount();
    return $row_count > 0;
}

function checkAssembly($id_assembly, $id_componente){
    $pdo=connect();
    $sql = "SELECT *
    FROM parti_componente
    WHERE id_assembly = :id_assembly
      AND id_raw = :id_componente;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_assembly' => $id_assembly,
        ':id_componente' => $id_componente
    ]);
    $row_count = $stmt->rowCount();
    return $row_count == 0;
}

function getComponenti(){
    $pdo=connect();
    $sql = "SELECT * 
    FROM componenti c
    JOIN stock s ON c.id = s.id_componente
    ORDER BY c.sku;";
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
    $id=$pdo->lastInsertId();

    $sql = 'INSERT INTO stock (id_componente) values (:id_componente);';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_componente'=>$id]);
    
    return $id;
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

function getStock($id_componente){
    $pdo=connect();
    $sql = "SELECT quantita FROM stock WHERE id_componente = :id_componente;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_componente' => $id_componente]);
    return $stmt->fetchColumn();
}

function getStockTotale(){
    $conn = connect();
    $sql = "SELECT id_componente, quantita FROM stock";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stock = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $stock[$row['id_componente']] = $row['quantita'];
    }
    return $stock;
}


?>