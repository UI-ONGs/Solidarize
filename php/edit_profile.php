<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

requireLogin();

$userId = $_SESSION['user_id'];

// Function to check if username exists
function isUsernameUnique($username, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM USUARIO WHERE username = ? AND id != ?");
    $stmt->execute([$username, $userId]);
    return $stmt->rowCount() === 0;
}

// Function to check if any changes were made
function hasChanges($oldData, $newData) {
    return $oldData['nome'] !== $newData['nome'] ||
           $oldData['username'] !== $newData['username'] ||
           $oldData['bio'] !== $newData['bio'] ||
           !empty($_FILES['profile_pic']['tmp_name']) ||
           !empty($_FILES['cover_pic']['tmp_name']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $username = $_POST['username'] ?? '';
    $bio = $_POST['bio'] ?? '';
    
    // Get current user data
    $stmt = $pdo->prepare("
        SELECT u.nome, u.username, v.bio
        FROM USUARIO u
        LEFT JOIN VOLUNTARIO v ON u.id = v.usuario_id
        WHERE u.id = ?
    ");
    $stmt->execute([$userId]);
    $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if any changes were made
    $newData = [
        'nome' => $nome,
        'username' => $username,
        'bio' => $bio
    ];

    if (!hasChanges($currentData, $newData)) {
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração foi feita.']);
        exit;
    }

    // Validate input
    if (empty($nome) || empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Nome e username são obrigatórios.']);
        exit;
    }

    if (strlen($bio) > 150) {
        echo json_encode(['success' => false, 'message' => 'A bio deve ter no máximo 150 caracteres.']);
        exit;
    }

    // Check username uniqueness
    if ($username !== $currentData['username'] && !isUsernameUnique($username, $userId)) {
        echo json_encode(['success' => false, 'message' => 'Este username já está em uso.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Update user table
        $stmt = $pdo->prepare("UPDATE USUARIO SET nome = ?, username = ? WHERE id = ?");
        $stmt->execute([$nome, $username, $userId]);

        // Update volunteer table
        $stmt = $pdo->prepare("UPDATE VOLUNTARIO SET bio = ? WHERE usuario_id = ?");
        $stmt->execute([$bio, $userId]);

        // Handle profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $imageData = file_get_contents($_FILES['profile_pic']['tmp_name']);
            $base64Image = base64_encode($imageData);
            
            // Delete old image if exists
            $stmt = $pdo->prepare("
                DELETE i FROM IMAGEM i
                INNER JOIN USUARIO u ON u.imagem_perfil_id = i.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            
            // Insert new image
            $stmt = $pdo->prepare("INSERT INTO IMAGEM (base64_data, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->execute([$base64Image]);
            $imageId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("UPDATE USUARIO SET imagem_perfil_id = ? WHERE id = ?");
            $stmt->execute([$imageId, $userId]);
        }

        // Handle cover image upload
        if (isset($_FILES['cover_pic']) && $_FILES['cover_pic']['error'] == 0) {
            $imageData = file_get_contents($_FILES['cover_pic']['tmp_name']);
            $base64Image = base64_encode($imageData);
            
            // Delete old image if exists
            $stmt = $pdo->prepare("
                DELETE i FROM IMAGEM i
                INNER JOIN USUARIO u ON u.imagem_capa_id = i.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            
            // Insert new image
            $stmt = $pdo->prepare("INSERT INTO IMAGEM (base64_data, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->execute([$base64Image]);
            $imageId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("UPDATE USUARIO SET imagem_capa_id = ? WHERE id = ?");
            $stmt->execute([$imageId, $userId]);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Perfil atualizado com sucesso.']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o perfil: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

