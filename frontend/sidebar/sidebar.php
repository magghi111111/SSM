<!-- HEADER -->
<?php

require_once 'backend/controller/roleCntrl.php';

?>

<aside class="sidebar d-flex flex-column justify-content-between">
    <div>
        <img id="sidebar-logo">

        <!-- PARTE ALTA -->
        <ul class="nav nav-pills flex-column gap-1">
            <?php foreach ($menu as $pagina => $icona): ?>
                <?php $pageSlug = lcfirst($pagina); ?>
                <li class="nav-item">
                    <a href="?page=<?= $pageSlug ?>"
                       class="nav-link d-flex align-items-center gap-2 <?= ($page === $pageSlug) ? 'active' : '' ?>">
                        
                        <i class="bi bi-<?= $icona ?>"></i>
                        <?= $pagina ?>

                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- PARTE BASSA -->
        <ul class="nav nav-pills flex-column gap-1 mb-3">
            <?php foreach ($bottomMenu as $pagina => $icona): ?>
                <?php $pageSlug = lcfirst($pagina); ?>
                <li class="nav-item">
                    <a href="?page=<?= $pageSlug ?>"
                    class="nav-link d-flex align-items-center gap-2 <?= ($page === $pageSlug) ? 'active' : '' ?>">
                        <i class="bi bi-<?= $icona ?>"></i>
                        <?= $pagina ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
</aside>
