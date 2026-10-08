<?php
require_once __DIR__ . '/../../app/Middleware/admin_middleware.php';
require_once __DIR__ . '/../../app/config/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control — CLOTHESSTREET Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 14px; }
        .admin-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 30px; }
        .admin-card { border: 1px solid #000; padding: 25px; text-align: center; text-decoration: none; color: #000; transition: background 0.2s; }
        .admin-card:hover { background: #f4f4f4; }
        .admin-card h3 { margin-bottom: 10px; font-size: 18px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="admin-nav-bar">
        <div><strong>CLOTHESSTREET</strong> | Panel de Administración</div>
        <div>
            <span>Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
            <a href="../logout.php" style="color: #ff4d4d; margin-left: 15px;">(Cerrar Sesión)</a>
        </div>
    </div>

    <main class="admin-container">
        <h2>GESTIÓN DEL SISTEMA</h2>
        <div class="admin-grid">
            <a href="admin_inventario.php" class="admin-card">
                <h3>Gestión de Inventario</h3>
                <p>Crear, editar, consultar y eliminar productos y sus variantes.</p>
            </a>
            <a href="admin_pedidos.php" class="admin-card">
                <h3>Gestión de Pedidos</h3>
                <p>Ver pedidos y actualizar estados de entrega.</p>
            </a>
            <a href="admin_catalogo.php" class="admin-card">
                <h3>Catálogo Admin</h3>
                <p>Visualización directa del catálogo general con buscador simple.</p>
            </a>
        </div>
    </main>
</body>
</html>