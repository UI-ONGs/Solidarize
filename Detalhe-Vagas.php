<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informaçoes da Vaga</title>
    <link rel="stylesheet" href="css/Detalhe-Vagas.css">
    <link rel="stylesheet" href="css/NavBar.css">
    <!--link para utilizar os icones-->
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script defer src="js/Detalhe-Vagas.js"></script>
    <script src="js/NavBar.js" defer></script>
    <!-- Link para o FavIcon -->
    <link rel="icon" href="imagens/logo.png">
</head>
<body>
    <!-- Barra de navegação -->
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>
    <div class="box">
        <form action="">
            <fieldset>
                <legend><a>Dados da Vaga</a></legend>
                <!-- Dados puxados -->
                <div class="conteudo-img"><img src="imagens/floresta.jpg" alt="Imagem"></div>
                <div id="eventDataDisplay">

                </div>
                <br>
                <!-- Botão de voltar -->
                <a href="https://ui-ongs.github.io/UI-PwbAval/Vagas.html"><button type="button" class="Voltar">Voltar</button></a>
            </fieldset>

        </form>
    </div>

</body>
</html>
