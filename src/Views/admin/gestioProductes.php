<?php
    $user = $_SESSION['user'] ?? null;
    $isAdmin = $user && isset($user['rol']) && $user['rol'] === 'admin';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestio Productes</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/themeChange.js"></script>
    <script src="/assets/js/carritoDEV.js"></script>
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
                <div id="articles" style="display:flex;gap:1rem;" class="row">
                    <?php
                    foreach ($data as $key => $article) {
                        echo '<div ';
                        echo 'data-id="' . $article["id"] . '" ';
                        echo 'data-file="' . $key . '" ';
                        echo 'class="article card col-12" style="min-height: 7rem;cursor:pointer;">
                                <div class="card-body" style="">
                                <div class="row">
                                <div class="col-4">
                                    <img style="width: 5rem;height: 5rem;object-fit: cover;"src="';
                        echo $article["imagen"] ? $article["imagen"] : "https://placehold.co/90x90";

                        echo '">';
                        echo '</div>';
                        echo '<div class="col-8">';
                        echo '<div class="row"style="display:flex;padding:1rem;">';
                        if (!empty($article["nombre"])) {
                            echo '<span class="col-8" style="padding:0rem 0rem 0rem 1rem;">';
                            echo $article["nombre"];
                            echo '</span>';
                        }

                        if (!empty($article["precio"])) {
                            echo '<span class="col-4" style="text-align:right;padding:0rem;">';
                            echo $article["precio"];
                            echo '</span>';

                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>
                            </div>
                        ';

                        echo '</div>';

                    }


                    //AfegirProductes
                    echo '<div id="btnAfegirProducte" class="article card col-12" style="min-height: 7rem;cursor:pointer;">
                        <div class="card-body" style="">
                            <svg style="display: block;margin:auto;width:5rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                <path d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z"/>
                            </svg>
                        </div>
                    </div>';

                    ?>
                </div>
            </div>
            <div class="col-9">
                <div id="dadesArticle">
                    
                </div>
            </div>


        </div>
    </div>
</body>
<script>
    var inputs;
    function alternarEdiciProductes() {
        var submitBtn = document.getElementById('btnGuardarProducte');

        if (inputs != null) {
            Array.from(inputs).forEach(function (input) {
                input.disabled = !input.disabled;
            });

            if (submitBtn) {
                submitBtn.disabled = !submitBtn.disabled;
            }
        }
    }


    // Evento para editar producto existente
    var data = '<?php echo json_encode($data); ?>';
    data = JSON.parse(data);
    var articles = document.getElementsByClassName('article');
    Array.from(articles).forEach(function (article) {
        article.addEventListener('click', function () {
            var file = this.dataset.file;
            if (data[file]) {
                var articleData = data[file];

                var dadesArticle = document.getElementById('dadesArticle');
                dadesArticle.innerHTML = '';

                var card = document.createElement('div');
                card.className = 'card';

                var cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                var form = document.createElement('form');
                form.setAttribute("action", "/admin/editar-producte");
                form.setAttribute("method", "POST");
                form.setAttribute("enctype", "multipart/form-data");

                function crearInput(inputType, inputClass, inputName, inputValue, inputEstat) {
                    var div = document.createElement('div');
                    var input;

                    if (inputType === 'textarea') {
                        input = document.createElement('textarea');
                        input.textContent = inputValue;
                    } else if (inputType == 'number') {
                        input = document.createElement('input');
                        input.type = inputType;
                        input.value = inputValue;
                        input.setAttribute("step", "0.01");
                    } else {
                        input = document.createElement('input');
                        input.type = inputType;
                        input.value = inputValue;
                    }

                    input.className = inputClass;
                    input.id = inputName;
                    input.name = inputName;
                    input.disabled = !inputEstat;

                    div.className = "col-9";
                    div.appendChild(input);
                    return div;
                }

                function crearLabel(labelText, labelClass, labelName) {
                    var div = document.createElement('div')
                    var label = document.createElement('label');
                    label.className = labelClass;
                    label.name = labelName;
                    label.textContent = labelText;
                    div.className = "col-3";
                    div.appendChild(label)
                    return div;
                }

                // Crear el row principal
                var rowPrincipal = document.createElement('div');
                rowPrincipal.className = 'row';

                // Crear la columna izquierda (col-6)
                var colIzquierda = document.createElement('div');
                colIzquierda.className = 'col-6';

                var divNombre = document.createElement('div');
                divNombre.className = 'row';
                divNombre.id = 'titol-article';
                divNombre.appendChild(crearInput('text', 'form-control articulo-nombre', 'articulo-nombre', articleData.nombre, false))

                var divDescripcio = document.createElement('div');
                divDescripcio.className = 'row';
                divDescripcio.id = '';
                divDescripcio.appendChild(crearLabel('Descripció', 'form-label articulo-descripcion', 'articulo-descripcion'))
                divDescripcio.appendChild(crearInput('textarea', 'form-control articulo-descripcion', 'articulo-descripcion', articleData.descripcion, false))

                var divPrecio = document.createElement('div');
                divPrecio.className = 'row';
                divPrecio.id = '';
                divPrecio.appendChild(crearLabel('Preu', 'form-label articulo-precio', 'articulo-precio'))
                divPrecio.appendChild(crearInput('number', 'form-control articulo-precio', 'articulo-precio', articleData.precio, false))

                var divHorario = document.createElement('div');
                divHorario.className = 'row';
                divHorario.id = '';
                divHorario.appendChild(crearLabel('Horari', 'form-label articulo-precio', 'articulo-horario'))
                divHorario.appendChild(crearInput('text', 'form-control articulo-precio', 'articulo-horario', articleData.horario, false))

                var divCantidad = document.createElement('div');
                divCantidad.className = 'row';
                divCantidad.id = '';
                divCantidad.appendChild(crearLabel('Ració', 'form-label articulo-cantidad', 'articulo-cantidad'))
                divCantidad.appendChild(crearInput('number', 'form-control articulo-cantidad', 'articulo-cantidad', articleData.cantidad, false))

                // Añadir campos ocultos a la columna izquierda
                colIzquierda.appendChild(crearInput('number', 'form-control articulo-id d-none', 'articulo-id', articleData.id, false));
                colIzquierda.appendChild(crearInput('text', 'form-control articulo-file d-none', 'articulo-file', file, false));

                // Añadir todos los campos al col-6 izquierdo
                colIzquierda.appendChild(divNombre);
                colIzquierda.appendChild(divDescripcio);
                colIzquierda.appendChild(divPrecio);
                colIzquierda.appendChild(divHorario);
                colIzquierda.appendChild(divCantidad);

                // Crear la columna derecha (col-6) - con input de imagen
                var colDerecha = document.createElement('div');
                colDerecha.className = 'col-6';

                // Crear contenedor para la imagen
                var divImagen = document.createElement('div');
                divImagen.className = 'mb-3';

                var labelImagen = document.createElement('label');
                labelImagen.className = 'form-label';
                labelImagen.textContent = 'Imatge del producte';
                labelImagen.setAttribute('for', 'articulo-imagen');

                var inputImagen = document.createElement('input');
                inputImagen.type = 'file';
                inputImagen.className = 'form-control';
                inputImagen.id = 'articulo-imagen';
                inputImagen.name = 'articulo-imagen';
                inputImagen.accept = 'image/*';
                inputImagen.disabled = true;

                divImagen.appendChild(labelImagen);
                divImagen.appendChild(inputImagen);

                // Crear elemento img para preview
                var imgPreview = document.createElement('img');
                imgPreview.id = 'preview-imagen';
                imgPreview.className = 'img-fluid mt-3';
                imgPreview.style.maxHeight = '300px';
                imgPreview.style.display = 'none';

                divImagen.appendChild(imgPreview);

                // Mostrar la imagen actual si existe
                if (articleData.imagen) {
                    imgPreview.src = articleData.imagen;
                    imgPreview.style.display = 'block';
                }

                // Event listener para mostrar la imagen cuando se seleccione
                inputImagen.addEventListener('change', function (e) {
                    var file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            imgPreview.src = event.target.result;
                            imgPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });

                colDerecha.appendChild(divImagen);

                // Crear la columna para los botones (col-12)
                var colBotones = document.createElement('div');
                colBotones.className = 'col-12';

                var boton = document.createElement('button');
                boton.textContent = 'Editar';
                boton.className = 'btn btn-primary';
                boton.id = 'btnEditarProducte';
                boton.type = 'button';

                boton.addEventListener('click', function () {
                    alternarEdiciProductes();
                    if (inputs && inputs.length > 0) {
                        boton.textContent = inputs[0].disabled ? 'Editar' : 'Desactivar Edición';
                    }
                });

                var submit = document.createElement('button');
                submit.textContent = 'Guardar';
                submit.className = 'btn btn-primary';
                submit.id = 'btnGuardarProducte';
                submit.type = 'submit';
                submit.disabled = true;

                var cancela = document.createElement('button');
                cancela.textContent = 'Cancela';
                cancela.className = 'btn btn-primary';
                cancela.id = 'btnCancelarEdicio';
                cancela.type = 'button';
                cancela.addEventListener('click', function () {
                    location.reload();
                });

                // Añadir botones al col-12
                colBotones.appendChild(boton);
                colBotones.appendChild(submit);
                colBotones.appendChild(cancela);

                // Montar la estructura
                rowPrincipal.appendChild(colIzquierda);
                rowPrincipal.appendChild(colDerecha);
                rowPrincipal.appendChild(colBotones);

                form.appendChild(rowPrincipal);

                cardBody.appendChild(form);
                card.appendChild(cardBody);
                dadesArticle.appendChild(card);

                inputs = document.getElementsByClassName('form-control');
            } else {
                console.log("AA")
            }



        });
    });


    // Evento para añadir nuevo producto
    document.getElementById('btnAfegirProducte').addEventListener('click', function() {
        var dadesArticle = document.getElementById('dadesArticle');
        dadesArticle.innerHTML = '';

        var card = document.createElement('div');
        card.className = 'card';

        var cardBody = document.createElement('div');
        cardBody.className = 'card-body';

        var form = document.createElement('form');
        form.setAttribute("action", "/admin/afegir-producte");
        form.setAttribute("method", "POST");
        form.setAttribute("enctype", "multipart/form-data");

        function crearInput(inputType, inputClass, inputName, inputValue, inputEstat) {
            var div = document.createElement('div');
            var input;

            if (inputType === 'textarea') {
                input = document.createElement('textarea');
                input.textContent = inputValue;
            } else if (inputType == 'number') {
                input = document.createElement('input');
                input.type = inputType;
                input.value = inputValue;
                input.setAttribute("step", "0.01");
            } else {
                input = document.createElement('input');
                input.type = inputType;
                input.value = inputValue;
            }

            input.className = inputClass;
            input.id = inputName;
            input.name = inputName;
            input.disabled = !inputEstat;
            input.required = true;

            div.className = "col-9";
            div.appendChild(input);
            return div;
        }

        function crearLabel(labelText, labelClass, labelName) {
            var div = document.createElement('div')
            var label = document.createElement('label');
            label.className = labelClass;
            label.name = labelName;
            label.textContent = labelText;
            div.className = "col-3";
            div.appendChild(label)
            return div;
        }

        // Crear el row principal
        var rowPrincipal = document.createElement('div');
        rowPrincipal.className = 'row';

        // Crear la columna izquierda (col-6)
        var colIzquierda = document.createElement('div');
        colIzquierda.className = 'col-6';

        var divNombre = document.createElement('div');
        divNombre.className = 'row';
        divNombre.id = 'titol-article';
        divNombre.appendChild(crearInput('text', 'form-control articulo-nombre', 'articulo-nombre', '', true))

        var divDescripcio = document.createElement('div');
        divDescripcio.className = 'row';
        divDescripcio.appendChild(crearLabel('Descripció', 'form-label articulo-descripcion', 'articulo-descripcion'))
        divDescripcio.appendChild(crearInput('textarea', 'form-control articulo-descripcion', 'articulo-descripcion', '', true))

        var divPrecio = document.createElement('div');
        divPrecio.className = 'row';
        divPrecio.appendChild(crearLabel('Preu', 'form-label articulo-precio', 'articulo-precio'))
        divPrecio.appendChild(crearInput('number', 'form-control articulo-precio', 'articulo-precio', '', true))

        var divHorario = document.createElement('div');
        divHorario.className = 'row';
        divHorario.appendChild(crearLabel('Horari', 'form-label articulo-horario', 'articulo-horario'))
        divHorario.appendChild(crearInput('text', 'form-control articulo-horario', 'articulo-horario', '', true))

        var divCantidad = document.createElement('div');
        divCantidad.className = 'row';
        divCantidad.appendChild(crearLabel('Ració', 'form-label articulo-cantidad', 'articulo-cantidad'))
        divCantidad.appendChild(crearInput('number', 'form-control articulo-cantidad', 'articulo-cantidad', '', true))

        // Añadir todos los campos al col-6 izquierdo
        colIzquierda.appendChild(divNombre);
        colIzquierda.appendChild(divDescripcio);
        colIzquierda.appendChild(divPrecio);
        colIzquierda.appendChild(divHorario);
        colIzquierda.appendChild(divCantidad);

        // Crear la columna derecha (col-6) - con input de imagen
        var colDerecha = document.createElement('div');
        colDerecha.className = 'col-6';

        // Crear contenedor para la imagen
        var divImagen = document.createElement('div');
        divImagen.className = 'mb-3';

        var labelImagen = document.createElement('label');
        labelImagen.className = 'form-label';
        labelImagen.textContent = 'Imatge del producte';
        labelImagen.setAttribute('for', 'articulo-imagen');

        var inputImagen = document.createElement('input');
        inputImagen.type = 'file';
        inputImagen.className = 'form-control';
        inputImagen.id = 'articulo-imagen';
        inputImagen.name = 'articulo-imagen';
        inputImagen.accept = 'image/*';
        inputImagen.disabled = false;
        inputImagen.required = true;

        divImagen.appendChild(labelImagen);
        divImagen.appendChild(inputImagen);

        // Crear elemento img para preview
        var imgPreview = document.createElement('img');
        imgPreview.id = 'preview-imagen';
        imgPreview.className = 'img-fluid mt-3';
        imgPreview.style.maxHeight = '300px';
        imgPreview.style.display = 'none';

        divImagen.appendChild(imgPreview);

        // Event listener para mostrar la imagen cuando se seleccione
        inputImagen.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    imgPreview.src = event.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        colDerecha.appendChild(divImagen);

        // Crear la columna para los botones (col-12)
        var colBotones = document.createElement('div');
        colBotones.className = 'col-12';

        var submit = document.createElement('button');
        submit.textContent = 'Guardar Nuevo Producto';
        submit.className = 'btn btn-primary';
        submit.id = 'btnGuardarProducte';
        submit.type = 'submit';

        var cancela = document.createElement('button');
        cancela.textContent = 'Cancelar';
        cancela.className = 'btn btn-primary';
        cancela.id = 'btnCancelarEdicio';
        cancela.type = 'button';
        cancela.addEventListener('click', function () {
            location.reload();
        });

        // Añadir botones al col-12
        colBotones.appendChild(submit);
        colBotones.appendChild(cancela);

        // Montar la estructura
        rowPrincipal.appendChild(colIzquierda);
        rowPrincipal.appendChild(colDerecha);
        rowPrincipal.appendChild(colBotones);

        form.appendChild(rowPrincipal);
        cardBody.appendChild(form);
        card.appendChild(cardBody);
        dadesArticle.appendChild(card);
    });

</script>
<style>
    #titol-article {
        padding: 1rem;

    }

    #articulo-nombre {
        border: none;
        font-size: 2.5rem;
    }


    .d-none {
        display: none;
    }
</style>



</html>