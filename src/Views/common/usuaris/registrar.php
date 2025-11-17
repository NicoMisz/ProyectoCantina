<?php
?>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrar Usuario</title>
</head>

<body>

    <form id="userForm">
        <input type="hidden" name="id" value="0">

        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="apellidos" placeholder="Apellidos">
        <input type="text" name="email" placeholder="Email">
        <!-- <input type="email" name="email" placeholder="Email"> -->
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_comprovacio" placeholder="Repeteix la Coontrasenya">
        <button type="submit">Guardar</button>
    </form>

    <div id="respuesta"></div>

    <script>
        document.getElementById('userForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/registrar', {
                method: 'POST',
                body: formData
            })
                .then(r => r.text())
                .then(d => {
                    document.getElementById('respuesta').innerHTML = d;
                })
                .catch(err => {
                    document.getElementById('respuesta').innerHTML = "Error: " + err;
                });
        });
    </script>

</body>

</html>