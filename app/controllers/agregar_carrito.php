<?php
session_start();
// Aseguramos la ruta correcta a la conexión de base de datos
require_once __DIR__ . '/../config/conexion.php';

// Forzamos a que PHP siempre responda en formato JSON para que el JS lo lea sin errores
header('Content-Type: application/json');

// 1. Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'status' => 'auth_required',
        'message' => 'Debes iniciar sesión para agregar productos al carrito'
    ]);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;

if ($id_producto <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Producto no válido'
    ]);
    exit;
}

// =====================================================================
// APLICACIÓN IEEE 730 / MODS: Iniciamos el control de errores (try)
// =====================================================================
try {
    // 2. Consultar disponibilidad en la tabla inventario
    $query_inventario = "SELECT id_inventario FROM inventario WHERE id_producto = $id_producto AND stock_disponible > 0 LIMIT 1";
    $res_inventario = mysqli_query($conexion, $query_inventario);

    if (!$res_inventario || mysqli_num_rows($res_inventario) === 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Producto sin stock'
        ]);
        exit;
    }

    $inventario = mysqli_fetch_assoc($res_inventario);
    $id_inventario = $inventario['id_inventario'];

    // 3. Buscar o crear el carrito activo del usuario
    $query_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
    $res_carrito = mysqli_query($conexion, $query_carrito);

    if ($res_carrito && mysqli_num_rows($res_carrito) > 0) {
        $carrito = mysqli_fetch_assoc($res_carrito);
        $id_carrito = $carrito['id_carrito'];
    } else {
        $insert_carrito = "INSERT INTO carrito (id_usuario) VALUES ($id_usuario)";
        mysqli_query($conexion, $insert_carrito);
        $id_carrito = mysqli_insert_id($conexion);
    }

    // 4. Agregar o actualizar la cantidad en item_carrito
    $query_item = "SELECT id_item_carrito, cantidad FROM item_carrito WHERE id_carrito = $id_carrito AND id_inventario = $id_inventario";
    $res_item = mysqli_query($conexion, $query_item);

    if ($res_item && mysqli_num_rows($res_item) > 0) {
        $item = mysqli_fetch_assoc($res_item);
        $nueva_cantidad = $item['cantidad'] + 1;
        $id_item = $item['id_item_carrito'];
        
        $update_item = "UPDATE item_carrito SET cantidad = $nueva_cantidad WHERE id_item_carrito = $id_item";
        mysqli_query($conexion, $update_item);
    } else {
        $insert_item = "INSERT INTO item_carrito (cantidad, id_carrito, id_inventario) VALUES (1, $id_carrito, $id_inventario)";
        mysqli_query($conexion, $insert_item);
    }

    // 5. Calcular total de prendas registradas con JOIN para enviar a JS
    $total_actualizado = 0;
    $query_recount = "
        SELECT SUM(ic.cantidad) as total_items 
        FROM item_carrito ic
        INNER JOIN carrito c ON ic.id_carrito = c.id_carrito
        WHERE c.id_usuario = ?";

    if ($stmt_recount = mysqli_prepare($conexion, $query_recount)) {
        mysqli_stmt_bind_param($stmt_recount, "i", $id_usuario);
        mysqli_stmt_execute($stmt_recount);
        $res_recount = mysqli_stmt_get_result($stmt_recount);
        if ($row = mysqli_fetch_assoc($res_recount)) {
            $total_actualizado = $row['total_items'] ? (int)$row['total_items'] : 0;
        }
        mysqli_stmt_close($stmt_recount);
    }

    // ÚNICA respuesta JSON permitida para evitar que el JS colapse
    echo json_encode([
        'status' => 'success', 
        'message' => 'Agregado al carrito',
        'total_items' => $total_actualizado
    ]);

} catch (Exception $e) {
    // =====================================================================
    // CAPTURA DEL ERROR (catch): Protegemos el sistema y al usuario
    // =====================================================================
    
    // 1. Guardamos el error crítico de forma silenciosa en el servidor para depuración
    error_log("Error crítico BD en agregar_carrito.php: " . $e->getMessage());

    // 2. Respondemos a JavaScript con un mensaje seguro
    echo json_encode([
        'status' => 'error',
        'message' => 'Ocurrió un problema interno al procesar tu solicitud. Por favor, intenta de nuevo.'
    ]);
}
?>