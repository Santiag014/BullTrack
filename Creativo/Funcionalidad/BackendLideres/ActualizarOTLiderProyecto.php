<?php
// Inicializar un array para la respuesta
$response = [];

session_start();

// Incluir la conexión a la base de datos
include '../../../ConexionesBD/ConexionBDBullTrack.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];
    $id_USER = $_SESSION['id'];

    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por POST
    $id_proyecto = $_POST['id_Proyecto'];
    $fechaEntregaComercial = $_POST['DateEntregaComercial'];
    $fechaSocializacion = $_POST['DateFechaSocializacion'];
    $fechaEntregaLink = $_POST['DateEntregaLink'];
    $artesProyecto = $_POST['artesCreativo'];
    $linkProyecto = $_POST['linkProyecto'];
    $horasTrabajadas = $_POST['HorasTrabajadas'];
    $horasExtra = $_POST['HorasExtra'];
    $estadoProyecto = $_POST['EstadoProyecto'];

    // Primera consulta: Actualizar SeguimientoCreativo
    $sqlCreativo = "UPDATE SeguimientoCreativo 
                    SET dateEntrega = ?, 
                        dateSocializacion = ?, 
                        artesProyecto = ?, 
                        linkProyecto = ?, 
                        dateLinkProyecto = ?,
                        EstadoProyecto = ?,
                        dateUpdate = Now()
                    WHERE id = ?";
    $stmtCreativo = $conexion_bull->prepare($sqlCreativo);

    if ($stmtCreativo) {
        $stmtCreativo->bind_param(
            "ssssssi", 
            $fechaEntregaComercial, 
            $fechaSocializacion, 
            $artesProyecto, 
            $linkProyecto, 
            $fechaEntregaLink, 
            $estadoProyecto, 
            $id_proyecto
        );

        if ($stmtCreativo->execute()) {
            $response['seguimiento_creativo'] = "Datos del proyecto actualizados con éxito.";
        } else {
            $response['seguimiento_creativo'] = "Error al actualizar los datos del proyecto: " . $stmtCreativo->error;
        }

        $stmtCreativo->close();
    } else {
        $response['seguimiento_creativo'] = "Error en la preparación de la declaración: " . $conexion_bull->error;
    }

    // Segunda consulta: Actualizar CreativosHoras
    $sqlHoras = "UPDATE CreativosHoras 
                 SET horasTrabajadas = ?, 
                     horasExtras = ?,
                     dateUpdate = Now()
                 WHERE usuario_id = ? AND id_seguimiento_creativo = ?";
    $stmtHoras = $conexion_bull->prepare($sqlHoras);

    if ($stmtHoras) {
        $stmtHoras->bind_param(
            "iiis", 
            $horasTrabajadas, 
            $horasExtra, 
            $id_USER, 
            $id_proyecto
        );

        if ($stmtHoras->execute()) {
            if ($stmtHoras->affected_rows > 0) {
                $response['creativos_horas'] = "Horas del creativo actualizadas con éxito.";
            } else {
                $response['creativos_horas'] = "No se encontraron filas para actualizar en CreativosHoras.";
            }
        } else {
            $response['creativos_horas'] = "Error al actualizar las horas del creativo: " . $stmtHoras->error;
        }

        $stmtHoras->close();
    } else {
        $response['creativos_horas'] = "Error en la preparación de la declaración para CreativoHoras: " . $conexion_bull->error;
    }
}

// Cerrar la conexión
$conexion_bull->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
