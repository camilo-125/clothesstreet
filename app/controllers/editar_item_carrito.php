<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$error_mensaje = "";

// PROCESAR LA ACTUALIZACIÓN (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_item_carrito'])) {
    $id_item_carrito = intval($_POST['id_item_carrito']);
    $id_inventario_nuevo = intval($_POST['id_inventario']);
    $cantidad_nueva = intval($_POST['cantidad']);

    // Consultar el stock disponible de la variante seleccionada
    $query_stock = "SELECT stock_disponible FROM inventario WHERE id_inventario = $id_inventario_nuevo";
    $res_stock = mysqli_query($conexion, $query_stock);
    $inv_data = mysqli_fetch_assoc($res_stock);
    $stock_maximo = $inv_data['stock_disponible'] ?? 0;

    // Validación de stock en el servidor
    if ($cantidad_nueva > $stock_maximo) {
        $error_mensaje = "Solo hay $stock_maximo unidades disponibles en inventario.";
    } elseif ($id_item_carrito > 0 && $id_inventario_nuevo > 0 && $cantidad_nueva > 0) {
        $query_valida = "SELECT ic.id_item_carrito 
                         FROM item_carrito ic
                         INNER JOIN carrito c ON ic.id_carrito = c.id_carrito
                         WHERE ic.id_item_carrito = $id_item_carrito AND c.id_usuario = $id_usuario";
        $res_valida = mysqli_query($conexion, $query_valida);

        if ($res_valida && mysqli_num_rows($res_valida) > 0) {
            $query_update = "UPDATE item_carrito 
                             SET id_inventario = $id_inventario_nuevo, cantidad = $cantidad_nueva 
                             WHERE id_item_carrito = $id_item_carrito";
            mysqli_query($conexion, $query_update);
            header('Location: carrito.php');
            exit;
        }
    }
}

// CARGAR LA VISTA DE EDICIÓN (GET)
$id_item_carrito = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id_item_carrito']) ? intval($_POST['id_item_carrito']) : 0);

if ($id_item_carrito <= 0) {
    header('Location: carrito.php');
    exit;
}

$query_item = "SELECT ic.id_item_carrito, ic.cantidad, ic.id_inventario, p.id_producto, p.nombre, p.precio, p.imagen, inv.stock_disponible
               FROM item_carrito ic
               INNER JOIN carrito c ON ic.id_carrito = c.id_carrito
               INNER JOIN inventario inv ON ic.id_inventario = inv.id_inventario
               INNER JOIN producto p ON inv.id_producto = p.id_producto
               WHERE ic.id_item_carrito = $id_item_carrito AND c.id_usuario = $id_usuario";

$res_item = mysqli_query($conexion, $query_item);

if (!$res_item || mysqli_num_rows($res_item) === 0) {
    header('Location: carrito.php');
    exit;
}

$item = mysqli_fetch_assoc($res_item);
$id_producto = $item['id_producto'];

// Obtener todas las variantes
$query_inv = "SELECT id_inventario, talla, color, stock_disponible 
              FROM inventario 
              WHERE id_producto = $id_producto AND stock_disponible > 0";
$res_inv = mysqli_query($conexion, $query_inv);

$variantes = [];
while ($row = mysqli_fetch_assoc($res_inv)) {
    $variantes[] = $row;
}
?>

