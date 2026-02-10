<?php

require_once '../query/assemblaggi.php';
require_once '../query/componenti.php';
require_once '../query/movimenti.php';
require_once '../model/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $qr_code = $_POST['assembly_qr'] ?? null;
    $id_componente = getComponenteByQR($qr_code);
    if(!$id_componente){
        setcookie('assemblaggio', 'component_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggi");
        exit();
    }

    $qty = $_POST['qty'] ?? null;
    if(checkStocks($id_componente, $qty)){
        setcookie('assemblaggio', 'stock_error', time() + 20, "/");
        header("Location: ../../index.php?page=assemblaggi");
        exit();
    }

    $user_id = $_POST['user_id'] ?? null;
    $note = $_POST['note'] ?? null;

    $idAssemblaggio = setAssemblaggio($id_componente, $qty, $user_id, $note);
    if($idAssemblaggio){
        if(updateStockAssemblaggio($id_componente, $qty)){
            if(setMovimento($idAssemblaggio,$id_componente, $qty, 'ASSEMBLY',$note)){
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