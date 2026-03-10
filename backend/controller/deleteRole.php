<?php

require_once '../model/database.php';
require_once '../query/utenti.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(!isset($_GET['delete_id']) || $_GET['delete_id']==='' || $_GET['delete_id'] === '1'){
        setcookie("delete_role_error", "ID ruolo mancante o non valido", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
    if(!getRuoloById($_GET['delete_id'])){
        setcookie("delete_role_error", "Ruolo non trovato", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if(!eliminaRuolo($_GET['delete_id'])){
        setcookie("delete_role_error", "Errore durante l'eliminazione del ruolo", time() + 5, "/");
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }else{
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }
}

?>