<?php

function getAssemblaggi(){
    $pdo=connect();
    $sql="SELECT * 
    FROM assemblaggi a
    JOIN componenti c ON a.id_componente = c.id
    JOIN utenti u ON a.id_utente = u.id
    ORDER BY a.data_inizio DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setAssemblaggio($id_componente, $quantita, $id_utente, $note){
    $pdo = connect();

    $sql = "INSERT INTO assemblaggi 
            (id_componente, quantita, id_utente, note, data_inizio, data_fine) 
            VALUES 
            (:id_componente, :quantita, :id_utente, :note, NOW(), NULL);";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $id_componente,
        ':quantita' => $quantita,
        ':id_utente' => $id_utente,
        ':note' => $note
    ]);

    return $pdo->lastInsertId();
}

function chiudiAssemblaggio($id_assemblaggio){
    $pdo = connect();

    $sql = "UPDATE assemblaggi
            SET data_fine = NOW()
            WHERE id = :id
            AND data_fine IS NULL;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id_assemblaggio
    ]);

    return $stmt->rowCount();
}

?>