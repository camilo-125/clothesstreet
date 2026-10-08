<?php
// app/controllers/procesar_compra_directa.php
session_start();
require_once __DIR__ . '/../config/conexion.php';

// 1. Validar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para realizar la compra.'); window.location.href = 'login.php';</script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// 2. Si entran por GET directo, redirigir al catálogo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 3. FASE DE GUARDADO: Confirmación y procesamiento del pago
if (isset($_POST['confirmar_pago'])) {

    $token_sesion = $_SESSION['csrf_token'] ?? 'VACIO';
    $token_post   = $_POST['csrf_token'] ?? 'VACIO';

    // Verificación de seguridad CSRF
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $html_diagnostico = '
        <!DOCTYPE html>
        <html lang="es">
        <head><meta charset="UTF-8"><title>Diagnóstico CSRF</title></head>
        <body style="background:#111; color:#fff; font-family:sans-serif; padding:40px;">
            <h2>Diagnóstico CSRF</h2>
            <p><strong>Token en $_SESSION:</strong> <code>' . htmlspecialchars($token_sesion) . '</code></p>
            <p><strong>Token recibido por $_POST:</strong> <code>' . htmlspecialchars($token_post) . '</code></p>
            <hr>
            <p><a href="index.php" style="color:#00ffff;">Volver al inicio</a></p>
        </body>
        </html>';
        die($html_diagnostico);
    }

    $tipo_origen = $_POST['origen_compra'] ?? 'directa';

    // =====================================================================
    // APLICACIÓN IEEE 730: Bloque Try...Catch para la Fase de Guardado
    // =====================================================================
    try {
        // Obtener dirección del usuario
        $query_usr = "SELECT direccion_envio FROM usuario WHERE id_usuario = $id_usuario";
        $res_usr = mysqli_query($conexion, $query_usr);
        $usr_data = mysqli_fetch_assoc($res_usr);
        $direccion = mysqli_real_escape_string($conexion, $usr_data['direccion_envio'] ?? 'Dirección de entrega');

        // Procesar según el origen
        if ($tipo_origen === 'directa') {
            $id_inventario = intval($_POST['id_inventario'] ?? 0);
            $cantidad = intval($_POST['cantidad'] ?? 1);

            $q_stk = "SELECT p.precio, inv.stock_disponible 
                      FROM inventario inv 
                      INNER JOIN producto p ON inv.id_producto = p.id_producto 
                      WHERE inv.id_inventario = $id_inventario";
            $r_stk = mysqli_query($conexion, $q_stk);
            $item = mysqli_fetch_assoc($r_stk);

            if (!$item || $cantidad > $item['stock_disponible']) {
                echo "<script>alert('Error: La cantidad supera el stock disponible.'); window.location.href='index.php';</script>";
                exit;
            }

            $total = $item['precio'] * $cantidad;

            // Crear pedido
            $query_pedido = "INSERT INTO pedido (fecha_pedido, estado, total, direccion_entrega, id_usuario) VALUES (NOW(), 'pagado', $total, '$direccion', $id_usuario)";
            mysqli_query($conexion, $query_pedido);
            $id_pedido = mysqli_insert_id($conexion);

            mysqli_query($conexion, "INSERT INTO item_pedido (cantidad, precio_unitario, id_pedido, id_inventario) VALUES ($cantidad, {$item['precio']}, $id_pedido, $id_inventario)");
            mysqli_query($conexion, "UPDATE inventario SET stock_disponible = stock_disponible - $cantidad WHERE id_inventario = $id_inventario");

        } else if ($tipo_origen === 'carrito') {
            $q_cart = "SELECT ic.id_inventario, ic.cantidad, p.precio, inv.stock_disponible 
                       FROM carrito c 
                       INNER JOIN item_carrito ic ON c.id_carrito = ic.id_carrito 
                       INNER JOIN inventario inv ON ic.id_inventario = inv.id_inventario 
                       INNER JOIN producto p ON inv.id_producto = p.id_producto 
                       WHERE c.id_usuario = $id_usuario";
            $res_cart = mysqli_query($conexion, $q_cart);

            if (!$res_cart || mysqli_num_rows($res_cart) === 0) {
                header('Location: carrito.php');
                exit;
            }

            $total = 0;
            $items_compra = [];

            while ($row = mysqli_fetch_assoc($res_cart)) {
                if ($row['cantidad'] > $row['stock_disponible']) {
                    echo "<script>alert('Error: Un producto en tu carrito supera el stock.'); window.location.href='carrito.php';</script>";
                    exit;
                }
                $total += ($row['precio'] * $row['cantidad']);
                $items_compra[] = $row;
            }

            // Crear pedido
            $query_pedido = "INSERT INTO pedido (fecha_pedido, estado, total, direccion_entrega, id_usuario) VALUES (NOW(), 'pagado', $total, '$direccion', $id_usuario)";
            mysqli_query($conexion, $query_pedido);
            $id_pedido = mysqli_insert_id($conexion);

            foreach ($items_compra as $it) {
                mysqli_query($conexion, "INSERT INTO item_pedido (cantidad, precio_unitario, id_pedido, id_inventario) VALUES ({$it['cantidad']}, {$it['precio']}, $id_pedido, {$it['id_inventario']})");
                mysqli_query($conexion, "UPDATE inventario SET stock_disponible = stock_disponible - {$it['cantidad']} WHERE id_inventario = {$it['id_inventario']}");
            }

            // Vaciar el carrito
            $get_cart = mysqli_query($conexion, "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario");
            $c_data = mysqli_fetch_assoc($get_cart);
            if ($c_data) {
                mysqli_query($conexion, "DELETE FROM item_carrito WHERE id_carrito = {$c_data['id_carrito']}");
            }
        }

        echo "<script>alert('¡Pago simulado con éxito! Pedido generado por $" . number_format($total, 0, ',', '.') . " COP'); window.location.href = 'index.php';</script>";
        exit;

    } catch (Exception $e) {
        // Captura del error crítico de pago
        error_log("Error crítico BD en procesar_compra_directa.php (Guardado): " . $e->getMessage());
        echo "<script>alert('Ocurrió un error interno al procesar tu pago. No te preocupes, no se han realizado cargos. Intenta de nuevo.'); window.location.href = 'index.php';</script>";
        exit;
    }
}

