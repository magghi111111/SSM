<?php

// prendere i messaggi dai cookie e mostrarli
if(isset($_COOKIE['assemblaggio'])){
    $message = '';
    switch ($_COOKIE['assemblaggio']) {
        case 'success':
            $message = 'Assemblaggio registrato con successo!';
            $success = true;
            break;
        case 'error':
            $message = 'Errore durante la registrazione dell\'assemblaggio.';
            break;
        case 'component_error':
            $message = 'Componente non trovato. Assicurati di aver scansionato un QR valido.';
            break;
        case 'stock_error':
            $message = 'Quantità richiesta supera lo stock disponibile.';
            break;
        case 'movimento_error':
            $message = 'Assemblaggio registrato, ma errore durante la registrazione del movimento.';
            break;
        case 'stock_update_error':
            $message = 'Assemblaggio registrato, ma errore durante l\'aggiornamento dello stock.';
            break;
    }
    $color = isset($success) && $success ? 'green' : 'red';
    echo "<p class='auto-hide' style='color: {$color};'>{$message}</p>";
}