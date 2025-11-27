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
            foreach ($data as $key => $value) {
                $articleId = $key;// Asegúrate de que tienes el ID en tus datos
                $html = '
        <div data-precio="' . $value["precio"] . '" data-file="' . $articleId . '" class="article col-4" style="padding:10px">
            <div class="card" style="min-height: 7rem;">
                <div class="card-body">
                    <div class="row" style="min-height:250px;">
                        <div class="col-12" style="min-height:100px;display: flex;justify-content: center;">
                            <img src="' . $value["imagen"] . '" style="width: 6rem;height: 6rem;object-fit: cover;">
                        </div>  
                        <div class="col-12" style="min-height:30px;">
                            <span><strong>' . $value["nombre"] . '</strong></span>
                        </div>  
                        <div class="col-12" style="min-height:50px;">
                            <span>' . $value["descripcion"] . '</span>
                        </div>  
                        <div class="col-12" style="min-height:50px;">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <span>Cantidad</span>
                                </div>  
                                <div class="col-5 d-flex align-items-center justify-content-between">
                                    <button class="btn btn-sm btn-outline-secondary btn-minus" data-article="' . $articleId . '">-</button>
                                    <span class="cantidad mx-2">0</span>
                                    <button class="btn btn-sm btn-outline-secondary btn-plus" data-article="' . $articleId . '">+</button>
                                </div>  
                            </div>
                        </div>
                        <div class="col-12" style="min-height:50px;">
                            <div class="row align-items-center btn-add-cart" onclick="añadirAlCarrito(\'' . $articleId . '\')" style="cursor:pointer;border-radius:1rem;border:black solid 3px;height:100%;padding:10px;">
                                <div class="col-8">
                                    <span>Afegir al carret</span>
                                </div>  
                                <div class="col-4 text-end">
                                    <span class="total">0.00</span>€
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                echo $html;
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
                    const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
                    const cantidadSpan = articleDiv.querySelector('.cantidad');
                    const totalSpan = articleDiv.querySelector('.total');
                    const precio = parseFloat(articleDiv.getAttribute('data-precio'));

                    let cantidad = parseInt(cantidadSpan.textContent);
                    cantidad++;
                    cantidadSpan.textContent = cantidad;

                    const total = (precio * cantidad).toFixed(2);
                    totalSpan.textContent = total;
                });
            });

            document.querySelectorAll('.btn-minus').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const articleId = this.getAttribute('data-article');
                    const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
                    const cantidadSpan = articleDiv.querySelector('.cantidad');
                    const totalSpan = articleDiv.querySelector('.total');
                    const precio = parseFloat(articleDiv.getAttribute('data-precio'));

                    let cantidad = parseInt(cantidadSpan.textContent);
                    if (cantidad > 0) {
                        cantidad--;
                        cantidadSpan.textContent = cantidad;

                        const total = (precio * cantidad).toFixed(2);
                        totalSpan.textContent = total;
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
            const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
            const cantidad = parseInt(articleDiv.querySelector('.cantidad').textContent);

            if (cantidad > 0) {
                afegirArticle(articleId, cantidad);
                // Opcional: resetear cantidad después de añadir
                // articleDiv.querySelector('.cantidad').textContent = '0';
                // articleDiv.querySelector('.total').textContent = '0.00';
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
            let data = [id, quantitat]
            json = JSON.stringify(data)
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
                        callback(res.res === 1 ? res.carreto : null);
                    } else {
                        callback(null);
                    }
                }
            };

            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function () {
            carregarCarreto(function (carretoRecibido) {
                carreto = carretoRecibido;
                console.log("Carreto final:", carreto);
            });
        });
    </script>

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