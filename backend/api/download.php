<?php
$baseDir = '../../qr/';
$fileName = basename($_GET['qr'] ?? '');
$filePath = $baseDir . $fileName . '.png';

if (!$fileName || !file_exists($filePath)) {
    http_response_code(404);
    exit('File non valido');
}

/* HEADER PER DOWNLOAD */
header('Content-Description: File Transfer');
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="' . $fileName . '.png"');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: public');

readfile($filePath);
exit;
?>
