<?php

function getUltimiMovimenti(){
    $pdo=connect();
    $sql = "SELECT delta, data_movimento, tipo, note
        from movimenti
        ORDER BY data_movimento DESC
        LIMIT 3;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMovimenti($filters = []) {
    $pdo = connect();

    $where = [];
    $params = [];

    /* ===== FILTRO TIPO ===== */
    if (!empty($filters['tipo'])) {
        $placeholders = implode(',', array_fill(0, count($filters['tipo']), '?'));
        $where[] = "m.tipo IN ($placeholders)";
        $params = array_merge($params, $filters['tipo']);
    }

    /* ===== FILTRO COMPONENTI ===== */
    if (!empty($filters['componenti'])) {
        $placeholders = implode(',', array_fill(0, count($filters['componenti']), '?'));
        $where[] = "m.id_componente IN ($placeholders)";
        $params = array_merge($params, $filters['componenti']);
    }

    $sql = "
        SELECT
            m.tipo,
            m.delta,
            m.data_movimento,
            m.note,
            c.nome
        FROM movimenti m
        left JOIN componenti c ON c.id = m.id_componente
    ";

    if ($where) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    /* ===== ORDINAMENTO ===== */
    $allowedOrder = [
        'tipo' => 'm.tipo',
        'data' => 'm.data_movimento',
        'nome' => 'c.nome'
    ];

    if (!empty($filters['order']) && isset($allowedOrder[$filters['order']])) {
        $sql .= " ORDER BY " . $allowedOrder[$filters['order']].", m.data_movimento DESC";
    } else {
        $sql .= " ORDER BY m.data_movimento DESC";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getDistinctComponenti() {
    $pdo=connect();
    $sql = "SELECT distinct c.id,c.nome
            FROM movimenti m
            JOIN componenti c ON m.id_componente = c.id
            ORDER BY c.nome DESC;";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setMovimento($idAssemblaggio,$idComponente, $delta, $tipo, $note){
    $pdo=connect();
    $sql = "INSERT INTO movimenti ( id_assemblaggio,id_componente, delta, tipo, note) 
            VALUES (:id_assemblaggio,:id_componente, :delta,:tipo, :note);";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id_assemblaggio'=> $idAssemblaggio,
        ':id_componente' => $idComponente,
        ':delta'         => $delta,
        ':tipo'          => $tipo,
        ':note'          => $note
    ]);
}


function setMovimentoConsegna($idConsegna,$idComponente, $delta, $tipo, $note){
    $pdo=connect();
    $sql = "INSERT INTO movimenti ( id_consegna,id_componente, delta, tipo, note) 
            VALUES (:id_consegna,:id_componente, :delta,:tipo, :note);";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id_consegna'   => $idConsegna,  
        ':id_componente' => $idComponente,
        ':delta'         => $delta,
        ':tipo'          => $tipo,
        ':note'          => $note
    ]);
}

function setStock($idComponente, $delta){
    $pdo=connect();
    $sql = "UPDATE stock 
            SET quantita = quantita + :qta 
            WHERE id_componente = :id_componente;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_componente' => $idComponente,
        ':qta'           => $delta
    ]);
}


?>