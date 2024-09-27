<?php
// Mostrar todos los errores y advertencias
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

try {
    // Incluir el archivo de conexión a la base de datos
    include '../../../ConexionesBD/ConexionBDBullTrack.php';
    
    // Iniciar la sesión
    session_start();

    // Verificar si la sesión contiene los datos necesarios
    if (!isset($_SESSION['id'])) {
        throw new Exception("Sesión no iniciada o datos de sesión faltantes");
    }

    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];
    $id_BULL = $_SESSION['id_user_bulltrack'];

    // Guardar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
        'id_bull' => $id_BULL
    );

    // Verificar si la solicitud es POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no válido");
    }

    // Variables para el segundo inserto (SeguimientoCreativo)
    $brief = $_POST['Brief'] ?? '';
    $objetivosBrief = $_POST['ObjetivosBrief'] ?? '';
    $tipoCliente = $_POST['tipoCliente'] ?? '';
    $entregables = $_POST['Entregables'] ?? '';
    $fechaEntregaCliente = $_POST['dateEntregaCliente'] ?? '';
    $datosAdicionales = $_POST['dateEntregaCliente'] ?? '';
    $id_proyecto = $_POST['id'] ?? null;

    $EstadoProyecto = 'Sin Asignar';

    // Iniciar una transacción para asegurar la consistencia en las inserciones
    $conexion_bull->begin_transaction();

    // Inserción en la tabla Seguimiento Creativo
    $sql2 = "INSERT INTO SeguimientoCreativo (nombreBrief, objetivoBrief, TipoCliente, tipoEntregables, dateEntrega, id_comercial, Created, EstadoProyecto) 
    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";


    $stmt2 = $conexion_bull->prepare($sql2);
    $stmt2->bind_param("sssssss", $brief, $objetivosBrief, $tipoCliente, $entregables, $fechaEntregaCliente, $id_proyecto, $EstadoProyecto);
    $stmt2->execute();

    // Confirmar la transacción
    $conexion_bull->commit();

    // Respuesta de éxito
    $response = ["success" => true, "message" => "Datos insertados correctamente"];
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    if (isset($conexion_bull)) {
        $conexion_bull->rollback();
    }

    // Respuesta de error
    $response = ["success" => false, "message" => $e->getMessage()];
} finally {
    // Cerrar las sentencias preparadas y la conexión a la base de datos
    if (isset($stmt1)) {
        $stmt1->close();
    }
    if (isset($stmt2)) {
        $stmt2->close();
    }
    if (isset($conexion_bull)) {
        $conexion_bull->close();
    }
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
exit;
?>
