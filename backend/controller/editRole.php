<?php

require_once '../model/database.php';
require_once '../query/utenti.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_ruolo = $_POST['id_ruolo'] ?? null;
    if(!$id_ruolo || !getRuoloById($id_ruolo)){
        setcookie('edit_role_error', 'ID ruolo mancante o non valido.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    $permessiSelezionati = $_POST['permessi'] ?? [];

    if(empty($permessiSelezionati)){
        setcookie('edit_role_error', 'Seleziona almeno un permesso.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if(count($permessiSelezionati) === 1 && $permessiSelezionati[0] === 'impostazioni'){
        setcookie('edit_role_error', 'Il permesso impostazioni non può essere assegnato da solo.', time() + 5, '/');
        header('Location: ../../index.php?page=impostazioni');
        exit();
    }

    if(in_array('inserimenti_nuovi', $permessiSelezionati)){
        if(!in_array('magazzino', $permessiSelezionati) || !in_array('consegne', $permessiSelezionati)){
            setcookie('edit_role_error', 'Inserimenti richiede anche i permessi Magazzino e Consegne.', time() + 5, '/');
            header('Location: ../../index.php?page=impostazioni');
            exit();
        }
    }

    if(in_array('ordini', $permessiSelezionati)){
        if(!in_array('assemblaggi', $permessiSelezionati)){
            setcookie('edit_role_error', 'Ordini richiede anche il permesso Assemblaggi.', time() + 5, '/');
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
        $valori[$p] = in_array($p, $permessiSelezionati) ? 1 : 0;
    }

    if(!editRole($id_ruolo, $valori)){
        setcookie('edit_role_error', 'Errore nell\'aggiornamento del ruolo.', time() + 5, '/');
    }

    header('Location: ../../index.php?page=impostazioni');
    exit();

}

?>