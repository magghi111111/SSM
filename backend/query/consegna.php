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

function getConsegne(){
    $pdo=connect();
    $sql = "SELECT c.id, f.nome AS fornitore, c.data_ordine, c.data_ricezione, c.note
            FROM consegna c
            JOIN fornitore f ON c.id_fornitore = f.id
            ORDER BY c.data_ordine DESC;";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDettagliConsegna($idConsegna){
    $pdo=connect();
    $sql = "SELECT rc.*, comp.nome,comp.unita_misura
            FROM righe_consegna rc
            JOIN componenti comp ON rc.id_componente = comp.id
            WHERE rc.id_consegna = :id_consegna;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_consegna' => $idConsegna]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>