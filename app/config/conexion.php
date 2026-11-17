<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "clothesstreet_db";
$port = 3307;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conexion = new mysqli($host, $user, $pass, $db, $port);
// 1. Verificar si hay error (y detener todo si falla)
// 1. Verificar si hay error (y detener todo si falla)
if ($conexion->connect_error) {
    // Registra el error técnico real en un log del servidor (no lo ve el usuario)
    error_log("Error de conexión BD: " . $conexion->connect_error);
    
    // Muestra un mensaje genérico y seguro al usuario final
    die("Error interno del servidor. Por favor, intente más tarde.");
}

// 2. Arreglar caracteres especiales (ñ, tildes)
$conexion->set_charset("utf8mb4");

// 3. Generación de Token CSRF (Fuera del if)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}
?>