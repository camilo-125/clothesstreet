<?php
// Conectamos la vista con el controlador para que existan las variables $resultado, $busqueda, etc.
require_once __DIR__ . '/../app/views/user/favoritos.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .fav-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-top: 20px; }
        .fav-card { border: 1px solid #eee; padding: 15px; border-radius: 8px; text-align: center; }
        .fav-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 4px; }
        .fav-card h3 { font-size: 16px; margin: 10px 0 5px; }
        .fav-card p { font-weight: bold; margin-bottom: 10px; }
        .btn-ver { display: block; background: #000; color: #fff; padding: 8px; text-decoration: none; font-weight: bold; font-size: 13px; margin-bottom: 8px; }
        .btn-quitar { background: none; border: none; color: red; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>
    <header class="header-items">
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CLOTHES<span>STREET</span></a>
</div>
        <nav class="nav-items">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="carrito.php">Carrito</a></li>
            </ul>
        </nav>
        <div class="cuenta">
            <span class="user">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
            <a href="logout.php" style="font-size: 12px; margin-left: 5px; color: red;">(Salir)</a>
        </div>
    </header>

    <main style="max-width: 950px; margin: 40px auto; padding: 20px;">
        <h2>MIS FAVORITOS ♥</h2>

        <?php if ($resultado_fav && mysqli_num_rows($resultado_fav) > 0): ?>
            <div class="fav-grid">
                <?php while ($prod = mysqli_fetch_assoc($resultado_fav)): ?>
                    <div class="fav-card">
                        <img src="<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                        <p>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?> COP</p>
                        
                        <a href="detalle_producto.php?id=<?php echo $prod['id_producto']; ?>" class="btn-ver">VER DETALLE</a>

                        <form action="favoritos.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="eliminar_favorito_id" value="<?php echo $prod['id_favorito']; ?>">
                            <button type="submit" class="btn-quitar">Quitar de favoritos</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="margin-top: 20px;">Aún no has agregado productos a tus favoritos.</p>
            <a href="index.php" style="display: inline-block; margin-top: 10px; color: #000; font-weight: bold;">Explorar la tienda</a>
        <?php endif; ?>
    </main>
</body>
</html>