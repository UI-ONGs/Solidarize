// Pegando os objetos da página HTML
let facebook = document.querySelector(".fab.fa-facebook-f");
let twitter = document.querySelector(".fab.fa-twitter");
let instagram = document.querySelector(".fab.fa-instagram");

// Adicionando um evento de clique para o botão de Facebook
facebook.addEventListener("click", function() {
    let user_face = prompt("Por favor, insira seu usuário do Facebook:");
    // Verificando se o usuário inseriu algum valor
    if (user_face !== null) {
        // Concatenando o valor inserido pelo usuário com outro texto
        let mensagem = "O usuário do Facebook inserido é: " + user_face;
        // Exibindo a mensagem concatenada
        alert(mensagem);
        trocarHref1(user_face);
    }     
});

// chamando a função do Facebook
function trocarHref1(user_face) {
    var novoHref = "https://www.facebook.com/" + user_face + "/";
    document.getElementById("link1").href = novoHref;
}


// Adicionando um evento de clique para o botão de Twitter
twitter.addEventListener("click", function() {
    let user_twitter = prompt("Por favor, insira seu usuário do Twitter:");
    if (user_twitter !== null) {
        let mensagem = "O usuário do Twitter inserido é: " + user_twitter;
        alert(mensagem);
        trocarHref2(user_twitter);
    }
    
});

// chamando a função do Twitter
function trocarHref2(user_twitter) {
    var novoHref = "https://x.com/" + user_twitter;
    document.getElementById("link2").href = novoHref;
}

// Adicionando um evento de clique para o botão de Instagram
instagram.addEventListener("click", function() {
    let user_insta = prompt("Por favor, insira seu usuário do Instagram:");
    if (user_insta !== null) {
        let mensagem = "O usuário do Instagram inserido é: " + user_insta;
        alert(mensagem);
        trocarHref3(user_insta);
    } 
});

// chamando a função do Instagram
function trocarHref3(user_insta) {
    var novoHref = "https://www.instagram.com/" + user_insta + "/";
    document.getElementById("link3").href = novoHref;
}

