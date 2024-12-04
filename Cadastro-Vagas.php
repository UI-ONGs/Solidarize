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
        <script src="js/Cadastro-Vagas.js"></script>
        <script src="js/NavBar.js" defer></script>
        <!-- Link para o FavIcon -->
        <link rel="icon" href="imagens/logo.png">
    </head>
    <body>
        <!-- Inclusão da barra de navegação -->
        <?php include 'NavBar.php'; ?>
        <div class="box">
            <!-- formulário -->
            <form method="POST" id="form" action="Cadastro-Vagas.php"> 
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
        <?php
            include_once('config.php'); 

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = htmlspecialchars(trim($_POST['nome']));
                $tipo = htmlspecialchars(trim($_POST['tipo']));
                $endereco = htmlspecialchars(trim($_POST['Endereco']));
                $data = htmlspecialchars(trim($_POST['data']));
                $horario_inicio = htmlspecialchars(trim($_POST['horarioI']));
                $horario_fim = htmlspecialchars(trim($_POST['horarioF']));
                $descricao = htmlspecialchars(trim($_POST['desc']));                

                echo "nome" ;

                $sql = "INSERT INTO vagas (nome, tipo, endereco, data, horarioI, horarioF, descricao) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $mysqli->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param('sssssss', $nome, $tipo, $endereco, $data, $horario_inicio, $horario_fim, $descricao);

                    if (!$stmt->execute()) {
                        echo "<p>Erro ao cadastrar a vaga: " . htmlspecialchars($stmt->error) . "</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Erro na preparação do SQL: " . htmlspecialchars($mysqli->error) . "</p>";
                }
                $mysqli->close();
            }
        ?>
</body>
</html>

<!-- nome, tipo, descricao, data, horário de início e horário final -->