<?php
// // Asegúrate de incluir tu archivo de conexión a la base de datos
// include '../../ConexionesBD/ConexcionDBcrm.php';
// include '../../ConexionesBD/ConexionBDBullTrack.php';

// // Inicializar la respuesta
// $response = array('success' => false, 'message' => '');

// // Verificar si se recibieron los datos
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Recoger los datos del formulario
//     $id = $_POST['id'] ?? null;  // Usar null por defecto
//     $nombre = $_POST['nombre'] ?? '';
//     $apellido = $_POST['apellido'] ?? '';
//     $cargo = $_POST['cargo'] ?? '';
//     $celular = $_POST['celular'] ?? '';
//     $correo = $_POST['correo'] ?? '';
//     $empresa = $_POST['empresa'] ?? '';
//     $ciudad = $_POST['ciudad'] ?? '';
//     $direccion = $_POST['direccion'] ?? '';
//     $web = $_POST['web'] ?? '';
//     $nit = $_POST['NIT'] ?? '';  // Usar null por defecto
//     $razon_social = $_POST['razon_social'] ?? ''; // Usar null por defecto

//     // Preparar la consulta SQL
//     $sql = "UPDATE contactos SET 
//             nombre = ?, apellido = ?, cargo = ?, celular = ?, 
//             correo = ?, empresa = ?, ciudad = ?, direccion = ?, 
//             web = ? WHERE id = ?";
    
//     $sql_Actualizar_Bulltrack = "UPDATE contacto_crm SET nit_contacto = ?, razon_social_contacto = ?, 
//             id_usuario = ?, id_contactos_CRM WHERE id_contactos_CRM = ?";

//     // Preparar la sentencia
//     if ($stmt = $conexion->prepare($sql)) {
//         // Vincular los parámetros
//         $stmt->bind_param("sssssssssssi", $nombre, $apellido, $cargo, $celular, 
//                           $correo, $empresa, $ciudad, $direccion, 
//                           $web, $nit, $razon_social, $id);

//         // Ejecutar la consulta
//         if ($stmt->execute()) {
//             $response['success'] = true;
//             $response['message'] = 'Contacto actualizado con éxito';
//         } else {
//             $response['message'] = 'Error al actualizar el contacto: ' . $stmt->error;
//         }

//         // Cerrar la sentencia
//         $stmt->close();
//     } else {
//         $response['message'] = 'Error en la preparación de la consulta: ' . $conexion->error;
//     }

//     // Cerrar la conexión
//     $conexion->close();
// } else {
//     $response['message'] = 'Método de solicitud no válido';
// }

// // Enviar la respuesta como JSON
// header('Content-Type: application/json');
// echo json_encode($response);

// Incluir archivos de conexión a la base de datos
include '../../../ConexionesBD/ConexcionDBcrm.php';
include '../../../ConexionesBD/ConexionBDBullTrack.php';

// Iniciar sesión y obtener datos del usuario
session_start();
$id_BULL = $_SESSION['id_user_bulltrack'] ?? null;

// Configurar el manejo de errores y logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Función para logging
function logMessage($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'update_log.log');
}

// Inicializar la respuesta
$response = array('success' => false, 'message' => '');

// Verificar si se recibieron los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $empresa = $_POST['empresa'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $web = $_POST['web'] ?? '';
    $nit = $_POST['NIT'] ?? '';
    $razon_social = $_POST['razon_social'] ?? '';

    // Iniciar transacción
    $conexion->begin_transaction();
    $conexion_bull->begin_transaction();

    try {
        // Actualizar la tabla 'contactos'
        $sql = "UPDATE contactos SET 
                nombre = ?, apellido = ?, cargo = ?, celular = ?, 
                correo = ?, empresa = ?, ciudad = ?, direccion = ?, 
                web = ? WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssssi", $nombre, $apellido, $cargo, $celular, 
                          $correo, $empresa, $ciudad, $direccion, 
                          $web, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar contacto en CRM: " . $stmt->error);
        }

        logMessage("Contacto actualizado en CRM: ID_ContactoCRm $id");

        // Verificar si el contacto existe en 'contacto_crm'
        $sql_Verificar_CRM = "SELECT id_contactos_CRM FROM contacto_crm WHERE id_contactos_CRM = ?";
        $stmt_verificar = $conexion_bull->prepare($sql_Verificar_CRM);
        $stmt_verificar->bind_param("i", $id);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows > 0) {
            // Actualizar registro existente
            $sql_Actualizar_Bulltrack = "UPDATE contacto_crm SET 
                                        nit_contacto = ?, razon_social_contacto = ?, id_usuario = ?
                                        WHERE id_contactos_CRM = ?";
            $stmt_crm = $conexion_bull->prepare($sql_Actualizar_Bulltrack);
            $stmt_crm->bind_param("ssii", $nit, $razon_social, $id_BULL, $id);

            if (!$stmt_crm->execute()) {
                throw new Exception("Error al actualizar Conctacto BullTrack: " . $stmt_crm->error);
            }

            logMessage("Contacto Actualido en BullTrack: ID_ContactoCRm $id");
        } else {
            // Insertar nuevo registro
            $sql_Insertar_CRM = "INSERT INTO contacto_crm (nit_contacto, razon_social_contacto, id_usuario, id_contactos_CRM) 
                                VALUES (?, ?, ?, ?)";
            $stmt_insertar = $conexion_bull->prepare($sql_Insertar_CRM);
            $stmt_insertar->bind_param("ssii", $nit, $razon_social, $id_BULL, $id);

            if (!$stmt_insertar->execute()) {
                throw new Exception("Error al insertar nuevo Contacto en BullTrack: " . $stmt_insertar->error);
            }

            logMessage("Nuevo Registro Contacto BullTrack: ID_ContactoCRm $id");
        }

        // Si llegamos aquí, todo está bien, confirmar las transacciones
        $conexion->commit();
        $conexion_bull->commit();

        $response['success'] = true;
        $response['message'] = 'Contacto y CRM actualizados con éxito';
        logMessage("Actualización completa para ID_ContactoCRm $id");

    } catch (Exception $e) {
        // Si hay algún error, revertir las transacciones
        $conexion->rollback();
        $conexion_bull->rollback();

        $response['message'] = 'Error: ' . $e->getMessage();
        logMessage("Error en la actualización: " . $e->getMessage());
    }

    // Cerrar todas las sentencias y conexiones
    if (isset($stmt)) $stmt->close();
    if (isset($stmt_verificar)) $stmt_verificar->close();
    if (isset($stmt_crm)) $stmt_crm->close();
    if (isset($stmt_insertar)) $stmt_insertar->close();
    
    $conexion->close();
    $conexion_bull->close();

} else {
    $response['message'] = 'Método de solicitud no válido';
    logMessage("Intento de acceso con método no válido");
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
