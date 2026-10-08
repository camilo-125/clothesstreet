<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

// 1. Validar que llegue un ID de producto por la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_producto = intval($_GET['id']);

// 2. Obtener la información del producto
$query_prod = "SELECT * FROM producto WHERE id_producto = $id_producto";
$res_prod = mysqli_query($conexion, $query_prod);

if (!$res_prod || mysqli_num_rows($res_prod) === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = mysqli_fetch_assoc($res_prod);

// 3. Obtener variantes disponibles (talla/color) desde la tabla inventario
$query_inv = "SELECT id_inventario, talla, color, stock_disponible FROM inventario WHERE id_producto = $id_producto AND stock_disponible > 0";
$res_inv = mysqli_query($conexion, $query_inv);

$variantes = [];
while ($row = mysqli_fetch_assoc($res_inv)) {
    $variantes[] = $row;
}
?>

