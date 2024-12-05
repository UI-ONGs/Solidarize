<?php
require_once 'config.php';

$query = $_GET['q'] ?? '';

if (empty($query)) {
    echo json_encode([]);
    exit;
}

// seleciona 10 atividades de uma instituição
$stmt = $pdo->prepare("
    SELECT 'instituicao' as tipo, i.usuario_id as id, u.nome
    FROM INSTITUICAO i
    JOIN USUARIO u ON i.usuario_id = u.id
    WHERE u.nome LIKE :query OR i.descricao LIKE :query
    UNION
    SELECT 'atividade' as tipo, a.id, a.titulo as nome
    FROM ATIVIDADE a
    WHERE a.titulo LIKE :query OR a.descricao LIKE :query
    LIMIT 10
");

$queryParam = "%{$query}%";
$stmt->bindParam(':query', $queryParam, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>