<?php

require_once '../model/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $idFornitore = $_POST['id_fornitore'] ?? null;
    if($idFornitore === 'new'){
        require_once '../query/fornitori.php';
        $idFornitore = setFornitore(
            $_POST['nome_fornitore'] ?? '',
            $_POST['email_fornitore'] ?? '',
            $_POST['telefono_fornitore'] ?? ''
        );
       
    }

    $dataOrdine    = $_POST['data_ordine'] ?? null;
    $dataRicezione = $_POST['data_ricezione'] ?? null;

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

    require_once '../query/consegna.php';

    $idConsegna = setConsegna($idFornitore, $dataOrdine, $dataRicezione, $note, $componenti);

    if($idConsegna){
        header("Location: ../../index.php?page=consegne&status=success");
    } else {
        header("Location: ../../index.php?page=consegne&status=error");
    }

}
