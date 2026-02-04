<?php
session_start();
$page = $_GET['page'] ?? 'dashboard';
if (!isset($_SESSION['user'])) {
    $page = 'login';
}
$page_file = __DIR__ . "/frontend/" . $page . '/' . $page . '.php';

require 'backend/model/database.php';

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
