<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Detalhes-Instituicao.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/NavBar.css">
    <!--link para utilizar os icones-->
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/Detalhes-Instituicao.js" defer></script>
    <script src="js/NavBar.js" defer></script>

    <!-- Link para o FavIcon -->
    <link rel="icon" href="imagens/logo.png">
    <title>Informações da Instituição</title>
</head>
<body>
    <!-- Barra de navegação -->
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>
    <!-- Card que contém todos os blocos de informação sobre a ONG -->
    <div class="card">
        <!-- Div que contém o título e categoria da ONG -->
        <div class="title">
            <h1 id="nome-ong">Terra Verde</h1>
            <h2 id="categoria-ong">Meio Ambiente</h2>
        </div>

        <!-- Div que contém a imagem da ONG -->
        <div class="icon">
            <img src="imagens/description_icon.svg" alt="icone">
        </div>

        <!-- Div que contém uma descrição da ONG -->
        <div class="description_content">
            <h3></h3>
            <p id="descricao-ong"></p>
        </div>

        <!-- Div que contém o endereço da ONG -->
        <div class="endereco">
            <h3>Endereço</h3>
            <p id="endereco-ong">Rua das Palmeiras, 123, Bairro Jardim Marítimo, Vitória - ES, CEP: 29000-000</p>
        </div>

        <!-- Div que contém os meios de contato da ONG -->
        <div class="contato">
            <h3>Contato e Redes Sociais</h3>
            <br>

            <!-- Div que armazena os links para contato -->
            <div class="link">
                <a href="#" target="_blank" id="instagram-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" target="_blank" id="facebook-link"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" target="_blank" id="telefone-link"><i class="fa-solid fa-phone"></i></a>
                <a href="#" target="_blank" id="email-link"><i class="fa-regular fa-envelope"></i></a>
            </div>
        </div>

        <!-- Div que contém o botão para ver os comentários -->
        <div class="main-container">
            <button id="openComments">Ver Comentários</button>
        </div>

        <!-- Dialog que contém o modal dos comentários -->
        <dialog id="commentsModal">
            <!-- Div que possui os botões do Modal -->
            <div class="container">
                <button id="closeComments" class="close-button">&times;</button>
                <div class="controls">
                    <button id="sortRecent">Mais Recentes</button>
                    <button id="sortLiked">Mais Curtidos</button>
                </div>
                <!-- Div que possui os comentários -->
                <div id="commentsContainer"></div>
                <!-- Div que possui os dados para input -->
                <form id="commentForm">
                    <div class="comment-input-container">
                        <input id="comment" placeholder="Seu comentário" required></input>
                        <button type="submit" class="send-button"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </dialog>
    </div>    
</body>
</html>
