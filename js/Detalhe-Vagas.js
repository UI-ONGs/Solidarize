document.addEventListener('DOMContentLoaded', () => {

    /* pega o item do local storage */

    const eventData = JSON.parse(localStorage.getItem('eventData'));

    /* pega a div onde ficará todos os elementos */

    const displayDiv = document.getElementById('eventDataDisplay');

    /* se tiver algo no local storage*/
    
    if (eventData) {

        /* adiciona todos os elementos na div */

        displayDiv.innerHTML = `
            <p class="Infos"><b>Nome Completo:</b> ${eventData.nome}</p>
            <p class="Infos"><b>Tipo da Ong:</b> ${eventData.tipo}</p>
            <p class="Infos"><b>Descrição:</b> ${eventData.desc}</p>
            <p class="Infos"><b>Local do Evento:</b> ${eventData.endereco}</p>
            <p class="Infos"><b>Data:</b> ${eventData.data}</p>
            <p class="Infos"><b>Horário de Início:</b> ${eventData.horarioI}</p>
            <p class="Infos"><b>Horário de Término:</b> ${eventData.horarioF}</p>
        `;
    } else {

        /* caso não for encontrado adiciona um paragrafo dizendo que não foi encontrado dados */

        displayDiv.innerHTML = `<p>Dados da vaga não encontrados.</p>`;
    }
});
