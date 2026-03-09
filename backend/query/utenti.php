<?php


function getUSer($user){
    $conn=connect();
    $sql="SELECT *
    FROM utenti u
    join ruoli r on u.id_ruolo=r.id 
    WHERE email=:email";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['email'=>$user]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
    return $utente?: null;
}

function getAllUsers(){
    $conn=connect();
    $sql="SELECT u.email, r.nome AS ruolo
    FROM utenti u
    join ruoli r on u.id_ruolo=r.id";
    $stmt=$conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setUser($email, $password_hashed, $id_ruolo){
    $conn=connect();
    $sql="INSERT INTO utenti (email, password_hash, id_ruolo) VALUES (:email, :password_hash, :id_ruolo)";
    $stmt=$conn->prepare($sql);
    return $stmt->execute(['email'=>$email, 'password_hash'=>$password_hashed, 'id_ruolo'=>$id_ruolo]);
}

function getRuoli(){
    $conn=connect();
    $sql="SELECT * FROM ruoli";
    $stmt=$conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRuoloById($id){
    $conn=connect();
    $sql="SELECT * FROM ruoli WHERE id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['id'=>$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function setRole($nome, $permessi){
    $conn = connect();
    $campi = "nome";
    $valori = ":nome";
    foreach($permessi as $campo => $v){
        $campi .= ", $campo";
        $valori .= ", :$campo";
    }
    $sql = "INSERT INTO ruoli ($campi) VALUES ($valori)";
    $stmt = $conn->prepare($sql);
    $parametri = ["nome" => $nome];
    foreach($permessi as $campo => $v){
        $parametri[$campo] = $v;
    }
    return $stmt->execute($parametri);
}

?>