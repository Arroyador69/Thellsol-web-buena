// Este script asegura que el menú móvil se pueda cerrar correctamente en todas las páginas y todos los idiomas
function initMobileMenuEvents() {
  // Cerrar menú al hacer clic en cualquier enlace del menú móvil o bandera de idioma
  document.querySelectorAll('.mobile-menu a, .mobile-menu .language-flag').forEach(function(el) {
    el.addEventListener('click', function() {
      closeMobileMenu();
    });
  });
  // Cerrar menú al pulsar la X
  var closeBtn = document.querySelector('.close-mobile-menu');
  if (closeBtn) closeBtn.addEventListener('click', closeMobileMenu);
  // Cerrar menú al pulsar fuera (fondo oscuro)
  var bg = document.getElementById('mobileMenuBg');
  if (bg) bg.addEventListener('click', closeMobileMenu);
  // Cerrar menú al volver a pulsar el botón hamburguesa
  var burger = document.getElementById('hamburgerBtnFixed');
  if (burger) burger.addEventListener('click', function() {
    if(document.getElementById('mobileMenu').classList.contains('open')) {
      closeMobileMenu();
    } else {
      openMobileMenu();
    }
  });
}

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

// Inicializar eventos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  mostrarHamburguesa();
  window.addEventListener('resize', mostrarHamburguesa);
  initMobileMenuEvents();
}); 