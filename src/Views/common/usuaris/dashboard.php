<?php
    $user = $_SESSION['user'] ?? null;
    $isAdmin = $user && isset($user['rol']) && $user['rol'] === 'admin';
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina Tony's</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/themeChange.js"></script>
</head>
<style>
    /* ============================================
   CARRITO LATERAL - STYLES
   ============================================ */

    /* Panel principal del carrito */
    #carreto {
        position: fixed;
        top: 0;
        right: -100%;
        width: min(450px, 85vw);
        height: 100vh;
        background: linear-gradient(135deg, var(--surface-primary) 0%, var(--bg-primary) 100%);
        z-index: 1000;
        box-shadow: -4px 0 24px rgba(0, 0, 0, 0.15);
        overflow-y: auto;
        border-left: 4px solid var(--color-primary);
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #carreto.active {
        right: 0;
    }

    /* Overlay del carrito */
    .cart-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--overlay-dark);
        backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 999;
    }

    .cart-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Header del carrito */
    .cart-header {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
        color: var(--text-on-primary);
        padding: 1.5rem;
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 3px solid var(--color-primary-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
    }

    /* Botón cerrar */
    .cart-close-btn {
        background: transparent;
        border: 2px solid var(--text-on-primary);
        color: var(--text-on-primary);
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        line-height: 1;
    }

    .cart-close-btn:hover {
        background: var(--text-on-primary);
        color: var(--color-primary);
        transform: rotate(90deg);
    }

    .cart-close-btn:active {
        transform: rotate(90deg) scale(0.9);
    }

    /* Contenido del carrito */
    .cart-content {
        padding: 1.5rem;
    }

    .cart-items {
        margin-bottom: 2rem;
    }

    /* Cards de items */
    .item-card {
        background: var(--surface-primary);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-primary);
    }

    /* Imagen del producto */
    .item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        min-height: 60px;
    }

    /* Información del producto */
    .item-nombre {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    .item-descripcion {
        color: var(--text-secondary);
        font-size: 0.85rem;
        line-height: 1.3;
    }

    /* Precio */
    .precio-info {
        text-align: right;
    }

    .cantidad-precio {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin-bottom: 5px;
    }

    .total-item {
        font-weight: bold;
        font-size: 1.1rem;
        color: var(--color-success);
    }

    /* Resumen del carrito */
    .cart-summary {
        background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-secondary-dark) 100%);
        color: var(--text-on-secondary);
        border-radius: 1rem;
        padding: 1.5rem;
        position: sticky;
        bottom: 0;
        margin: 0 -1.5rem -1.5rem -1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .summary-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        font-size: 1.25rem;
        font-weight: 700;
    }

    /* Botón comprar */
    .btn-comprar {
        background: linear-gradient(135deg, var(--color-success) 0%, #1e7e34 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 10px;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
        margin-top: 1rem;
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
    }

    .btn-comprar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
    }

    .btn-comprar:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }

    /* Responsive */
    @media (max-width: 480px) {
        #carreto {
            width: 100vw;
        }

        .cart-header {
            padding: 1rem;
        }

        .cart-content {
            padding: 1rem;
        }

        .item-nombre {
            font-size: 0.9rem;
        }

        .item-descripcion {
            font-size: 0.8rem;
        }
    }
</style>

