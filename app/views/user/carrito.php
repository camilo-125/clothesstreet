<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Eliminar producto del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $id_item_eliminar = intval($_POST['eliminar_id']);
    $query_delete = "DELETE FROM item_carrito WHERE id_item_carrito = $id_item_eliminar";
    mysqli_query($conexion, $query_delete);
}

// Consultar items del carrito
$query_carrito = "SELECT ic.id_item_carrito, ic.cantidad, p.nombre, p.precio, p.imagen, inv.talla, inv.color 
                 FROM carrito c
                 INNER JOIN item_carrito ic ON c.id_carrito = ic.id_carrito
                 INNER JOIN inventario inv ON ic.id_inventario = inv.id_inventario
                 INNER JOIN producto p ON inv.id_producto = p.id_producto
                 WHERE c.id_usuario = $id_usuario";

$resultado = mysqli_query($conexion, $query_carrito);
$total_general = 0;
?>

