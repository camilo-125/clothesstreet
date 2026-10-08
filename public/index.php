<?php
session_start();
require_once __DIR__ . '/../app/config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>clothesstreet</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <div id="toast-container" class="toast-container"></div>

    <!-- ARCHIVO JAVASCRIPT CON ANTI-CACHÉ -->
    <script src="js/main.js?v=2"></script>
</head>
<body>
    <div class="ticker">    
        <div class="ticker-track">      
            <span><span class="dot">●</span> Nuevo drop — colección "medianoche" disponible ahora</span>      
            <span><span class="dot">●</span> Envíos a toda Colombia</span>      
            <span><span class="dot">●</span> Edición limitada — quedan 12 unidades</span>      
            <span><span class="dot">●</span> Nuevo drop — colección "medianoche" disponible ahora</span>      
            <span><span class="dot">●</span> Envíos a toda Colombia</span>      
            <span><span class="dot">●</span> Edición limitada — quedan 12 unidades</span>    
        </div>  
    </div>

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
        <li><a href="nosotros.php">Nosotros</a></li>
    </ul>
</nav>

        <div class="lupa">
            <input type="text" placeholder="Buscar productos...">
            <button type="submit">🔍</button>
        </div>
        
        <div class="cuenta">
            <?php if (isset($_SESSION['id_usuario'])): ?>
            <span class="user">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
            <a href="logout.php" style="font-size: 12px; margin-left: 5px; color: red;">(Salir)</a>
            <?php else: ?>
            <a href="login.php" class="user">Log in</a>
            <?php endif; ?>

            <a href="favoritos.php" style="text-decoration: none; color: inherit; margin-right: 8px;">
            <button type="button" style="background: none; border: 1px solid #000; padding: 6px 12px; border-radius: 20px; font-weight: bold; cursor: pointer; font-size: 13px;">
                ♡ Favoritos
            </button>
            </a>

            <a href="carrito.php" style="text-decoration: none; color: inherit;">
                <button class="cart" style="cursor: pointer;">
                    🛒 <span class="cart-contador">0</span>
                </button>
            </a>
        </div>
    </header> 
    
    <main>  
        <section class="principal">
            <div class="camara">CAM 04 — CALLE 5, 11:42 PM</div>
            
            <h1>ROPA QUE<br>SUENA A <span class="cambiar-color">CALLE</span>.</h1>
            <div class="sub-principal">
                <p>Hoodies oversize, camisetas y accesorios de edición limitada. Diseñado para quien vive la cultura urbana, no solo la usa.</p>
                <a href="catalogo.php" class="btn">Ver colección</a>
            </div>
        </section>

<!-- SECCIÓN 1: NUEVOS DROPS (DESDE LA BASE DE DATOS) -->
        <section class="productos">
            <h2>NUEVOS DROPS</h2>
            <div class="grid-productos">
                <?php
                // Consultar los productos en la base de datos
                $query = "SELECT id_producto, nombre, precio, imagen FROM producto WHERE activo = 1 ORDER BY id_producto DESC LIMIT 3";
                $resultado = mysqli_query($conexion, $query);

                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($producto = mysqli_fetch_assoc($resultado)) {
                ?>
                        <article class="productos-card">
                            <!-- ENLACE AL DETALLE DE PRODUCTO (TÍTULO E IMAGEN) -->
                            <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>" style="text-decoration: none; color: inherit;">
                                <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">  
                            </a>
                            
                            <p>$<?php echo number_format($producto['precio'], 0, ',', '.'); ?> COP</p>
                            
                            <button class="agre-favorito" data-id="<?php echo $producto['id_producto']; ?>">
                                <span>♡</span><span>add to favorites</span>
                            </button>
                            <button class="agre-carrito" data-id="<?php echo $producto['id_producto']; ?>">
                                <span>🛒</span><span>add to cart</span>
                            </button>
                        </article>
                <?php
                    }
                } else {
                    echo "<p>No hay productos registrados en la tienda.</p>";
                }
                ?>
            </div>
        </section>

        <section class="mosaico-colecciones">
            <a href="catalogo.php?categoria=Camisetas"> 
                <img src="tarjetas/tarjeta1.jpg" alt="arrow">
                <span>EDICIÓN LIMITADA</span>
                <h2>STREET GRAPHIC TEES</h2>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
            <a href="catalogo.php?categoria=Tops"> 
                <img src="tarjetas/tarjeta2.jpg" alt="arrow">
                <span>TENDENCIA URBANA</span>
                <h2>CROP TOPS</h2>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
            <a href="catalogo.php?categoria=Hoodies"> 
                <img src="tarjetas/tarjeta3.jpg" alt="arrow">
                <span>CORTE HEAVYWEIGHT</span>
                <h2>OVERSIZED HOODIES</h2>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
            <a href="catalogo.php?categoria=Accesorios"> 
                <img src="tarjetas/tarjeta4.jpg" alt="arrow">
                <span>EDICIÓN LIMITADA</span>
                <h2>CAPS & SNAPBACKS</h2>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
        </section>

        <!-- SECCIÓN 2: DESTACADOS / MÁS VENDIDOS (DESDE LA BASE DE DATOS) -->
        <section class="productos2">
            <?php
            // Volvemos a ejecutar la consulta para llenar la segunda sección
            mysqli_data_seek($resultado, 0); // Reiniciar el puntero del resultado

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($producto = mysqli_fetch_assoc($resultado)) {
            ?>
                    <article class="prodctos2-card">
                        <!-- ENLACE AL DETALLE DE PRODUCTO (TÍTULO E IMAGEN) -->
                        <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>" style="text-decoration: none; color: inherit;">
                            <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">  
                        </a>
                        
                        <p>$<?php echo number_format($producto['precio'], 0, ',', '.'); ?> COP</p>
                        
                        <button class="agre-favorito" data-id="<?php echo $producto['id_producto']; ?>">
                            <span>♡</span><span>add to favorites</span>
                        </button>
                        <button class="agre-carrito" data-id="<?php echo $producto['id_producto']; ?>">
                            <span>🛒</span><span>add to cart</span>
                        </button>
                    </article>
            <?php
                }
            }
            ?>
        </section>

        <section class="twocards">
            <a href="catalogo.php?categoria=Shorts">
                <img src="tarjetas/tarjeta5.jpg" alt="arrow">
                <span>SUMMER SHORTS</span>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
            <a href="catalogo.php?categoria=Sweatpants">
                <img src="tarjetas/tarjeta6.jpg" alt="arrow">
                <span>SWEATPANTS</span>
                <span class="btn-comprar">SHOP NOW</span>
            </a>
        </section>
    </main> 

    <!-- FOOTER MINIMALISTA -->
    <footer class="footer-site">
        <div class="footer-contenido">
            <div class="logo-footer">
                CLOTHES<span>STREET</span>
            </div>

            <ul class="footer-links">
                <li><a href="#">Términos</a></li>
                <li><a href="#">Envíos y Cambios</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>

            <div class="footer-copy">
                &copy; 2026 CLOTHESSTREET. All rights reserved.
            </div>
        </div>
    </footer>
    <div id="toast-container" class="toast-container"></div>

    <!-- ARCHIVO JAVASCRIPT -->
    <script src="js/main.js"></script>
</body>
</html>