<?php

session_start();

require_once '../query/ordini.php';
require_once '../query/componenti.php';
require_once '../query/movimenti.php';
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ordine = $_POST['id_ordine'] ?? null;
    $componenti_finali = $_POST['componenti_finali'] ?? [];

    foreach ($componenti_finali as $assembly) {
        foreach ($assembly as $qr) {
            if (empty($qr)) {
                setcookie('ordine', 'input_error', time() + 20, "/");
                header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
                exit();
            }
        }
    }

    foreach ($componenti_finali as $id_componente => $qrList) {
        foreach ($qrList as $qr) {
            if($qr == 'ASSEMBLY'){
                $componenti_assemblati[] = $id_componente;
                continue;
            }
            $componente = getComponenteByQR($qr);
            if (!$componente || $componente!= $id_componente) {
                setcookie('ordine', 'component_error', time() + 20, "/");
                header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
                exit();
            }
            setStock($componente, -1);
        }
    }

    if(!$id_ordine){
        setcookie('ordine', 'input_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
        exit();
    }elseif(setStatoOrdine($id_ordine,'PREPARED')){
        if(setMovimentoOrdine($id_ordine, 'Ordine preparato da'.$_SESSION['user'])){
            if(!empty($componenti_assemblati)){
                foreach($componenti_assemblati as $id_componente){
                    if(!setMovimento(null, $id_componente, -1, 'ASSEMBLY', 'Componente assemblato per ordine '.$id_ordine)){
                        setcookie('ordine', 'movimento_error', time() + 20, "/");
                        header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
                        exit();
                    }
                }
            }
            setcookie('ordine', 'success', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
        } else {
            setcookie('ordine', 'movimento_error', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");
        }
    } else {
        setcookie('ordine', 'update_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggiOrdine&id_ordine=$id_ordine");

    }

}
