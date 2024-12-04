<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos ONG</title>
    <link rel="stylesheet" href="css/Calendario.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/NavBar.css">
    <script src="js/NavBar.js" defer></script>
    <script src="js/Calendario.js" defer></script>
</head>
<body>
    <!-- Include navbar -->
    <?php include 'NavBar.php'; ?>
    <main class="main-content">
        <div class="container">
            <h1>Calendário de Eventos ONG</h1>
            <div class="search-bar">
                <input type="date" id="date-search" aria-label="Pesquisar por data">
                <button id="search-btn">Pesquisar</button>
            </div>
            <div class="calendar-container">
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prev-month">&lt;</button>
                        <h2 id="current-month"></h2>
                        <button id="next-month">&gt;</button>
                    </div>
                    <div class="weekdays">
                        <div>Dom</div>
                        <div>Seg</div>
                        <div>Ter</div>
                        <div>Qua</div>
                        <div>Qui</div>
                        <div>Sex</div>
                        <div>Sáb</div>
                    </div>
                    <div class="calendar-grid" id="calendar-grid"></div>
                </div>
                <div class="event-list">
                    <h2>Eventos do Dia</h2>
                    <div id="event-list-container"></div>
                    <button class="new-event-btn" id="new-event-btn">Novo Evento</button>
                </div>
            </div>
        </div>

        <div id="event-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Novo Evento</h2>
                <form id="event-form">
                    <div class="form-grid">
                        <div class="form-column">
                            <input type="text" id="event-title" placeholder="Título do Evento" required>
                            <input type="date" id="event-date" required>
                            <input type="time" id="event-time" required>
                            <input type="text" id="event-institution" placeholder="Nome da Instituição" required>
                            <select id="event-category" required>
                                <option value="">Selecione uma categoria</option>
                                <option value="Educação">Educação</option>
                                <option value="Saúde">Saúde</option>
                                <option value="Meio Ambiente">Meio Ambiente</option>
                                <option value="Direitos Humanos">Direitos Humanos</option>
                                <option value="Cultura">Cultura</option>
                            </select>
                            <input type="number" id="event-capacity" placeholder="Capacidade" required min="1">
                            <input type="text" id="event-location" placeholder="Local do Evento" required>
                            <input type="text" id="event-contact" placeholder="Contato" required>
                            <input type="text" id="event-sponsors" placeholder="Patrocinadores (opcional)">
                        </div>
                        <div class="form-column">
                            <textarea id="event-description" placeholder="Descrição detalhada do Evento" required rows="5"></textarea>
                            <div id="map-container">
                                <div id="map"></div>
                            </div>
                            <div class="file-input-container">
                                <input type="file" id="event-images" accept="image/*" multiple required>
                                <label for="event-images">Escolher Imagens (3-5)</label>
                            </div>
                            <div id="image-preview" class="image-preview-container"></div>                    
                        </div>
                    </div>
                    <button type="submit" id="create-event-btn">Criar Evento</button>
                </form>
            </div>
        </div>

        <div id="event-details-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="event-details-title"></h2>
                <div class="event-details-grid">
                    <div class="event-details-column">
                        <p><strong>Instituição:</strong> <span id="event-details-institution"></span></p>
                        <p><strong>Categoria:</strong> <span id="event-details-category"></span></p>
                        <p><strong>Data:</strong> <span id="event-details-date"></span></p>
                        <p><strong>Horário:</strong> <span id="event-details-time"></span></p>
                        <p><strong>Local:</strong> <span id="event-details-location"></span></p>
                        <p><strong>Capacidade:</strong> <span id="event-details-capacity"></span></p>
                        <p><strong>Presenças:</strong> <span id="event-details-attendance"></span></p>
                        <p><strong>Contato:</strong> <span id="event-details-contact"></span></p>
                        <p><strong>Patrocinadores:</strong> <span id="event-details-sponsors"></span></p>
                        <button id="attend-event-btn">Confirmar Presença</button>
                    </div>
                    <div class="event-details-column">
                        <div class="image-slider" id="event-images-slider"></div>
                        <div class="slider-dots" id="slider-dots"></div>
                        <p><strong>Descrição:</strong></p>
                        <p id="event-details-description"></p>
                        <div id="event-details-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
</body>
</html>