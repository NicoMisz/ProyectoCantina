<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Cantina Tony's</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/assets/js/themeChange.js"></script>
</head>

<body class="login-page">
    <!-- Botón de cambio de tema -->
    <button id="theme-toggle" class="theme-toggle theme-toggle-fixed" aria-label="Cambiar tema">
        <span class="icon-light">☀️</span>
        <span class="icon-dark">🌙</span>
    </button>

    <!-- Contenedor de registro -->
    <div class="login-container register-container">
        <!-- Header -->
        <div class="login-header">
            <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
            <h1 class="login-title">Cantina Tony's</h1>
            <p class="login-subtitle">Crea tu cuenta</p>
        </div>

        <!-- Body -->
        <div class="login-body">
            <form id="userForm">
                <input type="hidden" name="id" value="0">

                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" placeholder="Tu nombre" required>
                </div>

                <div class="form-group">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-input" placeholder="Tus apellidos"
                        required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="tu@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••"
                        required>
                </div>

                <div class="form-group">
                    <label for="password_comprovacio" class="form-label">Repetir Contraseña</label>
                    <input type="password" id="password_comprovacio" name="password_comprovacio" class="form-input"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login">Crear Cuenta</button>
            </form>

            <div class="login-footer">
                <a href="/login" class="login-link">← Ya tengo cuenta, iniciar sesión</a>
            </div>
        </div>
    </div>

    <div id="respuesta"></div>

    <script>
        document.getElementById('userForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const password = formData.get('password');
            const passwordConfirm = formData.get('password_comprovacio');

            // Validar que las contraseñas coincidan
            if (password !== passwordConfirm) {
                document.getElementById('respuesta').innerHTML =
                    '<div class="alert alert-error">Las contraseñas no coinciden</div>';
                return;
            }

            fetch('/registrar', {
                method: 'POST',
                body: formData
            })
                .then(r => r.text())
                .then(d => {
                    // document.getElementById('respuesta').innerHTML = d;
                    window.location.href = '/login';
                })
                .catch(err => {
                    // document.getElementById('respuesta').innerHTML = 
                    //     '<div class="alert alert-error">Error: ' + err + '</div>';
                });
        });
    </script>
</body>
</htm