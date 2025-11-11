<?php
?>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usuario</title>
    <link rel="stylesheet" href="../../../public/css/bootstrap-grid.css">
</head>

<body>

    <form id="userForm">
        <input type="text" name="email" placeholder="Email">
        <!-- <input type="email" name="email" placeholder="Email"> -->
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Guardar</button>
    </form>

    <div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
    <div id="respuesta"></div>

    <script>
        document.getElementById('userForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/login', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.res === 1) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    } else {
                        alert(data.msg);
                    }
                    //     document.getElementById('respuesta').innerHTML = d;

                })
                .catch(err => {
                    // document.getElementById('respuesta').innerHTML = "Error: " + err;
                });
        });
    </script>

</body>

</html>