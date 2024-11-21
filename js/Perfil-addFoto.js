// pegando os elemntos DOM
const fileInput = document.querySelector(".file-input"), // arquivo de entrada (foto)
previewImg = document.querySelector(".preview-img img"); // seleciona uma imagem pre visualizada
//chooseImgBtn = document.querySelector(".choose-img"); // colocando função pro botão selecionar a imagem
const cameraIcon = document.getElementById('iconeFoto'); // colocando função pro icone selecionar a imagem

// carregando a imagem 
const loadImage = () => { 
    let file = fileInput.files[0]; // obtemo arquivo selecionado
    if(!file) return; // verifica se realmente há um arquivo
    previewImg.src = URL.createObjectURL(file); // criando URl temporario para pre visualização
}

fileInput.addEventListener("change", loadImage); // quando o usuario selecionar um arquivo, essa linha chama a função para testar
cameraIcon.addEventListener("click", () => fileInput.click()); // possibilita que o icone acesse os arquivos do pc