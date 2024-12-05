// Espera o DOM carregar completamente antes de executar o script
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.navbar-menu a, .navbar-mobile-menu a');
    const currentPage = window.location.pathname.split("/").pop();

    // Procura a página atual (em qual o usuário está
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }

        link.addEventListener('click', (e) => {
            navLinks.forEach(l => l.classList.remove('active'));
            e.target.closest('a').classList.add('active');
        });
    });

    // ativa a navbar mobile
    const navbarToggle = document.querySelector('.navbar-mobile-toggle');
    const navbarMenu = document.querySelector('.navbar-mobile-menu');

    // abre a navbar quando clica no ícone
    navbarToggle.addEventListener('click', () => {
        navbarToggle.classList.toggle('active');
        navbarMenu.classList.toggle('active');
    });

    // Fechar o menu ao clicar em um link
    const mobileNavLinks = document.querySelectorAll('.navbar-mobile-menu a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', () => {
            navbarToggle.classList.remove('active');
            navbarMenu.classList.remove('active');
        });
    });
});