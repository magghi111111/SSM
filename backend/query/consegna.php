<?php

function setConsegna($idFornitore, $dataOrdine, $dataRicezione, $note, $componenti): int {
    $pdo=connect();
    $sql = "INSERT INTO consegna (id_fornitore, data_ordine, data_ricezione, note) 
            VALUES (:id_fornitore, :data_ordine, :data_ricezione, :note);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_fornitore'   => $idFornitore,
        ':data_ordine'    => $dataOrdine,
        ':data_ricezione' => $dataRicezione,
        ':note'           => $note
    ]);
    $idConsegna = $pdo->lastInsertId();

    $sqlDettagli = "INSERT INTO righe_consegna (id_consegna, id_componente, qta_ricevuta) 
                    VALUES (:id_consegna, :id_componente, :quantita);";
    $stmtDettagli = $pdo->prepare($sqlDettagli);

    foreach ($componenti as $componente) {
        $stmtDettagli->execute([
            ':id_consegna'   => $idConsegna,
            ':id_componente' => $componente['id'],
            ':quantita'      => $componente['qta']
        ]);
    }

    return $idConsegna;
}

?>