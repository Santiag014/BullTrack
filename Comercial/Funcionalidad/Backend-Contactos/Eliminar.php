<?php
include '../../../ConexionesBD/ConexcionDBcrm.php';
include '../../../ConexionesBD/ConexionBDBullTrack.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_contacto = $_POST['id'] ?? null;

    if (!$id_contacto) {
        echo json_encode(['success' => false, 'message' => 'ID de contacto no proporcionado']);
        exit;
    }

    // Preparar la consulta SQL para eliminar el contacto específico de la tabla `contactos`
    $sql_contacto = "DELETE FROM contactos WHERE id = ?";
    
    if ($stmt_contacto = $conexion->prepare($sql_contacto)) {
        $stmt_contacto->bind_param("i", $id_contacto);
        if ($stmt_contacto->execute()) {
            // Ahora eliminar el registro de `contacto_crm`
            $sql_crm = "DELETE FROM contacto_crm WHERE id_contactos_CRM = ?";
            if ($stmt_crm = $conexion_bull->prepare($sql_crm)) {
                $stmt_crm->bind_param("i", $id_contacto);
                if ($stmt_crm->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Contacto y CRM eliminados con éxito';
                } else {
                    $response['message'] = 'Error al eliminar el contacto CRM: ' . $stmt_crm->error;
                }
                $stmt_crm->close();
            } else {
                $response['message'] = 'Error en la consulta SQL para eliminar CRM: ' . $conexion_bull->error;
            }
        } else {
            $response['message'] = 'Error al eliminar el contacto: ' . $stmt_contacto->error;
        }
        $stmt_contacto->close();
    } else {
        $response['message'] = 'Error en la consulta SQL: ' . $conexion->error;
    }

    $conexion->close();
    $conexion_bull->close();
} else {
    $response['message'] = 'Método no permitido';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
