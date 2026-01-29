<?php

require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_componente   = $_POST['id_componente'] ?? null;
    if($id_componente === 'new'){
        require_once '../query/componenti.php';
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

    $idMovimento = setMovimento($id_componente, $_POST['delta'], $_POST['note']);
    setStock($id_componente, $_POST['delta']);

    if($idMovimento){
        header("Location: ../../index.php?page=magazzino&aggiunta=success");
    } else {
        header("Location: ../../index.php?page=magazzino&aggiunta=error");
    }
}


?>