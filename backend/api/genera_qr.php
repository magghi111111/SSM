<?php
header('Content-Type: application/json');

// Tipi ammessi
$allowedTypes = ['RAW', 'ASSEMBLY'];

$tipo = $_GET['tipo'] ?? null;

if (!$tipo || !in_array($tipo, $allowedTypes)) {
    echo json_encode([
        'success' => false,
        'error' => 'Tipo non valido'
    ]);
    exit;
}

// UUID v4
function uuidv4() {
    $data = random_bytes(16);

    // Set versione a 0100
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    // Set variante a 10
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$uuid = uuidv4();
$qrCode = $tipo . '-' . $uuid;

echo json_encode([
    'success' => true,
    'qr' => $qrCode
]);
?>