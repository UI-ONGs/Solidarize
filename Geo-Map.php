<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoMap Vitória</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/NavBar.css">
    <link rel="stylesheet" href="css/Geo-Map.css">
    <link rel="icon" href="imagens/logo.png">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/Geo-Map.js" defer></script>
    <script src="js/NavBar.js" defer></script>
</head>
<body>
    <!-- Include navbar -->
    <?php include 'NavBar.php'; ?>

    <div class="container">
        <div class="controls">
            <div class="search-container">
                <input type="text" id="search" placeholder="Pesquise por nome de uma instituição ou evento...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="toggle-container">
                <div class="toggle-option active">ONGs</div>
                <div class="toggle-option">Eventos</div>
                <div class="toggle-switch"></div>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <button class="close-btn">&times;</button>
            <h2></h2>
            <div class="carousel">
                <div class="carousel-inner"></div>
                <div class="carousel-dots"></div>
            </div>
            <p class="description"></p>
            <p class="address"></p>
            <p class="institution"></p>
            <a href="#" class="see-more-btn">Ver mais</a>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</body>
</html>