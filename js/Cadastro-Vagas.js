document.addEventListener('DOMContentLoaded', () => {
    /* pega o forms */
    const desc = document.getElementById('desc'); // textarea
    const contador = document.querySelector('.counter'); // contador

    desc.addEventListener('input', () => {
        const maximo = desc.getAttribute('maxlength'); // número máximo de caracteres
        const tamanho = desc.value.length; // número de caracteres digitados
        
        // Atualiza o contador com o número de caracteres restantes
        contador.innerText = `${tamanho}/${maximo}`; 
    });

    
    

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        /* pega os campos de entrada */
        const nome = document.getElementById('nome').value;
        const tipo = document.getElementById('tipo').value;
        const desc = document.getElementById('desc').value;
        const endereco = document.getElementById('Endereco').value;
        const data = document.getElementById('data').value;
        const horarioI = document.getElementById('horarioI').value;
        const horarioF = document.getElementById('horarioF').value;

        /* guarda em um objeto */

        const eventData = {
            nome,
            tipo,
            desc,
            endereco,
            data,
            horarioI,
            horarioF
        };

        /* guardano local storage */

        localStorage.setItem('eventData', JSON.stringify(eventData));

        window.location.href = 'Detalhe-Vagas.html';
    });
});
