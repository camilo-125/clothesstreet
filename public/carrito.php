<?php
// Conectamos la vista con el controlador para que existan las variables $resultado, $busqueda, etc.
require_once __DIR__ . '/../app/views/user/carrito.php'; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header-items">
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CLOTHES<span>STREET</span></a>

    </div>
    

        
        <nav class="nav-items">
            <ul>
                <li><a href="javascript:history.back()" style="cursor: pointer; color: #ff3366; font-weight: bold;"> Volver</a></li>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
            </ul>
        </nav>
        <div class="cuenta">
            <span class="user">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
            <a href="logout.php" style="font-size: 12px; margin-left: 5px; color: red;">(Salir)</a>
        </div>
    </header>

    <main style="max-width: 950px; margin: 40px auto; padding: 20px;">
        <h2>TU CARRITO DE COMPRAS</h2>

        <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid #000; text-align: left;">
                        <th style="padding: 10px;">Producto</th>
                        <th style="padding: 10px;">Talla/Color</th>
                        <th style="padding: 10px;">Precio</th>
                        <th style="padding: 10px;">Cantidad</th>
                        <th style="padding: 10px;">Subtotal</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($resultado)): 
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total_general += $subtotal;
                    ?>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 10px; display: flex; align-items: center; gap: 10px;">
                                <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                <span><?php echo htmlspecialchars($item['nombre']); ?></span>
                            </td>
                            <td style="padding: 10px;">
                                <?php echo htmlspecialchars($item['talla']); ?> / <?php echo htmlspecialchars($item['color']); ?>
                            </td>
                            <td style="padding: 10px;">$<?php echo number_format($item['precio'], 0, ',', '.'); ?> COP</td>
                            <td style="padding: 10px;"><?php echo $item['cantidad']; ?></td>
                            <td style="padding: 10px;">$<?php echo number_format($subtotal, 0, ',', '.'); ?> COP</td>
                            <td style="padding: 10px;">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <!-- Botón Editar (Lleva a la vista estilo detalle_producto) -->
                                    <a href="editar_item_carrito.php?id=<?php echo $item['id_item_carrito']; ?>" 
                                       style="color: #000; font-weight: bold; text-decoration: underline;">
                                       Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="carrito.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="eliminar_id" value="<?php echo $item['id_item_carrito']; ?>">
                                        <button type="submit" style="background: none; border: none; color: red; cursor: pointer;">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

<!-- REEMPLAZAR ESTO EN CARRITO.PHP -->
<div style="margin-top: 30px; text-align: right;">
    <h3>Total a Pagar: <span style="color: #000;">$<?php echo number_format($total_general, 0, ',', '.'); ?> COP</span></h3>
    
    <!-- Formulario para enviar los items del carrito a procesar -->
    <form action="procesar_compra_directa.php" method="POST" style="margin-top: 15px;">
        <input type="hidden" name="origen" value="carrito">
        <button type="submit" style="padding: 12px 25px; background: #000; color: #fff; border: none; font-weight: bold; cursor: pointer; font-size: 16px;">
            PROCEDER AL PAGO
        </button>
    </form>
</div>

        <?php else: ?>
            <p style="margin-top: 20px;">Tu carrito está vacío.</p>
            <a href="index.php" style="display: inline-block; margin-top: 10px; color: #000; font-weight: bold;">Explorar productos</a>
        <?php endif; ?>
    </main>
</body>
</html>