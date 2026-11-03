<?php
require_once __DIR__ . '/../../Middleware/admin_middleware.php';
require_once __DIR__ . '/../../Config/conexion.php';
$mensaje = '';

// =================================================================================
// CREAR PRODUCTO + EFICIENCIA DE DESEMPEÑO ISO/IEC 25000 (Validación de Imágenes)
// =================================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $genero = mysqli_real_escape_string($conexion, trim($_POST['genero']));
    $precio = floatval($_POST['precio']);
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    
    // Datos variante
    $talla = mysqli_real_escape_string($conexion, trim($_POST['talla']));
    $color = mysqli_real_escape_string($conexion, trim($_POST['color']));
    $stock = intval($_POST['stock']);

    $ruta_imagen_final = "img/default.jpg"; // Imagen por defecto si algo falla
    $error_imagen = false;

    // VALIDACIÓN DE LA IMAGEN SUBIDA
    if (isset($_FILES['imagen_file']) && $_FILES['imagen_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen_file']['tmp_name'];
        $fileName = $_FILES['imagen_file']['name'];
        $fileSize = $_FILES['imagen_file']['size'];
        
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        $max_size_mb = 2;
        $max_size_bytes = $max_size_mb * 1024 * 1024;

        if (!in_array($fileExtension, $extensiones_permitidas)) {
            $mensaje = "Error: Solo se permiten imágenes JPG, PNG o WEBP.";
            $error_imagen = true;
        } else if ($fileSize > $max_size_bytes) {
            $mensaje = "Error: La imagen supera el límite de 2 MB permitido por las políticas de rendimiento.";
            $error_imagen = true;
        } else {
            $uploadFileDir = __DIR__ . '/../../public/img/productos/';
            
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $ruta_imagen_final = 'img/productos/' . $newFileName;
            } else {
                $mensaje = "Error crítico al mover la imagen al directorio de almacenamiento.";
                $error_imagen = true;
            }
        }
    } else if (isset($_FILES['imagen_file']) && $_FILES['imagen_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $mensaje = "Error en la subida del archivo. Código: " . $_FILES['imagen_file']['error'];
        $error_imagen = true;
    }

    if (!$error_imagen) {
        $query_p = "INSERT INTO producto (nombre, categoria, genero, precio, descripcion, imagen) VALUES ('$nombre', '$categoria', '$genero', $precio, '$descripcion', '$ruta_imagen_final')";
        if (mysqli_query($conexion, $query_p)) {
            $id_nuevo_producto = mysqli_insert_id($conexion);
            $query_i = "INSERT INTO inventario (talla, color, stock_disponible, id_producto) VALUES ('$talla', '$color', $stock, $id_nuevo_producto)";
            mysqli_query($conexion, $query_i);
            $mensaje = "Producto registrado y optimizado con éxito.";
        } else {
            $mensaje = "Error al guardar en la base de datos.";
        }
    }
}
?>