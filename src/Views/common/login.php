<?php
?>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usuario</title>
</head>

<body>

    <form id="userForm">
        <input type="text" name="email" placeholder="Email">
        <!-- <input type="email" name="email" placeholder="Email"> -->
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Guardar</button>
    </form>

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
                    document.getElementById('respuesta').innerHTML = d;
                })
                .catch(err => {
                    document.getElementById('respuesta').innerHTML = "Error: " + err;
                });
        });
    </script>

</body>

</html>