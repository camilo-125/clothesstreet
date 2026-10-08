<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

// 1. Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'status' => 'auth_required',
        'message' => 'Debes iniciar sesión para guardar productos en favoritos.'
    ]);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;

if ($id_producto <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Producto no válido.']);
    exit;
}

// 2. Comprobar si ya existe en la tabla favoritos
$query_check = "SELECT id_favorito FROM favoritos WHERE id_usuario = $id_usuario AND id_producto = $id_producto";
$res_check = mysqli_query($conexion, $query_check);

if ($res_check && mysqli_num_rows($res_check) > 0) {
    // Si ya existe, lo eliminamos
    $query_delete = "DELETE FROM favoritos WHERE id_usuario = $id_usuario AND id_producto = $id_producto";
    mysqli_query($conexion, $query_delete);
    echo json_encode(['status' => 'removed', 'action' => 'removed']);
} else {
    // Si no existe, lo insertamos
    $query_insert = "INSERT INTO favoritos (id_usuario, id_producto) VALUES ($id_usuario, $id_producto)";
    mysqli_query($conexion, $query_insert);
    echo json_encode(['status' => 'added', 'action' => 'added']);
}
?>