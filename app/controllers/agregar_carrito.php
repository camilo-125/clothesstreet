<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

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

// 5. Calcular total de prendas registradas para responder a JavaScript
$query_total = "SELECT SUM(cantidad) AS total FROM item_carrito WHERE id_carrito = $id_carrito";
$res_total = mysqli_query($conexion, $query_total);
$data_total = mysqli_fetch_assoc($res_total);
$total_items = $data_total['total'] ? intval($data_total['total']) : 0;

echo json_encode([
    'status' => 'success',
    'total_items' => $total_items
]);
?>