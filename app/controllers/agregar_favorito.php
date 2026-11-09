<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['status' => 'auth_required', 'message' => 'Debes iniciar sesión para guardar favoritos']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;

if ($id_producto <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Producto no válido']);
    exit;
}

try {
    $query_check = "SELECT id_favorito FROM favoritos WHERE id_usuario = ? AND id_producto = ?";
    $stmt_check = mysqli_prepare($conexion, $query_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);

    if ($res_check && mysqli_num_rows($res_check) > 0) {
        $query_delete = "DELETE FROM favoritos WHERE id_usuario = ? AND id_producto = ?";
        $stmt_delete = mysqli_prepare($conexion, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "ii", $id_usuario, $id_producto);
        mysqli_stmt_execute($stmt_delete);
        
        echo json_encode(['status' => 'success', 'action' => 'removed']);
        mysqli_stmt_close($stmt_delete);
    } else {
        $query_insert = "INSERT INTO favoritos (id_usuario, id_producto) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($conexion, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "ii", $id_usuario, $id_producto);
        mysqli_stmt_execute($stmt_insert);
        
        echo json_encode(['status' => 'success', 'action' => 'added']);
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt_check);
} catch (Exception $e) {
    error_log("Error crítico BD: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error.']);
}
?>