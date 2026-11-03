<?php
require_once __DIR__ . '/../../app/views/admin/admin_crear_producto.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto — Admin CLOTHESSTREET</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { margin: 0; padding-top: 60px; } 
        
        .admin-nav-bar { 
            background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; 
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; box-sizing: border-box; 
        }
        
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .form-crear { background: #f9f9f9; border: 1px solid #000; padding: 20px; margin-bottom: 40px; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .field { display: flex; flex-direction: column; }
        .field label { font-size: 12px; font-weight: bold; margin-bottom: 4px; }
        .field input, .field select, .field textarea { padding: 8px; border: 1px solid #ccc; }
        
        .field input[type="file"] { padding: 5px; background: #fff; cursor: pointer; }
        
        .btn-submit { background: #000; color: #fff; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer; margin-top: 15px; }
        
        .msg-error { color: #dc3545; font-weight: bold; background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; margin-bottom:15px; }
        .msg-exito { color: #155724; font-weight: bold; background: #d4edda; padding: 10px; border: 1px solid #c3e6cb; margin-bottom:15px; }
    </style>
</head>
<body>

    <header>
        <div class="admin-nav-bar">
            <div><strong>CLOTHESSTREET</strong> | Crear Producto</div>
            <div>
                <a href="admin_inventario.php" style="color: #4CAF50;">Ver Inventario</a>
                <a href="admin_dashboard.php">Volver al Panel</a>
                <a href="productos_desactivados.php">Productos Desactivados</a>
                <a href="admin_pedidos.php">Pedidos</a>
                <a href="logout.php" style="color: #ff4d4d;">(Salir)</a>
            </div>
        </div>
    </header>

    <main class="container">
        <h2>REGISTRAR NUEVO PRODUCTO</h2>
        
        <!-- El $mensaje viene del controlador -->
        <?php if (!empty($mensaje)): ?>
            <?php $es_error = strpos($mensaje, 'Error') !== false; ?>
            <div class="<?php echo $es_error ? 'msg-error' : 'msg-exito'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Importante: el action apunta al controlador en la carpeta public -->
        <form action="admin_crear_producto.php" method="POST" enctype="multipart/form-data" class="form-crear">
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
                    <label>Subir Imagen (Máx 2MB. JPG/PNG/WEBP)</label>
                    <input type="file" name="imagen_file" accept=".jpg, .jpeg, .png, .webp" required>
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
    </main>
</body>
</html>