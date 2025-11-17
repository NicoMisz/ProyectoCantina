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
</head>
<div class="nav"></div>

<body>
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