<?php
// Datos de conexión
$host = '82.197.82.76'; // Nombre del servidor
$usuario = 'u315067549_Editor'; // Nombre de usuario
$password = 'Sa.14012006.'; // Contraseña
$base_datos = 'u315067549_BullTrack'; // Nombre de la base de datos

// Crear una conexión
$conexion_bull = new mysqli($host, $usuario, $password, $base_datos);

// Comprobar la conexión
if ($conexion_bull->connect_error) {
    die("Error de conexión: " . $conexion_bull->connect_error);
}

// Si la conexión es exitosa, puedes continuar con tus consultas
echo "Conexión exitosa a la base de datos.";
?>
