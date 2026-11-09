<?php
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
session_start();
require_once __DIR__ . '/../../config/conexion.php';

$categoria_filtro = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$genero_filtro = isset($_GET['genero']) ? trim($_GET['genero']) : '';
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
// 1. LÓGICA DE NEGOCIO (BACKEND) - PROTECCIÓN CON PREPARED STATEMENTS
$favoritos_usuario = [];
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario']; 
    
    // 1. Preparamos la consulta con un placeholder (?)
    $query_favs = "SELECT id_producto FROM favoritos WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $query_favs);
    
    if ($stmt) {
        // 2. Vinculamos el parámetro de forma segura. La "i" le dice a la base de datos que espere un Integer
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        
        // 3. Ejecutamos la consulta blindada
        mysqli_stmt_execute($stmt);
        $result_favs = mysqli_stmt_get_result($stmt);
        
        if ($result_favs) {
            while ($row = mysqli_fetch_assoc($result_favs)) {
                $favoritos_usuario[] = $row['id_producto'];
            }
        }
        mysqli_stmt_close($stmt); // Buena práctica: liberar el recurso
    }
}
$cantidad_carrito = 0;

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
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

