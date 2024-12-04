// DOM Elements
const calendarGrid = document.getElementById('calendar-grid');
const currentMonthElement = document.getElementById('current-month');
const prevMonthButton = document.getElementById('prev-month');
const nextMonthButton = document.getElementById('next-month');
const eventListContainer = document.getElementById('event-list-container');
const newEventButton = document.getElementById('new-event-btn');
const eventModal = document.getElementById('event-modal');
const eventForm = document.getElementById('event-form');
const eventDetailsModal = document.getElementById('event-details-modal');
const attendEventButton = document.getElementById('attend-event-btn');
const dateSearch = document.getElementById('date-search');
const searchBtn = document.getElementById('search-btn');

// Variáveis globais
let currentDate = new Date();
let events = JSON.parse(localStorage.getItem('events')) || [];
let selectedEventId = null;
let map, eventMap, geocoder, marker;

// Categorias dos eventos e cores
const CATEGORIES = {
    'Educação': '#4CAF50',
    'Saúde': '#2196F3',
    'Meio Ambiente': '#FFC107',
    'Direitos Humanos': '#FF5722',
    'Cultura': '#9C27B0'
};

// Inicializa o mapa
function initMaps() {
    const vitoria = [-20.2976, -40.2958]; // Coordenadas de Vitória

    map = L.map('map').setView(vitoria, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    eventMap = L.map('event-details-map').setView(vitoria, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(eventMap);

    // Use o controle geocodificador integrado
    const geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).addTo(map);

    geocoder.on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        map.setView(latlng, 13);
        updateLocationField(e.geocode);
    });

    map.on('click', function(e) {
        geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocationField(results[0]);
            }
        });
    });
}

function updateLocationField(result) {
    const address = result.name || result.html;
    document.getElementById('event-location').value = address;
}


// Renderiza o calendário
function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();

    currentMonthElement.textContent = `${firstDay.toLocaleString('pt-BR', { month: 'long' })} ${year}`;

    calendarGrid.innerHTML = '';

    for (let i = 0; i < firstDay.getDay(); i++) {
        const emptyDay = document.createElement('div');
        emptyDay.classList.add('calendar-day');
        calendarGrid.appendChild(emptyDay);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('calendar-day');
        dayElement.textContent = day;

        const dateString = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        const isToday = dateString === new Date().toISOString().split('T')[0];
        if (isToday) {
            dayElement.classList.add('today');
        }

        const dayEvents = events.filter(event => event.date === dateString);
        if (dayEvents.length > 0) {
            const eventIndicator = document.createElement('div');
            eventIndicator.classList.add('event-indicator');
            dayEvents.slice(0, 3).forEach(event => {
                const dot = document.createElement('span');
                dot.style.backgroundColor = CATEGORIES[event.category];
                eventIndicator.appendChild(dot);
            });
            dayElement.appendChild(eventIndicator);
        }

        dayElement.addEventListener('click', () => showEventsForDay(dateString));

        calendarGrid.appendChild(dayElement);
    }
}

// Mostra os eventos do dia especifico
function showEventsForDay(dateString) {
    eventListContainer.innerHTML = '';
    const dayEvents = events.filter(event => event.date === dateString);

    if (dayEvents.length > 0) {
        dayEvents.forEach(event => {
            const eventItem = document.createElement('div');
            eventItem.classList.add('event-item');
            eventItem.innerHTML = `
                <h3>${event.title}</h3>
                <p>${event.category}</p>
            `;
            eventItem.addEventListener('click', () => showEventDetails(event));
            eventListContainer.appendChild(eventItem);
        });
    } else {
        eventListContainer.innerHTML = '<p>Nenhum evento para este dia.</p>';
    }

    document.querySelectorAll('.calendar-day').forEach(day => {
        day.classList.remove('active');
        if (day.textContent === dateString.split('-')[2]) {
            day.classList.add('active');
        }
    });
}

// Mostre os detalhes do evento especifico
function showEventDetails(event) {
    selectedEventId = event.id;
    document.getElementById('event-details-title').textContent = event.title;
    document.getElementById('event-details-institution').textContent = event.institution;
    document.getElementById('event-details-category').textContent = event.category;
    document.getElementById('event-details-date').textContent = new Date(event.date).toLocaleDateString('pt-BR');
    document.getElementById('event-details-time').textContent = event.time;
    document.getElementById('event-details-location').textContent = event.location;
    document.getElementById('event-details-description').textContent = event.description;
    document.getElementById('event-details-capacity').textContent = event.capacity;
    document.getElementById('event-details-attendance').textContent = event.attendance;
    document.getElementById('event-details-contact').textContent = event.contact;
    document.getElementById('event-details-sponsors').textContent = event.sponsors || 'Não informado';

    const imageSlider = document.getElementById('event-images-slider');
    const sliderDots = document.getElementById('slider-dots');
    imageSlider.innerHTML = '';
    sliderDots.innerHTML = '';

    event.images.forEach((image, index) => {
        const img = document.createElement('img');
        img.src = image;
        img.alt = `Imagem ${index + 1} do evento`;
        img.classList.toggle('active', index === 0);
        imageSlider.appendChild(img);

        const dot = document.createElement('div');
        dot.classList.add('slider-dot');
        dot.classList.toggle('active', index === 0);
        dot.addEventListener('click', () => changeSlide(index));
        sliderDots.appendChild(dot);
    });

    attendEventButton.disabled = event.attendance >= event.capacity;

    // Atualiza o Mapa
    eventMap.setView([event.latitude, event.longitude], 13);
    L.marker([event.latitude, event.longitude]).addTo(eventMap);

    eventDetailsModal.style.display = 'block';
}

