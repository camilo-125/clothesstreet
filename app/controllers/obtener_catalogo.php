<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$favoritos_usuario = []; 

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $query_favs = "SELECT id_producto FROM favoritos WHERE id_usuario = ?";
    
    if ($stmt = mysqli_prepare($conexion, $query_favs)) {
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $result_favs = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result_favs)) {
            $favoritos_usuario[] = $row['id_producto'];
        }
        mysqli_stmt_close($stmt);
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$favoritos_usuario = []; 
$cantidad_carrito = 0; // NUEVO: Iniciamos el contador del carrito en 0

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    
    // 1. Consulta de favoritos (que ya tenías)
    $query_favs = "SELECT id_producto FROM favoritos WHERE id_usuario = ?";
    if ($stmt = mysqli_prepare($conexion, $query_favs)) {
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $result_favs = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result_favs)) {
            $favoritos_usuario[] = $row['id_producto'];
        }
        mysqli_stmt_close($stmt);
    }

    // 2. NUEVO: Consulta para contar lo que hay en el carrito
    // Nota: Si en tu tabla 'carrito' tienes una columna 'cantidad', puedes cambiar COUNT(*) por SUM(cantidad)
    $query_cart = "SELECT COUNT(*) as total_items FROM carrito WHERE id_usuario = ?";
    if ($stmt_cart = mysqli_prepare($conexion, $query_cart)) {
        mysqli_stmt_bind_param($stmt_cart, "i", $id_usuario);
        mysqli_stmt_execute($stmt_cart);
        $result_cart = mysqli_stmt_get_result($stmt_cart);
        if ($row = mysqli_fetch_assoc($result_cart)) {
            $cantidad_carrito = $row['total_items'] ? $row['total_items'] : 0;
        }
        mysqli_stmt_close($stmt_cart);
    }
}
// IMPORTANTE: Cero "echo json_encode", cero texto HTML y cero "exit;" en este archivo.
?>