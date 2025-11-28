<?php

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
    <!-- <script src="/assets/js/carrito.js"></script> -->
    <script src="/assets/js/carritoDEV.js"></script>
</head>
<style>

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
                <!-- <a href="/carrito" class="header-icon cart-icon" aria-label="Carrito de compras"></a>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge">3</span>
                </a> -->
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

    <!-- Añade esto ANTES del cierre de </body> en tu HTML -->

    <!-- Overlay oscuro del carrito -->
    <div class="cart-overlay" id="cartOverlay"></div>

    <!-- Panel lateral del carrito -->
    <div id="carreto">
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>

        <div class="cart-content">


        </div>
    </div>
    <main class="content">


        <a href="#" onclick="netejarCarreto()">BOTON LIMPIAR CARRITO</a>
        <a href="#" onclick="afegirArticle('2-30122025-171618',2)">AÑADIR EJEMPLO</a>
        <a href="#" onclick="afegirArticle('1-30122025-171618',2)">AÑADIR EJEMPLO</a>
        <br>
        <a href="#" onclick="carregarCarreto()">Cargarcookies</a>
        <!-- <div id="carretos"> -->
        <?php

        
        if (isset($carreto)) {
            $total = 0;

            echo '
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
        <div class="cart-content">
            <div class="cart-items">';

            // Iterar por cada item del carrito
            foreach ($carreto as $item) {
                $totalItem = $item["cantidad"] * $item["precio"];
                $total += $totalItem;
                // Aquí deberías obtener el nombre y descripción del producto desde la BD
                $nombreProducto = $item["nombre"];
                $descripcionProducto = $item["descripcion"];

                echo '<div class="item-card">
                <div class="row" style="align-items: center;">
                <div class="col-2">
                        <img src="' . $item["imagen"] . '" alt="Pizza" class="item-img">
                    </div>
                    <div class="col-8">
                        <div class="item-nombre">' . htmlspecialchars($nombreProducto) . '</div>
                        <div class="item-descripcion">' . htmlspecialchars($descripcionProducto) . '</div>
                    </div>
                    <div class="col-2 precio-info">
                        <div class="cantidad-precio">' . $item["cantidad"] . ' × ' . number_format($item["precio"], 2, ',', '.') . '€</div>
                        <div class="total-item">' . number_format($totalItem, 2, ',', '.') . '€</div>
                    </div>
                </div>
            </div>';
            }

            echo '</div>';

            // Calcular IVA
            $subtotal = $total;
            $iva = $subtotal * 0.10;
            $totalFinal = $subtotal + $iva;

            // Mostrar resumen con el total
            echo '<div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>' . number_format($subtotal, 2, ',', '.') . '€</span>
        </div>
        <div class="summary-row">
            <span>IVA (10%):</span>
            <span>' . number_format($iva, 2, ',', '.') . '€</span>
        </div>
        <div class="summary-row summary-total">
            <span>TOTAL:</span>
            <span>' . number_format($totalFinal, 2, ',', '.') . '€</span>
        </div>
        <a class="btn-comprar" href="#" onclick="crearTicket();">
            Proceder al Pago
        </a>
    </div>
    </div>
    </div>';

        } else {
            echo '
            <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
        <div class="cart-content">
            <div>
            <span>Carreto Buit</span>
            </div>
    </div>';
        }
        ?>


    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- Sección: Sobre Nosotros -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
                    </div>
                    <p>Programamos tu comida con la mejor calidad y tecnología. Desde 2020 sirviendo a la comunidad educativa.</p>
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