<?php
echo "eco di prova 4";
session_start();

$page = $_GET['page'] ?? 'dashboard';

if (!isset($_SESSION['user'])) {
    $page = 'login';
}

$pagine_senza_permessi = ['login', 'dashboard','avvisi'];
$permessi_derivati = [
    'andamenti'  => 'previsioni',
    'ordini' => 'assemblaggiOrdine'
];

if(!in_array($page, $pagine_senza_permessi) && (!isset($_SESSION['permessi'][$page]) || !$_SESSION['permessi'][$page]) && 
(!isset($_SESSION['permessi'][$permessi_derivati[$page]]) || !$_SESSION['permessi'][$permessi_derivati[$page]])){
    header("Location: index.php?page=dashboard");
    exit();
}

$page_file = __DIR__ . "/frontend/" . $page . '/' . $page . '.php';

define('TITLE', 'SSM | ' . ucfirst($page));

require 'backend/model/database.php';

if ($page === 'assemblaggiOrdine') {
    require_once 'backend/query/ordini.php';
    if (empty($_GET['id_ordine']) || !getOrdineById($_GET['id_ordine'])) {
        header("Location: index.php?page=ordini");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="it">
    <?php
    include './frontend/head.php';
    if (file_exists($page_file) && $page!=='login') {
        echo "<body>";
        include './frontend/sidebar/sidebar.php';
        include './frontend/topbar/topbar.php';
        include($page_file);
        include './frontend/footer/footer.php';
        echo "</body>";
    } elseif ($page === 'login') {

        include($page_file);
    }else{
        include __DIR__. "/frontend/errori/404.php";
    }
    
    ?>
</html>


