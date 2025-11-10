</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usuario</title>
</head>

<body>
    <?php
    if ($vista == 'admin') {
        echo "<h1>Vista ADMIN";
    } else if ($vista == 'usuario') {
        echo "<h1>Vista usuari";
    }
    ?>
    <?php
    if (!empty($data["nombre"])) {
        echo "<h1>Perfil de: " . $data["nombre"] . "</h1>";
    }
    ?>

    <?php
    if (!empty($data["id"])) {
        echo '<p data-type="id">' . $data["id"] . '</p>';
    }
    if (!empty($data["nombre"])) {
        echo '<p data-type="nombre">' . $data["nombre"] . '</p>';
    }
    if (!empty($data["apellidos"])) {
        echo '<p data-type="apellidos">' . $data["apellidos"] . '</p>';
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