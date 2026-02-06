<?php

require_once '../model/database.php';
require_once '../query/consegna.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $idFornitore = $_POST['id_fornitore'] ?? null;
    if($idFornitore === 'new'){
        require_once '../query/fornitori.php';
        if(checkFornitoreExists($_POST['email_fornitore'], $_POST['telefono_fornitore'])){
            setcookie('consegna', 'fornitore_exists', time() + 20, "/");
            header("Location: ../../index.php?page=consegne");
            exit;
        }
        $idFornitore = setFornitore(
            $_POST['nome_fornitore'] ?? '',
            $_POST['email_fornitore'] ?? '',
            $_POST['telefono_fornitore'] ?? ''
        );
       
    }

    $dataOrdine    = $_POST['data_ordine'] ?? null;
    $dataRicezione = $_POST['data_ricezione'] ?? null;

    if($dataOrdine>$dataRicezione){
        setcookie('consegna', 'date_error', time() + 20, "/");
        header("Location: ../../index.php?page=consegne");
        exit;
    }

    $note = $_POST['note'] ?? 'Nessuna nota';

    $componentiPost = $_POST['componenti'] ?? [];
    $ids = $componentiPost['id']  ?? [];
    $qta = $componentiPost['qta'] ?? [];
    $componenti = [];
    for ($i = 0; $i < count($ids); $i++) {
        if (!empty($ids[$i]) && !empty($qta[$i])) {
            $componenti[] = [
                'id'  => (int)$ids[$i],
                'qta' => (int)$qta[$i]
            ];
        }
    }

    $idConsegna = setConsegna($idFornitore, $dataOrdine, $dataRicezione, $note, $componenti);

    if($idConsegna){
        setcookie('consegna', 'success', time() + 20, "/");
        header("Location: ../../index.php?page=consegne");
    } else {
        setcookie('consegna', 'error', time() + 20, "/");
        header("Location: ../../index.php?page=consegne");
    }

}
