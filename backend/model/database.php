<?php

function connect()
{

    $configPath = dirname(__DIR__, 2) . '/config.json';
    $config = json_decode(file_get_contents($configPath), true);
    $host = $config['db_host'];
    $dbname = $config['db_name'];

    $dsn  = "mysql:host=$host;dbname=$dbname;";
    $user = $config['db_user'];
    $password = $config['db_password'];
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("errore di connessione :" . $e->getMessage());
    }
}
