<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = "";


// (Asumiendo que arriba tienes tu session_start y la conexión)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. VALIDACIÓN DE SEGURIDAD CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $mensaje = "Error de seguridad: Token CSRF inválido o ausente. Intenta registrarte de nuevo.";
    } else {
        
        // 2. LÓGICA NORMAL DE REGISTRO (Solo se ejecuta si el token es válido)
        $nombre     = trim($_POST['nombre']);
        $correo     = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);
        $telefono   = trim($_POST['telefono']);
        $direccion  = trim($_POST['direccion']);

        // Validar que los campos obligatorios no estén vacíos
        if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
            
            // Verificar si el correo ya está registrado usando sentencia preparada
            $stmt_check = $conexion->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
            $stmt_check->bind_param("s", $correo);
            $stmt_check->execute();
            $resultado_check = $stmt_check->get_result();

            if ($resultado_check->num_rows > 0) {
                $mensaje = "El correo ya está registrado. Intenta con otro.";
            } else {
                // ENCRIPTAR / HASHEAR LA CONTRASEÑA
                $hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);
                $rol = 'cliente';

                // Insertar el usuario con la contraseña hasheada
                $stmt_insert = $conexion->prepare(
                    "INSERT INTO usuario (rol, nombre, correo, contrasena, telefono, direccion_envio) VALUES (?, ?, ?, ?, ?, ?)"
                );
                $stmt_insert->bind_param("ssssss", $rol, $nombre, $correo, $hash_contrasena, $telefono, $direccion);

                if ($stmt_insert->execute()) {
                    // Iniciar sesión automáticamente tras el registro
                    $_SESSION['id_usuario'] = $stmt_insert->insert_id;
                    $_SESSION['nombre_usuario'] = $nombre;
                    $_SESSION['rol'] = $rol;

                    header('Location: index.php');
                    exit;
                } else {
                    $mensaje = "Error al registrar el usuario: " . $conexion->error;
                }
                $stmt_insert->close();
            }
            $stmt_check->close();
        } else {
            $mensaje = "Por favor, completa todos los campos obligatorios.";
        }
    }
}
?>