<?php
require_once __DIR__ . '/../../app/views/admin/admin_editar_producto.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto #<?php echo $id_producto; ?> — Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .field { margin-bottom: 15px; }
        .field label { font-size: 13px; font-weight: bold; display: block; margin-bottom: 4px; }
        .field input, .field select, .field textarea { width: 100%; padding: 8px; border: 1px solid #ccc; box-sizing: border-box; }
        .btn-black { background: #000; color: #fff; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer; }
        .box-variantes { border: 1px solid #ddd; padding: 20px; background: #fafafa; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="admin-nav-bar">
        <div><strong>CLOTHESSTREET</strong> | Editar Producto #<?php echo $id_producto; ?></div>
        <div>
            <a href="admin_inventario.php">Volver al Inventario</a>
        </div>
    </div>

    <main class="container">
        <h2>EDITAR INFORMACIÓN</h2>
        <form action="admin_editar_producto.php?id=<?php echo $id_producto; ?>" method="POST">
            <input type="hidden" name="actualizar_producto" value="1">
            <div class="field">
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="field">
                <label>Categoría</label>
                <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
            </div>
            <div class="field">
                <label>Género</label>
                <select name="genero">
                    <option value="Unisex" <?php echo ($producto['genero'] === 'Unisex') ? 'selected' : ''; ?>>Unisex</option>
                    <option value="Hombre" <?php echo ($producto['genero'] === 'Hombre') ? 'selected' : ''; ?>>Hombre</option>
                    <option value="Mujer" <?php echo ($producto['genero'] === 'Mujer') ? 'selected' : ''; ?>>Mujer</option>
                </select>
            </div>
            <div class="field">
                <label>Precio (COP)</label>
                <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>
            </div>
            <div class="field">
                <label>Ruta Imagen</label>
                <input type="text" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>" required>
            </div>
            <div class="field">
                <label>Descripción</label>
                <textarea name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>

            <h3>STOCK POR VARIANTE (TALLA / COLOR)</h3>
            <?php while ($var = mysqli_fetch_assoc($res_inv)): ?>
                <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 10px;">
                    <span style="min-width: 150px;"><strong><?php echo htmlspecialchars($var['talla']); ?></strong> / <?php echo htmlspecialchars($var['color']); ?>:</span>
                    <input type="number" name="stock_inv[<?php echo $var['id_inventario']; ?>]" value="<?php echo $var['stock_disponible']; ?>" style="width: 100px; padding: 5px;">
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn-black" style="margin-top: 20px;">GUARDAR CAMBIOS</button>
        </form>

        <div class="box-variantes">
            <h3>AGREGAR NUEVA VARIANTE</h3>
            <form action="admin_editar_producto.php?id=<?php echo $id_producto; ?>" method="POST" style="display: flex; gap: 10px; align-items: flex-end;">
                <input type="hidden" name="crear_variante" value="1">
                <div>
                    <label style="font-size: 11px; font-weight: bold;">Talla</label>
                    <input type="text" name="talla" placeholder="Ej. XL" required style="padding: 6px;">
                </div>
                <div>
                    <label style="font-size: 11px; font-weight: bold;">Color</label>
                    <input type="text" name="color" placeholder="Ej. Blanco" required style="padding: 6px;">
                </div>
                <div>
                    <label style="font-size: 11px; font-weight: bold;">Stock</label>
                    <input type="number" name="stock" min="1" required style="padding: 6px; width: 80px;">
                </div>
                <button type="submit" class="btn-black">Añadir Variante</button>
            </form>
        </div>
    </main>
</body>
</html>