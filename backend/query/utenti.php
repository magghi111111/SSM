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

function setUser($email, $password_hashed){
    $conn=connect();
    $sql="INSERT INTO utenti (email, password_hash, ruolo) VALUES (:email, :password_hash, 'WAREHOUSE')";
    $stmt=$conn->prepare($sql);
    return $stmt->execute(['email'=>$email, 'password_hash'=>$password_hashed]);
}

function getRuoli(){
    $conn=connect();
    $sql="SELECT * FROM ruoli where nome <>'ADMIN'";
    $stmt=$conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>