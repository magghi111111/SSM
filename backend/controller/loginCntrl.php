<?php

session_start();

require '../query/userCheck.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login_user'];
    $password = $_POST['login_pass'];

    $utente = getUSer($username);

    

    if ($utente && password_verify($password, $utente['password_hash'])) {
        $_SESSION['user_id']= $utente['id'];
        $_SESSION['user'] = $utente['email'];
        $_SESSION['role'] = $utente['ruolo'];
        header('Location: ../../index.php');
        exit();
    } else {
        header('Location: ../../index.php?message=invalid_credentials&password='.$utente['password_hash']);
    }
}


?>