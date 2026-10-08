<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = '';

// Lógica para REACTIVAR un producto
if (isset($_GET['reactivar_id'])) {
    $id_reactivar = intval($_GET['reactivar_id']);
    
    $query_reactivar = "UPDATE producto SET activo = 1 WHERE id_producto = $id_reactivar";
    
    if (mysqli_query($conexion, $query_reactivar)) {
        header("Location: productos_desactivados.php?mensaje=reactivado");
        exit;
    } else {
        $mensaje = "Error al reactivar el producto: " . mysqli_error($conexion);
    }
}

// Consultar únicamente los productos inactivos (activo = 0)
$query_inactivos = "SELECT p.*, COALESCE(SUM(inv.stock_disponible), 0) AS stock_total 
                    FROM producto p 
                    LEFT JOIN inventario inv ON p.id_producto = inv.id_producto 
                    WHERE p.activo = 0 
                    GROUP BY p.id_producto 
                    ORDER BY p.id_producto DESC";
$res_inactivos = mysqli_query($conexion, $query_inactivos);
?>
