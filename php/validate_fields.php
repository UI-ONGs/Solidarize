<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $field = $data['field'] ?? '';
    $value = $data['value'] ?? '';

    if (empty($field) || empty($value)) {
        echo json_encode(['isUnique' => false, 'message' => 'Entrada inválida']);
        exit;
    }

    // valida os campos para impedir injeções
    $allowedFields = ['username', 'email', 'cnpj'];
    if (!in_array($field, $allowedFields)) {
        echo json_encode(['isUnique' => false, 'message' => 'Campo inválido']);
        exit;
    }

    // verifica se os valores são únicos
    try {
        if ($field === 'cnpj') {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM INSTITUICAO WHERE cnpj = :value");
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM USUARIO WHERE $field = :value");
        }
        
        $stmt->execute([':value' => $value]);
        $count = $stmt->fetchColumn();

        echo json_encode(['isUnique' => ($count === 0), 'field' => $field, 'value' => $value]);
    } catch (PDOException $e) {
        error_log("Erro ao validar campo: " . $e->getMessage());
        echo json_encode(['isUnique' => false, 'message' => 'Erro ao validar campo']);
    }
} else {
    echo json_encode(['isUnique' => false, 'message' => 'Método de requisição inválido']);
}