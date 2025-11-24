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

    <!-- Contenido de ejemplo (eliminar en producción) -->
    <main class="content">
        <h1>Catalogo</h1>

        <div class="row">
            <?php
            // echo "<pre>";
            // var_dump($data);
            // exit;
            
            foreach ($data as $key => $value) {
                // echo $key;
                $html = '
                <div data-precio="' . $value["precio"] . '" data-file="2-30122025-171618" class="article col-4" style="padding:10px">
                <div class="card" style="min-height: 7rem;">
                    <div class="card-body" style="">
                        <div class="row" style="min-height:250px;">
                            <div class="col-12" style="min-height:100px;display: flex;justify-content: center;">
                                <img src="' .
                    $value["imagen"]
                    . '"
                                 style="width: 6rem;height: 6rem;object-fit: cover;">
                            </div>  
                            <div class="col-12" style="min-height:30px;">
                                <span>' .
                    $value["nombre"]
                    . '
                                </span>
                            </div>  
                            <div class="col-12" style="min-height:50px;">
                                <span>' .
                    $value["descripcion"]
                    . '</span>
                            </div>  
                            <div class="col-12" style="min-height:50px;">
                                <div class="row">
                                    <div class="col-7">
                                        <span>
                                        cantidad
                                        </span>
                                    </div>  
                                    <div class="col-5">
                                        <span>
                                    - O +
                                        </span>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-12" style="min-height:50px;">
                                <div class="row" style="cursor:pointer;border-radius:1rem;border:black solid 3px;height 100%;">
                                    <div class="col-8">
                                        <span>
                                        afegir al carreto
                                        </span>
                                    </div>  
                                    <div class="col-4">
                                        <span class="total">0</span>€
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                ';
                echo $html;

            }



            ?>
        </div>
    </main>

</body>
<script>
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "/afegir-article-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };
    xhr.send("msg=Hola desde JavaScript");
</script>

</html>