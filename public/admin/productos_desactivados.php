<?php
// 1. Conectamos con la lógica de registro que está en la carpeta app/
require_once __DIR__ . '/../../app/views/admin/productos_desactivados.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Desactivados — Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container-admin { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #333; color: #fff; }
        .btn-rec { padding: 6px 12px; background: #28a745; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .msg-exito { color: green; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <header class="header-items">
        <div class="logo">CLOTHES<span>STREET</span> — PAPELERA</div>
        <nav class="nav-items">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_inventario.php">Volver al Inventario</a></li>
            </ul>
        </nav>
    </header>

    <main class="container-admin">
        <h2>PRODUCTOS DESACTIVADOS</h2>
        <p style="color: #666;">Aquí se encuentran los productos que fueron ocultados del catálogo. Puedes reactivarlos en cualquier momento.</p>

        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'reactivado'): ?>
            <p class="msg-exito">¡Producto reactivado correctamente! Ya está disponible en la tienda.</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($res_inactivos && mysqli_num_rows($res_inactivos) > 0): ?>
                    <?php while ($prod = mysqli_fetch_assoc($res_inactivos)): ?>
                        <tr style="background: #fdfdfd; color: #555;">
                            <td><?php echo $prod['id_producto']; ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($prod['imagen']); ?>" width="45" height="45" style="object-fit:cover; filter: grayscale(80%);">
                            </td>
                            <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($prod['categoria']); ?></td>
                            <td>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?></td>
                            <td><?php echo $prod['stock_total']; ?></td>
                            <td>
                                <a href="productos_desactivados.php?reactivar_id=<?php echo $prod['id_producto']; ?>" 
                                   onclick="return confirm('¿Quieres volver a mostrar este producto en la tienda?')" 
                                   class="btn-rec">🔄 Reactivar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="padding: 20px; color: #888;">No hay productos desactivados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>