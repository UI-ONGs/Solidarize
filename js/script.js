/*Define um Array de ONGS*/

let ongs = [
    {
        "nome": "Educar para o Futuro",
        "descricao": "Promovemos educação de qualidade para crianças e jovens.",
        "descricao_detalhada": "A Educar para o Futuro atua na promoção da educação de qualidade para crianças e jovens em situação de vulnerabilidade social no Espírito Santo. Através de programas educacionais inovadores e de acompanhamento individualizado, a organização busca garantir o acesso à educação e o desenvolvimento de habilidades essenciais para o futuro dos participantes. Atuando em parceria com escolas e comunidades, a Educar para o Futuro contribui para a construção de uma sociedade mais justa e igualitária.",
        "categoria": "Educação",
        "endereco": "Rua das Palmeiras, 123, Bairro Centro, Vitória, ES",
        "contato": {
            "instagram": "https://instagram.com/educarparafuturo",
            "facebook": "https://facebook.com/educarparafuturo",
            "telefone": "(27) 3333-1234",
            "email": "contato@educarparafuturo.org"
        }
    },
    {
        "nome": "Saúde e Vida",
        "descricao": "Assistência médica gratuita para comunidades carentes.",
        "descricao_detalhada": "A Saúde e Vida oferece assistência médica gratuita e de qualidade para comunidades carentes na Grande Vitória. Através de consultas médicas, exames, vacinação e ações de prevenção em saúde, a organização busca promover o bem-estar da população e reduzir as desigualdades no acesso à saúde. Atuando em parceria com postos de saúde e unidades móveis, a Saúde e Vida leva saúde para quem mais precisa.",
        "categoria": "Saúde",
        "endereco": "Avenida dos Andradas, 456, Bairro Jucutuquara, Vitória, ES",
        "contato": {
            "instagram": "https://instagram.com/saudeevida",
            "facebook": "https://facebook.com/saudeevida",
            "telefone": "(27) 3344-5678",
            "email": "contato@saudeevida.org"
        }
    },
    {
        "nome": "Cidadania Ativa",
        "descricao": "Empoderamento e defesa dos direitos humanos.",
        "descricao_detalhada": "A Cidadania Ativa é uma organização dedicada à defesa e promoção dos direitos humanos no Espírito Santo. Através de ações de conscientização, assessoria jurídica, acompanhamento de casos e advocacy, a organização busca fortalecer os direitos da população e garantir o acesso à justiça. Atuando em parceria com movimentos sociais e órgãos públicos, a Cidadania Ativa contribui para a construção de uma sociedade mais justa e democrática.",
        "categoria": "Direitos Humanos",
        "endereco": "Rua Sete de Setembro, 789, Bairro Praia do Canto, Vitória, ES",
        "contato": {
            "instagram": "https://instagram.com/cidadaniaativa",
            "facebook": "https://facebook.com/cidadaniaativa",
            "telefone": "(27) 3355-7890",
            "email": "contato@cidadaniaativa.org"
        }
    },
    {
        "nome": "Verde Esperança",
        "descricao": "Preservação ambiental e educação ecológica.",
        "descricao_detalhada": "A Verde Esperança trabalha pela preservação ambiental e pela educação ecológica no Espírito Santo. Através de ações de reflorestamento, proteção de áreas verdes, campanhas de conscientização e programas educativos, a organização busca promover a sustentabilidade e o respeito ao meio ambiente. Atuando em parceria com escolas, comunidades e órgãos públicos, a Verde Esperança contribui para a construção de um futuro mais verde e sustentável.",
        "categoria": "Meio Ambiente",
        "endereco": "Rua dos Ipês, 101, Bairro Jardim Camburi, Vitória, ES",
        "contato": {
            "instagram": "https://instagram.com/verdeesperanca",
            "facebook": "https://facebook.com/verdeesperanca",
            "telefone": "(27) 3366-1011",
            "email": "contato@verdeesperanca.org"
        }
    },
    {
        "nome": "Amigos do Bem-Estar",
        "descricao": "Apoio psicológico e emocional para a comunidade.",
        "descricao_detalhada": "A Amigos do Bem-Estar oferece suporte emocional e psicológico para pessoas em situação de vulnerabilidade no Espírito Santo. Através de terapias individuais e em grupo, oficinas socioeducativas e rodas de conversa, a organização busca promover o bem-estar mental, a saúde emocional e a qualidade de vida da população. Atuando em parceria com centros comunitários e unidades de saúde mental, a Amigos do Bem-Estar contribui para a quebra de tabus relacionados à saúde mental e para a criação de uma rede de apoio social.",
        "categoria": "Saúde Mental",
        "endereco": "Avenida Getúlio Vargas, 202, Bairro Centro, Vila Velha, ES",
        "contato": {
            "instagram": "https://instagram.com/amigosdobemestar",
            "facebook": "https://facebook.com/amigosdobemestar",
            "telefone": "(27) 3377-2022",
            "email": "contato@amigosdobemestar.org"
        }
    },
    {
        "nome": "Mãos que Ajudam",
        "descricao": "Assistência a famílias em situação de rua.",
        "descricao_detalhada": "A Mãos que Ajudam oferece assistência e suporte a famílias em situação de rua no Espírito Santo. Através de doações de alimentos, roupas e itens de higiene, a organização busca suprir necessidades básicas e promover a dignidade das pessoas em situação de vulnerabilidade. Além disso, a Mãos que Ajudam  trabalha pela reinserção social, oferecendo capacitação profissional, orientação jurídica e encaminhamento para serviços de assistência social.",
        "categoria": "Assistência Social",
        "endereco": "Rua das Flores, 303, Bairro Glória, Vila Velha, ES",
        "contato": {
            "instagram": "https://instagram.com/maosqueajudam",
            "facebook": "https://facebook.com/maosqueajudam",
            "telefone": "(27) 3388-3033",
            "email": "contato@maosqueajudam.org"
        }
    },
    {
        "nome": "Animal Acolhido",
        "descricao": "Resgate e cuidados para animais abandonados.",
        "descricao_detalhada": "A Animal Acolhido dedica-se ao resgate de animais abandonados e à promoção do bem-estar animal no Espírito Santo. Através de um centro de acolhimento animal, a organização oferece cuidados veterinários, castração, microchipagem e adoção responsável. Além disso, a Animal Acolhido trabalha na conscientização da população sobre maus-tratos e a guarda responsável de animais de estimação.",
        "categoria": "Proteção Animal",
        "endereco": "Rua dos Bichos, 404, Bairro Itapuã, Vila Velha, ES",
        "contato": {
            "instagram": "https://instagram.com/animalacolhido",
            "facebook": "https://facebook.com/animalacolhido",
            "telefone": "(27) 3399-4044",
            "email": "contato@animalacolhido.org"
        }
    },
    {
        "nome": "Jovens para o Futuro",
        "descricao": "Capacitação profissional para jovens.",
        "descricao_detalhada": "A Jovens para o Futuro é uma organização que atua na capacitação profissional de jovens à procura de oportunidades no mercado de trabalho no Espírito Santo. Através de cursos profissionalizantes, workshops e programas de orientação vocacional, a organização busca qualificar jovens e prepará-los para o ingresso no mercado de trabalho. Atuando em parceria com empresas e instituições de ensino, a Jovens para o Futuro contribui para a redução do desemprego juvenil e para a inserção social e econômica dos jovens.",
        "categoria": "Empregabilidade",
        "endereco": "Avenida Vitória, 505, Bairro Jardim da Penha, Vitória, ES",
        "contato": {
            "instagram": "https://instagram.com/jovensparafuturo",
            "facebook": "https://facebook.com/jovensparafuturo",
            "telefone": "(27) 3400-5055",
            "email": "contato@jovensparafuturo.org"
        }
    },
    {
        "nome": "Casa de Apoio",
        "descricao": "Acolhimento para mulheres vítimas de violência.",
        "descricao_detalhada": "A Casa de Apoio oferece acolhimento seguro e suporte psicossocial para mulheres vítimas de violência doméstica no Espírito Santo. A organização fornece um ambiente protegido, sigiloso e livre de julgamentos, além de oferecer atendimento psicológico, jurídico e social. A Casa de Apoio também trabalha pela autonomia econômica das mulheres vítimas, por meio de oficinas de geração de renda e capacitação profissional.",
        "categoria": "Direitos das Mulheres",
        "endereco": "Rua das Acácias, 606, Bairro São Torquato, Vila Velha, ES",
        "contato": {
            "instagram": "https://instagram.com/casadeapoio",
            "facebook": "https://facebook.com/casadeapoio",
            "telefone": "(27) 3411-6066",
            "email": "contato@casadeapoio.org"
        }
    },
    {
        "nome": "Esporte para Todos",
        "descricao": "Promoção do esporte e vida saudável.",
        "descricao_detalhada": "A Esporte para Todos é uma organização que acredita no poder do esporte como ferramenta de transformação social no Espírito Santo. Através da promoção da prática esportiva e de atividades físicas regulares, a organização busca estimular hábitos de vida saudáveis, o desenvolvimento do senso de equipe e o protagonismo juvenil. Atuando em parceria com prefeituras, escolas e comunidades, a Esporte para Todos contribui para a inclusão social e para a melhoria da qualidade de vida da população.",
        "categoria": "Esporte",
        "endereco": "Avenida Central, 707, Bairro Coqueiral de Itaparica, Vila Velha, ES",
        "contato": {
            "instagram": "https://instagram.com/esporteparatodos",
            "facebook": "https://facebook.com/esporteparatodos",
            "telefone": "(27) 3422-7077",
            "email": "contato@esporteparatodos.org"
        }
    }
];

  // Lista de eventos
  const events = [
    { date: new Date(2024, 9, 15), title: 'Dia Mundial da Limpeza', description: 'Junte-se a nós para limpar praias e parques em sua cidade.', action: 'Participar' },
    { date: new Date(2024, 9, 22), title: 'Maratona Solidária', description: 'Corra por uma causa! Arrecadação para projetos educacionais.', action: 'Inscrever-se' },
    { date: new Date(2024, 9, 1), title: 'Feira de ONGs', description: 'Conheça e apoie diversas organizações em um só lugar.', action: 'Mais informações' },
    { date: new Date(2024, 9, 5), title: 'Workshop de Reciclagem', description: 'Aprenda técnicas criativas de reciclagem.', action: 'Reservar vaga' },
    { date: new Date(2024, 9, 5), title: 'Palestra sobre Sustentabilidade', description: 'Descubra como tornar sua vida mais sustentável.', action: 'Assistir online' },
    { date: new Date(2024, 9, 10), title: 'Doação de Sangue', description: 'Doe sangue e salve vidas.', action: 'Agendar doação' },
    { date: new Date(2024, 9, 18), title: 'Plantio de Árvores', description: 'Ajude a reflorestar áreas urbanas.', action: 'Voluntariar-se' },
    { date: new Date(2024, 9, 25), title: 'Bazar Beneficente', description: 'Compre itens usados e ajude instituições de caridade.', action: 'Ver itens' },
    { date: new Date(2024, 9, 30), title: 'Concerto Solidário', description: 'Show beneficente com artistas locais.', action: 'Comprar ingresso' }
];