// Muda a imagem do slider
function changeSlide(index) {
    const images = document.querySelectorAll('#event-images-slider img');
    const dots = document.querySelectorAll('#slider-dots .slider-dot');

    images.forEach((img, i) => {
        img.classList.toggle('active', i === index);
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

// Cria um novo evento
function createEvent(e) {
    e.preventDefault();
    const title = document.getElementById('event-title').value;
    const date = document.getElementById('event-date').value;
    const time = document.getElementById('event-time').value;
    const institution = document.getElementById('event-institution').value;
    const category = document.getElementById('event-category').value;
    const description = document.getElementById('event-description').value;
    const capacity = parseInt(document.getElementById('event-capacity').value);
    const location = document.getElementById('event-location').value;
    const contact = document.getElementById('event-contact').value;
    const sponsors = document.getElementById('event-sponsors').value;
    const imageFiles = document.getElementById('event-images').files;

    if (imageFiles.length < 3 || imageFiles.length > 5) {
        alert('Por favor, selecione de 3 a 5 imagens.');
        return;
    }

    const imagePromises = Array.from(imageFiles).map(file => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    });

    Promise.all(imagePromises).then(images => {
        const newEvent = {
            id: Date.now().toString(),
            title,
            date,
            time,
            institution,
            category,
            description,
            capacity,
            attendance: 0,
            images,
            location,
            contact,
            sponsors,
            latitude: marker.getLatLng().lat,
            longitude: marker.getLatLng().lng
        };

        events.push(newEvent);
        localStorage.setItem('events', JSON.stringify(events));
        renderCalendar();
        showEventsForDay(date);
        eventModal.style.display = 'none';
        eventForm.reset();
    });
}

// Participar do evento
function attendEvent() {
    const event = events.find(e => e.id === selectedEventId);
    if (event && event.attendance < event.capacity) {
        event.attendance++;
        localStorage.setItem('events', JSON.stringify(events));
        showEventDetails(event);
    }
}

// Listeners do evento
prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

newEventButton.addEventListener('click', () => {
    eventModal.style.display = 'block';
    setTimeout(() => {
        map.invalidateSize();
    }, 100);
});

eventForm.addEventListener('submit', createEvent);

attendEventButton.addEventListener('click', attendEvent);

document.querySelectorAll('.close').forEach(closeButton => {
    closeButton.addEventListener('click', () => {
        eventModal.style.display = 'none';
        eventDetailsModal.style.display = 'none';
    });
});

window.addEventListener('click', (e) => {
    if (e.target === eventModal || e.target === eventDetailsModal) {
        eventModal.style.display = 'none';
        eventDetailsModal.style.display = 'none';
    }
});

searchBtn.addEventListener('click', () => {
    const searchDate = dateSearch.value;
    if (searchDate) {
        currentDate = new Date(searchDate);
        renderCalendar();
        showEventsForDay(searchDate);
    }
});

// Preview da Imagem
document.getElementById('event-images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    for (const file of e.target.files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }
        reader.readAs

DataURL(file);
    }
});

document.getElementById('event-images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    const files = e.target.files;

    if (files.length < 3 || files.length > 5) {
        alert('Por favor, selecione de 3 a 5 imagens.');
        e.target.value = ''; // Limpa o input
        return;
    }

    for (const file of files) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }
});

// Inicializa
initMaps();
renderCalendar();
showEventsForDay(new Date().toISOString().split('T')[0]);

// Add default events if there are no events
if (events.length === 0) {
    const defaultEvents = [
        {
            id: '1',
            title: 'Campanha de Vacinação',
            date: '2023-09-15',
            time: '09:00',
            institution: 'Hospital Municipal',
            category: 'Saúde',
            description: 'Campanha de vacinação contra a gripe para idosos e crianças.',
            capacity: 100,
            attendance: 0,
            images: ['/placeholder.svg?height=300&width=400'],
            location: 'Praça Central, Vitória - ES',
            contact: '(27) 3333-4444',
            sponsors: 'Prefeitura de Vitória',
            latitude: -20.2976,
            longitude: -40.2958
        },
        {
            id: '2',
            title: 'Plantio de Árvores',
            date: '2023-09-22',
            time: '10:00',
            institution: 'Secretaria do Meio Ambiente',
            category: 'Meio Ambiente',
            description: 'Ação de plantio de árvores no Parque Moscoso.',
            capacity: 50,
            attendance: 0,
            images: ['/placeholder.svg?height=300&width=400'],
            location: 'Parque Moscoso, Vitória - ES',
            contact: '(27) 3333-5555',
            sponsors: 'Empresa Verde Ltda.',
            latitude: -20.3195,
            longitude: -40.3364
        },
        {
            id: '3',
            title: 'Aula de Música para Crianças',
            date: '2023-09-30',
            time: '14:00',
            institution: 'Escola de Música Harmonia',
            category: 'Cultura',
            description: 'Aulas gratuitas de música para crianças de comunidades carentes.',
            capacity: 30,
            attendance: 0,
            images: ['/placeholder.svg?height=300&width=400'],
            location: 'Centro Cultural Carmélia, Vitória - ES',
            contact: '(27) 3333-6666',
            sponsors: 'Instituto Cultural ABC',
            latitude: -20.3119,
            longitude: -40.2968
        }
    ];

    events = defaultEvents;
    localStorage.setItem('events', JSON.stringify(events));
    renderCalendar();
}