<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../config/conexion.php';

// ACTUALIZAR ESTADO DE PEDIDO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'], $_POST['nuevo_estado'])) {
    $id_p = intval($_POST['id_pedido']);
    $nuevo_estado = trim($_POST['nuevo_estado']);
    $estados_permitidos = ['pendiente', 'pagado', 'enviado', 'entregado', 'cancelado'];

    if ($id_p > 0 && in_array($nuevo_estado, $estados_permitidos, true)) {
        $stmt_upd = mysqli_prepare($conexion, "UPDATE pedido SET estado = ? WHERE id_pedido = ?");
        if ($stmt_upd) {
            mysqli_stmt_bind_param($stmt_upd, "si", $nuevo_estado, $id_p);
            mysqli_stmt_execute($stmt_upd);
            mysqli_stmt_close($stmt_upd);
        }
    }
    header('Location: admin_pedidos.php?msg=updated');
    exit;
}

// CONSULTA DE PEDIDOS CON CLIENTE (Priorizando pedidos activos sobre entregados/cancelados)
$query_p = "SELECT p.*, u.nombre AS cliente, u.correo, u.telefono 
            FROM pedido p 
            INNER JOIN usuario u ON p.id_usuario = u.id_usuario 
            ORDER BY 
                CASE 
                    WHEN p.estado IN ('entregado', 'cancelado') THEN 1 
                    ELSE 0 
                END ASC,
                p.id_pedido DESC";
$res_pedidos = mysqli_query($conexion, $query_p);

// CONSULTA DE DETALLES DE TODOS LOS PEDIDOS (Productos, tallas, colores y cantidades)
$detalles_pedidos = [];
$query_detalles = "SELECT ip.id_pedido, ip.cantidad, ip.precio_unitario, 
                          i.talla, i.color, 
                          pr.nombre AS producto, pr.imagen 
                   FROM item_pedido ip
                   INNER JOIN inventario i ON ip.id_inventario = i.id_inventario
                   INNER JOIN producto pr ON i.id_producto = pr.id_producto
                   ORDER BY ip.id_item_pedido ASC";
$res_detalles = mysqli_query($conexion, $query_detalles);

if ($res_detalles) {
    while ($item = mysqli_fetch_assoc($res_detalles)) {
        $id_ped = (int)$item['id_pedido'];
        $detalles_pedidos[$id_ped][] = [
            'producto' => $item['producto'],
            'talla'    => $item['talla'],
            'color'    => $item['color'],
            'cantidad' => (int)$item['cantidad'],
            'precio'   => (float)$item['precio_unitario'],
            'subtotal' => (float)$item['precio_unitario'] * (int)$item['cantidad'],
            'imagen'   => $item['imagen']
        ];
    }
}
?>