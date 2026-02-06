<?php
session_start();
require_once '../model/database.php';
require_once '../query/componenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(checkComponenteExists($_POST['assembly_sku'], $_POST['assembly_nome'], $_POST['assembly_qrcode'])){
        setcookie('assembly', 'exists', time() + 20, "/");
        header("Location: ../../index.php?page=magazzino");
        exit();
    }

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

    $idAssembly = setComponente($sku, $nome, $unita, $qrcode, 'ASSEMBLY');

    foreach ($componenti as $comp) {
        setAssemblyComponente($idAssembly, $comp['id'], $comp['qta']);
    }
    if($idAssembly){
        setcookie('assembly', 'success', time() + 20, "/");
        header("Location: ../../index.php?page=magazzino");
    } else {
        setcookie('assembly', 'error', time() + 20, "/");
        header("Location: ../../index.php?page=magazzino&assembly=error");
    }

}


?>