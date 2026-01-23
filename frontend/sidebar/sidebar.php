<!-- HEADER -->
<?php
$menu = [
    'Dashboard'   => 'speedometer2',
    'Magazzino'   => 'box-seam',
    'Ordini'      => 'bi bi-cart3',
    'Consegne'    => 'truck',
    'Assemblaggi' => 'tools',
    'Movimenti'   => 'bi bi-terminal',
    'Andamenti'   => 'bi bi-bar-chart'
];
?>

<aside class="sidebar d-flex flex-column justify-content-between">
    <div>
        <img src="frontend/img/logo.jpg" class="sidebar-logo">

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
</aside>
