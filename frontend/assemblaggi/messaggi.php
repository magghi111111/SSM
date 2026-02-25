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
        case 'qr_error':
            $message = 'Il componente scansionato non è parte dell\'assemblaggio selezionato.';
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
        case 'input_error':
            $message = 'Dati mancanti o non validi. Assicurati di aver compilato tutti i campi e scansionato tutti i componenti.';
            break;
        case 'duplicate_error':
            $message = 'Errore: sono stati scansionati componenti duplicati. Assicurati di scansionare ogni componente una sola volta.';
            break;
    }
    $color = isset($success) && $success ? 'green' : 'red';
    echo "<p class='auto-hide' style='color: {$color};'>{$message}</p>";
}