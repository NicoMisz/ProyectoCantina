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
    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/themeChange.js" defer></script>
    <!-- <script src="/assets/js/carrito.js" defer></script> -->
    <script src="/assets/js/carritoDEV.js" defer></script>
    <script src="/assets/js/carruselDEV.js" defer></script>
</head>

<body>
    <header class="header" id="mainHeader">
        <div class="header-content">
            <div class="logo-container">
                <a href="/dashboard">
                    <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
                </a>
            </div>
            <div class="header-actions">
                <button id="theme-toggle" class="theme-toggle">
                    <span class="icon-light">☀️</span>
                    <span class="icon-dark">🌙</span>
                </button>
                <a href="javascript:void(0)" class="header-icon cart-icon" aria-label="Carrito de compras">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge">3</span>
                </a>
                <a href="/perfil" class="header-icon profile-icon" aria-label="Mi perfil">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Abrir menú">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>

    <div class="menu-overlay" id="menuOverlay"></div>

    <nav>
        <ul class="navigation" id="navigation">
            <li><a href="/catalogo">El Catálogo</a></li>
            <li><a href="/tickets">Mis Pedidos</a></li>
            <li><a href="/about-us">About Us</a></li>
            <!-- <li><a href="/formulari">Contacto</a></li> -->

            <?php if ($isAdmin): ?>
                <li class="admin-only">
                    <a href="/admin/gestio-productes">
                        <img src="/assets/media/admin.png" alt="Cantina Tony's" class="logo-admin">
                        Gestió Productes
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
                <li class="admin-only">
                    <a href="/admin/gestio-comandes">
                        <img src="/assets/media/admin.png" alt="Cantina Tony's" class="logo-admin">
                        Gestió Comandes
                    </a>
                </li>
            <?php endif; ?>

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
        <div class="cart-header">
            <h4 style="margin: 0;">Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
        <div class="cart-content">

        </div>
    </div>
    <main class="content">
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
                <button class="carousel-btn carousel-btn-prev" id="prevBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <button class="carousel-btn carousel-btn-next" id="nextBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
                <div class="carousel-indicators">
                    <span class="indicator active" data-slide="0"></span>
                    <span class="indicator" data-slide="1"></span>
                    <span class="indicator" data-slide="2"></span>
                </div>
            </div>
        </section>
        <section class="menu-dia-section">
            <div class="section-header">
                <h2 class="section-title">Menú del Día</h2>
                <p class="section-subtitle">Descubre nuestro menú especial de hoy</p>
            </div>
            <div class="menu-dia-card">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="menu-dia-image">
                            <img src="/assets/media/MDL.png" alt="Menú del Día">
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
                                    <span class="item-text">Entrante</span>
                                </div>
                                <div class="menu-item">
                                    <span class="item-icon"></span>
                                    <span class="item-text">Principal a elegir</span>
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
                <h2 class="section-title">Ofertas del Día</h2>
                <p class="section-subtitle">Aprovecha estas ofertas especiales solo por hoy</p>
            </div>
            <div class="row ofertas-grid">
                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-25%</div>
                        <div class="oferta-image">
                            <img src="/assets/media/Articles/28112025-210758.webp" alt="Empanadas Doradas">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Empanadas Doradas</h3>
                            <p class="oferta-description">
                                Porción de empanadas artesanales, crujientes y recién fritas. Perfectas para compartir o
                                disfrutar solas, con rellenos tradicionales y mucho sabor.
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">21.52€</span>
                                    <span class="price-new">16.14€</span>
                                </div>
                                <button class="btn-add-cart" onclick="afegirArticle('4-28112025-210758', 1)">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                        </path>
                                    </svg>
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-25%</div>
                        <div class="oferta-image">
                            <img src="/assets/media/Articles/28112025-210846.jpg" alt="Quesadillas Mixtas">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Quesadillas Mixtas</h3>
                            <p class="oferta-description">
                                Quesadillas rellenas con mezcla de queso, vegetales salteados y maíz. Doradas a la
                                plancha, calientes y listas para disfrutar en cualquier momento.
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">14.99€</span>
                                    <span class="price-new">11.24€</span>
                                </div>
                                <button class="btn-add-cart" onclick="afegirArticle('5-28112025-210846', 1)">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                        </path>
                                    </svg>
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="oferta-card">
                        <div class="oferta-badge">-25%</div>
                        <div class="oferta-image">
                            <img src="/assets/media/Articles/28112025-210955.webp" alt="Huevos Rellenos Especiales">
                        </div>
                        <div class="oferta-content">
                            <h3 class="oferta-title">Huevos Rellenos Especiales</h3>
                            <p class="oferta-description">
                                Huevos rellenos caseros cubiertos con una suave salsa cremosa y acabado de yema rallada.
                                Sabrosos, frescos y perfectos para cualquier ocasión.
                            </p>
                            <div class="oferta-footer">
                                <div class="oferta-price">
                                    <span class="price-old">12.79€</span>
                                    <span class="price-new">9.59€</span>
                                </div>
                                <button class="btn-add-cart" onclick="afegirArticle('6-28112025-210955', 1)">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                        </path>
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
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
                    </div>
                    <p>Programamos tu comida con la mejor calidad y tecnología. Desde 2020 sirviendo a la comunidad
                        educativa.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">F</a>
                        <a href="#" class="social-link" aria-label="Instagram">I</a>
                        <a href="#" class="social-link" aria-label="Twitter">T</a>
                        <a href="#" class="social-link" aria-label="YouTube">Y</a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/catalogo">Catálogo</a></li>
                        <li><a href="/menu">Menú del Día</a></li>
                        <li><a href="/carrito">Mis Pedidos</a></li>
                        <li><a href="/aboutUs">Sobre Nosotros</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Información</h3>
                    <ul>
                        <li><a href="">Cómo Funciona</a></li>
                        <li><a href="">Programa de Fidelidad</a></li>
                        <li><a href="">Alérgenos</a></li>
                        <li><a href="">Política de Privacidad</a></li>
                        <li><a href="">Términos y Condiciones</a></li>
                        <li><a href="">Política de Cookies</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contacto</h3>
                    <div class="contact-item">
                        <span><b>Direccion</b></span>
                        <span>C/ Riera de Cirera 57<br> 08304 Mataró, Barcelona</span>
                    </div>
                    <div class="contact-item">
                        <span><b>Telefono</b></span>
                        <span>+34 937 41 42 03</span>
                    </div>
                    <div class="contact-item">
                        <span><b>Correo</b></span>
                        <span>info@cantinatonys.com</span>
                    </div>
                    <div class="contact-item">
                        <span><b>Horario</b></span>
                        <span>Lun-Vie: 8:00 - 22:00</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    <p>&copy; 2025 Cantina Tony's. Todos los derechos reservados.</p>
                </div>

                <div class="footer-bottom-links">
                    <a href="/aviso-legal">Aviso Legal</a>
                    <a href="/politica-privacidad">Privacidad</a>
                    <a href="/cookies">Cookies</a>
                    <a href="/accesibilidad">Accesibilidad</a>
                </div>


            </div>
        </div>
    </footer>

    <script>

    </script>

</body>


</html>
<style>
    .item-card {
        position: relative;
        padding: 10px;
        /* Ajusta según necesites */
    }

    .item-card>a {
        position: absolute;
        top: -9px;
        right: -10px;
        cursor: pointer;
        z-index: 10;
        background: transparent;
        border: none;
        font-size: 1rem;
        height: 1.25rem;
        width: 1.25rem;
        background-color: white;
        text-align: center;
        border: 0.10rem solid black;
        border-radius: 100%;
        line-height: 1;
        color: #666;
        text-decoration: none;
    }

    .item-card>a:hover {
        color: #000;
    }
</style>