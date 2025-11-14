<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usuario</title>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>

    <form id="userForm" action="/login" method="POST">
        <input type="text" name="email" placeholder="Email">
        <!-- <input type="email" name="email" placeholder="Email"> -->
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Guardar</button>
    </form>
    <div class="row">
        <div class="col-6">1</div>
        <div class="col-6">2</div>
    </div>
    <div class="card">
        <div class="card-body">
            This is some text within a card body.
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