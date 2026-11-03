<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../Config/conexion.php';
$mensaje = '';

// ELIMINAR PRODUCTO (DESACTIVAR)
if (isset($_GET['eliminar_id'])) {
    $id_eliminar = intval($_GET['eliminar_id']);
    $query_del = "UPDATE producto SET activo = 0 WHERE id_producto = $id_eliminar";
    if (mysqli_query($conexion, $query_del)) {
        header('Location: admin_inventario.php?mensaje=producto_eliminado');
        exit;
    } else {
        $mensaje = "Error al desactivar el producto.";
    }
}

// LÓGICA PARA REACTIVAR UN PRODUCTO
if (isset($_GET['reactivar_id'])) {
    $id_reactivar = intval($_GET['reactivar_id']);
    $query_reactivar = "UPDATE producto SET activo = 1 WHERE id_producto = $id_reactivar";
    if (mysqli_query($conexion, $query_reactivar)) {
        header("Location: admin_inventario.php?mensaje=reactivado");
        exit;
    }
}

// OBTENER TODOS LOS PRODUCTOS ACTIVOS CON SU STOCK TOTAL
$query_list = "SELECT p.*, COALESCE(SUM(inv.stock_disponible), 0) AS stock_total 
               FROM producto p 
               LEFT JOIN inventario inv ON p.id_producto = inv.id_producto 
               WHERE p.activo = 1 
               GROUP BY p.id_producto 
               ORDER BY p.id_producto DESC";
$res_productos = mysqli_query($conexion, $query_list);
?>