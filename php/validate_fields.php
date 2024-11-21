<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $field = $data['field'] ?? '';
    $value = $data['value'] ?? '';

    if (empty($field) || empty($value)) {
        echo json_encode(['isUnique' => false, 'message' => 'Invalid input']);
        exit;
    }

    // Whitelist allowed fields to prevent SQL injection
    $allowedFields = ['username', 'email', 'cnpj'];
    if (!in_array($field, $allowedFields)) {
        echo json_encode(['isUnique' => false, 'message' => 'Invalid field']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM USUARIO WHERE $field = :value");
        $stmt->execute([':value' => $value]);
        $count = $stmt->fetchColumn();

        echo json_encode(['isUnique' => ($count === 0), 'field' => $field, 'value' => $value]);
    } catch (PDOException $e) {
        error_log("Error validating field: " . $e->getMessage());
        echo json_encode(['isUnique' => false, 'message' => 'Error validating field']);
    }
} else {
    echo json_encode(['isUnique' => false, 'message' => 'Invalid request method']);
}