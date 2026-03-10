<?php

require_once '../model/database.php';
require_once '../query/utenti.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(!isset($_GET['delete_id']) || $_GET['delete_id']==='' || $_GET['delete_id'] === '1'){
        setcookie("delete_user_error", "ID utente mancante o non valido", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
    if(!getUserById($_GET['delete_id'])){
        setcookie("delete_user_error", "Ruolo non trovato", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if(!eliminaUtente($_GET['delete_id'])){
        setcookie("delete_user_error", "Errore durante l'eliminazione dell'utente", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }else{
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
}

?>