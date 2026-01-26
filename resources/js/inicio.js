window.addEventListener('load', () => { // Usar 'load' asegura que las imágenes ya tienen tamaño
    const slide = document.querySelector('.carousel-slide');
    const images = document.querySelectorAll('.event-banner');
    
    if (images.length === 0) return; // Seguridad

    let counter = 0;
    
    const moveSlide = () => {
        const size = images[0].clientWidth; // Medimos el tamaño justo antes de mover
        if (counter >= images.length - 1) {
            counter = -1;
        }
        counter++;
        slide.style.transform = `translateX(${-size * counter}px)`;
    };

    setInterval(moveSlide, 4000);
});