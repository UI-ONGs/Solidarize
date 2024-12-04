<?php
session_start();
require_once 'php/config.php';
require_once 'php/check_auth.php';

requireLogin();

$loggedIn = false;
$username = '';
$profileImage = '';

if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT u.username, ip.base64_data AS imagem_perfil
        FROM USUARIO u
        LEFT JOIN IMAGEM ip ON u.imagem_perfil_id = ip.id
        WHERE u.id = ?
    ");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['username'];
        $profileImage = $user['imagem_perfil'] ? "data:image/jpeg;base64,{$user['imagem_perfil']}" : 'imagens/default_profile.png';
    }
}
?>

<!-- navbar.php -->
<nav class="navbar">
    <div class="navbar-logo">
        <img src="imagens/logo.png" alt="Solidarize Logo">
        <span class="navbar-logo-text">Solidarize</span>
    </div>
    <ul class="navbar-menu">
        <li><a href="index.php"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="Perfil.php"><i class="fas fa-user"></i><span>Perfil</span></a></li>
        <li><a href="Calendario.php"><i class="fas fa-calendar-alt"></i><span>Eventos</span></a></li>
        <li><a href="Vagas.php"><i class="fas fa-hands-helping"></i><span>Voluntariados</span></a></li>
        <li><a href="Geo-Map.php"><i class="fas fa-map-marked-alt"></i><span>Mapa</span></a></li>
        <li><a href="About.php"><i class="fas fa-info-circle"></i><span>Sobre Nós</span></a></li>
    </ul>
    <div class="navbar-user">
        <?php if ($loggedIn): ?>
                    <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Foto do usuário" class="navbar-user-avatar">
                    <span class="navbar-user-name"><?php echo htmlspecialchars($username); ?></span>
            <?php else: ?>
                    <a href="Login.php" class="login-link">Entrar</a>
        <?php endif; ?>
    </div>
</nav>

<nav class="navbar-mobile">
    <div class="navbar-mobile-header">
        <img src="imagens/logo.png" alt="Solidarize Logo" class="navbar-mobile-logo">
        <button class="navbar-mobile-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <ul class="navbar-mobile-menu">
        <li><a href="index.php"><i class="fas fa-home"></i>Home</a></li>
        <li><a href="Perfil.php"><i class="fas fa-user"></i>Perfil</a></li>
        <li><a href="Calendario.php"><i class="fas fa-calendar-alt"></i>Eventos</a></li>
        <li><a href="Vagas.php"><i class="fas fa-hands-helping"></i>Voluntariados</a></li>
        <li><a href="Geo-Map.php"><i class="fas fa-map-marked-alt"></i>Mapa</a></li>
        <li><a href="About.php"><i class="fas fa-info-circle"></i>Sobre Nós</a></li>
    </ul>
</nav>
