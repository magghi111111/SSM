<?php
session_start();
require_once '../query/avvisi.php';
require_once '../model/database.php';
header('Content-Type: application/json');
echo json_encode(['count' => countAvvisiByRuolo($_SESSION['role'])]);