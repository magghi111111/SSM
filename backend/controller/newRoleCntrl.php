<?php

session_start();

if($_SESSION['role'] != 'ADMIN'){
    header('Location: ../../index.php');
    exit();
}

require_once '../model/database.php';
require_once '../query/utenti.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nome = strtoupper($_POST['ruolo']);
    $permessiSelezionati = $_POST['permessi'] ?? [];

    if(empty($permessiSelezionati)){
        setcookie('role_error', 'Seleziona almeno un permesso.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    // ❌ solo impostazioni
    if(count($permessiSelezionati) === 1 && $permessiSelezionati[0] === 'impostazioni'){
        setcookie('role_error', 'Il permesso impostazioni non può essere assegnato da solo.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    // ❌ inserimenti senza dipendenze
    if(in_array('inserimenti_nuovi', $permessiSelezionati)){
        if(!in_array('magazzino', $permessiSelezionati) || !in_array('consegne', $permessiSelezionati)){
            setcookie('role_error', 'Inserimenti richiede anche i permessi Magazzino e Consegne.', time() + 5, '/');
            header('Location: ../../index.php?page=impostazioni');
            exit();
        }
    }

    // ❌ ordini senza assemblaggi
    if(in_array('ordini', $permessiSelezionati)){
        if(!in_array('assemblaggi', $permessiSelezionati)){
            setcookie('role_error', 'Ordini richiede anche il permesso Assemblaggi.', time() + 5, '/');
            header('Location: ../../index.php?page=impostazioni');
            exit();
        }
    }

    $permessi = [
        "magazzino",
        "inserimenti_nuovi",
        "ordini",
        "consegne",
        "assemblaggi",
        "movimenti",
        "andamenti",
        "acquisti",
        "impostazioni"
    ];

    $valori = [];

    foreach($permessi as $p){
        if(in_array($p, $permessiSelezionati)){
            $valori[$p] = 1;
        }else{
            $valori[$p] = 0;
        }
    }

    if(setRole($nome, $valori)){
        setcookie('role_success', 'Ruolo aggiunto con successo!', time() + 5, '/');
    }else{
        setcookie('role_error', 'Errore durante l\'aggiunta del ruolo.', time() + 5, '/');
    }

    header('Location: ../../index.php?page=impostazioni');
    exit();
}   