// Carrega os dados das ONGs do arquivo JSON
/*fetch('../json/ongs.json')
    .then(response => response.json())
    .then(data => {
        ongs = data;
        console.log('Dados carregados:', ongs);  // Log dos dados carregados
    });*/

console.log(ongs);

// Função principal executada quando o DOM é carregado
document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.getElementById('search-results');
    const searchBtn = document.querySelector('.search-button');
    const calendarGrid = document.getElementById('calendarGrid');
    const eventList = document.getElementById('eventList');
    const currentMonthElement = document.getElementById('currentMonth');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');

    let selectedCell = null;
    let currentDate = new Date();

    // Inicialização
    initializeSearch();
    initializeCalendar();
    updateStats();
    initializeNewsletterForm();
    initializeFadeInAnimation();

    // Funções de inicialização

    function initializeSearch() {
        searchInput.addEventListener('input', handleSearch);
        searchBtn.addEventListener('click', handleSearch);
        document.addEventListener('click', closeSearchResults);
    }

    function initializeCalendar() {
        renderCalendar();
        prevMonthButton.addEventListener('click', () => navigateMonth('prev'));
        nextMonthButton.addEventListener('click', () => navigateMonth('next'));
    }

    function initializeNewsletterForm() {
        const newsletterForm = document.querySelector('.newsletter-form');
        newsletterForm.addEventListener('submit', handleNewsletterSubmit);
    }

    function initializeFadeInAnimation() {
        const fadeElements = document.querySelectorAll('.fade-in');
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(element => {
            fadeObserver.observe(element);
        });
    }

    // Funções de manipulação

    function handleSearch() {
        const query = searchInput.value.toLowerCase().trim();
        if (query === '') {
            searchResults.style.display = 'none';
            return;
        }
        const results = ongs.filter(ong => 
            ong.nome.toLowerCase().includes(query) ||
            ong.descricao.toLowerCase().includes(query) ||
            ong.categoria.toLowerCase().includes(query)
        );
        displayResults(results);
    }

    function displayResults(results) {
        searchResults.innerHTML = '';
        if (results.length > 0) {
            results.forEach(ong => {
                const div = document.createElement('div');
                div.textContent = ong.nome;
                div.addEventListener('click', () => navigateToOngDetails(ong));
                searchResults.appendChild(div);
            });
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div>Nenhum resultado encontrado.</div>';
            searchResults.style.display = 'block';
        }
    }

    function closeSearchResults(event) {
        if (!event.target.closest('.search-container')) {
            searchResults.style.display = 'none';
        }
    }

    function navigateToOngDetails(ong) {
        sessionStorage.setItem('selectedOng', JSON.stringify(ong));
        window.location.href = 'Detalhes-Instituicao.html';
    }

    function renderCalendar(direction = '') {
        calendarGrid.innerHTML = '';
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        currentMonthElement.textContent = new Date(year, month, 1).toLocaleString('default', { month: 'long', year: 'numeric' });

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const totalDays = firstDay + daysInMonth;
        const rows = Math.ceil(totalDays / 7);

        calendarGrid.classList.remove('slide-left', 'slide-right');
        if (direction) {
            calendarGrid.classList.add(`slide-${direction}`);
        }

        for (let i = 0; i < rows * 7; i++) {
            const cell = document.createElement('div');
            cell.classList.add('calendar-cell');

            const cellDate = i - firstDay + 1;
            if (cellDate > 0 && cellDate <= daysInMonth) {
                cell.textContent = cellDate;
                const fullDate = new Date(year, month, cellDate);
                
                if (fullDate.toDateString() === new Date().toDateString()) {
                    cell.classList.add('today');
                    showEvents(fullDate);
                }

                const dayEvents = events.filter(event => event.date.toDateString() === fullDate.toDateString());
                if (dayEvents.length > 0) {
                    cell.classList.add('has-event');
                }

                cell.addEventListener('click', () => {
                    showEvents(fullDate);
                    if (selectedCell) {
                        selectedCell.style.border = '';
                    }
                    cell.style.border = '2px solid #68a19d';
                    selectedCell = cell;
                });
            } else {
                cell.style.visibility = 'hidden';
            }

            calendarGrid.appendChild(cell);
        }
    }

    function showEvents(date) {
        const dayEvents = events.filter(event => event.date.toDateString() === date.toDateString());
        eventList.innerHTML = '';

        if (dayEvents.length > 0) {
            dayEvents.forEach(event => {
                const eventElement = document.createElement('div');
                eventElement.classList.add('event-item');
                eventElement.innerHTML = `
                    <div class="event-date">
                        <div class="event-day">${event.date.getDate()}</div>
                        <div class="event-month">${event.date.toLocaleString('default', { month: 'short' })}</div>
                    </div>
                    <div class="event-content">
                        <div class="event-title">${event.title}</div>
                        <div class="event-description">${event.description}</div>
                        <a href="#" class="event-action">${event.action}</a>
                    </div>
                `;
                eventList.appendChild(eventElement);
            });
        } else {
            eventList.innerHTML = '<p>Nenhum evento neste dia.</p>';
        }
    }

    function navigateMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + (direction === 'prev' ? -1 : 1));
        renderCalendar(direction === 'prev' ? 'right' : 'left');
    }

    function updateStats() {
        const stats = {
            voluntarios: 10000,
            ongs: 500,
            cidades: 50,
            arvores: 1000000
        };
    
        const duration = 2000;
        Object.keys(stats).forEach(key => {
            animateValue(document.querySelector(`.stat-number[data-stat="${key}"]`), 0, stats[key], duration);
        });
    }

    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.textContent = Math.floor(progress * (end - start) + start).toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    function handleNewsletterSubmit(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        alert(`Obrigado por se inscrever! Você receberá nossas atualizações em ${email}`);
        this.reset();
    }
});

// Ocultar resultados de pesquisa ao rolar a página
const searchResults = document.getElementById('search-results');
const initialOffsetTop = searchResults.offsetTop;

document.addEventListener('scroll', () => {
    if (window.scrollY > initialOffsetTop) {
        searchResults.classList.add('hidden');
    } else {
        searchResults.classList.remove('hidden');
    }
});
