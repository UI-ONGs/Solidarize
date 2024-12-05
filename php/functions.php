<?php
session_start();
require_once 'config.php';

// Função para o upload de imagem
function handleImageUpload($imageFile) {
    // Verifica se um arquivo foi enviado e se não houve erros no upload
    if (!$imageFile || $imageFile['error'] !== UPLOAD_ERR_OK) {
        error_log("Falha no upload da imagem: " . print_r($imageFile, true));
        return null;
    }
    
    // Verifica o tipo de arquivo
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($imageFile['type'], $allowedTypes)) {
        error_log("Tipo de arquivo não permitido: " . $imageFile['type']);
        return null;
    }
    
    // Limita o tamanho do arquivo (por exemplo, 5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5MB em bytes
    if ($imageFile['size'] > $maxFileSize) {
        error_log("Arquivo muito grande: " . $imageFile['size'] . " bytes");
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
        error_log("Erro ao inserir imagem: " . $e->getMessage());
        return null;
    }
}

// Função para registrar usuário
function registerUser($userData, $userType) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Lida com imagem de perfil e de capa
        $profileImageId = isset($_FILES['profilePic']) ? handleImageUpload($_FILES['profilePic']) : null;
        $headerImageId = isset($_FILES['headerImage']) ? handleImageUpload($_FILES['headerImage']) : null;
        
        // Faz hash na senha
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Insere os dados na tabela usuário
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

        $email = filter_var($userData['email'], FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
        
        $stmt->execute([
            ':nome' => $userData['name'],
            ':username' => $userData['username'] ?? $userData['name'],
            ':senha' => $hashedPassword,
            ':email' => $email,
            ':tipo_usuario' => $userType,
            ':imagem_perfil_id' => $profileImageId,
            ':imagem_capa_id' => $headerImageId
        ]);
        
        $userId = $pdo->lastInsertId();
        
        // Verifica qual tipo de usuário e adiciona o restante dos dados
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

            // Insere as necessidades e quantidades da instituição
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

            // Insere as categorias da instituição
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
        error_log("Erro no registro: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erro ao realizar cadastro: ' . $e->getMessage()];
    }
}

// Função para pegar as categorias do banco
function getCategorias() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, nome FROM CATEGORIA ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar categorias: " . $e->getMessage());
        return [];
    }
}

// Função para pegar as necessidades do banco
function getNecessidades() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, nome FROM NECESSIDADE ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar necessidades: " . $e->getMessage());
        return [];
    }
}

// Lida com as requisições de post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'registerVolunteer':
        case 'registerInstitution':
            // Verifica se foram enviados arquivos e se não excedem o tamanho permitido
            if (!empty($_FILES)) {
                foreach ($_FILES as $key => $file) {
                    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
                        $response = ['success' => false, 'message' => 'O arquivo enviado é muito grande.'];
                        break 2; // Sai do switch e do if
                    }
                }
            }
            
            $userData = [
                'name' => $_POST['name'] ?? '',
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'data_nascimento' => $_POST['dob'] ?? null,
                'bio' => $_POST['description'] ?? null,
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
            $response = registerUser($userData, $action === 'registerVolunteer' ? 'VOLUNTARIO' : 'INSTITUICAO');
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