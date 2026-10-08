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
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .form-crear { background: #f9f9f9; border: 1px solid #000; padding: 20px; margin-bottom: 40px; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .field { display: flex; flex-direction: column; }
        .field label { font-size: 12px; font-weight: bold; margin-bottom: 4px; }
        .field input, .field select, .field textarea { padding: 8px; border: 1px solid #ccc; }
        .btn-submit { background: #000; color: #fff; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer; margin-top: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #000; color: #fff; }
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
        <h2>CREAR NUEVO PRODUCTO</h2>
        <?php if (!empty($mensaje)): ?>
            <p style="color: green; font-weight: bold;"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form action="admin_inventario.php" method="POST" class="form-crear">
            <input type="hidden" name="crear_producto" value="1">
            <div class="form-grid">
                <div class="field">
                    <label>Nombre del Producto</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="field">
                    <label>Categoría</label>
                    <input type="text" name="categoria" placeholder="Ej. Camisetas, Hoodies" required>
                </div>
                <div class="field">
                    <label>Género</label>
                    <select name="genero" required>
                        <option value="Unisex">Unisex</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                    </select>
                </div>
                <div class="field">
                    <label>Precio (COP)</label>
                    <input type="number" name="precio" step="0.01" required>
                </div>
                <div class="field">
                    <label>Ruta de la Imagen</label>
                    <input type="text" name="imagen" value="img/default.jpg" required>
                </div>
                <div class="field">
                    <label>Talla Inicial</label>
                    <input type="text" name="talla" placeholder="Ej. L, M, UNIQUE" required>
                </div>
                <div class="field">
                    <label>Color Inicial</label>
                    <input type="text" name="color" placeholder="Ej. Negro" required>
                </div>
                <div class="field">
                    <label>Stock Inicial</label>
                    <input type="number" name="stock" min="1" required>
                </div>
            </div>
            <div class="field" style="margin-top: 10px;">
                <label>Descripción</label>
                <textarea name="descripcion" rows="2"></textarea>
            </div>
            <button type="submit" class="btn-submit">GUARDAR PRODUCTO</button>
        </form>

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