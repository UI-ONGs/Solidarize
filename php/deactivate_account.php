<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

requireLogin();

$userId = $_SESSION['user_id'];

//pega o id do usuário logado e realiza um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // troca o status da conta de ativo para inativo
        $stmt = $pdo->prepare("UPDATE USUARIO SET status = 'INATIVO', updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$userId]);
        
        if ($result) {
            // Realiza o logout depois de desativar a conta
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Conta desativada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao desativar conta.']);
        }
    // caso dê algum erro, pega a exceção
    } catch (Exception $e) {
        error_log("Error deactivating account: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro ao desativar conta: ' . $e->getMessage()]);
    }
} else {
    // caso o método não seja permitido
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

