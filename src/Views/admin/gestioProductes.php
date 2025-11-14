<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestio Productes</title>
    <link rel="stylesheet" href="/css/main.css">

</head>

<body>
    <div class="content">
        <div class="row">
            <div class="col-3">
                <div id="articles" style="display:flex;gap:1rem;" class="row">
                    <?php
                    foreach ($data as $key => $article) {
                        echo '<div ';
                        echo 'data-id="' . $article["id"] . '" ';
                        echo 'data-file="' . $key . '" ';
                        echo 'class="article card col-12" style="min-height: 7rem;padding:1rem;cursor:pointer;">
                                <div class="card-body" style="padding:0;display:flex;">
                                <div style="">
                                    <img style="width: 100%;height: auto;"src="';
                        echo "https://placehold.co/90x90";
                        echo '">';

                        echo '</div>';
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
                        echo '</div>
                            </div>
                        ';

                        echo '</div>';

                    }
                    ?>
                </div>
            </div>
            <div class="col-9">
                <div id="dadesArticle">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            echo '<pre>';
                            var_dump($data);
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
    </div>
</body>
<script>
    var inputs;
    function alternarEdiciProductes() {
        if (inputs != null) {
            Array.from(inputs).forEach(function (input) {
                input.disabled = !input.disabled;
            });
        }
    }


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

                function crearInput(inputType, inputClass, inputName, inputValue, inputEstat) {
                    var input = document.createElement('input');
                    input.type = inputType;
                    input.className = inputClass;
                    input.id = inputName;
                    input.name = inputName;
                    input.value = inputValue;
                    input.disabled = !inputEstat;
                    return input;
                }

                function crearLabel(labelText, labelClass, labelName) {
                    var label = document.createElement('label');
                    label.className = labelClass;
                    label.name = labelName;
                    label.textContent = labelText;
                    return label;
                }
                var div;
                var input;
                var label;
                var divNombre = document.createElement('div');
                divNombre.className = '';
                divNombre.id = 'titol-article';
                // div.nombre.appendChild(crearLabel())
                divNombre.appendChild(crearInput('text', 'form-control articulo-nombre', 'articulo-nombre', articleData.nombre, false))
                // var input = document.createElement('input');
                // divNombre.appendChild(input);

                // input.type = 'text';
                // input.className = 'form-control';
                // input.id = 'nombre';
                // input.name = 'nombre';
                // input.value = articleData.nombre;
                // input.disabled = true;





                var boton = document.createElement('button');
                boton.textContent = 'Editar';
                boton.className = 'btn btn-primary'; // Puedes cambiar la clase según tu framework CSS
                boton.id = 'btnEditarProducte';

                // Añadir el evento click
                boton.addEventListener('click', function () {
                    alternarEdiciProductes();
                    // Opcional: cambiar el texto del botón según el estado
                    if (inputs && inputs.length > 0) {
                        boton.textContent = inputs[0].disabled ? 'Editar' : 'Desactivar Edición';
                    }
                });
                // div.appendChild(label);
                // divNombre.appendChild(input);
                cardBody.appendChild(divNombre);
                // cardBody.appendChild(createInputGroup('ID', articleData.id));
                // cardBody.appendChild(createInputGroup('Nombre', articleData.nombre));
                // cardBody.appendChild(createInputGroup('Descripción', articleData.descripcion));
                // cardBody.appendChild(createInputGroup('Precio', articleData.precio));
                // cardBody.appendChild(createInputGroup('Horario', articleData.horario));
                // cardBody.appendChild(createInputGroup('Cantidad', articleData.cantidad));
                // cardBody.appendChild(createInputGroup('Imagen', articleData.imagen));
                cardBody.appendChild(boton);
                card.appendChild(cardBody);
                dadesArticle.appendChild(card);



                inputs = document.getElementsByClassName('form-control');

            }

        });
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
</style>



</html>