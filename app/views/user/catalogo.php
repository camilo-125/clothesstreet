<?php
$categoria_filtro = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$genero_filtro = isset($_GET['genero']) ? trim($_GET['genero']) : '';
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

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

// Guardar la página actual para que el botón "Volver" sepa a dónde regresar
if (isset($_SERVER['REQUEST_URI'])) {
    if (strpos($_SERVER['REQUEST_URI'], 'favoritos.php') === false && strpos($_SERVER['REQUEST_URI'], 'carrito.php') === false) {
        $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
    }
}
?>