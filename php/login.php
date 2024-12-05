<?php
session_start();
require_once 'config.php';

// Função para mostrar mensagens
function ShowMessage($message, $isError = false) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => !$isError,
        'message' => $message
    ]);
    exit;
}

// Verifica se os dados foram inseridos e checa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Filtro de validação
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
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
            // Checa o status do usuário
            if ($user['status'] === 'INATIVO') {
                ShowMessage('Esta conta está inativa. Entre em contato com o suporte.', true);
            }
            
            if ($user['status'] === 'SUSPENSO') {
                ShowMessage('Esta conta foi suspensa. Entre em contato com o suporte.', true);
            }
            
            if ($user['status'] !== 'ATIVO') {
                ShowMessage('Não foi possível fazer login. Entre em contato com o suporte.', true);
            }

            // Para "Manter conectado", a sessão irá durar mais tempo
            if ($stayConnected) {
                ini_set('session.cookie_lifetime', 30 * 24 * 60 * 60); // 30 dias
            } else {
                ini_set('session.cookie_lifetime', 0); // Sessão cookie
            }
            
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_type'] = $user['tipo_usuario'];
            $_SESSION['logged_in'] = true;

            // Atualiza o último acesso
            $updateStmt = $pdo->prepare("UPDATE USUARIO SET ultimo_acesso = NOW() WHERE id = ?");
            $updateStmt->execute([$user['id']]);

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
