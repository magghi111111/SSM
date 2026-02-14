<?php

session_start();

require_once '../query/utenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['signup_email'];
    $password = $_POST['signup_pass'];
    $password_confirm = $_POST['signup_pass_confirm'];

    if ($password !== $password_confirm) {
        setcookie("signup_error", "Le password non coincidono", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/";

    if (!preg_match($pattern, $password)) {
        setcookie("signup_error", "La password deve contenere almeno 8 caratteri, una maiuscola, una minuscola, un numero e un simbolo.", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (!preg_match($pattern_email, $email)) {
        setcookie("signup_error", "Formato email non valido", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if (getUSer($email)) {
        setcookie("signup_error", "Utente già esistente", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    if (setUser($email, $password_hashed)) {
        setcookie("signup_success", "Utente creato con successo", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    } else {
        setcookie("signup_error", "Errore durante la creazione dell'utente", time() + 20, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
}
