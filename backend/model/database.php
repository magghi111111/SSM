<?php

function connect(){
    $host = "localhost";
    $dbname = "gestore_magazzino";

    $dsn  = "mysql:host=$host;dbname=$dbname;";
    $user = "root";
    $password = "";
    try{
        $pdo = new PDO($dsn,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        die("errore di connessione :". $e->getMessage());
    }
}

?>