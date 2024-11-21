<?php
session_start();
require_once 'php/config.php';

function ShowMessage($message, $isError = false) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => !$isError,
        'message' => $message
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $stayConnected = $data['stayConnected'] ?? false;

    if (empty($email) || empty($password)) {
        ShowMessage("Por favor, preencha todos os campos.", true);
    }

    try {
        if (!isset($pdo) || !($pdo instanceof PDO)) {
            throw new Exception("Database connection not established.");
        }

        $stmt = $pdo->prepare("SELECT * FROM USUARIO WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare the SQL statement.");
        }
        
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            if ($stayConnected) {
                // For "Manter conectado", set a long-lasting session
                ini_set('session.cookie_lifetime', 30 * 24 * 60 * 60); // 30 days
                session_regenerate_id(true);
            } else {
                // For normal login, set session to expire when browser closes
                ini_set('session.cookie_lifetime', 0);
                session_regenerate_id(true);
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_type'] = $user['tipo_usuario'];

            ShowMessage("Login bem-sucedido!");
        } else {
            error_log("Login failed for email: $email");
            ShowMessage("Email ou senha incorretos.", true);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        ShowMessage("Erro ao processar o login. Por favor, tente novamente mais tarde.", true);
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        ShowMessage("Erro ao processar o login. Por favor, tente novamente mais tarde.", true);
    }
} else {
    ShowMessage("Método de requisição inválido.", true);
}