<body>
    <!-- Header Principal -->
    <header class="header" id="mainHeader">
        <div class="header-content">
            <!-- Logo (centrado por defecto, se mueve a la izquierda al hacer scroll) -->
            <div class="logo-container">
                <a href="/dashboard">
                    <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
                </a>
            </div>

            <!-- Iconos de la derecha (carrito, perfil, hamburguesa) -->
            <div class="header-actions">
                <!-- Botón de cambio de tema -->
                <button id="theme-toggle" class="theme-toggle">
                    <span class="icon-light">☀️</span>
                    <span class="icon-dark">🌙</span>
                </button>
                <!-- Carrito -->
                <a href="javascript:void(0)" class="header-icon cart-icon" aria-label="Carrito de compras">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge">3</span>
                </a>

                <!-- Perfil -->
                <a href="/perfil" class="header-icon profile-icon" aria-label="Mi perfil">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>

                <!-- Botón Hamburguesa -->
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Abrir menú">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

            </div>
        </div>
    </header>

    <!-- Overlay oscuro -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Menú lateral -->
    <nav>
        <ul class="navigation" id="navigation">
            <li><a href="/catalogo">El Catálogo</a></li>
            <li><a href="/pedidos">Mis Pedidos</a></li>
            <li><a href="/about-us">About Us</a></li>
            <li><a href="/formulari">Contacto</a></li>

            <?php if ($isAdmin): ?>
            <!-- Solo visible para administradores -->
            <li class="admin-only">
                <a href="/admin/gestio-productes">
                    <img src="/assets/media/admin.png" alt="Cantina Tony's" class="logo-admin">
                    Gestió Productes
                </a>
            </li>
            <?php endif; ?>

            <!-- Footer del menú -->
            <div class="menu-footer">
                <div class="menu-footer-content">
                    <div class="menu-social">
                        <a href="/log-out" class="social-link" aria-label="logOut">X</a>
                        <a href="#" class="social-link" aria-label="Instagram">I</a>
                        <a href="#" class="social-link" aria-label="Email">E</a>
                        <a href="/dashboard" class="social-link" aria-label="Web">W</a>
                    </div>
                </div>
            </div>
        </ul>
    </nav>
    <div class="cart-overlay" id="cartOverlay"></div>

    <div id="carreto">
        
    </div>

    <!-- Contenido Principal -->
    <main class="content">
        <!-- CARRUSEL DE IMÁGENES -->
        <section class="carousel-section">
            <div class="carousel-container">
                <div class="carousel-track" id="carouselTrack">
                    <div class="carousel-slide active">
                        <img src="/assets/media/carusel1.png" alt="Slide 1">
                        <div class="carousel-caption">
                            <h2>¡Bienvenidos a Cantina Tony's!</h2>
                            <p>La mejor comida de la ciudad</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="/assets/media/carusel2.png" alt="Slide 2">
                        <div class="carousel-caption">
                            <h2>Ofertas del Día</h2>
                            <p>Descubre nuestros platos especiales</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="/assets/media/carusel3.png" alt="Slide 3">
                        <div class="carousel-caption">
                            <h2>Delivery Gratis</h2>
                            <p>En pedidos superiores a 20€</p>
                        </div>
                    </div>
                </div>
                
                <!-- Controles del carrusel -->
                <button class="carousel-btn carousel-btn-prev" id="prevBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <button class="carousel-btn carousel-btn-next" id="nextBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>

                <!-- Indicadores -->
                <div class="carousel-indicators">
                    <span class="indicator active" data-slide="0"></span>
                    <span class="indicator" data-slide="1"></span>
                    <span class="indicator" data-slide="2"></span>
                </div>
            </div>
        </section>

        <!-- SECCIÓN DEL MENÚ DEL DÍA -->
        <section class="menu-dia-section">
            <div class="section-header">
                <h2 class="section-title">🍽️ Menú del Día</h2>
                <p class="section-subtitle">Descubre nuestro menú especial de hoy</p>
            </div>
            
            <div class="menu-dia-card">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="menu-dia-image">
                            <img src="https://placehold.co/600x400/DB380D/FFFFFF?text=Menu+del+Dia" alt="Menú del Día">
                            <div class="menu-dia-badge">
                                <span class="badge-price">12.99€</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="menu-dia-content">
                            <h3>Menú Completo</h3>
                            <p class="menu-dia-description">
                                Disfruta de nuestro menú del día que incluye entrada, plato principal, postre y bebida. 
                                Una experiencia gastronómica completa a un precio increíble.
                            </p>
                            
                            <div class="menu-dia-items">
                                <div class="menu-item">
                                    <span class="item-icon"></span>
                                    <span class="item-text">Ensalada o Sopa</span>
                                </div>
                                <div class="menu-item">
                                    <span class="item-icon"></span>
                                    <span class="item-text">Plato Principal a elegir</span>
                                </div>
                                <div class="menu-item">
                                    <span class="item-icon"></span>
                                    <span class="item-text">Postre del día</span>
                                </div>
                                <div class="menu-item">
                                    <span class="item-icon"></span>
                                    <span class="item-text">Bebida</span>
                                </div>
                            </div>

                            <a href="/menu" class="btn-menu">Ver Menú Completo →</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE OFERTAS DEL DÍA -->
        <section class="ofertas-section">
            <div class="section-header">
                <h2 class="section-title">🔥 Ofertas del Día</h2>
                <p class="section-subtitle">Aprovecha estas ofertas especiales solo por hoy</p>
            </div>

            <div class="row ofertas-grid">
                <!-- Oferta 1 -->
                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-20%</div>
                        <div class="oferta-image">
                            <img src="https://placehold.co/400x300/DB380D/FFFFFF?text=Ramen+Especial" alt="Ramen Especial">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Ramen Especial</h3>
                            <p class="oferta-description">
                                Delicioso ramen con caldo casero, chashu, huevo marinado y vegetales frescos.
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">11.99€</span>
                                    <span class="price-new">9.59€</span>
                                </div>
                                <button class="btn-add-cart">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Oferta 2 -->
                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-15%</div>
                        <div class="oferta-image">
                            <img src="https://placehold.co/400x300/5382A1/FFFFFF?text=Sushi+Variado" alt="Sushi Variado">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Sushi Variado (16 piezas)</h3>
                            <p class="oferta-description">
                                Selección premium de sushi: nigiri, maki y california rolls con ingredientes frescos.
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">18.99€</span>
                                    <span class="price-new">16.14€</span>
                                </div>
                                <button class="btn-add-cart">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Oferta 3 -->
                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-25%</div>
                        <div class="oferta-image">
                            <img src="https://placehold.co/400x300/27AE60/FFFFFF?text=Bento+Box" alt="Bento Box">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Bento Box Completo</h3>
                            <p class="oferta-description">
                                Caja bento con teriyaki, arroz, gyoza, ensalada y mochi de postre. ¡Todo incluido!
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">14.99€</span>
                                    <span class="price-new">11.24€</span>
                                </div>
                                <button class="btn-add-cart">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ver-mas-container">
                <a href="/catalogo" class="btn-ver-mas">
                    Ver Todo el Catálogo
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </section>
    </main>

    <script>
        // CARRUSEL DE IMÁGENES
        const track = document.getElementById('carouselTrack');
        const slides = document.querySelectorAll('.carousel-slide');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('.indicator');
        
        let currentSlide = 0;
        const totalSlides = slides.length;

        function updateCarousel() {
            slides.forEach((slide, index) => {
                slide.classList.remove('active');
                if (index === currentSlide) {
                    slide.classList.add('active');
                }
            });

            indicators.forEach((indicator, index) => {
                indicator.classList.remove('active');
                if (index === currentSlide) {
                    indicator.classList.add('active');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                updateCarousel();
            });
        });

        // Auto-advance carousel
        setInterval(nextSlide, 5000);
    </script>

</body>


</html>