<?php
// Datos de conexión
$host = '82.197.82.76'; // Nombre del servidor
$usuario = 'u315067549_Editor'; // Nombre de usuario
$password = 'Sa.14012006.'; // Contraseña
$base_datos = 'u315067549_BullTrack'; // Nombre de la base de datos

// Crear una conexión
$conexion_bull = new mysqli($host, $usuario, $password, $base_datos);

// Establecer la zona horaria manualmente usando un desplazamiento
$conexion_bull->query("SET time_zone = '-05:00'");

// Asegurarte de que PHP esté configurado para la misma zona horaria
date_default_timezone_set('America/Bogota');

// Comprobar la conexión
if ($conexion_bull->connect_error) {
    die("Error de conexión: " . $conexion_bull->connect_error);
}
?>
