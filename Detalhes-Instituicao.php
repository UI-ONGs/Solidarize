<?php
require_once 'php/config.php';
require_once 'php/functions.php';

// ID GENERALIZADO - MUDAR PARA MÉTODO NECESSÁRIO
$idInstituicao = 1;

try {    
    // Buscar informações da instituição
    $stmt = $pdo->prepare("SELECT i.*, u.nome, u.username, ip.base64_data AS imagem_perfil, ic.base64_data AS imagem_capa 
                           FROM INSTITUICAO i 
                           JOIN USUARIO u ON i.usuario_id = u.id
                           LEFT JOIN IMAGEM ip ON u.imagem_perfil_id = ip.id
                           LEFT JOIN IMAGEM ic ON u.imagem_capa_id = ic.id
                           WHERE u.id = ?");
    $stmt->execute([$idInstituicao]);
    $instituicao = $stmt->fetch(PDO::FETCH_ASSOC);

    // Buscar eventos da instituição
    $stmt = $pdo->prepare("SELECT * FROM ATIVIDADE a
                           JOIN EVENTO e ON a.id = e.atividade_id
                           WHERE a.instituicao_id = ?
                           ORDER BY a.data_inicio ASC
                           LIMIT 5");
    $stmt->execute([$idInstituicao]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Buscar avaliações da instituição
    $stmt = $pdo->prepare("SELECT AVG(nota) as media_avaliacao FROM INSTITUICAO_AVALIACAO WHERE instituicao_id = ?");
    $stmt->execute([$idInstituicao]);
    $avaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Tratar erro de conexão com o banco de dados
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/NavBar.css">
    <link rel="stylesheet" href="css/Detalhes-Instituicao.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/NavBar.js" defer></script>
    <script src="js/Detalhes-Instituicao.js" defer></script>
    <script src="js/Obter-Localizacao.js" defer></script>
    <title>Perfil Instituição - <?php echo htmlspecialchars($instituicao['nome']); ?></title>
</head>
<body>
    <!-- Include navbar -->
    <?php include 'NavBar.php'; ?>

    <div class="card">

    <!-- Bloco 1 -->
        <div class="profile">

            <div class="capa">
                <img src="data:image/jpeg;base64,<?php echo $instituicao['imagem_capa']; ?>" alt="foto de capa">
            </div>

            <div class="info-instituicao" >
                <div class="desc1">
                    <h1 id="nome_instituicao"><?php echo htmlspecialchars($instituicao['nome']); ?></h1><br>
                    <p id="descricao_instituicao"><?php echo htmlspecialchars($instituicao['descricao']); ?></p>
                </div>

                <div class="cont-icon">
                    <div class="icones">
                        <a href="#" class="fa fa-instagram"></a>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-whatsapp"></a>
                    </div>
                </div>
                
            </div>

            <div class="perfil">
                <img src="data:image/jpeg;base64,<?php echo $instituicao['imagem_perfil']; ?>" alt="foto de perfil">
            </div>

        </div>

    <!-- Bloco 2 -->
    <!-- Carrossel/slider colaboradores -->
        <div class="colaboradores">
            
                <h1>Colaboradores</h1>

                <div class="slider-colab">
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab1">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab2">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab3">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab4">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>
                    <div class="colab">
                        <img src="img/perfil.png" alt="colab5">
                    </div>

                </div>
                
            
            
        </div>

    <!-- Bloco 3 -->
        <div class="detalhes">
            <div class="desc2">
                <h1>Missão, Visão e Valores</h1><br>
                <p id="missao"><?php echo htmlspecialchars($instituicao['missao']); ?></p><br>
                <p id="visao"><?php echo htmlspecialchars($instituicao['visao']); ?></p><br>
                <p id="valores"><?php echo htmlspecialchars($instituicao['valores']); ?></p><br>
            </div>

            <!-- Carrossel com fotos da instituição ou sla -->

            <div class="slider-container">
                <div class="slider">
                    <img src="data:image/jpeg;base64,<?php echo $instituicao['imagem_capa']; ?>" class="slide" alt="Imagem 1">
                    <img src="data:image/jpeg;base64,<?php echo $instituicao['imagem_capa']; ?>" class="slide" alt="Imagem 2">
                    <img src="data:image/jpeg;base64,<?php echo $instituicao['imagem_capa']; ?>" class="slide" alt="Imagem 3">
                </div>
                <div class="controls">
                    <button class="prev" onclick="moveSlide(-1)">❮</button>
                    <button class="next" onclick="moveSlide(1)">❯</button>
                </div>
            </div>
            
        </div>

    <!-- Bloco 4 -->
        <div class="localizacao">
            <div class="desc3">
                <h1>Nossa localização</h1><br>
                <h2>Unidade</h2>
                <p id="endereco-formatado">Carregando endereço...</p>
                <a id="link-mapa" href="#" target="_blank">Ver no mapa</a>            
            </div>
            
            <div class="map">
                <img src="img/map.png" alt="Imagem Mapa">
                <a href="#" id="geomap-link" target="_blank">-> ir para o Geomap</a>
            </div>
        </div>
    <!-- Bloco 5 -->
        <div class="eventos">
            
                <h1>Participe dos Nossos Eventos</h1>
                <h4>Eventos Próximos</h4>
            
            <div class="slider-event">
                <?php foreach ($eventos as $evento): ?>
                    <div class="event">
                        <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                        <p>Data: <?php echo date('d/m/Y', strtotime($evento['data_inicio'])); ?></p>
                        <p>Horário: <?php echo date('H:i', strtotime($evento['data_inicio'])); ?> 
                        às <?php echo date('H:i', strtotime($evento['data_fim'])); ?></p>
                        <a href="#">Ir para o Calendário</a>
                    </div>
                <?php endforeach; ?>
            </div>
            
        </div>

    <!-- Bloco 6 -->
        <div class="avaliacao">
            <h1>Nos avalie</h1>
            <div class="rating" id="rating">
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
            </div>
            <p>Avaliação média: <?php echo number_format($avaliacao['media_avaliacao'], 1); ?></p>
        </div>
        
        
    </div>
</body>
</html>