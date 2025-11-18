<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cantina Tony's</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/assets/js/themeChange.js"></script>
</head>
<body class="login-page">
    <!-- Botón de cambio de tema -->
    <button id="theme-toggle" class="theme-toggle theme-toggle-fixed" aria-label="Cambiar tema">
        <span class="icon-light">☀️</span>
        <span class="icon-dark">🌙</span>
    </button>

    <!-- Contenedor de login -->
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <img src="/assets/media/E.png" alt="Cantina Tony's" class="logo-image">
            <h1 class="login-title">Cantina Tony's</h1>
            <p class="login-subtitle">Bienvenido de vuelta</p>
        </div>

        <!-- Body -->
        <div class="login-body">
            <form id="userForm">
                <div class="form-group">
                    <label for="email" class="form-label">Usuario o Email</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="tu@email.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>

            <div class="login-footer">
                <a href="/registrar" class="login-link">¿No tienes cuenta? Regístrate →</a>
            </div>
        </div>
    </div>

    <div id="respuesta"></div>

    <script>
        // Manejo del formulario
        document.getElementById('userForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/login', {
                method: 'POST',
                body: formData
            })
            .then(r => r.text())
            .then(d => {
                // Aquí puedes manejar la respuesta del servidor
                console.log('Respuesta:', d);
                window.location.href = '/dashboard';
            })
            .catch(err => {
                console.error('Error:', err);
                document.getElementById('respuesta').innerHTML = "Error al iniciar sesión";
            });
        });
    </script>
</body>
</html>