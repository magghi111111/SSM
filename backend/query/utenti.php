<?php


function getUSer($user){
    $conn=connect();
    $sql="SELECT u.id as uid,u.email,u.password_hash,r.*
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
    $sql="SELECT u.id,u.email, r.nome AS ruolo
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
    return $stmt->fetch(PDO::FETCH_ASSOC) ?? null;
}

function getUserById($id){
    $conn=connect();
    $sql="SELECT u.id,u.email, r.nome AS ruolo
    FROM utenti u
    join ruoli r on u.id_ruolo=r.id 
    WHERE u.id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['id'=>$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?? null;
}

function eliminaRuolo($id){
    $conn=connect();
    $sql="DELETE FROM ruoli WHERE id=:id";
    $stmt=$conn->prepare($sql);
    return $stmt->execute(['id'=>$id]);
}

function eliminaUtente($id){
    $conn=connect();
    $sql="DELETE FROM utenti WHERE id=:id";
    $stmt=$conn->prepare($sql);
    return $stmt->execute(['id'=>$id]);
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

function editRole($id, $valori){
    $conn = connect();
    $campi = [];
    foreach($valori as $campo => $v){
        $campi[] = "$campo = :$campo";
    }
    $sql = "UPDATE ruoli SET " . implode(", ", $campi) . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $parametri = ["id" => $id];
    foreach($valori as $campo => $v){
        $parametri[$campo] = $v;
    }
    return $stmt->execute($parametri);
}

function editUser($id, $email, $id_ruolo){
    $conn = connect();
    $sql = "UPDATE utenti SET email = :email, id_ruolo = :id_ruolo WHERE id = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(['email' => $email, 'id_ruolo' => $id_ruolo, 'id' => $id]);
}

?>