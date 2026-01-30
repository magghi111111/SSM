<?php

session_start();

require_once '../query/utenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['signup_email'];
    $password = $_POST['signup_pass'];
    $password_confirm = $_POST['signup_pass_confirm'];

    if ($password !== $password_confirm) {
        $_SESSION['error'] = 'Le password non coincidono';
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/";

    if (!preg_match($pattern, $password)) {
        $_SESSION['error'] = "La password deve contenere almeno 8 caratteri, una maiuscola, una minuscola, un numero e un simbolo.";
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (!preg_match($pattern_email, $email)) {
        $_SESSION['error'] = "Formato email non valido";
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if (getUSer($email)) {
        $_SESSION['error'] = 'Utente già esistente';
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    if (setUser($email, $password_hashed)) {
        $_SESSION['success'] = 'Utente creato con successo';
        header('Location: ../../index.php?page=impostazioni');
        exit();
    } else {
        $_SESSION['error'] = 'Errore durante la creazione dell\'utente';
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
}
