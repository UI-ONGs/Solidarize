// ID GENERALIZADO - MUDAR PARA MÉTODO NECESSÁRIO
const idInstituicao = 1;

document.addEventListener("DOMContentLoaded", function () {
    // =================== EventListeners
    // Obtém todos os elementos que representam as estrelas
    const stars = document.querySelectorAll(".star");
    // Obtém o elemento onde será mostrado o número de estrelas selecionadas
    const ratingValue = document.getElementById("rating-value");

    // Adiciona um ouvinte de evento para cada estrela
    stars.forEach((star, index) => {
        // Quando o mouse passar sobre a estrela, destacar as estrelas até a posição atual
        star.addEventListener("mouseover", function () {
            resetStars(); // Reseta as estrelas para o estado padrão
            highlightStars(index + 1); // Destaca as estrelas até o índice da estrela sobre a qual o mouse está
        });

        // Quando o mouse sair de cima da estrela, restaurar o estado das estrelas
        star.addEventListener("mouseout", function () {
            resetStars(); // Reseta as estrelas para o estado padrão
            highlightStars(getSelectedRating()); // Mantém o destaque da avaliação que foi selecionada
        });

        // Quando o usuário clica na estrela, define a avaliação
        star.addEventListener("click", function () {
            setSelectedRating(index + 1); // Define o número de estrelas como a avaliação do usuário
        });
    });

    // =================== Functions
    
    // Função que destaca as estrelas até o número passado como argumento
    function highlightStars(count) {
        stars.forEach((star, index) => {
            if (index < count) {
                star.classList.add("selected"); // Adiciona a classe 'selected' para destacar a estrela
            }
        });
    }

    // Função que reseta as estrelas, removendo a classe 'selected'
    function resetStars() {
        stars.forEach(star => {
            star.classList.remove("selected"); // Remove a classe 'selected' de todas as estrelas
        });
    }

    // Função que armazena a avaliação selecionada no localStorage
    function setSelectedRating(rating) {
        localStorage.setItem("rating", rating); // Salva a avaliação no localStorage (para persistir após o recarregamento)
        ratingValue.textContent = rating; // Atualiza a exibição da avaliação selecionada
    }

    // Função que recupera a avaliação salva (se houver) no localStorage
    function getSelectedRating() {
        const savedRating = localStorage.getItem("rating"); // Tenta obter o valor da avaliação salva
        return savedRating ? parseInt(savedRating) : 0; // Retorna a avaliação salva ou 0 se não houver avaliação
    }
 
    // ================ Call functions
    // Inicializa a página com a avaliação salva, caso haja uma
    highlightStars(getSelectedRating()); // Chama a função para destacar as estrelas com base na avaliação salva
});


let currentIndex = 0;

function moveSlide(step) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    currentIndex = (currentIndex + step + totalSlides) % totalSlides;
    const newTransform = -currentIndex * 100 + '%';
    document.querySelector('.slider').style.transform = `translateX(${newTransform})`;
}

// =================== Evento
fetchDataEventos();
const elementoPai = document.querySelector('.slider-event');

// Functions
async function fetchDataEventos() {
    try {
        const formData = new FormData();
        formData.append('id', idInstituicao);

        const response = await fetch('php/requestEventos.php', {
            method: 'POST',
            body: formData
        });
        if (!response.ok) {
            throw new Error('Network response deu ruim');
        }
        const data = await response.json();

        // Cria Card de evento
        data.forEach(e => adicionaEvento(e['titulo'], e['data_inicio'], e['data_fim']));
    
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

async function adicionaEvento(tituloE, horaInicioE, horaFimE){
    let horaInicioE2 = horaInicioE.split(" ")[1];
    let horaFimE2 = horaFimE.split(" ")[1];
    let [ano, mes, dia] = horaInicioE.split("-");
    dia = dia.split(' ')[0];

    let cadEvento = document.createElement('div');
    const modEvento = `
    <div class="event">
        <h3>${tituloE}</h3>
        <p>Data: ${dia}/${mes}/${ano}</p>
        <p>Horário: ${horaInicioE2.split(':')[0]}:${horaInicioE2.split(':')[1]}  
        às ${horaFimE2.split(':')[0]}:${horaFimE2.split(':')[1]}</p>
        <a href="#">Ir para o Calendário</a>
    </div>`;

    cadEvento.innerHTML = modEvento;

    elementoPai.appendChild(cadEvento);

}


// =================== Dados da instituição
const titulo = document.getElementById('nome_instituicao');
const descricao = document.getElementById('descricao_instituicao');
const missao = document.getElementById('missao');
const visao = document.getElementById('visao');
const valores = document.getElementById('valores');

// Functions
async function fetchDataInst() {
    try {
        const response = await fetch('php/requestInstituicao.php');
        if (!response.ok) {
            throw new Error('Network response deu ruim');
        }
        const data = await response.json();

        titulo.textContent = data[idInstituicao-1]['nome'];
        descricao.textContent = data[idInstituicao-1]['descricao'];
        missao.textContent = data[idInstituicao-1]['missao'];
        visao.textContent = data[idInstituicao-1]['visao'];
        valores.textContent = data[idInstituicao-1]['valores'];
    } catch (error) {
        console.error('Fetch error:', error);
    }
}
fetchDataInst();