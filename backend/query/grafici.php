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
        $bind = [':anno' => $anno];
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
        $bind = [':anno' => $anno];
        break;


    case 'tempo_preparazione':

        $sql = "
            SELECT 
                DATE_FORMAT(data_assemblaggio, '%Y-%m') AS mese,

                ROUND(
                    AVG(
                        TIMESTAMPDIFF(
                            MINUTE,
                            data_creazione,
                            data_assemblaggio
                        )
                    ), 2
                ) AS totale

            FROM ordini

            WHERE stato = 'PREPARED'
            AND data_assemblaggio IS NOT NULL
            AND YEAR(data_assemblaggio) = :anno

            GROUP BY mese
            ORDER BY mese
        ";

        $bind = [':anno' => $anno];

        break;


    default:
        http_response_code(400);
        echo json_encode(["error" => "Tipo grafico non valido"]);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->execute($bind);

$dati = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dati);