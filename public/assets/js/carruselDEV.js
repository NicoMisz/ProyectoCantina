// Obtener elementos del DOM del carrusel
const track = document.getElementById('carouselTrack');
const slides = document.querySelectorAll('.carousel-slide');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const indicators = document.querySelectorAll('.indicator');

let currentSlide = 0;
const totalSlides = slides.length;

function updateCarousel() {
    // Actualizar clases 'active' en las diapositivas
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
        if (index === currentSlide) {
            slide.classList.add('active');
        }
    });

    // Actualizar clases 'active' en los indicadores
    indicators.forEach((indicator, index) => {
        indicator.classList.remove('active');
        if (index === currentSlide) {
            indicator.classList.add('active');
        }
    });
}

function nextSlide() {
    // Avanzar a la siguiente diapositiva (vuelve al inicio al llegar al final)
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
}

function prevSlide() {
    // Retroceder a la diapositiva anterior (va al final si está en la primera)
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
}

// Event listener para el botón siguiente i anterior
nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

// Event listeners para los indicadores (puntos de navegación)
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentSlide = index;
        updateCarousel();
    });
});

// Cambio automático de diapositiva cada 5 segundos
setInterval(nextSlide, 5000);