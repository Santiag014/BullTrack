<?php
// Datos de conexión
$host = '89.117.7.103'; // Nombre del servidor
$usuario = 'u630167073_root'; // Nombre de usuario
$password = 'I*1m?aUYg:'; // Contraseña
$base_datos = 'u630167073_CRM'; // Nombre de la base de datos

// Crear una conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Comprobar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>