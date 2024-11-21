<?php
session_start();
require_once 'config.php';

function handleImageUpload($imageFile) {
    if (!$imageFile || $imageFile['error'] !== UPLOAD_ERR_OK) {
        error_log("Image upload failed: " . print_r($imageFile, true));
        return null;
    }
    
    $imageData = file_get_contents($imageFile['tmp_name']);
    $base64Image = base64_encode($imageData);
    
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO IMAGEM (base64_data, created_at, updated_at) VALUES (?, NOW(), NOW())");
        $stmt->execute([$base64Image]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error inserting image: " . $e->getMessage());
        return null;
    }
}

function registerUser($userData, $userType) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Handle profile and cover images
        $profileImageId = isset($_FILES['profilePic']) ? handleImageUpload($_FILES['profilePic']) : null;
        $headerImageId = isset($_FILES['headerImage']) ? handleImageUpload($_FILES['headerImage']) : null;
        
        // Hash the password
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Insert into usuario table
        $stmt = $pdo->prepare("
            INSERT INTO USUARIO (
                nome, username, senha, email, tipo_usuario,
                imagem_perfil_id, imagem_capa_id, data_cadastro,
                ultimo_acesso, status, created_at, updated_at
            ) VALUES (
                :nome, :username, :senha, :email, :tipo_usuario,
                :imagem_perfil_id, :imagem_capa_id, NOW(),
                NOW(), 'ativo', NOW(), NOW()
            )
        ");
        
        $stmt->execute([
            ':nome' => $userData['name'],
            ':username' => $userData['username'] ?? $userData['name'],
            ':senha' => $hashedPassword,
            ':email' => $userData['email'],
            ':tipo_usuario' => $userType,
            ':imagem_perfil_id' => $profileImageId,
            ':imagem_capa_id' => $headerImageId
        ]);
        
        $userId = $pdo->lastInsertId();
        
        // Additional user type specific registration logic can be added here
        
        $pdo->commit();
        return ['success' => true, 'message' => 'Cadastro realizado com sucesso!'];
        
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error in registration: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erro ao realizar cadastro: ' . $e->getMessage()];
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'registerVolunteer':
        case 'registerInstitution':
            $response = registerUser($_POST, $action === 'registerVolunteer' ? 'VOLUNTARIO' : 'INSTITUICAO');
            break;
            
        case 'login':
            $response = loginUser($_POST['email'], $_POST['password']);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Ação inválida'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function loginUser($email, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM USUARIO WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_type'] = $user['tipo_usuario'];
            
            // Update last access
            $updateStmt = $pdo->prepare("UPDATE USUARIO SET ultimo_acesso = NOW() WHERE id = :id");
            $updateStmt->execute([':id' => $user['id']]);
            
            return ['success' => true, 'message' => 'Login realizado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'E-mail ou senha inválidos.'];
        }
    } catch (PDOException $e) {
        error_log("Error in login: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erro ao realizar login.'];
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'registerVolunteer':
        case 'registerInstitution':
            $response = registerUser($_POST, $action === 'registerVolunteer' ? 'VOLUNTARIO' : 'INSTITUICAO');
            break;
            
        case 'login':
            $response = loginUser($_POST['email'], $_POST['password']);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Ação inválida'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}