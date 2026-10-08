<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

// Redirigir al login si no hay sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Eliminar de favoritos desde la vista si el usuario presiona "Quitar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_favorito_id'])) {
    $id_fav_eliminar = intval($_POST['eliminar_favorito_id']);
    $query_del = "DELETE FROM favoritos WHERE id_favorito = $id_fav_eliminar AND id_usuario = $id_usuario";
    mysqli_query($conexion, $query_del);
}

// Consultar los productos favoritos del usuario
$query_fav = "SELECT f.id_favorito, p.id_producto, p.nombre, p.precio, p.imagen 
              FROM favoritos f
              INNER JOIN producto p ON f.id_producto = p.id_producto
              WHERE f.id_usuario = $id_usuario
              ORDER BY f.fecha_agregado DESC";

$resultado_fav = mysqli_query($conexion, $query_fav);
?>

