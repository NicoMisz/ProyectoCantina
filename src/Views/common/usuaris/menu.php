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
 <li><a href="/pedidos">Mis Pedidos</a></li>
 <li><a href="/about-us">About Us</a></li>
 <li><a href="/formulari">Contacto</a></li>

 <?php if ($isAdmin): ?>
 <li class="admin-only">
 <a href="/admin/gestio-productes">
 <img src="/assets/media/admin.png" alt="Cantina Tony's" class="logo-admin">
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
 <div class="cart-overlay" id="cartOverlay"></div>

 <div id="carreto">
 <div class="cart-header">
 <h4 style="margin: 0;">🛒 Mi Carrito</h4>
 <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
 </div>
 <div class="cart-content">

 </div>
 </div>

 <main class="content">
 <section class="menu-dia-section">
 <div class="section-header">
 <h2 class="section-title">Menú del Día</h2>
 <p class="section-subtitle">Descubre nuestro menú especial de hoy</p>
 </div>

 <?php
 // echo "<pre>";
 // var_dump($data);
 // exit;
 foreach ($data as $key => $categoria) {
 ?>
 <div class="section-header">
 <h2 class="section-title"><?php echo $key ?></h2>
 <p class="section-subtitle">Descubre nuestros entrantes</p>
 </div>
 <div class="row">
 <?php
 foreach ($categoria as $articleId => $article) {
 ?>
 <div class="col-4">
 <div class="producto-card<?php if ($key == "Postre" || $key == "Bebida"): ?> selected<?php endif; ?>"
 data-precio="<?php echo $article["precio"]; ?>" data-file="<?php echo $articleId; ?>">
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
<script>
 // Variables globales para el menú seleccionado
 let menuSeleccionado = {
 entrante: null,
 principal: null,
 postre: null,
 bebida: null
 };

 // Función para añadir el menú completo al carrito
 function afegirMenu() {
 // Verificar que se haya seleccionado al menos un artículo
 const articulosSeleccionados = Object.values(menuSeleccionado).filter(item => item !== null);

 if (articulosSeleccionados.length === 0) {
 alert('Por favor, selecciona al menos un artículo del menú');
 return;
 }

 // Crear el objeto de datos para enviar
 const menuData = {
 entrante: menuSeleccionado.entrante,
 principal: menuSeleccionado.principal,
 postre: menuSeleccionado.postre,
 bebida: menuSeleccionado.bebida
 };

 // Enviar petición XMLHttpRequest
 let xhr = new XMLHttpRequest();
 xhr.open("POST", "/afegir-article-carreto", true);
 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

 xhr.onreadystatechange = function () {
 if (xhr.readyState === 4) {
 if (xhr.status === 200) {
 console.log("Respuesta del servidor:", xhr.responseText);

 // Recargar el carrito después de añadir el menú
 carregarCarreto(function (carretoRecibido) {
 carreto = carretoRecibido;
 actualitzarBadgeCarreto(carreto);
 });

 // Mostrar mensaje de éxito
 alert('¡Menú añadido al carrito exitosamente!');

 // Opcional: Limpiar selección
 limpiarSeleccionMenu();
 } else {
 console.error("Error en la petición:", xhr.status);
 alert('Error al añadir el menú. Por favor, inténtalo de nuevo.');
 }
 }
 };

 // Enviar los datos como JSON
 let json = JSON.stringify(menuData);
 xhr.send("menu=" + encodeURIComponent(json));
 }

 // Función para limpiar la selección del menú
 function limpiarSeleccionMenu() {
 menuSeleccionado = {
 entrante: null,
 principal: null,
 postre: null,
 bebida: null
 };

 // Remover clases de selección visual
 document.querySelectorAll('.producto-card.selected').forEach(card => {
 card.classList.remove('selected');
 });
 }

 // Función para manejar la selección de artículos
 function seleccionarArticulo(card, categoria) {
 const articulo = card.getAttribute('data-file');
 const precio = parseFloat(card.getAttribute('data-precio'));
 const nombre = card.querySelector('.producto-title').textContent;
 const descripcion = card.querySelector('.producto-description').textContent;

 // Remover selección anterior de la misma categoría
 const categoriaRow = card.closest('.row');
 categoriaRow.querySelectorAll('.producto-card.selected').forEach(c => {
 c.classList.remove('selected');
 });

 // Si se hace clic en el mismo artículo, deseleccionar
 if (menuSeleccionado[categoria] && menuSeleccionado[categoria].articulo === articulo) {
 menuSeleccionado[categoria] = null;
 card.classList.remove('selected');
 } else {
 // Añadir nueva selección
 menuSeleccionado[categoria] = {
 articulo: articulo,
 precio: precio,
 nombre: nombre,
 descripcion: descripcion
 };
 card.classList.add('selected');
 }

 // Actualizar contador de selecciones
 actualizarContadorMenu();
 }

 // Función para actualizar el contador de artículos seleccionados
 function actualizarContadorMenu() {
 const contador = document.getElementById('menu-counter');
 if (contador) {
 const numSeleccionados = Object.values(menuSeleccionado).filter(item => item !== null).length;
 contador.textContent = numSeleccionados;

 if (numSeleccionados > 0) {
 contador.style.display = 'inline-block';
 } else {
 contador.style.display = 'none';
 }
 }
 }

 // Función para cargar artículos preseleccionados
 function cargarPreseleccionados() {
 const cardsPreseleccionadas = document.querySelectorAll('.producto-card.selected');

 cardsPreseleccionadas.forEach(card => {
 // Encontrar la categoría de esta tarjeta
 let categoria = null;
 const seccionHeader = card.closest('.row').previousElementSibling;

 if (seccionHeader && seccionHeader.classList.contains('section-header')) {
 const titulo = seccionHeader.querySelector('.section-title').textContent.toLowerCase();

 if (titulo.includes('entrante')) categoria = 'entrante';
 else if (titulo.includes('principal')) categoria = 'principal';
 else if (titulo.includes('postre')) categoria = 'postre';
 else if (titulo.includes('bebida')) categoria = 'bebida';
 }

 if (categoria) {
 const articulo = card.getAttribute('data-file');
 const precio = parseFloat(card.getAttribute('data-precio'));
 const nombre = card.querySelector('.producto-title').textContent;
 const descripcion = card.querySelector('.producto-description').textContent;

 menuSeleccionado[categoria] = {
 articulo: articulo,
 precio: precio,
 nombre: nombre,
 descripcion: descripcion
 };
 }
 });

 // Actualizar contador después de cargar preseleccionados
 actualizarContadorMenu();
 }

 // Inicializar el script cuando el DOM esté listo
 document.addEventListener('DOMContentLoaded', function () {

 // Obtener todas las secciones de categorías
 const secciones = document.querySelectorAll('.section-header');
 const categorias = ['entrante', 'principal', 'postre', 'bebida'];

 // Asignar eventos de clic a cada producto-card
 secciones.forEach((seccion, index) => {
 const titulo = seccion.querySelector('.section-title').textContent.toLowerCase();
 let categoria = null;

 // Determinar la categoría basándose en el título
 if (titulo.includes('entrante')) categoria = 'entrante';
 else if (titulo.includes('principal')) categoria = 'principal';
 else if (titulo.includes('postre')) categoria = 'postre';
 else if (titulo.includes('bebida')) categoria = 'bebida';

 if (categoria) {
 // Obtener el siguiente .row después de esta sección
 const row = seccion.nextElementSibling;
 if (row && row.classList.contains('row')) {
 const cards = row.querySelectorAll('.producto-card');
 cards.forEach(card => {
 card.style.cursor = 'pointer';
 card.addEventListener('click', function () {
 seleccionarArticulo(this, categoria);
 });
 });
 }
 }
 });

 // Cargar artículos preseleccionados al iniciar
 cargarPreseleccionados();

 // Crear y añadir el botón "Añadir Menú"
 const menuSection = document.querySelector('.menu-dia-section');
 if (menuSection) {
 const botonContainer = document.createElement('div');
 botonContainer.style.cssText = 'text-align: center; margin: 30px 0; padding: 20px;';

 const boton = document.createElement('button');
 boton.id = 'btnAnadirMenu';
 boton.className = 'btn-anadir-menu';
 boton.innerHTML = 'Añadir Menú <span id="menu-counter" style="display:none; margin-left: 8px; background: white; color: #e74c3c; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold;">0</span>';

 botonContainer.appendChild(boton);
 menuSection.appendChild(botonContainer);

 // Event listener para el botón
 boton.addEventListener('click', function () {
 afegirMenu();
 });
 }
 });

 // Estilos CSS para las tarjetas seleccionadas (añadir a tu CSS)
 const style = document.createElement('style');
 style.textContent = `
 .producto-card.selected {
 border: 3px solid #e74c3c;
 box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
 transform: scale(1.02);
 transition: all 0.3s ease;
 }

 .producto-card {
 transition: all 0.3s ease;
 }

 .producto-card:hover {
 transform: translateY(-5px);
 box-shadow: 0 5px 20px rgba(0,0,0,0.1);
 }

 .btn-anadir-menu {
 background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
 color: white;
 border: none;
 padding: 15px 40px;
 font-size: 18px;
 font-weight: bold;
 border-radius: 50px;
 cursor: pointer;
 box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
 transition: all 0.3s ease;
 display: inline-flex;
 align-items: center;
 gap: 10px;
 }

 .btn-anadir-menu:hover {
 background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
 transform: translateY(-2px);
 box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
 }

 .btn-anadir-menu:active {
 transform: translateY(0);
 }

 #menu-counter {
 background: white !important;
 color: #e74c3c !important;
 display: inline-flex !important;
 }
`;
 document.head.appendChild(style);
</script>

</html>