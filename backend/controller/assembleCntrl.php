<?php

require_once '../query/assemblaggi.php';
require_once '../query/componenti.php';
require_once '../query/movimenti.php';
require_once '../model/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $user_id = $_POST['user_id'] ?? null;
    $note = $_POST['note'] == '' ? 'Assemblaggio effettuato il '.date('Y-m-d H:i:s') : $_POST['note'];
    $assembly_type = $_POST['assembly_type'] ?? null;
    $componenti_qr = $_POST['componenti_qr'] ?? [];

    if(empty($componenti_qr) || !$assembly_type){
        setcookie('assemblaggio', 'input_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggi");
        exit();
    }

    if(count($componenti_qr) != count(array_unique($componenti_qr))){
        setcookie('assemblaggio', 'duplicate_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggi");
        exit();
    }

    foreach($componenti_qr as $componente_id => $qr_code){
        $id_componente = getComponenteByQR($qr_code);
        if(!$id_componente){
            setcookie('assemblaggio', 'component_error', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggi");
            exit();
        }
        if(checkStocks($id_componente, 1)){
            setcookie('assemblaggio', 'stock_error', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggi");
            exit();
        }
        if(checkAssembly($assembly_type, $id_componente)){
            setcookie('assemblaggio', 'qr_error', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggi");
            exit();
        }
    }

    $idAssemblaggio = setAssemblaggio($assembly_type, 1, $user_id, $note);
    if($idAssemblaggio){
        if(updateStockAssemblaggio($assembly_type, 1)){
            if(setMovimento($idAssemblaggio,$assembly_type, 1, 'ASSEMBLY',$note)){
                setcookie('assemblaggio', 'success', time() + 20, "/");
                header("Location: ../../index.php?page=assemblaggi");
            } else {
                setcookie('assemblaggio', 'movimento_error', time() + 20, "/");
                header("Location: ../../index.php?page=assemblaggi");
            }
        }
        else {
            setcookie('assemblaggio', 'stock_update_error', time() + 20, "/");
            header("Location: ../../index.php?page=assemblaggi");
        }
    }
    else {
        setcookie('assemblaggio', 'error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggi");
    }


}


?>