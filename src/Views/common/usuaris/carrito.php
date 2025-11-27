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

</body>
<!-- <script>

    let carreto = null;

    function netejarCarreto() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/netejar-carreto", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Respuesta del servidor:", xhr.responseText);
                    // CORREGIDO: Añadir callback
                    carregarCarreto(function (carretoRecibido) {
                        carreto = carretoRecibido;
                        console.log("Carreto actualizado:", carreto);
                    });
                } else {
                    console.error("Error en la petición:", xhr.status);
                }
            }
        };
        xhr.send("msg=Hola desde JavaScript");
    }

    function afegirArticle(id, quantitat) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/afegir-article-carreto", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Respuesta del servidor:", xhr.responseText);
                    // CORREGIDO: Añadir callback
                    carregarCarreto(function (carretoRecibido) {
                        carreto = carretoRecibido;
                        console.log("Carreto actualizado:", carreto);
                    });
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
                    let carretoData = res.res === 1 ? res.carreto : null;

                    // CORREGIDO: Actualizar con el carreto correcto
                    actualitzarLlistaCarreto(carretoData);

                    // Llamar al callback con los datos
                    if (callback) {
                        callback(carretoData);
                    }
                } else {
                    if (callback) {
                        callback(null);
                    }
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

    function actualitzarLlistaCarreto(carreto) {
        const carretoElement = document.getElementById('carreto');

        if (!carretoElement) {
            console.error('No se encontró el elemento con id "carreto"');
            return;
        }

        // Verificar si el carreto es null, undefined o está vacío
        if (!carreto || Object.keys(carreto).length === 0) {
            carretoElement.innerHTML = `
<div class="cart-header">
    <h4 style="margin: 0;">🛒 Mi Carrito</h4>
    <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
</div>
<div class="cart-content">
    <div class="cart-items">
        <div style="text-align: center; padding: 40px 20px; color: #999;">
            <p>Tu carrito está vacío</p>
        </div>
    </div>
    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>0.00€</span>
        </div>
        <div class="summary-row">
            <span>IVA (10%):</span>
            <span>0.00€</span>
        </div>
        <div class="summary-row summary-total">
            <span>TOTAL:</span>
            <span>0.00€</span>
        </div>
        <button class="btn-comprar" disabled style="opacity: 0.5; cursor: not-allowed;">
            Proceder al Pago
        </button>
    </div>
</div>

`;

            const closeBtn = document.getElementById('closeCart');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    carretoElement.style.display = 'none';
                });
            }

            return;
        }

        const items = Object.values(carreto);

        let subtotal = 0;
        items.forEach(item => {
            const precio = parseFloat(item.precio) || 0;
            const cantidad = parseInt(item.cantidad) || 1;
            subtotal += precio * cantidad;
        });

        const iva = subtotal * 0.10;
        const total = subtotal + iva;

        const itemsHTML = items.map(item => {
            const precio = parseFloat(item.precio) || 0;
            const cantidad = parseInt(item.cantidad) || 1;
            const totalItem = precio * cantidad;
            const descripcion = item.descripcion || '';

            return `
<div class="item-card">
    <div class="row" style="align-items: center;">
        <div class="col-8">
            <div class="item-nombre">${item.nombre}</div>
            <div class="item-descripcion">${descripcion}</div>
        </div>
        <div class="col-4 precio-info">
            <div class="cantidad-precio">${cantidad} × ${precio.toFixed(2)}€</div>
            <div class="total-item">${totalItem.toFixed(2)}€</div>
        </div>
    </div>
</div>
`;
        }).join('');

        const contenidoHTML = `
<div class="cart-header">
    <h4 style="margin: 0;">🛒 Mi Carrito</h4>
    <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
</div>
<div class="cart-content">
    <div class="cart-items">
        ${itemsHTML}
    </div>
    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>${subtotal.toFixed(2)}€</span>
        </div>
        <div class="summary-row">
            <span>IVA (10%):</span>
            <span>${iva.toFixed(2)}€</span>
        </div>
        <div class="summary-row summary-total">
            <span>TOTAL:</span>
            <span>${total.toFixed(2)}€</span>
        </div>
        <button class="btn-comprar">
            Proceder al Pago
        </button>
    </div>
</div>
`;

        carretoElement.innerHTML = contenidoHTML;

        const closeBtn = document.getElementById('closeCart');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                carretoElement.style.display = 'none';
            });
        }
    }

    // CORREGIDO: Añadir parámetro callback
    function crearTicket(callback) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/crear-ticket", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let res = JSON.parse(xhr.responseText);
                    if (callback) {
                        callback(res.res === 1 ? res.ticket : null);
                    }
                } else {
                    if (callback) {
                        callback(null);
                    }
                }
            }
        };

        xhr.send();
    }
</script>
<script>
    // window.onload = carregarCarreto();

</script> -->

</html>