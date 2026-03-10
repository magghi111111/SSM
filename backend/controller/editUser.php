<?php

require_once '../model/database.php';
require_once '../query/utenti.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_user = $_POST['id_user'] ?? null;
    if(!$id_user || !getUserById($id_user)){
        setcookie('edit_user_error', 'ID utente mancante o non valido.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit;
    }

    $email = $_POST['email'] ?? null;
    $ruolo = $_POST['ruolo'] ?? null;

    if(!$email || !$ruolo){
        setcookie('edit_user_error', 'Email e ruolo sono obbligatori.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit;
    }

    $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (!preg_match($pattern_email, $email)) {
        setcookie("edit_user_error", "Formato email non valido", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if(getUser($email) && getUser($email)['uid'] != $id_user){
        setcookie('edit_user_error', 'Email già in uso da un altro utente.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit;
    }

    if(!getRuoloById($ruolo) || $ruolo==1){
        setcookie('edit_user_error', 'Ruolo non valido.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit;
    }

    if(!editUser($id_user, $email, $ruolo)){
        setcookie('edit_user_error', 'Errore durante l\'aggiornamento dell\'utente.', time() + 5, '/');
    }

    header('Location: ../../index.php?page=impostazioni');
    exit;

}
?>