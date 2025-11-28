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
</head>

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
            <li><a href="/tickets">Mis Pedidos</a></li>
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
            <?php if ($isAdmin): ?>
                <!-- Solo visible para administradores -->
                <li class="admin-only">
                    <a href="/admin/gestio-comandes">
                        <img src="/assets/media/admin.png" alt="Cantina Tony's" class="logo-admin">
                        Gestió Comandes
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
        <div class="cart-header">
            <h4 style="margin: 0;">Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
        <div class="cart-content">

        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="content">
        <!-- Hero Section -->
        <section class="about-hero">
            <div class="about-hero-content">
                <h1 class="about-hero-title">Sobre Nosotros</h1>
                <p class="about-hero-subtitle">Conoce al equipo detrás de Cantina Tony's</p>
            </div>
        </section>

        <!-- Sobre el Proyecto -->
        <section class="about-project">
            <div class="section-header">
                <h2 class="section-title">Nuestro Proyecto</h2>
            </div>

            <div class="project-card">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="project-image">
                            <img src="/assets/media/cantinaTonys.png" alt="Proyecto Cantina Tony's">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="project-content">
                            <h3>¿Qué es Cantina Tony's?</h3>
                            <p>
                                Cantina Tony's es un proyecto innovador desarrollado como parte de nuestra formación en
                                desarrollo web.
                                Nace de la necesidad de digitalizar y modernizar la experiencia de pedidos en cantinas
                                educativas.
                            </p>
                            <p>
                                Nuestro sistema permite a los estudiantes y profesores realizar pedidos de forma rápida
                                y eficiente,
                                gestionar menús del día, y mantener un historial completo de sus compras. Todo desde una
                                interfaz
                                intuitiva y moderna.
                            </p>

                            <div class="project-features">
                                <div class="feature-item">
                                    <span class="feature-text">Sistema de pedidos online</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-text">Diseño responsive y moderno</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-text">Sistema de autenticación seguro</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-text">Panel de administración completo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-team">
            <div class="section-header">
                <h2 class="section-title">Nuestro Equipo</h2>
                <p class="section-subtitle">Los desarrolladores detrás del proyecto</p>
            </div>

            <div class="row team-grid">
                <div class="col-12 col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="/assets/media/1.png" alt="Desarrollador 1">
                            <div class="team-badge">Full Stack</div>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">Jan Lopez</h3>
                            <p class="team-role">Desarrollador Full Stack</p>
                            <p class="team-description">
                                Contribución integral en el proyecto, desde la arquitectura backend con PHP hasta
                                el diseño de interfaces responsive. Participación activa en la gestión de los fitxeros
                                de datos, sistema de autenticación y desarrollo del panel de administración.
                            </p>
                            <div class="team-skills">
                                <span class="skill-tag">JavaScript</span>
                                <span class="skill-tag">HTML/CSS</span>
                                <span class="skill-tag">PHP</span>
                                <span class="skill-tag">Git</span>
                            </div>
                            <div class="team-social">
                                <a href="#" class="team-social-link" aria-label="GitHub">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                    </svg>
                                </a>
                                <a href="#" class="team-social-link" aria-label="LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desarrollador 2 -->
                <div class="col-12 col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="/assets/media/2.png" alt="Desarrollador 2">
                            <div class="team-badge">Full Stack</div>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">Nico</h3>
                            <p class="team-role">Desarrollador Full Stack</p>
                            <p class="team-description">
                                Desarrollo transversal en todas las capas del proyecto. Implementación del sistema
                                de carrito de compras, gestión de pedidos y diseño del sistema visual. Colaboración
                                en la lógica de negocio y optimización de la experiencia de usuario.
                            </p>
                            <div class="team-skills">
                                <span class="skill-tag">JavaScript</span>
                                <span class="skill-tag">HTML/CSS</span>
                                <span class="skill-tag">PHP</span>
                                <span class="skill-tag">Git</span>
                            </div>
                            <div class="team-social">
                                <a href="#" class="team-social-link" aria-label="GitHub">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                    </svg>
                                </a>
                                <a href="#" class="team-social-link" aria-label="LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desarrollador 3 -->
                <div class="col-12 col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="/assets/media/3.png" alt="Desarrollador 3">
                            <div class="team-badge">Full Stack</div>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">John Esparrell Molina</h3>
                            <p class="team-role">Desarrollador Full Stack</p>
                            <p class="team-description">
                                Participación completa en el ciclo de desarrollo del proyecto. Creación de la
                                gestión de productos, integración frontend-backend, y desarrollo del sistema de
                                temas claro/oscuro. Trabajo colaborativo en debugging y testing de la aplicación.
                            </p>
                            <div class="team-skills">
                                <span class="skill-tag">JavaScript</span>
                                <span class="skill-tag">HTML/CSS</span>
                                <span class="skill-tag">PHP</span>
                                <span class="skill-tag">Git</span>
                            </div>
                            <div class="team-social">
                                <a href="#" class="team-social-link" aria-label="GitHub">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                    </svg>
                                </a>
                                <a href="#" class="team-social-link" aria-label="LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ubicación -->
        <section class="about-location">
            <div class="section-header">
                <h2 class="section-title">Nuestra Ubicación</h2>
                <p class="section-subtitle">Visítanos en el instituto</p>
            </div>

            <div class="location-card">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="location-info">
                            <h3>Institut Thos i Codina</h3>
                            <div class="location-details">
                                <div class="location-item">
                                    <div>
                                        <strong>Dirección</strong>
                                        <p>C/ Riera de Cirera 57<br>08304 Mataró, Barcelona</p>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div>
                                        <strong>Teléfono</strong>
                                        <p>+34 937 41 42 03</p>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div>
                                        <strong>Email</strong>
                                        <p>info@cantinatonys.com</p>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div>
                                        <strong>Horario</strong>
                                        <p>Lunes a Viernes: 8:00 - 22:00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="location-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d746.4804906100874!2d2.4383229765363468!3d41.54928688116325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4b51615a9afb5%3A0xb29dc50d1b9b10a4!2sInstitut%20p%C3%BAblic%20Thos%20i%20Codina!5e0!3m2!1sca!2ses!4v1764359704392!5m2!1sca!2ses"
                                width="100%" height="400" style="border:0; border-radius: 1rem;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- Sección: Sobre Nosotros -->
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

                <!-- Sección: Enlaces Rápidos -->
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

                <!-- Sección: Información -->
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

                <!-- Sección: Contacto -->
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

            <!-- Footer Bottom -->
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
</body>


</html>