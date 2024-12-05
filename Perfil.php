<?php
session_start();
require_once 'php/config.php';
require_once 'php/check_auth.php';

requireLogin();
// verifica se o usuário estálogado

$userId = $_SESSION['user_id'];
// pega seu id

// puxa todas suas informações (tanto na tabela usuário quanto na voluntário)
$stmt = $pdo->prepare("
    SELECT u.*,
           COALESCE(v.bio, i.descricao) as bio,
           v.data_nascimento,
           ip.base64_data AS imagem_perfil,
           ic.base64_data AS imagem_capa
    FROM USUARIO u
    LEFT JOIN VOLUNTARIO v ON u.id = v.usuario_id
    LEFT JOIN INSTITUICAO i ON u.id = i.usuario_id
    LEFT JOIN IMAGEM ip ON u.imagem_perfil_id = ip.id
    LEFT JOIN IMAGEM ic ON u.imagem_capa_id = ic.id
    WHERE u.id = ?
");

$stmt->execute([$userId]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// ajusta o output da imagem
function saidaImagem($dadosImagem, $imagemPadrao) {
    if ($dadosImagem) {
        echo "data:image/jpeg;base64," . $dadosImagem;
    } else {
        echo $imagemPadrao;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/Perfil.css">
    <link rel="stylesheet" href="css/NavBar.css">
    <script src="js/NavBar.js" defer></script>
    <link rel="icon" href="imagens/logo.png">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/Perfil.js" defer></script>
</head>
<body>

    <!-- Include navbar -->
    <?php include 'NavBar.php'; ?>

    <!-- container principal -->
    <div class="container">
        <div class="profile">
            <!-- define capa caso haja, se não houver coloca uma imagem padrão -->
            <div class="wallpaper">
                <img src="<?php saidaImagem($usuario['imagem_capa'], 'https://via.placeholder.com/800x200'); ?>" alt="Wallpaper" id="wallpaperImg">
            </div>
            <!-- define imagem de perfil caso haja, se não houver coloca uma imagem padrão -->
            <div class="profile-info">
                <div class="profile-photo-container">
                    <img src="<?php saidaImagem($usuario['imagem_perfil'], 'https://via.placeholder.com/150'); ?>" alt="Foto de perfil" class="profile-photo" id="profileImg">
                </div>
                <!-- coloca o restante dos dados do usuário, garantindo a remoção de caracteres especiais -->
                <div class="name-username">
                    <h1 class="name"><?php echo htmlspecialchars($usuario['nome']) ?></h1>
                    <p class="username"><?php echo htmlspecialchars('@' . $usuario['username']) ?></p>
                </div>
                <button class="edit-profile">Editar Perfil</button>
                <div class="bio">
                    <p><?php echo !empty($usuario['bio']) ? nl2br(htmlspecialchars($usuario['bio'])) : "Nenhuma bio disponível."; ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- botões de sair e desatiar conta -->
    <div class="profile-actions">
            <a href="php/logout.php" class="logout-button">Sair</a>
            <button class="deactivate-account">Desativar Conta</button>
    </div>

    <!-- modal de editar perfil -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Perfil</h2>
            <form id="edit-profile-form" enctype="multipart/form-data">
                <div class="image-upload">
                    <label for="profileImageUpload">Alterar foto de perfil</label>
                    <input type="file" id="profileImageUpload" name="profile_pic" accept="image/*">
                    <label for="wallpaperImageUpload">Alterar wallpaper</label>
                    <input type="file" id="wallpaperImageUpload" name="cover_pic" accept="image/*">
                </div>
                <input type="text" id="editName" name="nome" placeholder="Nome Completo" value="<?php echo htmlspecialchars($usuario['nome']) ?>" required>
                <input type="text" id="editUsername" name="username" placeholder="Username" value="<?php echo htmlspecialchars($usuario['username']) ?>" required>
                <textarea id="editBio" name="bio" placeholder="Bio" rows="4" maxlength="150"><?php echo htmlspecialchars($usuario['bio']) ?></textarea>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div> 
    
    <!-- modal dpara desativar perfil -->
    <div id="deactivateModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Desativar Conta</h2>
        <p>Tem certeza que deseja desativar sua conta? Esta ação pode ser revertida entrando em contato com o suporte.</p>
        <div class="modal-actions">
            <button id="confirmDeactivate" class="danger-button">Sim, desativar conta</button>
            <button id="cancelDeactivate" class="secondary-button">Cancelar</button>
        </div>
    </div>
</div>
</body>
</html>

