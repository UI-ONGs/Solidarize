let currentCategory = "instituicao"; // Categoria padrão
document.addEventListener("DOMContentLoaded", function () {
    initMap(); // Inicializa o mapa
    const btn = document.getElementById("btn");
    const switchDiv = document.querySelector(".switch");

    // Função para clique no lado esquerdo
    function leftClick() {
        btn.style.left = '0'; // Move o botão para a esquerda
        currentCategory = "instituicao"; // Define a categoria como instituicao
        filterMarkers(currentCategory); // Filtra os marcadores pela categoria
    }

    // Função para clique no lado direito
    function rightClick() {
        const switchWidth = switchDiv.offsetWidth;
        const btnWidth = btn.offsetWidth;
        btn.style.left = (switchWidth - btnWidth - 6) + 'px'; // Move o botão para a direita
        currentCategory = "evento"; // Define a categoria como evento
        filterMarkers(currentCategory); // Filtra os marcadores pela categoria
    }

    // Adiciona eventos de clique aos botões de alternância
    document.querySelector(".toggle-btn:nth-of-type(1)").addEventListener("click", leftClick);
    document.querySelector(".toggle-btn:nth-of-type(2)").addEventListener("click", rightClick);

    // Evento de redimensionamento da janela
    window.addEventListener("resize", function () {
        if (btn.style.left !== '0') {
            rightClick(); // Se o botão não estiver à esquerda, clica no lado direito
        }
    });
});

let map;
let currentInfoWindow = null;
let geocoder;
let markersArray = [];
let allMarkers = []; // Array para manter todos os marcadores

// Inicializa o mapa
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -20.3155, lng: -40.3128 }, // Coordenadas do centro do mapa
        zoom: 12 // Nível de zoom
    });

    geocoder = new google.maps.Geocoder();

    loadMarkers(); // Carrega os marcadores
    console.log("a");
    map.addListener('click', function (event) {
        console.log("b");
        showAddLocationForm(event.latLng); // Exibe o formulário para adicionar localização
        console.log("c");
    });
}

// Exibe o formulário para adicionar localização
function showAddLocationForm(location) {
    if (currentInfoWindow) {
        currentInfoWindow.close();
    }

    geocoder.geocode({ location: location }, function (results, status) {
        if (status === 'OK' && results[0]) {
            // Extrai informações de endereço
            const address = results[0].formatted_address;
            const addressComponents = results[0].address_components;
            let street = '';
            let neighborhood = '';
            let city = '';

            for (const component of addressComponents) {
                if (component.types.includes('route')) {
                    street = component.long_name;
                }
                if (component.types.includes('sublocality') || component.types.includes('political')) {
                    neighborhood = component.long_name;
                }
                if (component.types.includes('administrative_area_level_2')) {
                    city = component.long_name;
                }
            }

            // Formulário HTML
            const formHtml = `
                <div id="form">
                    <h3>Adicionar Local</h3>
                    <label>Nome:</label><br>
                    <input type="text" id="name"><br>
                    <label>Descrição:</label><br>
                    <textarea id="description"></textarea><br>
                    <label>Imagens:</label><br>
                    <input type="file" id="images" multiple><br>
                    <p>Endereço: ${address}</p>
                    <p>Rua: ${street}</p>
                    <p>Bairro: ${neighborhood}</p>
                    <p>Cidade: ${city}</p>
                    <button onclick="addMarker('${street}', '${neighborhood}', '${city}', ${location.lat()}, ${location.lng()}, '${currentCategory}')">Adicionar</button>
                </div>
            `;

            // Janela de informações do Google Maps
            const infoWindow = new google.maps.InfoWindow({
                content: formHtml,
                position: location
            });

            infoWindow.open(map);
            currentInfoWindow = infoWindow;
        } else {
            alert('Geocoder falhou devido a: ' + status);
        }
    });
}

