<?php
// Conectamos la vista con el controlador para que existan las variables $resultado, $busqueda, etc.
require_once __DIR__ . '/../app/views/user/catalogo.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .catalogo-container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .catalogo-header { text-align: center; margin-bottom: 30px; }
        .grid-productos { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px; }
        .productos-card { border: 1px solid #eee; border-radius: 8px; padding: 15px; text-align: center; transition: box-shadow 0.3s ease; }
        .productos-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .productos-card img { width: 100%; height: 260px; object-fit: cover; border-radius: 4px; }
        .productos-card h2 { font-size: 16px; margin: 12px 0 6px; }
        .productos-card p { font-weight: bold; font-size: 15px; margin-bottom: 12px; }
        .acciones-card { display: flex; gap: 8px; justify-content: center; }
        .acciones-card button { padding: 8px 12px; border: 1px solid #000; background: #none; cursor: pointer; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <header class="header-items">
        <div class="logo">CLOTHES<span>STREET</span></div>
        
        <nav class="nav-items">
            <ul class="main-nav">
                <li><a href="catalogo.php">Ver Todo</a></li>
                <!-- MEGA MENÚ MEN'S -->
                <li class="has-megamenu">
                    <a href="catalogo.php?genero=Hombre" class="nav-link">Men's ▾</a>
                    <div class="megamenu">
                        <div class="megamenu-column">
                            <h4>PARTES SUPERIORES</h4>
                            <a href="catalogo.php?genero=Hombre&categoria=Camisetas">Camisetas / Tees</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Hoodies">Hoodies & Busos</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Chaquetas">Chaquetas</a>
                        </div>
                        <div class="megamenu-column">
                            <h4>PARTES INFERIORES</h4>
                            <a href="catalogo.php?genero=Hombre&categoria=Pantalones">Pantalones & Cargos</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Bermudas">Bermudas / Shorts</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Sweatpants">Sweatpants</a>
                        </div>
                        <div class="megamenu-column">
                            <h4>ACCESORIOS</h4>
                            <a href="catalogo.php?genero=Hombre&categoria=Accesorios">Gorras & Caps</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Medias">Medias & Socks</a>
                            <a href="catalogo.php?genero=Hombre&categoria=Bolsos">Bolsos & Chest Rigs</a>
                        </div>
                    </div>
                </li>

                <!-- MEGA MENÚ WOMEN'S -->
                <li class="has-megamenu">
                    <a href="catalogo.php?genero=Mujer" class="nav-link">Women's ▾</a>
                    <div class="megamenu">
                        <div class="megamenu-column">
                            <h4>TOPS & CAMISETAS</h4>
                            <a href="catalogo.php?genero=Mujer&categoria=Camisetas">Camisetas Oversize</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Tops">Crop Tops</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Hoodies">Hoodies & Sweaters</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Chaquetas">Chaquetas</a>
                        </div>
                        <div class="megamenu-column">
                            <h4>BOTTOMS</h4>
                            <a href="catalogo.php?genero=Mujer&categoria=Pantalones">Pantalones Cargo</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Faldas">Faldas</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Shorts">Shorts</a>
                        </div>
                        <div class="megamenu-column">
                            <h4>ACCESORIOS</h4>
                            <a href="catalogo.php?genero=Mujer&categoria=Accesorios">Gorras & Boinas</a>
                            <a href="catalogo.php?genero=Mujer&categoria=Bolsos">Bolsos & Shoulder Bags</a>
                        </div>
                    </div>
                </li>
                <li><a href="catalogo.php?categoria=Accesorios">Accesorios</a></li>
            </ul>
        </nav>

        <form action="catalogo.php" method="GET" class="lupa">
            <input type="text" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar...">
            <button type="submit">🔍</button>
        </form>

        <div class="cuenta">
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <span class="user">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                <a href="logout.php" style="font-size: 12px; color: red;">(Salir)</a>
            <?php else: ?>
                <a href="login.php" class="user">Log in</a>
            <?php endif; ?>

            <a href="favoritos.php" style="text-decoration: none;">
                <button type="button" style="background: none; border: 1px solid #000; padding: 6px 12px; border-radius: 20px; font-weight: bold; cursor: pointer;">♡ Favoritos</button>
            </a>
            <a href="carrito.php"><button class="cart">🛒 <span class="cart-contador">0</span></button></a>
        </div>
    </header>

    <main class="catalogo-container">
        <div class="catalogo-header">
            <h2>
                <?php 
                if (!empty($busqueda)) {
                    echo "RESULTADOS PARA: \"" . htmlspecialchars($busqueda) . "\"";
                } elseif (!empty($genero_filtro) && !empty($categoria_filtro)) {
                    echo strtoupper(htmlspecialchars($genero_filtro)) . " — " . strtoupper(htmlspecialchars($categoria_filtro));
                } elseif (!empty($genero_filtro)) {
                    echo "COLECCIÓN " . strtoupper(htmlspecialchars($genero_filtro));
                } elseif (!empty($categoria_filtro)) {
                    echo "CATEGORÍA " . strtoupper(htmlspecialchars($categoria_filtro));
                } else {
                    echo "TODOS LOS PRODUCTOS";
                }
                ?>
            </h2>
        </div>

        <section class="grid-productos">
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($prod = mysqli_fetch_assoc($resultado)): ?>
                    <article class="productos-card">
                        <a href="detalle_producto.php?id=<?php echo $prod['id_producto']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                            <h2><?php echo htmlspecialchars($prod['nombre']); ?></h2>
                        </a>
                        <p>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?> COP</p>

                        <div class="acciones-card">
                            <button class="agre-favorito" data-id="<?php echo $prod['id_producto']; ?>">
                                <span>♡</span> Favorito
                            </button>
                            <a href="detalle_producto.php?id=<?php echo $prod['id_producto']; ?>">
                                <button style="background: #000; color: #fff;">Ver Detalle</button>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; margin: 40px 0;">No se encontraron productos para los filtros seleccionados.</p>
            <?php endif; ?>
        </section>
    </main>

    <script src="js/main.js"></script>
</body>
</html>
/**
 * Controlador de Procesamiento de Compras Directas
 *
 * Este script maneja la lógica central de transacciones del e-commerce.
 * Recibe peticiones POST, verifica la seguridad (CSRF), valida la 
 * disponibilidad del inventario y registra el pedido finalizando la compra.
 * Implementa control de excepciones (Try/Catch) según IEEE 730.
 *
 * @package    ClothesStreet
 * @subpackage Controllers
 * @author     [Tu Nombre o "Equipo de Desarrollo"]
 * @version    1.1.0
 * @since      2026-10-08
 *
 * @uses       $_SESSION Para validar autenticación de usuario y tokens CSRF.
 * @uses       $_POST Para recuperar datos del carrito o compra directa.
 * @throws     Exception Si ocurre un error crítico de base de datos durante la transacción.
 */