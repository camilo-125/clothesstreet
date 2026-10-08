<?php
// Conectamos la vista con el controlador para que existan las variables $resultado, $busqueda, etc.
require_once __DIR__ . '/../app/views/user/detalle_producto.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre']); ?> — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detalle-container { display: flex; gap: 40px; max-width: 1000px; margin: 40px auto; padding: 20px; }
        .galeria { flex: 1; }
        .galeria-principal { width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; }
        .info-producto { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        .precio { font-size: 24px; font-weight: bold; }
        .selector select, .selector input { padding: 10px; width: 100%; margin-top: 5px; }
        .btn-comprar { padding: 14px; background: #000; color: #fff; border: none; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; display: block; margin-top: 15px; }
    </style>
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

    <main class="detalle-container">
        <!-- Imagen principal -->
        <div class="galeria">
            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="galeria-principal">
        </div>

        <!-- Información y formulario de compra -->
        <div class="info-producto">
            <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
            <p class="precio">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?> COP</p>
            <p class="descripcion"><?php echo htmlspecialchars($producto['descripcion'] ?? 'Prenda urbana de alta calidad.'); ?></p>

            <form action="procesar_compra_directa.php" method="POST">
                <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">

                <div class="selector">
                    <label><strong>Talla y Color disponible:</strong></label>
                    <select name="id_inventario" required>
                        <option value="">-- Seleccionar opción --</option>
                        <?php foreach ($variantes as $var): ?>
                            <option value="<?php echo $var['id_inventario']; ?>">
                                Talla: <?php echo htmlspecialchars($var['talla']); ?> | Color: <?php echo htmlspecialchars($var['color']); ?> (Disponibles: <?php echo $var['stock_disponible']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="selector">
                    <label><strong>Cantidad:</strong></label>
                    <input type="number" name="cantidad" value="1" min="1" required>
                </div>

                <button type="submit" class="btn-comprar">PROCEDER AL PAGO</button>
            </form>
        </div>
    </main>
</body>
</html>