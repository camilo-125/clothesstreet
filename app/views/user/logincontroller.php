<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. VALIDACIÓN DE SEGURIDAD CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Si no hay token o es falso, se bloquea el proceso aquí.
        $mensaje = "Error de seguridad: Token CSRF inválido o ausente. Intenta enviar el formulario de nuevo.";
    } else {
        // 2. LÓGICA NORMAL DE LOGIN (Solo se ejecuta si el token es válido)
        $correo     = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        if (!empty($correo) && !empty($contrasena)) {
            
            // Buscar el usuario mediante sentencia preparada
            $stmt = $conexion->prepare("SELECT id_usuario, nombre, contrasena, rol FROM usuario WHERE correo = ?");
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado && $resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();

                // COMPARAR LA CONTRASEÑA EN TEXTO PLANO CON EL HASH GUARDADO
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    // Guardar los datos en la sesión
                    $_SESSION['id_usuario']     = $usuario['id_usuario'];
                    $_SESSION['nombre_usuario'] = $usuario['nombre'];
                    $_SESSION['rol']            = $usuario['rol'];

                    // Redirección según el rol
                    if ($_SESSION['rol'] === 'administrador') {
                        header('Location: admin/admin_dashboard.php');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                } else {
                    $mensaje = "Contraseña incorrecta.";
                }
            } else {
                $mensaje = "El correo ingresado no existe.";
            }
            $stmt->close();
        } else {
            $mensaje = "Por favor, completa todos los campos.";
        }
    }
}
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