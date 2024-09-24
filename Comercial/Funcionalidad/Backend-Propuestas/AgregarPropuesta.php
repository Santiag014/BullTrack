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

    // Capturar los valores del formulario
    $nombreProyecto = $_POST['NombreProyecto'] ?? '';
    $descripcionProyecto = $_POST['DescipcionProyecto'] ?? '';
    $unidadNegocio = $_POST['UnidadNegocio'] ?? '';
    $formatoProceso = $_POST['FormatoProceso'] ?? '';
    $estadoPropuesta = $_POST['estadoPropuesta'] ?? '';
    $ciudadesImpacto = $_POST['CiudadesImpacto'] ?? '';
    $valorPropuesta = $_POST['ValorPropuesta'] ?? '';
    $fechaEntregaEconomica = $_POST['FechaEntregaEconomica'] ?? '';
    $contacto1 = $_POST['Contacto_1'] ?? '';
    $contacto2 = $_POST['Contacto_2'] ?? '';
    $observacion1 = $_POST['Observación_1'] ?? '';
    $observacion2 = $_POST['Observación_2'] ?? '';
    $archivosAdjuntosComercial = $_POST['ArchivosAdjuntosComercial'] ?? '';
    $necesidadOT = $_POST['NecesidadOTSelect'] ?? '';
    $id_contacto_crm = $_POST['id_contacto_crm'] ?? '';

    // Variables para el segundo inserto (SeguimientoCreativo)
    $brief = $_POST['Brief'] ?? '';
    $objetivosBrief = $_POST['ObjetivosBrief'] ?? '';
    $tipoCliente = $_POST['tipoCliente'] ?? '';
    $entregables = $_POST['Entregables'] ?? '';
    $fechaEntregaCliente = $_POST['dateEntregaCliente'] ?? '';

    // Iniciar una transacción para asegurar la consistencia en las inserciones
    $conexion_bull->begin_transaction();

    // Inserción en la tabla SeguimientoComercial
    $sql1 = "INSERT INTO SeguimientoComercial 
            (id_user, nombreProyecto, descripcionProyecto, valorProyecto, estadoPropuesta, dateEntregaEconomicaCliente, medioContacto1, medioContacto2, observacionProyecto1, observacionProyecto2, id_contacto, id_unidadNegocio, formatoProceso, archivosAdjuntos, NecesitaOT, CiudadesImpacto, isDeleted) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0')";

    $stmt1 = $conexion_bull->prepare($sql1);
    $stmt1->bind_param("isssssssssssssis", $id_BULL, $nombreProyecto, $descripcionProyecto, $valorPropuesta, $estadoPropuesta, $fechaEntregaEconomica, $contacto1, $contacto2, $observacion1, $observacion2, $id_contacto_crm, $unidadNegocio, $formatoProceso, $archivosAdjuntosComercial, $necesidadOT, $ciudadesImpacto);
    $stmt1->execute();

    // Obtener el ID del último inserto en la tabla SeguimientoComercial
    $id_proyecto = $conexion_bull->insert_id;

    // Verificar si NecesitaOT es "Si"
    if ($necesidadOT === 'Si') {
        // Inserción en SeguimientoCreativo si se necesita OT
        $sql2 = "INSERT INTO SeguimientoCreativo (nombreBrief, objetivoBrief, TipoCliente, tipoEntregables, dateEntrega, id_comercial) 
                 VALUES (?, ?, ?, ?, ?, ?)";

        $stmt2 = $conexion_bull->prepare($sql2);
        $stmt2->bind_param("sssssi", $brief, $objetivosBrief, $tipoCliente, $entregables, $fechaEntregaCliente, $id_proyecto);
        $stmt2->execute();
    }

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