// Adiciona um marcador
function addMarker(street, neighborhood, city, lat, lng, category) {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const imageFiles = document.getElementById('images').files;

    let images = [];
    if (imageFiles.length > 0) {
        // Carrega imagens
        const promises = Array.from(imageFiles).map(file => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = function () {
                    resolve(reader.result);
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        });

        Promise.all(promises).then(results => {
            images = results;
            saveMarker({ lat, lng, name, description, category, images, street, neighborhood, city });
            createMarker({ lat, lng, name, description, category, images, street, neighborhood, city });
        }).catch(error => {
            console.error("Error loading images: ", error);
        });
    } else {
        saveMarker({ lat, lng, name, description, category, street, neighborhood, city });
        createMarker({ lat, lng, name, description, category, street, neighborhood, city });
    }

    if (currentInfoWindow) {
        currentInfoWindow.close();
    }
}

// Salva um marcador
function saveMarker(marker) {
    let markers = JSON.parse(localStorage.getItem('markers')) || [];
    markers.push(marker);
    localStorage.setItem('markers', JSON.stringify(markers));
    allMarkers.push(marker);
}

// Carrega marcadores
function loadMarkers() {
    let markers = JSON.parse(localStorage.getItem('markers')) || [];
    markers.forEach(marker => {
        createMarker(marker);
        allMarkers.push(marker);
    });
}

// Cria um marcador no mapa
function createMarker({ lat, lng, name, description, category, images, street, neighborhood, city }) {
    const location = { lat: parseFloat(lat), lng: parseFloat(lng) };

    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: name,
        category: category // Adiciona a categoria ao marcador
    });

    markersArray.push(marker);

    // Evento de clique no marcador
    marker.addListener('click', function () {
        displayMarkerInfo({ name, description, category, images, street, neighborhood, city, lat, lng });
    });

    map.panTo(location);
}

// Exibe informações do marcador
function displayMarkerInfo({ name, description, category, images, street, neighborhood, city, lat, lng }) {
    const infoDiv = document.querySelector(".info");
    let imageHtml = '';

    // Verifica se há imagens e cria HTML correspondente
    if (images && images.length > 0) {
        imageHtml = `
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    ${images.map((_, index) => `<li data-target="#carouselExampleIndicators" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>`).join('')}
                </ol>
                <div class="carousel-inner">
                    ${images.map((image, index) => `<div class="carousel-item ${index === 0 ? 'active' : ''}"><img src="${image}" class="d-block w-100"></div>`).join('')}
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        `;
    }

    // Insere as informações do marcador na div de informações
    infoDiv.innerHTML = `
        <h3>${name}</h3>
        <p>${description}</p>
        <p>Categoria: ${category.charAt(0).toUpperCase() + category.slice(1)}</p>
        <p>Endereço: ${street}, ${neighborhood}, ${city}</p>
        <p>Coordenadas: ${lat}, ${lng}</p>
        ${imageHtml}
        <button onclick="deleteMarker(${lat}, ${lng})">Excluir</button>
    `;
}

// Exclui um marcador
function deleteMarker(lat, lng) {
    let markers = JSON.parse(localStorage.getItem('markers')) || [];
    markers = markers.filter(marker => marker.lat !== lat || marker.lng !== lng);
    localStorage.setItem('markers', JSON.stringify(markers));

    clearMarkers(); // Limpa os marcadores do mapa
    loadMarkers(); // Recarrega os marcadores

    const infoDiv = document.querySelector(".info");
    infoDiv.innerHTML = ''; // Limpa a div de informações
}

// Limpa os marcadores do mapa
function clearMarkers() {
    for (let i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray = [];
}

// Evento de clique no botão "Ir para"
document.querySelector("#go-to").addEventListener("click", function() {
    const address = document.getElementById("searchBox").value;
    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
        } else {
            alert('Geocode was not successful devido a: ' + status);
        }
    });
});

// Filtra os marcadores pela categoria
function filterMarkers(category) {
    clearMarkers(); // Limpa os marcadores do mapa
    let markers = JSON.parse(localStorage.getItem('markers')) || [];
    markers = markers.filter(marker => marker.category === category);
    markers.forEach(marker => {
        createMarker(marker); // Cria os marcadores filtrados
    });
}

