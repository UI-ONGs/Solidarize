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
    <link rel="icon" href="imagens/logo.png">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/NavBar.js"></script>
    <style>
        :root {
            --primary-color: #4A7B78;
            --secondary-color: #6DA0A6;
            --tertiary-color: #335351;
            --background-color: #f6f6f6;
            --text-color: #333333;
            --white: #ffffff;
            --gray: #cccccc;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        #map {
            height: calc(100vh - 200px);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: var(--white);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            flex-grow: 1;
            margin-right: 20px;
            position: relative;
        }

        #search {
            width: 100%;
            padding: 12px 40px 12px 15px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            background-color: var(--background-color);
            transition: var(--transition);
        }

        #search:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--secondary-color);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            cursor: pointer;
        }

        .toggle-container {
            position: relative;
            width: 200px;
            height: 40px;
            background-color: var(--background-color);
            border-radius: 20px;
            cursor: pointer;
            overflow: hidden;
        }

        .toggle-option {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: var(--transition);
            z-index: 1;
        }

        .toggle-option:first-child {
            left: 0;
        }

        .toggle-option:last-child {
            right: 0;
        }

        .toggle-switch {
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(50% - 4px);
            height: calc(100% - 4px);
            background-color: var(--primary-color);
            border-radius: 18px;
            transition: var(--transition);
        }

        .toggle-container.events .toggle-switch {
            left: calc(50% + 2px);
        }

        .toggle-option:nth-child(2){
            right: 0;
        }

        .toggle-container .toggle-option {
            color: var(--text-color);
        }

        .toggle-container .toggle-option.active {
            color: var(--white);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: block;
            opacity: 1;
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            width: 90%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(-50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show .modal-content {
            transform: translateY(0);
            opacity: 1;
        }

        .modal h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .carousel {
            position: relative;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .carousel-inner {
            display: flex;
            transition: transform 0.3s ease;
        }

        .carousel-item {
            flex: 0 0 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--gray);
            margin: 0 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .carousel-dot.active {
            background-color: var(--primary-color);
        }

        .modal p {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .modal .address {
            font-style: italic;
            color: var(--gray);
        }

        .modal .institution {
            font-weight: bold;
            color: var(--secondary-color);
        }

        .close-btn {
            position: absolute;
            top: 0;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 3rem;
            color: var(--primary-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .close-btn:hover {
            color: var(--tertiary-color);
        }

        .see-more-btn {
            background-color: var(--primary-color);
            border: none;
            border-radius: 25px;
            color: var(--white);
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            transition: var(--transition);
            display: inline-block;
            margin-top: 10px;
        }

        .see-more-btn:hover {
            background-color: var(--tertiary-color);
        }

        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .toggle-container {
                width: 100%;
            }

            .modal-content {
                padding: 20px;
            }

            .carousel-item img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>
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
    <script>
        const map = L.map('map').setView([-20.2976, -40.2958], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const toggleContainer = document.querySelector('.toggle-container');
        const toggleOptions = document.querySelectorAll('.toggle-option');
        const modal = document.getElementById('modal');
        const closeBtn = document.querySelector('.close-btn');
        const searchInput = document.getElementById('search');
        const searchIcon = document.querySelector('.search-icon');
        const carouselInner = document.querySelector('.carousel-inner');
        const carouselDots = document.querySelector('.carousel-dots');

        let currentMode = 'ngos';
        let markers = [];
        let currentSlide = 0;

        const data = {
            ngos: [
                {
                    name: 'ONG Vitória Solidária',
                    lat: -20.2976,
                    lng: -40.2958,
                    description: 'ONG dedicada a ajudar pessoas em situação de vulnerabilidade social em Vitória. Nossos projetos incluem distribuição de alimentos, aulas de reforço escolar e oficinas profissionalizantes.',
                    address: 'Av. Marechal Campos, 1355 - Santa Cecília, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    fullDescription: 'A ONG Vitória Solidária atua há mais de 10 anos na região de Vitória, promovendo ações sociais e projetos que visam melhorar a qualidade de vida das pessoas em situação de vulnerabilidade. Nosso trabalho é baseado em três pilares principais: assistência social, educação e capacitação profissional. Contamos com uma equipe de voluntários dedicados e parcerias com empresas locais para realizar nossas atividades.'
                },
                {
                    name: 'Instituto Capixaba',
                    lat: -20.3118,
                    lng: -40.2927,
                    description: 'Organização que promove educação e cultura para jovens em Vitória. Oferecemos cursos de arte, música e teatro, além de atividades esportivas.',
                    address: 'R. José de Anchieta, 56 - Parque Moscoso, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    fullDescription: 'O Instituto Capixaba é uma organização sem fins lucrativos fundada em 2005 com o objetivo de proporcionar acesso à educação e cultura para jovens de comunidades carentes de Vitória. Nossos programas incluem aulas de música, artes plásticas, teatro e dança, além de oficinas de literatura e cinema. Também oferecemos atividades esportivas como forma de promover a saúde e o bem-estar dos participantes.'
                },
                {
                    name: 'Ação Ambiental ES',
                    lat: -20.3187,
                    lng: -40.3392,
                    description: 'ONG focada na preservação do meio ambiente e educação ambiental no Espírito Santo. Realizamos ações de limpeza de praias, reflorestamento e palestras em escolas.',
                    address: 'Av. Fernando Ferrari, 1080 - Mata da Praia, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    fullDescription: 'A Ação Ambiental ES é uma organização não governamental dedicada à preservação do meio ambiente e à promoção da educação ambiental no estado do Espírito Santo. Fundada em 2010 por um grupo de ambientalistas e biólogos, nossa ONG realiza diversas atividades como limpeza de praias e manguezais, projetos de reflorestamento, monitoramento da qualidade da água e do ar, além de programas educativos em escolas e comunidades.'
                },
            ],
            events: [
                {
                    name: 'Festival de Cultura Capixaba',
                    lat: -20.3199,
                    lng: -40.3377,
                    description: 'Evento cultural celebrando as tradições e arte do Espírito Santo. O festival contará com apresentações musicais, dança, teatro e exposições de artesanato local.',
                    address: 'Parque Pedra da Cebola - Mata da Praia, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    institution: 'Instituto Capixaba',
                    fullDescription: 'O Festival de Cultura Capixaba é um evento anual que celebra a rica herança cultural do Espírito Santo. Durante três dias, o Parque Pedra da Cebola se transforma em um verdadeiro centro cultural a céu aberto, oferecendo uma programação diversificada que inclui shows musicais, apresentações de dança folclórica, peças teatrais, exposições de arte e artesanato, além de uma praça de alimentação com comidas típicas da região. O evento é uma oportunidade única para moradores e turistas conhecerem e valorizarem a cultura capixaba.'
                },
                {
                    name: 'Mutirão de Limpeza da Praia',
                    lat: -20.3347,
                    lng: -40.2869,
                    description: 'Ação voluntária para limpeza da Praia de Camburi. Junte-se a nós neste importante evento de conscientização ambiental e preservação de nossas praias.',
                    address: 'Praia de Camburi - Jardim da Penha, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    institution: 'Ação Ambiental ES',
                    fullDescription: 'O Mutirão de Limpeza da Praia é uma iniciativa da Ação Ambiental ES em parceria com a Prefeitura de Vitória. Este evento semestral reúne centenas de voluntários para uma ação coletiva de limpeza da Praia de Camburi, uma das mais importantes áreas de lazer e turismo da cidade. Além da coleta de lixo, o mutirão inclui atividades educativas sobre a importância da preservação ambiental, o impacto do lixo marinho na vida marinha e dicas práticas para redução do uso de plásticos no dia a dia.'
                },
                {
                    name: 'Feira Solidária de Vitória',
                    lat: -20.3195,
                    lng: -40.3386,
                    description: 'Feira beneficente com produtos locais e artesanato. Toda a renda será revertida para projetos sociais em Vitória.',
                    address: 'Praça dos Namorados - Praia do Canto, Vitória - ES',
                    images: [
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400',
                        'https://via.placeholder.com/800x400'
                    ],
                    institution: 'ONG Vitória Solidária',
                    fullDescription: 'A Feira Solidária de Vitória é um evento mensal organizado pela ONG Vitória Solidária em colaboração com artesãos e produtores locais. A feira oferece uma variedade de produtos artesanais, alimentos orgânicos, plantas ornamentais e itens de decoração, todos produzidos por membros da comunidade local. Além de promover o empreendedorismo local, 100% da renda obtida com as taxas de participação dos expositores é destinada a projetos sociais em áreas carentes de Vitória, como melhorias em creches comunitárias e programas de capacitação profissional.'
                },
            ]
        };

        function addMarkers(items) {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            items.forEach(item => {
                const marker = L.marker([item.lat, item.lng]).addTo(map);
                marker.on('click', () => showModal(item));
                markers.push(marker);
            });
        }

        function showModal(item) {
            modal.querySelector('h2').textContent = item.name;
            modal.querySelector('.description').textContent = item.description;
            modal.querySelector('.address').textContent = `Endereço: ${item.address}`;
            
            const institutionElement = modal.querySelector('.institution');
            if (item.institution) {
                institutionElement.textContent = `Instituição: ${item.institution}`;
                institutionElement.style.display = 'block';
            } else {
                institutionElement.style.display = 'none';
            }

            carouselInner.innerHTML = '';
            carouselDots.innerHTML = '';
            item.images.forEach((image, index) => {
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');
                carouselItem.innerHTML = `<img src="${image}" alt="${item.name} - Imagem ${index + 1}">`;
                carouselInner.appendChild(carouselItem);

                const dot = document.createElement('div');
                dot.classList.add('carousel-dot');
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateCarousel();
                });
                carouselDots.appendChild(dot);
            });

            currentSlide = 0;
            updateCarousel();

            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function updateCarousel() {
            carouselInner.style.transform = `translateX(-${currentSlide * 100}%)`;
            const dots = carouselDots.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        let startX, moveX;
        carouselInner.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX;
        });

        carouselInner.addEventListener('touchmove', (e) => {
            moveX = e.touches[0].pageX;
        });

        carouselInner.addEventListener('touchend', () => {
            if (startX - moveX > 50 && currentSlide < carouselInner.children.length - 1) {
                currentSlide++;
            } else if (moveX - startX > 50 && currentSlide > 0) {
                currentSlide--;
            }
            updateCarousel();
        });

        toggleContainer.addEventListener('click', () => {
            toggleContainer.classList.toggle('events');
            toggleOptions.forEach(option => option.classList.toggle('active'));
            currentMode = toggleContainer.classList.contains('events') ? 'events' : 'ngos';
            addMarkers(data[currentMode]);
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            const filteredItems = data[currentMode].filter(item => 
                item.name.toLowerCase().includes(searchTerm) || 
                item.address.toLowerCase().includes(searchTerm)
            );
            addMarkers(filteredItems);

            if (filteredItems.length === 1) {
                map.setView([filteredItems[0].lat, filteredItems[0].lng], 15);
            }
        }

        searchInput.addEventListener('input', performSearch);

        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && markers.length === 1) {
                map.setView(markers[0].getLatLng(), 15);
            }
        });

        searchIcon.addEventListener('click', () => {
            if (markers.length === 1) {
                map.setView(markers[0].getLatLng(), 15);
            }
        });

        addMarkers(data.ngos);
    </script>
</body>
</html>
