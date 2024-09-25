<?php

include '../../ConexionesBD/ConexcionDBcrm.php';

// Verifica si los datos se enviaron correctamente mediante POST
if (isset($_POST['registroId'])) {
    // Obtén el valor de registroId enviado desde el JavaScript
    $registroId = $_POST['registroId'];

    // Actualizar la columna 'productor' en la tabla 'presupuesto_proyecto' para que sea NULL donde el 'id' sea igual a registroIdSeleccionado
    $sql = "UPDATE presupuesto_proyecto SET productor = NULL WHERE id = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($sql)) {

        // Bindear el parámetro (i = integer)
        $stmt->bind_param("i", $registroId); 

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro actualizado correctamente. Usuario eliminado.";
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
