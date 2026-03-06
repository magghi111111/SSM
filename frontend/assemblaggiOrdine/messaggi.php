<?php

// prendere i messaggi dai cookie e mostrarli
if(isset($_COOKIE['ordine'])){
    $message = '';
    switch ($_COOKIE['ordine']) {
        case 'input_error':
            $message = 'Dati mancanti o non validi. Assicurati di aver compilato tutti i campi e scansionato tutti i componenti.';
            break;
        case 'component_error':
            $message = 'Componente non riconosciuto. Verifica che il QR code sia corretto e appartenga a un componente valido.';
            break;
        case 'movimento_error':
            $message = 'Errore durante la registrazione del movimento. Riprova più tardi.';
            break;
        case 'update_error':
            $message = 'Errore durante l\'aggiornamento dello stato dell\'ordine. Riprova più tardi.';
            break;
        case 'success':
            $message = 'Ordine assemblato con successo!';
            break;
    }
    $color = isset($success) && $success ? 'green' : 'red';
    echo "<p class='auto-hide' style='color: {$color};'>{$message}</p>";
}