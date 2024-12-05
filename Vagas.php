<?php
require_once 'php/config.php';
require_once 'php/functions.php';

try {
    
    // adiciona rportador de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // puxa todos os voluntariados e todas suas informações (da tabela atividade e voluntariado)
    $sql = "SELECT a.id, a.titulo, a.descricao, i.base64_data AS imagem 
            FROM ATIVIDADE a 
            JOIN VOLUNTARIADO v ON a.id = v.atividade_id 
            LEFT JOIN ATIVIDADE_IMAGEM ai ON a.id = ai.atividade_id 
            LEFT JOIN IMAGEM i ON ai.imagem_id = i.id 
            ORDER BY a.data_inicio DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // adiciona os resultados num array, para debugar
    $voluntariados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug output
    if (empty($voluntariados)) {
        error_log("No voluntariados found in database");
    } else {
        error_log("Found " . count($voluntariados) . " voluntariados");
    }
    
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $voluntariados = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voluntariados</title>
    
    <!-- Load Swiper from CDN with integrity check -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    
    <link rel="stylesheet" href="css/NavBar.css">
    <link rel="stylesheet" href="css/Vagas.css">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/NavBar.js" defer></script>
    <script src="js/Vagas.js" defer></script>
    
    <link rel="icon" href="imagens/logo.png">
</head>
<body>
    <?php include 'NavBar.php'; ?>
    <main>
        <!-- Header -->
        <header class="blurElem">
                <form class="form">
                  <button class="segurar">
                      <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                          <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg>
                  </button>
                  <input class="input" placeholder="Pesquisar..." required="" type="text">
                  <button class="reset segurar" type="reset">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                  </button>
               </form>
                   <a href="index.html">
                       <button class="shadow__btn">
                           SOLIDARIZE
                       </button>
                   </a>
            </header>
        
        <!-- Swiper container -->
        <div class="slide-container swiper">
            <div class="wrapper swiper-wrapper">
                <?php
                if (!empty($voluntariados)) {
                    foreach ($voluntariados as $voluntariado) {
                        $encryptedId = encryptId($voluntariado['id']);
                        ?>
                        <div class="card swiper-slide">
                            <!-- cria um card para cada voluntariado e adiciona suas informações -->
                            <div class="conteudoImg">
                                <span class="overlay"></span>
                                <div class="cardImage">
                                    <?php if (!empty($voluntariado['imagem'])): ?>
                                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($voluntariado['imagem']); ?>" 
                                             alt="<?php echo htmlspecialchars($voluntariado['titulo']); ?>" 
                                             class="cardImg">
                                    <?php else: ?>
                                        <img src="imagens/floresta.jpg" alt="Imagem padrão" class="cardImg">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="conteudoCard">
                                <h2 class="nome"><?php echo htmlspecialchars($voluntariado['titulo']); ?></h2>
                                <p class="descricao"><?php echo htmlspecialchars($voluntariado['descricao']); ?></p>
                                <a href="Detalhe-Vagas.php?id=<?php echo $encryptedId; ?>">
                                    <button class="botao">Ver Mais</button>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="no-results">Nenhum voluntariado encontrado.</div>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="swiper-button-next swiper-navBtn blurElem"></div>
        <div class="swiper-button-prev swiper-navBtn blurElem"></div>
        
        <div class="footer blurElem">
            <div class="btn_cadastrar">
                <a href="Cadastro-Vagas.php">
                    <button class="cadastrar botao">Cadastrar Vaga</button>
                </a>
            </div>
        </div>
    </main>

    <?php
    // função pre encriptar id
    function encryptId($id) {
        $key = '23091750396'; 
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedId = openssl_encrypt($id, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encryptedId . '::' . $iv); 
    }
    ?>
</body>
</html>