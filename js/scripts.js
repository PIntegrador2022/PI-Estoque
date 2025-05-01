// Mostrar/Esconder o submenu ao clicar no título
const submenuTitles = document.querySelectorAll('.submenu-title');
submenuTitles.forEach(title => {
    title.addEventListener('click', () => {
        const submenuItems = title.nextElementSibling;
        submenuItems.classList.toggle('show');
    });
});

// Script para o Menu Dropdown
// Mostrar/Esconder o menu dropdown ao clicar no nome do usuário
const userInfo = document.querySelector('.user-info');
const dropdownMenu = document.querySelector('.dropdown-menu');

userInfo.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
});

// Fechar o menu quando clicar fora dele
document.addEventListener('click', (event) => {
    if (!userInfo.contains(event.target)) {
        dropdownMenu.classList.remove('show');
    }
});

// Script para o Menu Lateral
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.sidebar');

    // Alterna a classe 'show' no sidebar
    menuToggle.addEventListener('click', function () {
        sidebar.classList.toggle('show');
    });

    // Fecha o sidebar se o usuário clicar fora dele
    document.addEventListener('click', function (event) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('show');
        }
    });

    // Listener para redimensionamento da janela
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show'); // Remove a classe 'show' quando a tela for maior que 768px
        }
    });
});