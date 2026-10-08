<?php
// 1. Conectamos con la lógica de registro que está en la carpeta app/
require_once __DIR__ . '/../app/views/user/registro.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — CLOTHESSTREET</title>
    <!-- La ruta del CSS es correcta -->
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

    <!-- 2. Reutilizamos la misma clase del login para que el formulario quede centrado y ordenado -->
    <main class="login-container">
        <h2>CREAR CUENTA</h2>
        
        <!-- 3. Usamos la clase de error en lugar del style inline -->
        <?php if (!empty($mensaje)): ?>
            <p class="alerta-error"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <!-- 4. Limpiamos todos los inputs y el botón usando las clases de style.css -->
        <form action="registro.php" method="POST" class="form-auth">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div>
                <label>Nombre Completo *</label><br>
                <input type="text" name="nombre" required class="input-auth">
            </div>

            <div>
                <label>Correo Electrónico *</label><br>
                <input type="email" name="correo" required class="input-auth">
            </div>

            <div>
                <label>Contraseña *</label><br>
                <input type="password" name="contrasena" required class="input-auth">
            </div>

            <div>
                <label>Teléfono</label><br>
                <input type="text" name="telefono" class="input-auth">
            </div>

            <div>
                <label>Dirección de Envío</label><br>
                <input type="text" name="direccion" class="input-auth">
            </div>

            <button type="submit" class="btn-auth">REGISTRARME</button>
        </form>

        <p style="margin-top: 15px;">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
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