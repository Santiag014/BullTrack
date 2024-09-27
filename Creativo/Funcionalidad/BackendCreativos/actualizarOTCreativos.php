<?php

session_start();

// Inicializar un array para la respuesta
$response = ['success' => true, 'message' => ''];

// Incluir la conexión a la base de datos
include '../../../ConexionesBD/ConexionBDBullTrack.php';

// Comprobar si el usuario está autenticado
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];
    $id_USER = $_SESSION['id'];

    $_SESSION['datos_usuario'] = [
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    ];
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_proyecto = $_POST['id_Proyecto']; // ID de la tabla SeguimientoCreativo
    $horasTrabajadas = $_POST['HorasTrabajadas'];
    $horasExtra = $_POST['HorasExtra'];

    // SQL para verificar si existen filas para actualizar
    $checkQuery = "SELECT * FROM CreativosHoras WHERE usuario_id = ? AND id_seguimiento_creativo = ?";
    $stmtCheck = $conexion_bull->prepare($checkQuery);
    $stmtCheck->bind_param("is", $id_USER, $id_proyecto);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    // Verificar si se encontró alguna fila
    if ($result->num_rows === 0) {
        $response['success'] = false;
        $response['message'] .= "No se encontró ninguna fila con esos parámetros.";
        echo json_encode($response);
        exit;
    }
    $stmtCheck->close();

    // SQL para actualizar las horas en la tabla CreativosHoras
    $sqlHoras = "UPDATE CreativosHoras 
                 SET horasTrabajadas = ?, 
                     horasExtras = ? 
                 WHERE usuario_id = ? AND id_seguimiento_creativo = ?";

    // Preparar la declaración para el UPDATE en CreativosHoras
    $stmtHoras = $conexion_bull->prepare($sqlHoras);

    if (!$stmtHoras) {
        // Respuesta en caso de error al preparar la declaración
        $response['success'] = false;
        $response['message'] = "Error en la preparación de la declaración para CreativosHoras: " . $conexion_bull->error;
        echo json_encode($response);
        exit; // Terminar el script
    }

    // Asociar los parámetros al UPDATE en CreativosHoras
    $stmtHoras->bind_param("iiis", $horasTrabajadas, $horasExtra, $id_USER, $id_proyecto);

    // Ejecutar la declaración para CreativosHoras
    if ($stmtHoras->execute()) {
        // Verificar si se actualizó alguna fila
        if ($stmtHoras->affected_rows > 0) {
            $response['message'] .= "Horas del creativo actualizadas con éxito.";
        } else {
            $response['success'] = false;
            $response['message'] .= "No se encontraron filas para actualizar en CreativosHoras.";
        }
    } else {
        $response['success'] = false;
        $response['message'] .= "Error al actualizar las horas del creativo: " . $stmtHoras->error;
    }

    // Cerrar la declaración para CreativosHoras
    $stmtHoras->close();
}

// Cerrar la conexión
$conexion_bull->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
