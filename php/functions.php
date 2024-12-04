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
                NOW(), 'ATIVO', NOW(), NOW()
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
        
        // Additional user type specific registration logic
        if ($userType === 'INSTITUICAO') {
            $stmt = $pdo->prepare("
                INSERT INTO INSTITUICAO (
                    usuario_id, cnpj, descricao, missao, visao, valores,
                    localizacao, website, data_fundacao, tamanho
                ) VALUES (
                    :usuario_id, :cnpj, :descricao, :missao, :visao, :valores,
                    :localizacao, :website, NOW(), :tamanho
                )
            ");
            
            $stmt->execute([
                ':usuario_id' => $userId,
                ':cnpj' => $userData['cnpj'],
                ':descricao' => $userData['description'] ?? null,
                ':missao' => $userData['mission'] ?? null,
                ':visao' => $userData['vision'] ?? null,
                ':valores' => $userData['values'] ?? null,
                ':localizacao' => $userData['location'] ?? null,
                ':website' => $userData['website'] ?? null,
                ':tamanho' => $userData['size'] ?? null
            ]);

            // Insert institution needs with quantities
            if (!empty($userData['needs'])) {
                $stmt = $pdo->prepare("
                    INSERT INTO INSTITUICAO_NECESSIDADE (
                        instituicao_id, necessidade_id, quantidade
                    ) VALUES (
                        :instituicao_id, :necessidade_id, :quantidade
                    )
                ");

                foreach ($userData['needs'] as $need) {
                    $stmt->execute([
                        ':instituicao_id' => $userId,
                        ':necessidade_id' => $need['id'],
                        ':quantidade' => $need['quantidade']
                    ]);
                }
            }

            // Insert institution categories
            if (!empty($userData['categories'])) {
                $stmt = $pdo->prepare("
                    INSERT INTO USUARIO_CATEGORIA (
                        usuario_id, categoria_id
                    ) VALUES (
                        :usuario_id, :categoria_id
                    )
                ");

                foreach ($userData['categories'] as $categoryId) {
                    $stmt->execute([
                        ':usuario_id' => $userId,
                        ':categoria_id' => $categoryId
                    ]);
                }
            }
        } elseif ($userType === 'VOLUNTARIO') {
            $stmt = $pdo->prepare("
                INSERT INTO VOLUNTARIO (
                    usuario_id, data_nascimento, bio
                ) VALUES (
                    :usuario_id, :data_nascimento, :bio
                )
            ");
            
            $stmt->execute([
                ':usuario_id' => $userId,
                ':data_nascimento' => $userData['data_nascimento'] ?? null,
                ':bio' => $userData['bio'] ?? null
            ]);
        }
        
        $pdo->commit();
        return ['success' => true, 'message' => 'Cadastro realizado com sucesso!'];
        
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error in registration: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erro ao realizar cadastro: ' . $e->getMessage()];
    }
}

// Function to get categories from database
function getCategorias() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, nome FROM CATEGORIA ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching categories: " . $e->getMessage());
        return [];
    }
}

// Function to get needs from database
function getNecessidades() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, nome FROM NECESSIDADE ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching needs: " . $e->getMessage());
        return [];
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'registerVolunteer':
            $userData = [
                'name' => $_POST['name'] ?? '',
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'data_nascimento' => $_POST['dob'] ?? null,
                'bio' => $_POST['description'] ?? null
            ];
            $response = registerUser($userData, 'VOLUNTARIO');
            break;
        case 'registerInstitution':
            $userData = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'cnpj' => $_POST['cnpj'] ?? '',
                'description' => $_POST['description'] ?? null,
                'mission' => $_POST['mission'] ?? null,
                'vision' => $_POST['vision'] ?? null,
                'values' => $_POST['values'] ?? null,
                'location' => $_POST['location'] ?? null,
                'website' => $_POST['website'] ?? null,
                'size' => $_POST['size'] ?? null,
                'categories' => $_POST['categories'] ?? [],
                'needs' => $_POST['needs'] ?? []
            ];
            $response = registerUser($userData, 'INSTITUICAO');
            break;
        case 'login':
            $response = loginUser($_POST['email'], $_POST['password']);
            break;
        case 'getCategorias':
            $response = ['success' => true, 'data' => getCategorias()];
            break;
        case 'getNecessidades':
            $response = ['success' => true, 'data' => getNecessidades()];
            break;
        default:
            $response = ['success' => false, 'message' => 'Ação inválida'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}