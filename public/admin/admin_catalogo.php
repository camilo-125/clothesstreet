<?php
require_once __DIR__ . '/../../app/views/admin/admin_catalogo.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Admin — CLOTHESSTREET</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .catalogo-container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .search-box { text-align: center; margin-bottom: 30px; }
        .search-box input { padding: 10px; width: 300px; border: 1px solid #000; }
        .search-box button { padding: 10px 15px; background: #000; color: #fff; border: none; cursor: pointer; font-weight: bold; }
        .grid-productos { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .productos-card { border: 1px solid #eee; padding: 15px; text-align: center; }
        .productos-card img { width: 100%; height: 200px; object-fit: cover; }
        .productos-card h2 { font-size: 15px; margin: 10px 0 5px; }
    </style>
</head>
<body>
    <div class="admin-nav-bar">
        <div><strong>CLOTHESSTREET</strong> | Catálogo Admin</div>
        <div>
            <a href="admin_dashboard.php">Volver al Panel</a>
            <a href="../logout.php" style="color: #ff4d4d;">(Salir)</a>
        </div>
    </div>

    <main class="catalogo-container">
        <!-- BUSCADOR SIMPLE (SIN MEGA MENÚS NI FILTROS DE CATEGORÍA) -->
        <div class="search-box">
            <form action="admin_catalogo.php" method="GET">
                <input type="text" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar en el catálogo...">
                <button type="submit">🔍 BUSCAR</button>
            </form>
        </div>

        <section class="grid-productos">
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($prod = mysqli_fetch_assoc($resultado)): ?>
                    <article class="productos-card">
                        <img src="../<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                        <h2><?php echo htmlspecialchars($prod['nombre']); ?></h2>
                        <p><strong>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?> COP</strong></p>
                        <a href="admin_editar_producto.php?id=<?php echo $prod['id_producto']; ?>" style="display: block; margin-top: 10px; color: #000; font-weight: bold;">Editar Producto</a>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center;">No se encontraron coincidencia de productos.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>