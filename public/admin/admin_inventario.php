<?php
require_once __DIR__ . '/../../app/views/admin/admin_inventario.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario — Admin CLOTHESSTREET</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* La barra superior fija que solicitó el cliente */
        body { margin: 0; padding-top: 60px; } 
        
        .admin-nav-bar { 
            background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; 
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; box-sizing: border-box; 
        }
        
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #000; color: #fff; }
        
        .msg-error { color: #dc3545; font-weight: bold; background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; margin-bottom:15px; }
        .msg-exito { color: #155724; font-weight: bold; background: #d4edda; padding: 10px; border: 1px solid #c3e6cb; margin-bottom:15px; }
    </style>
</head>
<body>

    <header>
        <div class="admin-nav-bar">
            <div><strong>CLOTHESSTREET</strong> | Inventario</div>
            <div>
                <a href="admin_dashboard.php">Volver al Panel</a>
                <a href="productos_desactivados.php">Productos Desactivados</a>
                <a href="admin_pedidos.php">Pedidos</a>
                <a href="logout.php" style="color: #ff4d4d;">(Salir)</a>
            </div>
        </div>
    </header>

    <main class="container">
        
        <?php if (!empty($mensaje)): ?>
            <?php $es_error = strpos($mensaje, 'Error') !== false; ?>
            <div class="<?php echo $es_error ? 'msg-error' : 'msg-exito'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'producto_eliminado'): ?>
            <div class="msg-exito">Producto desactivado con éxito.</div>
        <?php endif; ?>

        <h2>PRODUCTOS EN INVENTARIO</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Género</th>
                    <th>Precio</th>
                    <th>Stock Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prod = mysqli_fetch_assoc($res_productos)): ?>
                    <tr>
                        <td>#<?php echo $prod['id_producto']; ?></td>
                        <td><img src="../<?php echo htmlspecialchars($prod['imagen']); ?>" style="width: 40px; height: 40px; object-fit: cover;"></td>
                        <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($prod['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($prod['genero']); ?></td>
                        <td>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?></td>
                        <td><strong><?php echo $prod['stock_total']; ?></strong> unids.</td>
                        <td>
                            <!-- Este enlace ahora lleva a la nueva página de creación -->
                            <a href="admin_crear_producto.php" style="font-weight: bold; color: #4CAF50;">Crear Nuevo</a> | 
                            <a href="admin_editar_producto.php?id=<?php echo $prod['id_producto']; ?>" style="font-weight: bold; color: #000;">Editar</a> | 
                            <a href="admin_inventario.php?eliminar_id=<?php echo $prod['id_producto']; ?>" onclick="return confirm('¿Desactivar este producto?');" style="color: red;">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>