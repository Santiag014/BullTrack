<?php

include '../../ConexionesBD/ConexcionDBcrm.php';

// Verifica si los datos se enviaron correctamente mediante POST
if (isset($_POST['userId']) && isset($_POST['registroId'])) {
    // Obtén los valores enviados desde el JavaScript
    $userId = $_POST['userId'];
    $registroId = $_POST['registroId'];

    // Actualizar la columna 'productor' en la tabla 'presupuesto_proyecto' donde el 'id' sea igual a registroIdSeleccionado
    $sql = "UPDATE presupuesto_proyecto SET productor = ? WHERE id = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($sql)) {

        // Bindear los parámetros (s = string, i = integer)
        $stmt->bind_param("ii", $userId, $registroId); 

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    echo "No se enviaron datos válidos.";
}
?>
