<?php

session_start();

require_once '../model/database.php';
require '../query/utenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login_user'];
    $password = $_POST['login_pass'];

    $utente = getUSer($username);

    

    if ($utente && password_verify($password, $utente['password_hash'])) {
        $_SESSION['user_id']= $utente['uid'];
        $_SESSION['user'] = $utente['email'];
        $_SESSION['role'] = $utente['nome'];
        $_SESSION['permessi'] = [
            'impostazioni' => $utente['impostazioni'],
            'magazzino' => $utente['magazzino'],
            'ordini' => $utente['ordini'],
            'inserimenti' => $utente['inserimenti_nuovi'],
            'consegne' => $utente['consegne'],
            'assemblaggi' => $utente['assemblaggi'],
            'movimenti' => $utente['movimenti'],
            'andamenti' => $utente['andamenti']
        ];
        header('Location: ../../index.php');
        exit();
    } else {
        header('Location: ../../index.php?message=invalid_credentials');
    }
}


?>