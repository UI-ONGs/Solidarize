<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Metadados básicos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link para o arquivo CSS do calendário -->
    <link rel="stylesheet" href="css/Calendario.css">
    <!-- Link para o arquivo CSS da barra de navegação -->
    <link rel="stylesheet" href="css/NavBar.css">
    <!-- Link para o Font Awesome (ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link para o arquivo JavaScript do calendário -->
    <script src="js/Calendario.js" defer></script>
    <script src="js/NavBar.js" defer></script>
    <!-- Título da página -->
    <title>Calendário de Eventos</title>
    <!-- Link para o FavIcon -->
    <link rel="icon" href="imagens/logo.png">
</head>
<body>
    <!-- Barra de navegação -->
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Container do Calendário -->
    <div class="container">
        <div class="left">
            <div class="calendar">
                <!-- Navegação do mês -->
                <div class="month">
                    <i class="fa fa-angle-left prev"></i>
                    <div class="date"></div>
                    <i class="fa fa-angle-right next"></i>
                </div>
                <!-- Dias da semana -->
                <div class="weekdays">
                    <div>dom</div>
                    <div>seg</div>
                    <div>ter</div>
                    <div>qua</div>
                    <div>qui</div>
                    <div>sex</div>
                    <div>sáb</div>
                </div>
                <!-- Dias do mês (adicionados via JS) -->
                <div class="days"></div>
                <!-- Seção de navegação rápida -->
                <div class="goto-today">
                    <div class="goto">
                        <input type="text" placeholder="mm/aaaa" class="date-input">
                        <button class="goto-btn">ir</button>
                    </div>
                    <button class="today-btn">hoje</button>
                </div>
            </div>
        </div>
        <div class="right">
            <!-- Data de hoje -->
            <div class="today-date">
                <div class="event-day">Wed</div>
                <div class="event-date">16 November 2022</div>
            </div>
            <!-- Lista de eventos (adicionados via JS) -->
            <div class="events"></div>
            <!-- Formulário para adicionar eventos -->
            <div class="add-event-wrapper">
                <div class="add-event-header">
                    <div class="title">Adicionar Evento</div>
                    <i class="fas fa-times close"></i>
                </div>
                <div class="add-event-body">
                    <div class="add-event-input">
                        <input type="text" placeholder="Nome do Evento" class="event-name">
                    </div>
                    <div class="add-event-input">
                        <input type="text" placeholder="Nome da ONG" class="ong-name">
                    </div>
                    <div class="add-event-input">
                        <input type="text" placeholder="Horário Início" class="event-time-from">
                    </div>
                    <div class="add-event-input">
                        <input type="text" placeholder="Horário Final" class="event-time-to">
                    </div>
                    <div class="add-event-input">
                        <select class="event-category">
                            <option value="" disabled selected>Selecione uma Categoria</option>
                            <option value="Health">Saúde</option>
                            <option value="Education">Educação</option>
                            <option value="Environment">Meio Ambiente</option>
                            <option value="Animal Welfare">Proteção Animal</option>
                        </select>
                    </div>
                    <div class="add-event-input">
                        <input id="file-upload" class="event-photos" type="file" multiple accept="image/*">
                        <label for="file-upload" class="file-count">Selecione um Arquivo</label>
                    </div>
                </div>
                <div class="add-event-footer">
                    <button class="add-event-btn">Adicionar Evento</button>
                </div>            
            </div>            
        </div>
        <!-- Botão para abrir o formulário de adicionar eventos -->
        <button class="add-event">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <!-- Modal de detalhes do evento -->
    <div id="event-dialog" class="event-dialog">
        <div class="event-dialog-content">
            <span class="close-dialog">&times;</span>
            <h2>Detalhes Evento</h2>
            <p id="event-details"></p>
        </div>
    </div>
</body>
</html>
