<?php
$user = $_SESSION['user'] ?? null;
$isAdmin = $user && isset($user['rol']) && $user['rol'] === 'admin';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Cantina Tony's</title>
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
            <li><a href="/tickets">Mis Pedidos</a></li>
            <li><a href="/about-us">About Us</a></li>
            <li><a href="/formulari">Contacto</a></li>

            <?php if ($isAdmin): ?>
                <li class="admin-only">
                    <a href="/admin/gestio-productes">
                        <img src="/assets/media/admin.png" alt="Admin" class="logo-admin">
                        Gestió Productes
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

    <!-- Contenido Principal -->
    <main class="content">
        <!-- Header del Catálogo -->
        <div class="catalogo-header">
            <h1 class="catalogo-title">Nuestro Catálogo</h1>
            <p class="catalogo-subtitle">Descubre todos nuestros deliciosos PROGRAMADOS</p>
        </div>

        <!-- Grid de Productos -->
        <div class="row catalogo-grid">
            <?php
            foreach ($data as $key => $value) {
                $articleId = $key;
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="producto-card" data-precio="<?php echo $value["precio"]; ?>" data-file="<?php echo $articleId; ?>">
                        <!-- Imagen del Producto -->
                        <div class="producto-image">
                            <img src="<?php echo $value["imagen"]; ?>" alt="<?php echo $value["nombre"]; ?>">
                        </div>

                        <!-- Contenido del Producto -->
                        <div class="producto-content">
                            <h3 class="producto-title"><?php echo $value["nombre"]; ?></h3>
                            <p class="producto-description"><?php echo $value["descripcion"]; ?></p>
                            
                            <!-- Precio -->
                            <div class="producto-precio">
                                <span class="precio-valor"><?php echo number_format($value["precio"], 2); ?>€</span>
                            </div>

                            <!-- Control de Cantidad -->
                            <div class="producto-cantidad">
                                <label class="cantidad-label">Cantidad:</label>
                                <div class="cantidad-controls">
                                    <button class="btn-cantidad btn-minus" data-article="<?php echo $articleId; ?>">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                    <span class="cantidad-display">0</span>
                                    <button class="btn-cantidad btn-plus" data-article="<?php echo $articleId; ?>">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón Añadir al Carrito -->
                            <button class="btn-add-carrito" onclick="añadirAlCarrito('<?php echo $articleId; ?>')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <span>Añadir</span>
                                <span class="producto-total">0.00€</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Manejadores para botones + y -
            document.querySelectorAll('.btn-plus').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const articleId = this.getAttribute('data-article');
                    const productCard = document.querySelector(`[data-file="${articleId}"]`);
                    const cantidadSpan = productCard.querySelector('.cantidad-display');
                    const totalSpan = productCard.querySelector('.producto-total');
                    const precio = parseFloat(productCard.getAttribute('data-precio'));

                    let cantidad = parseInt(cantidadSpan.textContent);
                    cantidad++;
                    cantidadSpan.textContent = cantidad;

                    const total = (precio * cantidad).toFixed(2);
                    totalSpan.textContent = total + '€';

                    // Añadir animación
                    cantidadSpan.classList.add('cantidad-pulse');
                    setTimeout(() => cantidadSpan.classList.remove('cantidad-pulse'), 300);
                });
            });

            document.querySelectorAll('.btn-minus').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const articleId = this.getAttribute('data-article');
                    const productCard = document.querySelector(`[data-file="${articleId}"]`);
                    const cantidadSpan = productCard.querySelector('.cantidad-display');
                    const totalSpan = productCard.querySelector('.producto-total');
                    const precio = parseFloat(productCard.getAttribute('data-precio'));

                    let cantidad = parseInt(cantidadSpan.textContent);
                    if (cantidad > 0) {
                        cantidad--;
                        cantidadSpan.textContent = cantidad;

                        const total = (precio * cantidad).toFixed(2);
                        totalSpan.textContent = total + '€';

                        // Añadir animación
                        cantidadSpan.classList.add('cantidad-pulse');
                        setTimeout(() => cantidadSpan.classList.remove('cantidad-pulse'), 300);
                    }
                });
            });
        });

        function netejarCarreto() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/netejar-carreto", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Respuesta del servidor:", xhr.responseText);
                        carregarCarreto();
                    } else {
                        console.error("Error en la petición:", xhr.status);
                    }
                }
            };
            xhr.send("msg=Hola desde JavaScript");
        }

        // Función para añadir al carrito
        function añadirAlCarrito(articleId) {
            const productCard = document.querySelector(`[data-file="${articleId}"]`);
            const cantidad = parseInt(productCard.querySelector('.cantidad-display').textContent);

            if (cantidad > 0) {
                afegirArticle(articleId, cantidad);
                
                // Mostrar feedback visual
                const btn = productCard.querySelector('.btn-add-carrito');
                btn.classList.add('btn-success-animation');
                setTimeout(() => btn.classList.remove('btn-success-animation'), 600);
                
                // Opcional: resetear cantidad después de añadir
                // productCard.querySelector('.cantidad-display').textContent = '0';
                // productCard.querySelector('.producto-total').textContent = '0.00€';
            } else {
                alert('Selecciona una cantidad mayor a 0');
            }
        }

        function afegirArticle(id, quantitat) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/afegir-article-carreto", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Respuesta del servidor:", xhr.responseText);
                        carregarCarreto();
                    } else {
                        console.error("Error en la petición:", xhr.status);
                    }
                }
            };
            let data = [id, quantitat];
            json = JSON.stringify(data);
            xhr.send("data=" + json);
        }

        function carregarCarreto(callback) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/carregar-carreto", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        let res = JSON.parse(xhr.responseText);
                        if (callback) callback(res.res === 1 ? res.carreto : null);
                    } else {
                        if (callback) callback(null);
                    }
                }
            };

            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function () {
            carregarCarreto(function (carretoRecibido) {
                let carreto = carretoRecibido;
                console.log("Carreto final:", carreto);
            });
        });
    </script>
</body>
</html>