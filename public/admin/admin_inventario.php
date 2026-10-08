<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../Config/conexion.php';

$mensaje = '';

// ELIMINAR PRODUCTO (DESACTIVAR)
if (isset($_GET['eliminar_id'])) {$id_eliminar = intval($_GET['eliminar_id']);$query_del = "UPDATE producto SET activo = 0 WHERE id_producto = $id_eliminar";
    if (mysqli_query($conexion,$query_del)) {
        header('Location: admin_inventario.php?mensaje=producto_eliminado');
        exit;
    } else {
        $mensaje = "Error al desactivar el producto.";
    }
}

// LÓGICA PARA REACTIVAR UN PRODUCTO
if (isset($_GET['reactivar_id'])) {$id_reactivar = intval($_GET['reactivar_id']);$query_reactivar = "UPDATE producto SET activo = 1 WHERE id_producto = $id_reactivar";
    if (mysqli_query($conexion,$query_reactivar)) {
        header("Location: admin_inventario.php?mensaje=reactivado");
        exit;
    }
}

// =================================================================================
// CREAR PRODUCTO + EFICIENCIA DE DESEMPEÑO ISO/IEC 25000 (Validación de Imágenes)
// =================================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));$categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $genero = mysqli_real_escape_string($conexion, trim($_POST['genero']));$precio = floatval($_POST['precio']);$descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    
    // Datos variante
    $talla = mysqli_real_escape_string($conexion, trim($_POST['talla']));$color = mysqli_real_escape_string($conexion, trim($_POST['color']));
    $stock = intval($_POST['stock']);

    $ruta_imagen_final = "img/default.jpg"; // Imagen por defecto si algo falla
    $error_imagen = false;

    // VALIDACIÓN DE LA IMAGEN SUBIDA
    if (isset($_FILES['imagen_file']) &&$_FILES['imagen_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath =$_FILES['imagen_file']['tmp_name'];
        $fileName =$_FILES['imagen_file']['name'];
        $fileSize =$_FILES['imagen_file']['size'];
        $fileType =$_FILES['imagen_file']['type'];
        
        // 1. Validar extensión (Formato Seguro)
        $fileNameCmps = explode(".", $fileName);$fileExtension = strtolower(end($fileNameCmps));$extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        // 2. Validar tamaño (Máximo 2MB para Eficiencia de Desempeño)
        $max_size_mb = 2;
        $max_size_bytes =$max_size_mb * 1024 * 1024;

        if (!in_array($fileExtension, $extensiones_permitidas)) {$mensaje = "Error: Solo se permiten imágenes JPG, PNG o WEBP.";
            $error_imagen = true;
        } else if ($fileSize > $max_size_bytes) {$mensaje = "Error: La imagen supera el límite de 2 MB permitido por las políticas de rendimiento.";
            $error_imagen = true;
        } else {
            // Si la imagen pasa las normas ISO/IEC 25000, la preparamos para guardarla
            // Asegúrate de que esta carpeta exista: public/img/productos/
            $uploadFileDir = __DIR__ . '/../../public/img/productos/';
            
            // Creamos la carpeta si no existe
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            // Renombramos el archivo para evitar duplicados
            $newFileName = md5(time() . $fileName) . '.' .$fileExtension;
            $dest_path = $uploadFileDir .$newFileName;

            if (move_uploaded_file($fileTmpPath,$dest_path)) {
                // Guardamos la ruta relativa que leerá el HTML
                $ruta_imagen_final = 'img/productos/' .$newFileName;
            } else {
                $mensaje = "Error crítico al mover la imagen al directorio de almacenamiento.";
                $error_imagen = true;
            }
        }
    } else if (isset($_FILES['imagen_file']) && $_FILES['imagen_file']['error'] !== UPLOAD_ERR_NO_FILE) {$mensaje = "Error en la subida del archivo. Código: " . $_FILES['imagen_file']['error'];$error_imagen = true;
    }

    // Solo creamos el producto en la BD si NO hubo errores con la imagen
    if (!$error_imagen) {$query_p = "INSERT INTO producto (nombre, categoria, genero, precio, descripcion, imagen) VALUES ('$nombre', '$categoria', '$genero',$precio, '$descripcion', '$ruta_imagen_final')";
        if (mysqli_query($conexion, $query_p)) {$id_nuevo_producto = mysqli_insert_id($conexion);$query_i = "INSERT INTO inventario (talla, color, stock_disponible, id_producto) VALUES ('$talla', '$color', $stock,$id_nuevo_producto)";
            mysqli_query($conexion, $query_i);$mensaje = "Producto registrado y optimizado con éxito.";
        } else {
            $mensaje = "Error al guardar en la base de datos.";
        }
    }
}

// OBTENER TODOS LOS PRODUCTOS ACTIVOS CON SU STOCK TOTAL
$query_list = "SELECT p.*, COALESCE(SUM(inv.stock_disponible), 0) AS stock_total 
               FROM producto p 
               LEFT JOIN inventario inv ON p.id_producto = inv.id_producto 
               WHERE p.activo = 1 
               GROUP BY p.id_producto 
               ORDER BY p.id_producto DESC";
$res_productos = mysqli_query($conexion,$query_list);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario — Admin CLOTHESSTREET</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .form-crear { background: #f9f9f9; border: 1px solid #000; padding: 20px; margin-bottom: 40px; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .field { display: flex; flex-direction: column; }
        .field label { font-size: 12px; font-weight: bold; margin-bottom: 4px; }
        .field input, .field select, .field textarea { padding: 8px; border: 1px solid #ccc; }
        
        /* Estilo para el nuevo input de archivo */
        .field input[type="file"] { padding: 5px; background: #fff; cursor: pointer; }
        
        .btn-submit { background: #000; color: #fff; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer; margin-top: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #000; color: #fff; }
        
        /* Clases para los mensajes de error/éxito */
        .msg-error { color: #dc3545; font-weight: bold; background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; margin-bottom:15px; }
        .msg-exito { color: #155724; font-weight: bold; background: #d4edda; padding: 10px; border: 1px solid #c3e6cb; margin-bottom:15px; }
    </style>
</head>
<body>

    <header>
        <div class="admin-nav-bar">
            <div><strong>CLOTHESSTREET</strong> | Inventario</div>
            <div>
                <a href="admin_dashboard.php">Volver al Panel</a>
                <a href="productos_desactivados.php">Productos Desactivados</a>
                <a href="admin_pedidos.php">Pedidos</a>
                <a href="logout.php" style="color: #ff4d4d;">(