<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../Config/conexion.php';

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$sql = "SELECT id_producto, nombre, precio, imagen, categoria FROM producto WHERE 1=1";

if (!empty($busqueda)) {
    $busq_safe = mysqli_real_escape_string($conexion, $busqueda);
    $sql .= " AND (nombre LIKE '%$busq_safe%' OR descripcion LIKE '%$busq_safe%' OR categoria LIKE '%$busq_safe%')";
}

$sql .= " ORDER BY id_producto DESC";
$resultado = mysqli_query($conexion, $sql);
?>
