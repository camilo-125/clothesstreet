<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../Config/conexion.php';

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_producto <= 0) {
    header('Location: admin_inventario.php');
    exit;
}

// PROCESAR ACTUALIZACIÓN DEL PRODUCTO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_producto'])) {
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $genero = mysqli_real_escape_string($conexion, trim($_POST['genero']));
    $precio = floatval($_POST['precio']);
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    $imagen = mysqli_real_escape_string($conexion, trim($_POST['imagen']));

    $update = "UPDATE producto SET nombre='$nombre', categoria='$categoria', genero='$genero', precio=$precio, descripcion='$descripcion', imagen='$imagen' WHERE id_producto=$id_producto";
    mysqli_query($conexion, $update);

    // Actualizar existencias de inventario
    if (isset($_POST['stock_inv']) && is_array($_POST['stock_inv'])) {
        foreach ($_POST['stock_inv'] as $id_inv => $cant) {
            $id_inv_safe = intval($id_inv);
            $cant_safe = intval($cant);
            mysqli_query($conexion, "UPDATE inventario SET stock_disponible=$cant_safe WHERE id_inventario=$id_inv_safe");
        }
    }

    header("Location: admin_editar_producto.php?id=$id_producto&msg=updated");
    exit;
}

// AGREGAR NUEVA VARIANTE (Talla/Color)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_variante'])) {
    $talla = mysqli_real_escape_string($conexion, trim($_POST['talla']));
    $color = mysqli_real_escape_string($conexion, trim($_POST['color']));
    $stock = intval($_POST['stock']);

    mysqli_query($conexion, "INSERT INTO inventario (talla, color, stock_disponible, id_producto) VALUES ('$talla', '$color', $stock, $id_producto)");
    header("Location: admin_editar_producto.php?id=$id_producto");
    exit;
}

// Cargar Producto
$res_p = mysqli_query($conexion, "SELECT * FROM producto WHERE id_producto = $id_producto");
$producto = mysqli_fetch_assoc($res_p);

// Cargar Variantes
$res_inv = mysqli_query($conexion, "SELECT * FROM inventario WHERE id_producto = $id_producto");
?>
