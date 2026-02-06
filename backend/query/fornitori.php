<?php

function getFornitori(){
    $pdo=connect();
    $sql = "SELECT * FROM fornitore;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkFornitoreExists($email, $telefono){
    $pdo=connect();
    $sql = "SELECT COUNT(*) as count FROM fornitore WHERE email = :email OR telefono = :telefono;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':telefono' => $telefono
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

function setFornitore($nome, $email, $telefono){
    $pdo=connect();
    $sql = "INSERT INTO fornitore (nome, email, telefono) VALUES (:nome, :email, :telefono);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':telefono' => $telefono
    ]);
    return $pdo->lastInsertId();
}


?>