<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

$categoria_filtro = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$genero_filtro = isset($_GET['genero']) ? trim($_GET['genero']) : '';
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Consulta dinámica SQL
$sql = "SELECT id_producto, nombre, precio, imagen, categoria, genero FROM producto WHERE 1=1 AND activo = 1";

if (!empty($genero_filtro)) {
    $gen_safe = mysqli_real_escape_string($conexion, $genero_filtro);
    if ($gen_safe === 'Hombre' || $gen_safe === 'Mujer') {
        $sql .= " AND (genero = '$gen_safe' OR genero = 'Unisex')";
    } else {
        $sql .= " AND genero = '$gen_safe'";
    }
}

if (!empty($categoria_filtro)) {
    $cat_safe = mysqli_real_escape_string($conexion, $categoria_filtro);
    $sql .= " AND categoria = '$cat_safe'";
}

if (!empty($busqueda)) {
    $busq_safe = mysqli_real_escape_string($conexion, $busqueda);
    $sql .= " AND (nombre LIKE '%$busq_safe%' OR descripcion LIKE '%$busq_safe%')";
}

$sql .= " ORDER BY id_producto DESC";
$resultado = mysqli_query($conexion, $sql);
?>

/**
 * Controlador de Procesamiento de Compras Directas
 *
 * Este script maneja la lógica central de transacciones del e-commerce.
 * Recibe peticiones POST, verifica la seguridad (CSRF), valida la 
 * disponibilidad del inventario y registra el pedido finalizando la compra.
 * Implementa control de excepciones (Try/Catch) según IEEE 730.
 *
 * @package    ClothesStreet
 * @subpackage Controllers
 * @author     [Tu Nombre o "Equipo de Desarrollo"]
 * @version    1.1.0
 * @since      2026-10-08
 *
 * @uses       $_SESSION Para validar autenticación de usuario y tokens CSRF.
 * @uses       $_POST Para recuperar datos del carrito o compra directa.
 * @throws     Exception Si ocurre un error crítico de base de datos durante la transacción.
 */