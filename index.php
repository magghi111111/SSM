<?php
session_start();
$page = $_GET['page'] ?? 'login';
// if (!isset($_SESSION['user']) && $page !== 'login') {
//     $page = 'login';
// }
$page_file = __DIR__ . "/frontend/" . $page . '/' . $page . '.php';

require 'backend/model/database.php';

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="frontend/stile.css">
</head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<body>

    <?php
    
    if (file_exists($page_file) && $page!=='login') {
        include './frontend/sidebar/sidebar.php';
        include './frontend/topbar/topbar.php';
        include($page_file);
        include './frontend/footer/footer.php';
    } elseif ($page === 'login') {
        include($page_file);
    }else{
        include __DIR__. "/frontend/errori/404.php";
    }
    
    ?>

</body>

</html>