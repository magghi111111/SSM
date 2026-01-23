<header class="header-wrapper">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <img src="frontend/img/scritta.png" class="topbar-logo">
        </div>

        <div class="topbar-right">
            <div class="user-menu">
                <img src="frontend/img/avatar.jpeg " class="avatar-logo">
                <span class="username"><?= $_SESSION['user'] ?? 'Utente' ?></span>
                <a href="backend/controller/logout.php" style="color: red;">Logout</a>
            </div>
        </div>
    </div>

    <!-- PAGE HEADING -->
    <div class="page-heading-wrapper">
        <h1 class="page-title"><?= ucfirst($page) ?></h1>
    </div>

</header>
