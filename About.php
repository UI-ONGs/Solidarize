<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Solidarize</title>
    <link rel="stylesheet" href="css/About.css">
    <link rel="stylesheet" href="css/NavBar.css">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <link rel="icon" href="imagens/logo.png">
</head>
<body>
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>

    <!--Adicionando a navbar da página em smartphone-->
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
            <li><a href="index.html"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="Perfil.html"><i class="fas fa-user"></i>Perfil</a></li>
            <li><a href="Calendario.html"><i class="fas fa-calendar-alt"></i>Eventos</a></li>
            <li><a href="Vagas.html"><i class="fas fa-hands-helping"></i>Voluntariados</a></li>
            <li><a href="Geo-Map.html"><i class="fas fa-map-marked-alt"></i>Mapa</a></li>
            <li><a href="About.html"><i class="fas fa-info-circle"></i>Sobre Nós</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <!-- Seção Hero -->
        <section id="home" class="hero">
            <div class="hero-content">
                <h1>Um pouco sobre a Solizarize</h1>
            </div>
        </section>

        <!-- Pequena contextualização -->
        <section id="about" class="about">
            <div class="about-image">
                <h2>"Conexão + Otimização"</h2>
                <img src="imagens/img_contextualizacao.png" alt="Conexão e Otimização">   
            </div>
            <div class="about-text">
                <p><strong>Dado que o Espírito Santo abriga uma comunidade composta por mais de 18 mil Organizações Não Governamentais registradas, surgiu a necessidade de desenvolver uma plataforma que reúna todas essas instituições, as quais já se encontram cadastradas em nosso aplicativo. Tal iniciativa visa proporcionar praticidade e eficiência na localização dessas informações.</strong></p>
            </div>
        </section>

        <!-- Ala de patrocinadores -->
        <section id="sponsors" class="sponsors">
            <h2>PATROCINADORES</h2>
            <div class="sponsor-grid">
                <div class="sponsor-item">
                    <i class="fas fa-building"></i>
                    <span>Condo</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-cog"></i>
                    <span>Contraktor</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-industry"></i>
                    <span>Correa Gomes</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-ship"></i>
                    <span>COCS</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-truck"></i>
                    <span>DHL</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-plane"></i>
                    <span>DMT</span>
                </div>
                <div class="sponsor-item">
                    <i class="fas fa-box"></i>
                    <span>Eterni</span>
                </div>
            </div>
        </section>
        
        <!-- Funcionalidades da plataforma -->
        <section class="features">
            <div class="features-container">
                <div class="features-scroll">
                    <div class="feature-item" data-feature="1">
                        <h3>PESQUISAR POR EVENTOS</h3>
                        <p>Através do calendário você poderá conferir os eventos próximos, também podendo filtrar por localização ou categoria de preferência</p>
                        <a href="Calendario.html" class="feature-link">Ir para o Calendário</a>
                    </div>
                    <div class="feature-item" data-feature="2">
                        <h3>CONHECER ONGS</h3>
                        <p>Como voluntário, você pode encontrar diferentes instituições através da barra de pesquisa ou selecionando uma categoria </p>
                        <a href="Vagas.html" class="feature-link">Ir para Voluntariados</a>
                    </div>
                    <div class="feature-item" data-feature="3">
                        <h3>MAPEAR INSTITUIÇÕES</h3>
                        <p>Por meio do mapa, é possível encontrar por ONGs próximas de você, podendo também selecionar uma área específica</p>
                        <a href="Geo-Map.html" class="feature-link">Ir para o Mapa</a>
                    </div>
                </div>
                <div class="features-static">
                    <h2>Funcionalidades da Plataforma</h2>
                    <p>como <span class="highlight">Voluntário</span></p>
                </div>
            </div>
            <div class="features-container">
                <div class="features-scroll">
                    <div class="feature-item" data-feature="1">
                        <h3>GERENCIAR EVENTOS</h3>
                        <p>Crie e gerencie eventos de voluntariado, controlando inscrições e comunicando-se com os voluntários</p>
                        <a href="Calendario.html" class="feature-link">Gerenciar Eventos</a>
                    </div>
                    <div class="feature-item" data-feature="2">
                        <h3>FORNECER TRABALHO VOLUNTÁRIO</h3>
                        <p>Publique sobre oportunidades de trabalho que os voluntariados tenham interesse, pormovendo o conhecimento de sua ONG</p>
                        <a href="Vagas.html" class="feature-link">Criar Trabalho Voluntário</a>
                    </div>
                    <div class="feature-item" data-feature="3">
                        <h3>PERFIL DA INSTITUIÇÃO</h3>
                        <p>Mantenha o perfil da sua instituição atualizado para atrair voluntários alinhados com sua missão</p>
                        <a href="Detalhes-Instituicao.html" class="feature-link">Ir para o Perfil</a>
                    </div>
                </div>
                <div class="features-static">
                    <h2>Funcionalidades da Plataforma</h2>
                    <p>como <span class="highlight">Instituição</span></p>
                </div>
            
            </div>
        </section>

        <!-- Ala de valores -->
        <section id="values" class="values">
        <h2>VALORES</h2>
        <div class="value-grid">
            <div class="value-item">
                <div class="icon-container">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3>Solidariedade</h3>
                <p>Atuamos em busca de um bem comum e contra as injustiças e desigualdades.</p>
            </div>
            <div class="value-item">
                <div class="icon-container">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Diversidade</h3>
                <p>Valorizamos as diferenças e promovemos um ambiente inclusivo, onde todos têm voz e oportunidades iguais para participarem do melhor lugar.</p>
            </div>
            <div class="value-item">
                <div class="icon-container">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Praticidade</h3>
                <p>Priorizamos soluções eficientes e descomplicadas para atender rapidamente às necessidades dos nossos usuários.</p>
            </div>
            <div class="value-item">
                <div class="icon-container">
                    <i class="fas fa-check"></i>
                </div>
                <h3>Transparência</h3>
                <p>Atuamos de forma clara e aberta, garantindo confiança e alinhamento em todas as nossas ações e comunicações.</p>
            </div>
            <div class="value-item">
                <div class="icon-container">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Responsabilidade</h3>
                <p>Assumimos o compromisso com nossos usuários, patrocinadores e o meio digital, agindo de forma ética e segura.</p>
            </div>
        </div>
    </section>

     <!-- Sessão das Perguntas -->
    <section class="faq-section">
        <h1>Perguntas Frequentes</h1>
    
        <div class="tabs">
            <button class="tab active" data-tab="sobre">Sobre Nós</button>
            <button class="tab" data-tab="instituicoes">Instituições</button>
            <button class="tab" data-tab="voluntariados">Voluntariados</button>
        </div>
        
        <div id="faq-container"></div>
    </section>
    

        <!-- Sessão de contato -->
        <section id="newsletter" class="newsletter">
            <h2>Fique por Dentro</h2>
            <p>Receba atualizações sobre eventos, oportunidades de voluntariado e histórias inspiradoras.</p>
            <form id="newsletter-form">
                <input type="email" placeholder="Seu melhor e-mail" required>
                <button type="submit">Inscrever-se</button>
            </form>
        </section>
    </main>

    <script src="js/About.js"></script>
</body>
</html>