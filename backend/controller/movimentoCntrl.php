<?php
session_start();
require_once '../model/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_componente   = $_POST['id_componente'] ?? null;
    if($id_componente === 'new'){
        require_once '../query/componenti.php';
        if(checkComponenteExists($_POST['sku'], $_POST['nome_componente'], $_POST['qrcode'])){
            setcookie('aggiunta_componente', 'exists', time() + 5, "/");
            header("Location: ../../index.php?page=magazzino");
            exit;
        }
        $id_componente = setComponente(
            $_POST['sku'] ?? '',
            $_POST['nome_componente'] ?? '',
            $_POST['unita_misura'] ?? '',
            $_POST['qrcode'] ?? '',
            $_POST['tipo']
        );
    }
    $_POST['delta'] ?? 0;
    $_POST['note'] ?? 'Nessuna nota';

    require_once '../query/movimenti.php';

    $idMovimento = setMovimento(null,$id_componente, $_POST['delta'],'MANUAL',$_POST['note']);
    setStock($id_componente, $_POST['delta']);

    if($idMovimento){
        setcookie('aggiunta_componente', 'success', time() + 5, "/");
        header("Location: ../../index.php?page=magazzino");
    } else {
        setcookie('aggiunta_componente', 'error', time() + 5, "/");
        header("Location: ../../index.php?page=magazzino");
    }
}


?>