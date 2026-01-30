<?php

require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sku  = $_POST['assembly_sku'] ?? null;
    $nome = $_POST['assembly_nome'] ?? null;
    $unita= $_POST['assembly_unita'] ?? null;
    $qrcode = $_POST['assembly_qrcode'] ?? null;

    // Componenti RAW
    $componenti_id  = $_POST['componenti']['id'] ?? [];
    $componenti_qta = $_POST['componenti']['qta'] ?? [];
    $componenti = [];
    for ($i = 0; $i < count($componenti_id); $i++) {
        $componenti[] = [
            'id' => $componenti_id[$i],
            'qta'=> $componenti_qta[$i]
        ];
    }

    require_once '../query/componenti.php';

    $idAssembly = setComponente($sku, $nome, $unita, $qrcode, 'ASSEMBLY');

    foreach ($componenti as $comp) {
        setAssemblyComponente($idAssembly, $comp['id'], $comp['qta']);
    }
    if($idAssembly){
        header("Location: ../../index.php?page=magazzino&assembly=success");
    } else {
        header("Location: ../../index.php?page=magazzino&assembly=error");
    }

}


?>