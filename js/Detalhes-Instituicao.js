document.addEventListener('DOMContentLoaded', function () {
    // Recupera os dados do sessionStorage
    const storedOng = sessionStorage.getItem('selectedOng');
    let ongData;

    if (storedOng) {
        ongData = JSON.parse(storedOng);

        // Função para atualizar os elementos da página com os dados da ONG
        function updateOngDetails() {
            document.getElementById('nome-ong').textContent = ongData.nome || 'Nome não disponível';
            document.getElementById('categoria-ong').textContent = ongData.categoria || 'Categoria não disponível';
            document.getElementById('descricao-ong').textContent = ongData.descricao || 'Descrição não disponível';
            document.getElementById('endereco-ong').textContent = ongData.endereco || 'Endereço não disponível';
            document.getElementById('instagram-link').href = ongData.contato.instagram || '#';
            document.getElementById('facebook-link').href = ongData.contato.facebook || '#';
            document.getElementById('telefone-link').href = ongData.contato.telefone ? `tel:${ongData.telefone}` : '#';
            document.getElementById('email-link').href = ongData.contato.email ? `mailto:${ongData.email}` : '#';
        }

        updateOngDetails();
    } else {
        console.error('Dados da ONG não encontrados no sessionStorage');
        document.querySelector('.card').innerHTML = '<p class="error-message">Informações da ONG não encontradas ou incompletas.</p>';
    }
});

// Aguarda até que o DOM esteja totalmente carregado para executar o script
document.addEventListener('DOMContentLoaded', () => {
    // Obtém referências para os elementos do DOM
    const commentsContainer = document.getElementById('commentsContainer');
    const sortRecentButton = document.getElementById('sortRecent');
    const sortLikedButton = document.getElementById('sortLiked');
    const commentForm = document.getElementById('commentForm');
    const nameInput = localStorage.getItem("username");
    console.log(nameInput);
    const commentInput = document.getElementById('comment');
    const commentsModal = document.getElementById('commentsModal');
    const openCommentsButton = document.getElementById('openComments');
    const closeCommentsButton = document.getElementById('closeComments');

    // Comentários padrão pré-definidos
    const defaultComments = [
        {
            name: "Malu",
            text: "Ótima iniciativa! Admiro muito o trabalho que vocês fazem pela comunidade.",
            likes: 5,
            date: new Date('2024-06-16T12:30:00')
        },
        {
            name: "Dani",
            text: "Essa ONG merece todo o reconhecimento pelo trabalho excepcional que realiza. Continuem assim!",
            likes: 3,
            date: new Date('2024-06-17T09:00:00')
        },
        {
            name: "Isa",
            text: "Essa ONG é incrível! Eles estão fazendo a diferença na vida das pessoas que mais precisam.",
            likes: 8,
            date: new Date('2023-06-18T14:45:00')
        },
        {
            name: "Guilerme",
            text: "É tão inspirador ver o esforço dessas pessoas em ajudar os outros. Estou feliz por apoiar essa causa.",
            likes: 21,
            date: new Date('2024-06-14T13:30:00')
        }
    ];

    // Função para carregar os comentários
    function loadComments() {
        // Obtém os comentários salvos no armazenamento local
        const comments = JSON.parse(localStorage.getItem('comments'));
         // Se não houver comentários salvos, usa os comentários padrão e salva no armazenamento local
        if (comments === null) {
            saveComments(defaultComments);
            // Converte as datas dos comentários para objetos Date
            return defaultComments.map(comment => ({
                ...comment,
                date: new Date(comment.date)
            }));
        }
        // Converte as datas dos comentários para objetos Date
        return comments.map(comment => ({
            ...comment,
            date: new Date(comment.date)
        }));
    }

    // Função para salvar os comentários no armazenamento local
    function saveComments(comments) {
        localStorage.setItem('comments', JSON.stringify(comments));
    }

    // Função para exibir os comentários na página
    function displayComments(comments) {
         // Limpa o conteúdo anterior do contêiner de comentários
        commentsContainer.innerHTML = '';
        // Itera sobre os comentários e os adiciona ao contêiner
        comments.forEach(comment => {
            // Cria elementos HTML para cada comentário e suas propriedades
            const commentDiv = document.createElement('div');
            commentDiv.classList.add('comment');

            const authorDiv = document.createElement('div');
            authorDiv.classList.add('author');
            authorDiv.textContent = comment.name;

            const dateDiv = document.createElement('div');
            dateDiv.classList.add('date');
            dateDiv.textContent = comment.date.toLocaleString();

            const textDiv = document.createElement('div');
            textDiv.classList.add('text');
            textDiv.textContent = comment.text;

            const likesDiv = document.createElement('div');
            likesDiv.classList.add('likes');
            likesDiv.textContent = `Likes: ${comment.likes}`;

            commentDiv.appendChild(authorDiv);
            commentDiv.appendChild(dateDiv);
            commentDiv.appendChild(textDiv);
            commentDiv.appendChild(likesDiv);

            commentsContainer.appendChild(commentDiv);
        });
    }

    function addComment(name, text) {
        // Verifica se o nome do usuário está logado
        if (!name) {
            alert("Por favor, faça login para comentar!");
            return;
        }
        // Carrega os comentários existentes
        const comments = loadComments();
        // Cria um novo comentário
        const newComment = {
            name: name,
            text: text,
            likes: 0,
            date: new Date()
        };
         // Adiciona o novo comentário à lista de comentários
        comments.unshift(newComment);
        saveComments(comments);
        displayComments(comments);
    }

     // Adiciona um evento de clique para ordenar os comentários por data (mais recentes primeiro)
    sortRecentButton.addEventListener('click', () => {
        const comments = loadComments();
        // Ordena os comentários por data
        const sortedComments = comments.sort((a, b) => b.date - a.date);
        displayComments(sortedComments);
    });

     // Adiciona um evento de clique para ordenar os comentários por número de likes (mais curtidos primeiro)
    sortLikedButton.addEventListener('click', () => {
        const comments = loadComments();
          // Ordena os comentários por número de likes
        const sortedComments = comments.sort((a, b) => b.likes - a.likes);
        displayComments(sortedComments);
    });

     // Adiciona um evento de envio para o formulário de comentários
    commentForm.addEventListener('submit', (event) => {
        // Impede o comportamento padrão de recarregar a página ao enviar o formulário
        event.preventDefault();
        const text = commentInput.value;
        // Adiciona o comentário com o nome do usuário atual
        addComment(nameInput, text);
        commentInput.value = '';
    });

     // Adiciona um evento de clique para abrir o modal de comentários
    openCommentsButton.addEventListener('click', () => {
        commentsModal.showModal();
    });

     // Adiciona um evento de clique para fechar o modal de comentários
    closeCommentsButton.addEventListener('click', () => {
        commentsModal.close();
    });

    // Fechar modal ao clicar fora do container
    commentsModal.addEventListener('click', (event) => {
        if (event.target === commentsModal) {
            commentsModal.close();
        }
    });

    // Exibe os comentários inicialmente ordenados por data (mais recentes primeiro)
    const initialSortedComments = loadComments().sort((a, b) => b.date - a.date);
    displayComments(initialSortedComments);
});
