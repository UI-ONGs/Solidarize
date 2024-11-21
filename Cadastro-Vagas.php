<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta class="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar Nova Vaga</title>
        <link rel="stylesheet" href="css/Cadastro-Vagas.css">
        <link rel="stylesheet" href="css/NavBar.css">
        <!--link para utilizar os icones-->
        <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
        <script defer src="js/Cadastro-Vagas.js"></script>
        <script src="js/NavBar.js" defer></script>
        <!-- Link para o FavIcon -->
        <link rel="icon" href="imagens/logo.png">
    </head>
    <body>
        <!-- Barra de navegação -->
        <!-- Include navbar -->
        <?php include 'navbar.php'; ?>
    
        <div class="navbar-mobile">
            <div class="navbar-mobile-header">
                <img src="imagens/logo.png" alt="Solidarize Logo" class="navbar-mobile-logo">
                <button class="navbar-mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <ul class="navbar-mobile-menu">
                <li><a href="index.html"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="Perfil.html"><i class="fas fa-user"></i><span>Perfil</span></a></li>
                <li><a href="Calendario.html"><i class="fas fa-calendar-alt"></i><span>Eventos</span></a></li>
                <li><a href="Vagas.html"><i class="fas fa-hands-helping"></i><span>Voluntariados</span></a></li>
                <li><a href="Geo-Map.html"><i class="fas fa-map-marked-alt"></i><span>Mapa</span></a></li>
                <li><a href="About.html"><i class="fas fa-info-circle"></i><span>Sobre Nós</span></a></li>
            </ul>
        </div>
    
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
        <div class="box">
            <!-- formulário -->
            <form id="form"> 
                <fieldset>
                    <legend><b>Formulário de Vagas</b></legend>
                            <!-- Inputs -->
                        <div class="inputBox">
                            <input type="text" name="nome" id="nome" class="inputUser" required>
                            <label for="nome" class="labelInput">Nome Completo</label>
                        </div>
                        <div class="inputBox">
                            <input type="text" name="tipo" id="tipo" class="inputUser" required>
                            <label for="tipo" class="labelInput">Tipo da Ong</label>
                        </div>
                        
                        <div class="inputBox">
                            <input type="text" name="Endereco" id="Endereco" class="inputUser" required>
                            <label for="Endereco" class="labelInput">Local: </label>
                        </div>
                        
                        <div class="inputBox">
                            <b><label for="data">Data: </label></b>
                            <input type="date" name="data" id="data" class="noWrite" required>
                        </div>
                        
                        <div class="inputBox">
                            <b><label for="horarioI">Horário de início: </label></b>
                            <input type="time" name="horarioI" id="horarioI" class="noWrite" required>
                        </div>
                        
                        <div class="inputBox">
                            <b><label for="horarioF">Horário de término: </label></b>
                            <input type="time" name="horarioF" id="horarioF" class="noWrite" required>
                        </div>
                        <div class="inputBox">
                            <label for="desc" class="labelInput">Descrição</label>
                            <span class="counter">0/1000</span>
                            <textarea name="desc" id="desc" class="inputUser" cols="30" rows="10" required maxlength="1000"></textarea>
                        </div>
                        <div class="botao">
                            <input type="submit" name="submit" id="submit">
                        </div>
                </fieldset>
            </form>
        </div>
</body>
</html>

<!-- nome, tipo, descricao, data, horário de início e horário final -->
