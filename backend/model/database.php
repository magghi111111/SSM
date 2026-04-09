<?php

function connect(){

    $config = json_decode(file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/SSM-1/config.json'), true);
    //percorso assoluto per evitare problemi di path perche il file è incluso in più punti del progetto
    $host = $config['db_host'];
    $dbname = $config['db_name'];

    $dsn  = "mysql:host=$host;dbname=$dbname;";
    $user = $config['db_user'];
    $password = $config['db_password'];
    try{
        $pdo = new PDO($dsn,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        die("errore di connessione :". $e->getMessage());
    }
}

?>