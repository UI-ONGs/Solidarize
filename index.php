<?php
session_start();
require_once 'php/config.php';
require_once 'php/check_auth.php';

// verifica login
requireLogin();

$loggedIn = false;
$username = '';
$profileImage = '';

// puxa informações do usuário (username e imagem de perfil)
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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solidarize - Conectando ONGs para Causas Globais</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/NavBar.css">
    <link rel="stylesheet" href="css/Footer.css">
    <link rel="icon" href="imagens/logo.png">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/script.js" defer></script>
    <script src="js/NavBar.js"></script>
</head>
<body>
     <!-- Include navbar -->
     <?php include 'NavBar.php'; ?>
    
    <!-- Container principal -->
    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <input type="text" placeholder="Pesquisar ONGs, eventos, causas..." class="search-input">
                <button class="search-button"><i class="fas fa-search"></i></button>
                <div id="search-results" class="search-results"></div>

            </div>
            <!-- área do usuário -->
            <div class="user-menu">
                <!-- verifica se está logado e coloca as informações dele-->
                <?php if ($loggedIn): ?>
                    <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Foto do usuário" class="user-avatar">
                    <span class="user-name">Olá, <?php echo htmlspecialchars($username); ?></span>
                <?php else: ?>
                    <!-- caso não, coloque um link para o logn.php  -->
                    <a href="Login.php" class="login-link">Entrar</a>
                <?php endif; ?>
            </div>
        </header>
        <!-- área de seja bem-vindo -->
        <div class="content-area">
            <section class="welcome-section">
                <h2>Bem-vindo ao Portal ONGs</h2>
                <p>Conectando pessoas a causas que transformam o mundo. Descubra como você pode fazer a diferença hoje!</p>
                <div class="cta-buttons">
                    <a href="#register" class="cta-button primary">Cadastre sua ONG</a>
                    <a href="#explore" class="cta-button secondary">Explorar Causas</a>
                </div>
            </section>
            <!--instituições por causa -->
            <section class="featured-causes">
                <h3>Causas em Destaque</h3>
                <div class="cause-slider">
                    <div class="cause-item">
                        <img src="imagens/floresta.jpg" alt="Causa 1" class="cause-image">
                        <h4>Preservação Ambiental</h4>
                        <p>Protegendo nossas florestas e oceanos para as futuras gerações.</p>
                        <a href="Detalhes-Instituicao.php" class="learn-more">Saiba mais</a>
                    </div>
                    <div class="cause-item">
                        <img src="imagens/floresta.jpg" alt="Causa 2" class="cause-image">
                        <h4>Educação para Todos</h4>
                        <p>Garantindo acesso à educação de qualidade em comunidades carentes.</p>
                        <a href="#cause2" class="learn-more">Saiba mais</a>
                    </div>
                    <div class="cause-item">
                        <img src="imagens/floresta.jpg" alt="Causa 3" class="cause-image">
                        <h4>Combate à Fome</h4>
                        <p>Trabalhando para erradicar a fome e promover a segurança alimentar.</p>
                        <a href="#cause3" class="learn-more">Saiba mais</a>
                    </div>
                </div>
            </section>
            <!-- layout em duas colunas, para mapa e calendário -->
            <div class="two-column-layout">
                <section class="upcoming-events">
                    <h3>Próximos Eventos</h3>
                    <!-- Container principal do calendário -->
                <div class="calendar-container">
                    <!-- Cabeçalho do calendário com botões de navegação -->
                    <div class="calendar-header">
                        <button id="prevMonth">&lt;</button>
                        <h2 id="currentMonth">Outubro 2024</h2>
                        <button id="nextMonth">&gt;</button>
                    </div>
                    <!-- Dias da semana -->
                    <div class="calendar-weekdays">
                        <div>Dom</div>
                        <div>Seg</div>
                        <div>Ter</div>
                        <div>Qua</div>
                        <div>Qui</div>
                        <div>Sex</div>
                        <div>Sáb</div>
                    </div>
                    <!-- Grade do calendário (preenchida via JavaScript) -->
                    <div id="calendarGrid" class="calendar-grid"></div>
                    <!-- Lista de eventos (preenchida via JavaScript) -->
                    <div id="eventList" class="event-list"></div>
                </div>
                </section>
                <!-- área do mapa -->
                <section class="nearby-organizations">
                    <h3>ONGs Próximas a Você</h3>
                    <!--mostra o mapa e algumas nstituições próxima (simulado- não funcional ainda) -->
                    <div class="org-map">
                        <img src="imagens/header.webp" alt="Mapa de ONGs" class="map-image">
                    </div>
                    <ul class="org-list">
                        <li class="org-item">
                            <img src="imagens/floresta.jpg" alt="ONG 1" class="org-logo">
                            <div class="org-info">
                                <h5>Amigos da Natureza</h5>
                                <p>Conservação ambiental e educação ecológica</p>
                                <span class="distance">2.5 km</span>
                            </div>
                            <a href="#org1" class="org-link">Ver perfil</a>
                        </li>
                        <li class="org-item">
                            <img src="imagens/floresta.jpg" alt="ONG 2" class="org-logo">
                            <div class="org-info">
                                <h5>Educação para Todos</h5>
                                <p>Promovendo acesso à educação de qualidade</p>
                                <span class="distance">3.7 km</span>
                            </div>
                            <a href="#org2" class="org-link">Ver perfil</a>
                        </li>
                        <li class="org-item">
                            <img src="imagens/floresta.jpg" alt="ONG 3" class="org-logo">
                            <div class="org-info">
                                <h5>Abrigo Esperança</h5>
                                <p>Cuidando de animais abandonados</p>
                                <span class="distance">5.1 km</span>
                            </div>
                            <a href="#org3" class="org-link">Ver perfil</a>
                        </li>
                    </ul>
                </section>
            </div>
            <!-- status de impacto -->
            <section class="impact-stats">
                <h3>Nosso Impacto</h3>
                <div class="stats-container">
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <span class="stat-number" data-stat="voluntarios">0</span>
                        <span class="stat-label">Voluntários Ativos</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span class="stat-number" data-stat="ongs">0</span>
                        <span class="stat-label">ONGs Cadastradas</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-globe-americas"></i>
                        <span class="stat-number" data-stat="cidades">0</span>
                        <span class="stat-label">Cidades Alcançadas</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-seedling"></i>
                        <span class="stat-number" data-stat="arvores">0</span>
                        <span class="stat-label">Árvores Plantadas</span>
                    </div>
                </div>
            </section>
            <!-- declarações, testemunho -->
            <section class="testimonials">
                <h3>O Que Dizem Sobre Nós</h3>
                <div class="testimonial-slider">
                    <div class="testimonial-item">
                        <p>"O Portal ONGs transformou a maneira como nossa organização se conecta com voluntários. É uma ferramenta incrível!"</p>
                        <div class="testimonial-author">
                            <img src="imagens/malu_perfil.png" alt="Autor 1" class="author-image">
                            <div class="author-info">
                                <span class="author-name">Maria Luiza</span>
                                <span class="author-role">Diretora, Amigos da Natureza</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <p>"Graças ao Portal ONGs, conseguimos aumentar nossas doações em 200% no último ano. É uma plataforma essencial!"</p>
                        <div class="testimonial-author">
                            <img src="imagens/dani_perfil.png" alt="Autor 2" class="author-image">
                            <div class="author-info">
                                <span class="author-name">Daniel Haddad</span>
                                <span class="author-role">Coordenador, Educação para Todos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- newsletter (não funciona, ainda) -->
            <section class="newsletter">
                <h3>Fique por Dentro</h3>
                <p>Receba atualizações sobre eventos, oportunidades de voluntariado e histórias inspiradoras.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu melhor e-mail" required>
                    <button type="submit">Inscrever-se</button>
                </form>
            </section>
        </div>
    </main>
</div>
    <!-- Include Footer -->
    <?php include 'Footer.php'; ?>
</body>
</html>
