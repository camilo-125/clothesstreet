<?php
// 1. Ejecuta toda la lógica secreta del backend que acabas de crear
require_once __DIR__ . '/../app/views/user/logincontroller.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — CLOTHESSTREET</title>
    <!-- La ruta funciona porque este archivo y la carpeta css están juntos en public/ -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header-items">
        <div class="logo">CLOTHES<span>STREET</span></div>
        <nav class="nav-items">
            <ul>
                <li><a href="index.php">Volver al inicio</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <h2>INICIAR SESIÓN</h2>

        <!-- 2. Muestra el error en pantalla si el controlador (arriba) definió un $mensaje -->
        <?php if (!empty($mensaje)): ?>
            <p class="alerta-error"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <!-- 3. Envía los datos a esta misma página para procesarlos -->
        <form action="login.php" method="POST" class="form-auth">
            
    <!-- INYECCIÓN DEL TOKEN CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <!-- Aquí siguen tus inputs normales de correo y contraseña... -->
            <div>
                <label>Correo Electrónico</label><br>
                <input type="email" name="correo" required class="input-auth">
            </div>
            <div>
                <label>Contraseña</label><br>
                <input type="password" name="contrasena" required class="input-auth">
            </div>
            <button type="submit" class="btn-auth">INGRESAR</button>
        </form>

        <p style="margin-top: 15px;">¿Aún no tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formsAuth = document.querySelectorAll('.form-auth');
            
            formsAuth.forEach(form => {
                form.addEventListener('submit', function() {
                    const btnSubmit = this.querySelector('.btn-auth');
                    
                    if (btnSubmit) {
                        // 1. Deshabilitar el botón para evitar doble clic
                        btnSubmit.disabled = true;
                        
                        // 2. Dar retroalimentación visual al usuario
                        btnSubmit.textContent = 'PROCESANDO...';
                        btnSubmit.style.opacity = '0.7';
                        btnSubmit.style.cursor = 'wait';
                    }
                });
            });
        });
    </script>
</body>
</html>