<?php

require_once 'backend/query/avvisi.php';
require_once 'backend/query/componenti.php';
require_once 'backend/query/utenti.php';

$stock = getStockTotale();
$ordini = getAllOrdini();

foreach ($ordini as $ordine) {
    if($ordine['stato'] == 'PREPARED'){
        if(getAvvisoByTitolo("Ordine #{$ordine['id_shopify']} in attesa da più di 3 giorni")){
            deleteAvvisoByTitolo("Ordine #{$ordine['id_shopify']} in attesa da più di 3 giorni");
        }
        continue;
    }
    // verifica se l'ordine può essere preparato
    $stockTemp = $stock;
    if(checkDisponibilitaComponenti($ordine['id'], $stockTemp)){
        $stock = $stockTemp;
        setStatoOrdine($ordine['id'], 'PENDING');
        if($ordine['stato'] === 'OUT_OF_STOCK'){
            deleteAvvisoByOrderId($ordine['id']);
        }
    }else{
        setStatoOrdine($ordine['id'], 'OUT_OF_STOCK');
        if($ordine['stato'] != 'OUT_OF_STOCK'){
            $ruoli = getRuoliOrdini();
            setAvviso("Ordine #{$ordine['id_shopify']} in attesa di componenti", "L'ordine #{$ordine['id_shopify']} è in attesa di componenti. Verificare lo stock e preparare l'ordine.", "ALTO", $ordine['id'], null, $ruoli);
        }
    }

    //avvisi per ordini in pending da più di 3 giorni
    if($ordine['data_creazione'] < date('d-m-Y', strtotime('-3 days')) && !getAvvisoByTitolo("Ordine #{$ordine['id_shopify']} in attesa da più di 3 giorni")){
        $ruoli = getRuoliOrdini();
        setAvviso("Ordine #{$ordine['id_shopify']} in attesa da più di 3 giorni", "L'ordine #{$ordine['id_shopify']} è in attesa da più di 3 giorni. Verificare lo stato dell'ordine e prepararlo.", "MEDIO", $ordine['id'], null, $ruoli);
    }
}

$ordidni_da_evadere = getOrdiniDaProcessare();
if($ordidni_da_evadere > 5 && !getAvvisoByTitolo("Alto numero di ordini da evadere")) {
    $ruoli = getRuoliOrdini();
    setAvviso("Alto numero di ordini da evadere", "Ci sono attualmente {$ordidni_da_evadere} ordini da evadere. Verificare lo stato degli ordini e preparare quelli in attesa.", "MEDIO", null, null, $ruoli);
}else if(getAvvisoByTitolo("Alto numero di ordini da evadere") && $ordidni_da_evadere <= 5){
    deleteAvvisoByTitolo("Alto numero di ordini da evadere");
}


?>