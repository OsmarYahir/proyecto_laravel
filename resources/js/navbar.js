window.addEventListener('scroll', () => {
    const nav = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        nav.style.backgroundColor = '#000000'; // Se vuelve negro sólido al bajar
        nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.5)';
    } else {
        nav.style.backgroundColor = '#1f262d';
        nav.style.boxShadow = 'none';
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const buscador = document.querySelector('input[type="text"]');

    buscador.addEventListener('input', (e) => {
        console.log("Buscando evento:", e.target.value);
        // Aquí es donde en el futuro conectarás con tu controlador de Laravel
    });
});

const logo = document.querySelector('.nav-logo');
logo.addEventListener('mouseover', () => {
    logo.style.transform = 'scale(1.1)';
    logo.style.transition = '0.3s';
});

logo.addEventListener('mouseout', () => {
    logo.style.transform = 'scale(1)';
});