// =====================================================================
// APLICACIÓN IEEE 730: Bloque Try...Catch para la Fase de Preparación Visual
// =====================================================================
try {
    // 4. FASE DE PREPARACIÓN VISUAL: Cálculo previo de totales para renderizar el formulario
    $origen = $_POST['origen'] ?? 'directa';
    $subtotal = 0;

    if ($origen === 'directa' && isset($_POST['id_inventario'])) {
        $id_inventario = intval($_POST['id_inventario']);
        $cantidad = intval($_POST['cantidad'] ?? 1);

        $query = "SELECT p.precio, inv.stock_disponible FROM inventario inv INNER JOIN producto p ON inv.id_producto = p.id_producto WHERE inv.id_inventario = $id_inventario";
        $res = mysqli_query($conexion, $query);
        $item = mysqli_fetch_assoc($res);

        if (!$item || $cantidad > $item['stock_disponible']) {
            echo "<script>alert('La cantidad seleccionada supera el stock disponible.'); window.history.back();</script>";
            exit;
        }
        $subtotal = $item['precio'] * $cantidad;

    } else if ($origen === 'carrito') {
        $q_cart = "SELECT SUM(ic.cantidad * p.precio) AS total 
                   FROM carrito c 
                   INNER JOIN item_carrito ic ON c.id_carrito = ic.id_carrito 
                   INNER JOIN inventario inv ON ic.id_inventario = inv.id_inventario 
                   INNER JOIN producto p ON inv.id_producto = p.id_producto 
                   WHERE c.id_usuario = $id_usuario";
        $res = mysqli_query($conexion, $q_cart);
        $data = mysqli_fetch_assoc($res);
        $subtotal = $data['total'] ?? 0;

        if ($subtotal <= 0) {
            header('Location: carrito.php');
            exit;
        }
    }
} catch (Exception $e) {
    // Captura del error al intentar cargar los datos para pagar
    error_log("Error crítico BD en procesar_compra_directa.php (Preparación): " . $e->getMessage());
    echo "<script>alert('Error al cargar la información de la compra. Por favor, intenta de nuevo.'); window.location.href = 'index.php';</script>";
    exit;
}
?>