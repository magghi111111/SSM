<?php
require_once __DIR__ . '/../model/database.php';

$conn = connect();

$tipo = $_GET['tipo'] ?? '';
$anno = $_GET['anno'] ?? date('Y');

switch ($tipo) {

    case 'ordini':
        $sql = "
            SELECT 
                DATE_FORMAT(data_creazione, '%Y-%m') AS mese,
                COUNT(*) AS totale
            FROM ordini
            WHERE YEAR(data_creazione) = :anno
            GROUP BY mese
            ORDER BY mese
        ";
        break;

    case 'consegne':
        $sql = "
            SELECT 
                DATE_FORMAT(data_ricezione, '%Y-%m') AS mese,
                COUNT(*) AS totale
            FROM consegna
            WHERE data_ricezione IS NOT NULL
              AND YEAR(data_ricezione) = :anno
            GROUP BY mese
            ORDER BY mese
        ";
        break;

    case 'tempo_assemblaggio':
        $sql = "
            SELECT 
                c.nome AS prodotto,
                AVG(TIMESTAMPDIFF(MINUTE, a.data_inizio, a.data_fine)) AS tempo_medio
            FROM assemblaggi a
            JOIN componenti c ON c.id = a.id_componente
            WHERE a.data_fine IS NOT NULL
            AND YEAR(a.data_inizio) = :anno
            GROUP BY c.nome
            ORDER BY tempo_medio DESC
        ";
        break;

    default:
        http_response_code(400);
        echo json_encode(["error" => "Tipo grafico non valido"]);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->execute([':anno' => $anno]);

$dati = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dati);
?>