<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

requireLogin();

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE USUARIO SET status = 'INATIVO', updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$userId]);
        
        if ($result) {
            // Logout the user after deactivating
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Conta desativada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao desativar conta.']);
        }
    } catch (Exception $e) {
        error_log("Error deactivating account: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro ao desativar conta: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

