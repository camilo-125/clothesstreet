<?php
session_start();
require_once __DIR__ . '/../app/config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header-items">
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CLOTHES<span>STREET</span></a>
</div>
        
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

        <form action="catalogo.php" method="GET" class="lupa">
            <input type="text" name="busqueda" placeholder="Buscar...">
            <button type="submit">🔍</button>
        </form>

        <div class="cuenta">
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <span class="user">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                <a href="logout.php">(Salir)</a>
            <?php else: ?>
                <a href="login.php" class="user">Log in</a>
            <?php endif; ?>

            <a href="favoritos.php">
                <button type="button">♡ Favoritos</button>
            </a>
            <a href="carrito.php"><button class="cart">🛒 <span class="cart-contador">0</span></button></a>
        </div>
    </header>

    <main class="about-container">
        <section class="about-hero">
            <h1>Definiendo la Cultura Urbana</h1>
            <p>En CLOTHESSTREET no vendemos simplemente prendas; diseñamos uniformes para quienes caminan la ciudad con actitud, autenticidad y estilo propio.</p>
        </section>

        <section class="about-grid">
            <article class="about-card">
                <h3>Nuestra Esencia</h3>
                <p>Nacimos del movimiento urbano y la necesidad de expresar individualidad a través de siluetas oversize, cortes estructurados y materiales de alta durabilidad.</p>
            </article>

            <article class="about-card">
                <h3>Calidad Heavyweight</h3>
                <p>Seleccionamos textiles de alto gramaje para garantizar durabilidad, volumen y la caída perfecta en cada una de nuestras camisetas, hoodies y pantalones.</p>
            </article>

            <article class="about-card">
                <h3>Diseño Sin Etiquetas</h3>
                <p>Creemos en la moda inclusiva y versátil. Muchas de nuestras prendas clave son desarrolladas bajo un concepto Unisex para adaptarse a cualquier estilo.</p>
            </article>
        </section>

        <section class="about-banner">
            <h2>¿LISTO PARA RENOVAR TU DROP?</h2>
            <p>Explora nuestras colecciones exclusivas para Hombre, Mujer y la línea Unisex.</p>
            <a href="catalogo.php">VER CATÁLOGO COMPLETO</a>
        </section>
    </main>

    <script src="js/main.js"></script>
</body>
</html>