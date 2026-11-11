<?php
// 1. EXTRAER FAVORITOS DEL USUARIO
$favoritos_usuario = [];
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario']; 
    $query_favs = "SELECT id_producto FROM favoritos WHERE id_usuario = ?";
    if ($stmt_favs = mysqli_prepare($conexion, $query_favs)) {
        mysqli_stmt_bind_param($stmt_favs, "i", $id_usuario);
        mysqli_stmt_execute($stmt_favs);
        $result_favs = mysqli_stmt_get_result($stmt_favs);
        if ($result_favs) {
            while ($row = mysqli_fetch_assoc($result_favs)) {
                $favoritos_usuario[] = $row['id_producto'];
            }
        }
        mysqli_stmt_close($stmt_favs); 
    }
}

// 2. EXTRAER TOTAL DEL CARRITO (+9 LÓGICA)
$cantidad_carrito = 0;
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $query_cart = "
        SELECT SUM(ic.cantidad) as total_items 
        FROM item_carrito ic
        INNER JOIN carrito c ON ic.id_carrito = c.id_carrito
        WHERE c.id_usuario = ?";
    
    if ($stmt_cart = mysqli_prepare($conexion, $query_cart)) {
        mysqli_stmt_bind_param($stmt_cart, "i", $id_usuario);
        mysqli_stmt_execute($stmt_cart);
        $result_cart = mysqli_stmt_get_result($stmt_cart);
        if ($row = mysqli_fetch_assoc($result_cart)) {
            $cantidad_carrito = $row['total_items'] ? (int)$row['total_items'] : 0;
        }
        mysqli_stmt_close($stmt_cart);
    }
}
?>