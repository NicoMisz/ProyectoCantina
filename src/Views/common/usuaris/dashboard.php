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
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>

        <div class="cart-content">
            <div class="cart-items">
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>
                <div class="item-card">
                    <div class="row" style="align-items: center;">

                        <div class="col-8">
                            <div class="item-nombre">Hamburguesa Deluxe</div>
                            <div class="item-descripcion">Carne angus, queso cheddar, bacon</div>
                        </div>
                        <div class="col-4 precio-info">
                            <div class="cantidad-precio">1 × 12.50€</div>
                            <div class="total-item">12.50€</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Resumen Total -->
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>52.98€</span>
                </div>
                <div class="summary-row">
                    <span>IVA (10%):</span>
                    <span>5.30€</span>
                </div>
                <div class="summary-row summary-total">
                    <span>TOTAL:</span>
                    <span>58.28€</span>
                </div>
                <button class="btn-comprar">
                    Proceder al Pago
                </button>
            </div>

        </div>
    </div>

    <main class="content">
        <h1>¡Bienvenido a Cantina Tony's!</h1>
    </main>

</body>


</html>