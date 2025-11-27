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
    <!-- <script src="/assets/js/carrito.js"></script> -->
    <script src="/assets/js/carritoDEV.js"></script>
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
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
        <div class="cart-content">

        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="content">
        <section class="menu-dia-section">
            <div class="section-header">
                <h2 class="section-title">Menú del Día</h2>
                <p class="section-subtitle">Descubre nuestro menú especial de hoy</p>
            </div>

            <?php
            foreach ($data as $key => $categoria) {
                ?>
                <div class="section-header">
                    <h2 class="section-title"><?php echo $key ?></h2>
                    <p class="section-subtitle">Descubre nuestros entrantes</p>
                </div>
                <div class="row">
                    <?php
                    foreach ($categoria as $article) {
                        ?>
                        <div class="col-4">
                            <div class="producto-card" data-precio="<?php echo $article["precio"]; ?>"
                                data-file="<?php echo $articleId; ?>">
                                <div class="producto-image">
                                    <img src="<?php echo $article["imagen"]; ?>" alt="<?php echo $article["nombre"]; ?>">
                                </div>

                                <div class="producto-content">
                                    <h3 class="producto-title"><?php echo $article["nombre"]; ?></h3>
                                    <p class="producto-description"><?php echo $article["descripcion"]; ?></p>


                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                </div>
                <?php
            }
            ?>
        </section>


    </main>
</body>


</html>