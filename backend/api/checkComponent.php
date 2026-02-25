<?php
require_once '../query/componenti.php';
require_once '../model/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$qr = $data['qr'] ?? null;

if (!$qr) {
    echo json_encode(['success' => false]);
    exit;
}

$componente = getComponenteByQr($qr);

if (!$componente) {
    echo json_encode([
        'success' => false,
        'message' => 'QR sconosciuto'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'component_id' => $componente
]);