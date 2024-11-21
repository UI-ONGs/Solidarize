// Recupera os valores da sessionStorage
var nome = localStorage.getItem("fullname");
var email = localStorage.getItem("email");
var nickname = localStorage.getItem("username");
var senha = localStorage.getItem("password");


// definição do elementos
const nomeU = document.querySelector("#nome"),
    gmail = document.querySelector("#email"),
    password = document.querySelector("#senha"),
    nick = document.querySelector("#nickname");

// Exibe os valores na tela
nomeU.textContent = nome;
gmail.textContent = email;
password.textContent = senha;
nick.textContent = nickname;

