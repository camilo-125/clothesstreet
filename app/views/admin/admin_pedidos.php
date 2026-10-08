<?php
require_once __DIR__ . '/../..//Middleware/admin_middleware.php';
require_once __DIR__ . '/../../config/conexion.php';

// ACTUALIZAR ESTADO DE PEDIDO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'], $_POST['nuevo_estado'])) {
    $id_p = intval($_POST['id_pedido']);
    $est_safe = mysqli_real_escape_string($conexion, $_POST['nuevo_estado']);
    
    mysqli_query($conexion, "UPDATE pedido SET estado = '$est_safe' WHERE id_pedido = $id_p");
    header('Location: admin_pedidos.php?msg=updated');
    exit;
}

// CONSULTA DE PEDIDOS CON CLIENTE
$query_p = "SELECT p.*, u.nombre AS cliente, u.correo 
            FROM pedido p 
            INNER JOIN usuario u ON p.id_usuario = u.id_usuario 
            ORDER BY p.id_pedido DESC";
$res_pedidos = mysqli_query($conexion, $query_p);
?>
