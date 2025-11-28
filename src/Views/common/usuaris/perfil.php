<?php
    $user = $_SESSION['user'] ?? null;
    $isAdmin = $user && isset($user['rol']) && $user['rol'] === 'admin';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil
        <?php
        if ($vista == 'admin' && $data["fechaCreacion"] != $_SESSION['user']['fechaCreacion']) {
            echo "Vista ADMIN";
        }
        ?>
    </title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/themeChange.js"></script>
    <script src="/assets/js/carritoDEV.js" defer></script>
</head>

<body>
    <!-- Header Principal -->
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

    <div class="content">
        <div class="row">
            <div class="col-3">
                <div style="margin:0rem 3rem 3rem 0rem;">
                    <div>
                        <div>
                            <img style="width: 100%;
                            height: auto;
                            border-radius: 50%;
                            border: 3px black solid;
                            " src="https://placehold.co/320x320" alt="">
                        </div>
                    </div>
                    <?php
                    echo '
                        <div class="card" style="margin-top:5rem;">
                            <div class="card-body">
                                <h5 class="card-title">Mostrar nomes si te comandas recients</h5>
                                <p>1</p>
                                <p>1</p>
                                <p>1</p>
                                <p>1</p>
                                <p>1</p>
                                <p>1</p>
                            </div>
                        </div>';
                    ?>

                    <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
<p class="card-text">Some quick example text to build on the card title and make up the bulk
   </p>
<a href="#" class="card-link">Card link</a>
<a href="#" class="card-link">Another link</a> -->
                </div>
            </div>
            <div class="col-9">
                <div style="margin:2rem 3rem 3rem 3rem;">
                    <?php
                    if ($vista == 'admin') {
                        echo '<div class="col-12" style="padding:0px;margin:0 0 3rem 0;">';
                        echo '<div class="card">';
                        echo "<span class='h1-titol' style='padding: 2rem 0;text-align: center;'>Vista Administrador</span>";
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (!empty($data["nombre"]) && !empty($data["apellidos"])) {
                                echo "<span class='h1-titol card-title' style='padding: 1rem 2rem 2rem;text-align: center;display:block;'>" . $data["nombre"] . " " . $data["apellidos"] . " - ";
                                switch ($data["rol"]) {
                                    case "admin":
                                        echo "Administrador";
                                        break;
                                }
                                echo "</span>";
                            }
                            ?>

                            <?php
                            if (!empty($data["id"])) {
                                echo '<p data-type="id">' . $data["id"] . '</p>';
                            }
                            if (!empty($data["nombre"])) {
                                echo '<p data-type="nombre">' . $data["nombre"] . '</p>';
                            }
                            if (!empty($data["email"])) {
                                echo '<p data-type="email">' . $data["email"] . '</p>';
                            }
                            if (!empty($data["rol"])) {
                                echo '<p data-type="rol">' . $data["rol"] . '</p>';
                            }
                            if (!empty($data["activo"])) {
                                echo '<p data-type="activo">' . $data["activo"] . '</p>';
                            }
                            if (!empty($data["fechaCreacion"])) {
                                $tokenDateTime = DateTime::createFromFormat('dmY-His', $data["fechaCreacion"]);

                                echo '<p data-type="fechaCreacion">' . $tokenDateTime->format('d/m/Y') . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>






        <!-- 
    <form id="userForm">
        <input type="text" name="email" placeholder="Email" <?php
        if (!empty($data["email"])) {
            echo 'value="' . $data["email"] . '"';
        }
        ?>>
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Guardar</button>
    </form> -->

        <div id="respuesta"></div>

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
        <script>
            document.getElementById('userForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('/login', {
                    method: 'POST',
                    body: formData
                })
                    .then(r => r.text())
                    .then(d => {
                        //     document.getElementById('respuesta').innerHTML = d;

                    })
                    .catch(err => {
                        // document.getElementById('respuesta').innerHTML = "Error: " + err;
                    });
            });
        </script>

</body>

</html>