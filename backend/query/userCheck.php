<?php

require '../model/database.php';

function getUSer($user){
    $conn=connect();
    $sql="SELECT * FROM utenti WHERE email=:email";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['email'=>$user]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
    return $utente?: null;
}
?>