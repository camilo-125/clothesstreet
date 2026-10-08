<?php
// Conectamos la vista con el controlador para que existan las variables $resultado, $busqueda, etc.
require_once __DIR__ . '/../app/controllers/editar_item_carrito.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detalle-container { display: flex; gap: 40px; max-width: 900px; margin: 40px auto; padding: 20px; }
        .galeria-principal { width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; }
        .info-producto { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        .precio { font-size: 24px; font-weight: bold; }
        .selector select, .selector input { padding: 10px; width: 100%; margin-top: 5px; box-sizing: border-box; }
        .btn-guardar { padding: 14px; background: #000; color: #fff; border: none; font-weight: bold; cursor: pointer; margin-top: 15px; width: 100%; }
        .btn-cancelar { display: block; text-align: center; margin-top: 10px; color: #666; text-decoration: none; font-size: 14px; }
        .error-msg { color: red; font-weight: bold; background: #ffe6e6; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <header class="header-items">
        <div class="logo">CLOTHES<span>STREET</span></div>
        <nav class="nav-items">
            <ul><li><a href="carrito.php">Volver al carrito</a></li></ul>
        </nav>
    </header>

    <main class="detalle-container">
        <div class="galeria" style="flex: 1;">
            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" class="galeria-principal">
        </div>

        <div class="info-producto">
            <h2>EDITAR: <?php echo htmlspecialchars($item['nombre']); ?></h2>
            <p class="precio">$<?php echo number_format($item['precio'], 0, ',', '.'); ?> COP</p>

            <?php if (!empty($error_mensaje)): ?>
                <div class="error-msg"><?php echo $error_mensaje; ?></div>
            <?php endif; ?>

            <form action="editar_item_carrito.php" method="POST">
                <input type="hidden" name="id_item_carrito" value="<?php echo $item['id_item_carrito']; ?>">

                <div class="selector">
                    <label><strong>Seleccionar Talla y Color:</strong></label>
                    <select name="id_inventario" id="select_inventario" required onchange="actualizarMaximoStock(this)">
                        <?php foreach ($variantes as $var): ?>
                            <option value="<?php echo $var['id_inventario']; ?>" 
                                    data-stock="<?php echo $var['stock_disponible']; ?>"
                                    <?php echo ($var['id_inventario'] == $item['id_inventario']) ? 'selected' : ''; ?>>
                                Talla: <?php echo htmlspecialchars($var['talla']); ?> | Color: <?php echo htmlspecialchars($var['color']); ?> (Disponibles: <?php echo $var['stock_disponible']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="selector">
                    <label><strong>Cantidad:</strong></label>
                    <input type="number" id="input_cantidad" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="<?php echo $item['stock_disponible']; ?>" required>
                </div>

                <button type="submit" class="btn-guardar">ACEPTAR Y GUARDAR CAMBIOS</button>
                <a href="carrito.php" class="btn-cancelar">Cancelar</a>
            </form>
        </div>
    </main>

    <script>
        // Actualiza el atributo max del input dinámicamente cuando el usuario cambia la variante
        function actualizarMaximoStock(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const inputCantidad = document.getElementById('input_cantidad');
            
            inputCantidad.max = stock;
            if (parseInt(inputCantidad.value) > parseInt(stock)) {
                inputCantidad.value = stock;
            }
        }
    </script>
</body>
</html>