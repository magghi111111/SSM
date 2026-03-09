<?php


$menu = [
    'Dashboard'   => 'speedometer2',
    'Magazzino'   => 'box-seam',
    'Ordini'      => 'cart3',
    'Consegne'    => 'truck',
    'Assemblaggi' => 'tools',
    'Movimenti'   => 'terminal',
    'Andamenti'   => 'bar-chart'
];
$bottomMenu = [
    'Impostazioni'=> 'gear'
];

if(isset($_SESSION['permessi']) && is_array($_SESSION['permessi'])){
    foreach ($_SESSION['permessi'] as $pagina => $permesso) {
        if (!$permesso && $pagina!='inserimenti_nuovi') {
            unset($menu[ucfirst($pagina)]);
        }
    }
}
if(!isset($_SESSION['permessi']['impostazioni']) || !$_SESSION['permessi']['impostazioni']){
    echo $_SESSION['permessi']['impostazioni'];
    unset($bottomMenu['Impostazioni']);
}

?>