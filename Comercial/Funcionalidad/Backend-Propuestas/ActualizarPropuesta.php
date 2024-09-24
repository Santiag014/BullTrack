<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    include '../../../ConexionesBD/ConexionBDBullTrack.php';

    session_start();

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $NombreUsuario = $_SESSION['NombreUsuario'];
        $CorreoUsuario = $_SESSION['CorreoUsuario'];
        $rol_user = $_SESSION['NombreRol'];
        $id_rol = $_SESSION['id_rol'];
        $id_CRM = $_SESSION['id_CRM'];
        $id_BULL = $_SESSION['id_user_bulltrack'];

        $_SESSION['datos_usuario'] = array(
            'id' => $id,
            'nombre' => $NombreUsuario,
            'correo' => $CorreoUsuario,
            'rol_user' => $rol_user,
            'id_bull' => $id_BULL
        );
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_proyecto = $_POST['id_Proyecto'];
        $nombreProyecto = $_POST['NombreProyecto'];
        $descripcionProyecto = $_POST['DescipcionProyecto'];
        $unidadNegocio = $_POST['UnidadNegocio'];
        $formatoProceso = $_POST['FormatoProceso'];
        $estadoPropuesta = $_POST['estadoPropuesta'];
        $ciudadesImpacto = $_POST['CiudadesImpacto'];
        $valorPropuesta = $_POST['ValorPropuesta'];
        $fechaEntregaEconomica = $_POST['FechaEntregaEconomica'];
        $contacto1 = $_POST['Contacto_1'];
        $contacto2 = $_POST['Contacto_2'];
        $observacion1 = $_POST['Observación_1'];
        $observacion2 = $_POST['Observación_2'];
        $archivosAdjuntosComercial = $_POST['ArchivosAdjuntosComercial'];
        $necesidadOT = $_POST['NecesidadOTSelect'];

        $brief = $_POST['Brief'];
        $objetivosBrief = $_POST['ObjetivosBrief'];
        $tipoCliente = $_POST['tipoCliente'];
        $entregables = $_POST['Entregables'];
        $fechaEntregaCliente = $_POST['dateEntregaCliente'];

        // Verificar si id_proyecto existe en SeguimientoComercial
        $sqlVerify = "SELECT id FROM SeguimientoComercial WHERE id = ?";
        $stmtVerify = $conexion_bull->prepare($sqlVerify);
        $stmtVerify->bind_param("i", $id_proyecto);
        $stmtVerify->execute();
        $stmtVerify->store_result();

        if ($stmtVerify->num_rows === 0) {
            throw new Exception("El id_comercial proporcionado no existe en SeguimientoComercial.");
        }
        $stmtVerify->close();

        $sql1 = "UPDATE SeguimientoComercial 
                 SET 
                     nombreProyecto = ?, 
                     descripcionProyecto = ?, 
                     valorProyecto = ?, 
                     estadoPropuesta = ?,
                     dateEntregaEconomicaCliente = ?,
                     medioContacto1 = ?, 
                     medioContacto2 = ?,
                     observacionProyecto1 = ?, 
                     observacionProyecto2 = ?, 
                     id_unidadNegocio = ?, 
                     formatoProceso = ?, 
                     archivosAdjuntos = ?, 
                     NecesitaOT = ?, 
                     CiudadesImpacto = ? 
                 WHERE id = ?";

        $conexion_bull->begin_transaction();
        
        $stmt1 = $conexion_bull->prepare($sql1);
        $stmt1->bind_param("ssssssssssssssi", $nombreProyecto, $descripcionProyecto, $valorPropuesta, $estadoPropuesta, $fechaEntregaEconomica, $contacto1, $contacto2, $observacion1, $observacion2, $unidadNegocio, $formatoProceso, $archivosAdjuntosComercial, $necesidadOT, $ciudadesImpacto, $id_proyecto);
        $stmt1->execute();

        if ($necesidadOT === 'Si') {
            $sqlCheck = "SELECT id_comercial FROM SeguimientoCreativo WHERE id_comercial = ?";
            $stmtCheck = $conexion_bull->prepare($sqlCheck);
            $stmtCheck->bind_param("i", $id_proyecto);
            $stmtCheck->execute();
            $stmtCheck->store_result();

            if ($stmtCheck->num_rows > 0) {
                $sql2 = "UPDATE SeguimientoCreativo 
                         SET 
                             nombreBrief = ?, 
                             objetivoBrief = ?, 
                             TipoCliente = ?, 
                             tipoEntregables = ?, 
                             dateEntrega = ? 
                         WHERE id_comercial = ?";
                $stmt2 = $conexion_bull->prepare($sql2);
                $stmt2->bind_param("sssssi", $brief, $objetivosBrief, $tipoCliente, $entregables, $fechaEntregaCliente, $id_proyecto);
                $stmt2->execute();
            } else {
                $sql2 = "INSERT INTO SeguimientoCreativo (nombreBrief, objetivoBrief, TipoCliente, tipoEntregables, dateEntrega, id_comercial) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt2 = $conexion_bull->prepare($sql2);
                $stmt2->bind_param("sssssi", $brief, $objetivosBrief, $tipoCliente, $entregables, $fechaEntregaCliente, $id_proyecto);
                $stmt2->execute();
            }
            $stmtCheck->close();
        } elseif ($necesidadOT === 'No') {
            $sqlCheck = "SELECT id_comercial FROM SeguimientoCreativo WHERE id_comercial = ?";
            $stmtCheck = $conexion_bull->prepare($sqlCheck);
            $stmtCheck->bind_param("i", $id_proyecto);
            $stmtCheck->execute();
            $stmtCheck->store_result();

            if ($stmtCheck->num_rows > 0) {
                $sqlDelete = "UPDATE SeguimientoCreativo SET isDeleted = 1, dateDeletd = NOW() WHERE id_comercial = ?";
                $stmtDelete = $conexion_bull->prepare($sqlDelete);
                $stmtDelete->bind_param("i", $id_proyecto);
                $stmtDelete->execute();
                $stmtDelete->close();
            }
            $stmtCheck->close();
        }

        $conexion_bull->commit();

        $response = ["success" => true, "message" => "Actualización exitosa"];
    } else {
        throw new Exception("Método de solicitud no válido");
    }
} catch (Exception $e) {
    if (isset($conexion_bull)) {
        $conexion_bull->rollback();
    }
    $response = ["success" => false, "message" => $e->getMessage()];
} finally {
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

echo json_encode($response);
exit;
