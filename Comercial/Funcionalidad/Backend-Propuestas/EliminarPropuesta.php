<?php
include '../../../ConexionesBD/ConexionBDBullTrack.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proyecto = $_POST['id'] ?? null;

    if (!$id_proyecto) {
        echo json_encode(['success' => false, 'message' => 'ID de proyecto no proporcionado']);
        exit;
    }

    // Preparar la consulta SQL para actualizar `isDeleted` y `dateDeleted`
    $sql_contacto = "UPDATE SeguimientoComercial SET isDeleted = 1, dateDeletd = NOW() WHERE id = ?";
    
    if ($stmt_contacto = $conexion_bull->prepare($sql_contacto)) {
        $stmt_contacto->bind_param("i", $id_proyecto);
        if ($stmt_contacto->execute()) {
            $response['success'] = true;
            $response['message'] = 'Proyecto actualizado con éxito';
        } else {
            $response['message'] = 'Error al actualizar el proyecto: ' . $stmt_contacto->error;
        }
        $stmt_contacto->close();
    } else {
        $response['message'] = 'Error en la consulta SQL: ' . $conexion_bull->error;
    }

    $conexion_bull->close();
} else {
    $response['message'] = 'Método no permitido';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
