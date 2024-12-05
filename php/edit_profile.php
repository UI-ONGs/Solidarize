<?php
// Inicia a sessão e inclui os arquivos necessários
session_start();
require_once 'config.php';
require_once 'check_auth.php';

// Verifica se o usuário está autenticado
requireLogin();

// Obtém o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Função para verificar se o username é único
function isUsernameUnique($username, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM USUARIO WHERE username = ? AND id != ?");
    $stmt->execute([$username, $userId]);
    return $stmt->rowCount() === 0;
}

// Função para verificar se houve alterações nos dados do perfil
function hasChanges($oldData, $newData) {
    return $oldData['nome'] !== $newData['nome'] ||
           $oldData['username'] !== $newData['username'] ||
           $oldData['bio'] !== $newData['bio'] ||
           !empty($_FILES['profile_pic']['tmp_name']) ||
           !empty($_FILES['cover_pic']['tmp_name']);
}

// Função para processar e redimensionar imagens
function processImage($file, $maxWidth, $maxHeight) {
    // Cria uma imagem a partir do arquivo enviado
    $sourceImage = imagecreatefromstring(file_get_contents($file['tmp_name']));
    $sourceWidth = imagesx($sourceImage);
    $sourceHeight = imagesy($sourceImage);

    // Calcula as novas dimensões mantendo a proporção
    $ratioWidth = $maxWidth / $sourceWidth;
    $ratioHeight = $maxHeight / $sourceHeight;
    $ratio = min($ratioWidth, $ratioHeight);

    $newWidth = $sourceWidth * $ratio;
    $newHeight = $sourceHeight * $ratio;

    // Cria uma nova imagem com as dimensões calculadas
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

    // Converte a imagem para JPEG e a armazena em um buffer
    ob_start();
    imagejpeg($newImage, null, 90);
    $imageData = ob_get_clean();

    // Libera a memória
    imagedestroy($sourceImage);
    imagedestroy($newImage);

    // Retorna a imagem como uma string base64
    return base64_encode($imageData);
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $username = $_POST['username'] ?? '';
    $bio = $_POST['bio'] ?? '';
    
    // Busca os dados atuais do usuário no banco de dados
    $stmt = $pdo->prepare("
        SELECT u.nome, u.username, v.bio
        FROM USUARIO u
        LEFT JOIN VOLUNTARIO v ON u.id = v.usuario_id
        WHERE u.id = ?
    ");
    $stmt->execute([$userId]);
    $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepara os novos dados para comparação
    $newData = [
        'nome' => $nome,
        'username' => $username,
        'bio' => $bio
    ];

    // Verifica se houve alterações
    if (!hasChanges($currentData, $newData)) {
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração foi feita.']);
        exit;
    }

    // Valida os campos obrigatórios
    if (empty($nome) || empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Nome e username são obrigatórios.']);
        exit;
    }

    // Valida o tamanho da bio
    if (strlen($bio) > 150) {
        echo json_encode(['success' => false, 'message' => 'A bio deve ter no máximo 150 caracteres.']);
        exit;
    }

    // Verifica se o novo username já está em uso
    if ($username !== $currentData['username'] && !isUsernameUnique($username, $userId)) {
        echo json_encode(['success' => false, 'message' => 'Este username já está em uso.']);
        exit;
    }

    try {
        // Inicia uma transação no banco de dados
        $pdo->beginTransaction();

        // Atualiza os dados do usuário
        $stmt = $pdo->prepare("UPDATE USUARIO SET nome = ?, username = ? WHERE id = ?");
        $stmt->execute([$nome, $username, $userId]);

        // Atualiza a bio do voluntário
        $stmt = $pdo->prepare("UPDATE VOLUNTARIO SET bio = ? WHERE usuario_id = ?");
        $stmt->execute([$bio, $userId]);

        // Processa e atualiza a imagem de perfil, se fornecida
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $base64Image = processImage($_FILES['profile_pic'], 400, 400);
            
            // Remove a imagem de perfil antiga
            $stmt = $pdo->prepare("
                DELETE i FROM IMAGEM i
                INNER JOIN USUARIO u ON u.imagem_perfil_id = i.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            
            // Insere a nova imagem de perfil
            $stmt = $pdo->prepare("INSERT INTO IMAGEM (base64_data, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->execute([$base64Image]);
            $imageId = $pdo->lastInsertId();

            // Atualiza o ID da imagem de perfil do usuário
            $stmt = $pdo->prepare("UPDATE USUARIO SET imagem_perfil_id = ? WHERE id = ?");
            $stmt->execute([$imageId, $userId]);
        }

        // Processa e atualiza a imagem de capa, se fornecida
        if (isset($_FILES['cover_pic']) && $_FILES['cover_pic']['error'] == 0) {
            $base64Image = processImage($_FILES['cover_pic'], 1200, 400);
            
            // Remove a imagem de capa antiga
            $stmt = $pdo->prepare("
                DELETE i FROM IMAGEM i
                INNER JOIN USUARIO u ON u.imagem_capa_id = i.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            
            // Insere a nova imagem de capa
            $stmt = $pdo->prepare("INSERT INTO IMAGEM (base64_data, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->execute([$base64Image]);
            $imageId = $pdo->lastInsertId();

            // Atualiza o ID da imagem de capa do usuário
            $stmt = $pdo->prepare("UPDATE USUARIO SET imagem_capa_id = ? WHERE id = ?");
            $stmt->execute([$imageId, $userId]);
        }

        // Confirma as alterações no banco de dados
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Perfil atualizado com sucesso.']);
    } catch (Exception $e) {
        // Em caso de erro, desfaz as alterações
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o perfil: ' . $e->getMessage()]);
    }
} else {
    // Responde com erro se o método não for POST
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

