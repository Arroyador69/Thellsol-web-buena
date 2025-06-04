function openMobileMenu() {
    document.getElementById('mobileMenu').classList.add('open');
    document.getElementById('mobileMenuBg').classList.add('open');
}

function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('mobileMenuBg').classList.remove('open');
}

// Mostrar el botón hamburguesa solo en móvil
function mostrarHamburguesa() {
    var btn = document.getElementById('hamburgerBtnFixed');
    if(window.innerWidth < 900) {
        btn.style.display = 'flex';
    } else {
        btn.style.display = 'none';
    }
}

// Ajustar el título de la navbar según el tamaño de la pantalla
function ajustarTituloNavbar() {
    const navbarTitle = document.querySelector('.navbar-title');
    const mobileTitle = document.querySelector('.navbar-mobile-title');
    if(window.innerWidth < 900) {
        navbarTitle.style.display = 'none';
        mobileTitle.style.display = 'block';
    } else {
        navbarTitle.style.display = '';
        mobileTitle.style.display = 'none';
    }
}

// Inicializar eventos
document.addEventListener('DOMContentLoaded', function() {
    mostrarHamburguesa();
    ajustarTituloNavbar();
    window.addEventListener('resize', mostrarHamburguesa);
    window.addEventListener('resize', ajustarTituloNavbar);
}); 