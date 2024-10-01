<?php
// Inicializar un array para la respuesta
$response = [];

// Incluir la conexión a la base de datos
include '../../../ConexionesBD/ConexionBDBullTrack.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del proyecto
    $id_proyecto = $_POST['id_Proyecto'];
    $EstadoPropuesta = "En Producción"; // Definir el estado de la propuesta a "En Producción"

    // Obtener el ID del líder seleccionado
    $lider_proyecto = $_POST['liderId'];

    // Obtener los creativos seleccionados (puede haber múltiples)
    $creativos_proyecto = isset($_POST['CreativosProyecto']) ? $_POST['CreativosProyecto'] : [];

    // Preparar una sentencia SQL para la inserción de creativos
    $sql = "INSERT INTO CreativosHoras (id_seguimiento_creativo, usuario_id, horasTrabajadas, horasExtras, rolCreativos, dateCreated) VALUES (?, ?, ?, ?, ?, NOW())";

    // Usar una declaración preparada
    $stmt = $conexion_bull->prepare($sql);

    if (!$stmt) {
        // Respuesta en caso de error al preparar la declaración
        $response['success'] = false;
        $response['message'] = "Error en la preparación de la declaración: " . $conexion_bull->error;
        echo json_encode($response);
        exit; // Terminar el script
    }

    // Bucle para insertar los creativos
    foreach ($creativos_proyecto as $usuario_id) {
        // Rol para creativos (0)
        $rolCreativos = 0; 

        // Valores nulos para horas
        $horasTrabajadas = 0;
        $horasExtras = 0;

        // Asociar los parámetros
        $stmt->bind_param("iiiii", $id_proyecto, $usuario_id, $horasTrabajadas, $horasExtras, $rolCreativos);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['messages'][] = "Registro de creativo insertado exitosamente para usuario_id: $usuario_id con rol $rolCreativos.";
        } else {
            $response['success'] = false;
            $response['messages'][] = "Error al insertar creativo (rol $rolCreativos): " . $stmt->error;
        }
    }

    // Insertar el líder una vez
    $rolLider = 1; // Definir el rol del líder
    $horasTrabajadasLider = 0; // Valores nulos para horas
    $horasExtrasLider = 0; // Valores nulos para horas extras

    // Asociar los parámetros para el líder
    $stmt->bind_param("iiiii", $id_proyecto, $lider_proyecto, $horasTrabajadasLider, $horasExtrasLider, $rolLider);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['messages'][] = "Registro de líder insertado exitosamente para usuario_id: $lider_proyecto con rol $rolLider.";
    } else {
        $response['success'] = false;
        $response['messages'][] = "Error al insertar líder (rol $rolLider): " . $stmt->error;
    }

    // Si las inserciones fueron exitosas, actualizar el EstadoPropuesta en la tabla SeguimientoCreativo
    if ($response['success'] === true) {
        // Preparar la consulta para actualizar el EstadoPropuesta
        $update_sql = "UPDATE SeguimientoCreativo SET EstadoProyecto = ? WHERE id = ?";

        // Usar una declaración preparada para el UPDATE
        $update_stmt = $conexion_bull->prepare($update_sql);

        if (!$update_stmt) {
            $response['success'] = false;
            $response['message'] = "Error en la preparación de la declaración de actualización: " . $conexion_bull->error;
            echo json_encode($response);
            exit; // Terminar el script
        }

        // Asociar los parámetros (EstadoPropuesta y id_proyecto)
        $update_stmt->bind_param("si", $EstadoPropuesta, $id_proyecto);

        // Ejecutar la consulta de actualización
        if ($update_stmt->execute()) {
            $response['success'] = true;
            $response['messages'][] = "Estado de la propuesta actualizado a 'En Producción' para id_proyecto: $id_proyecto.";
        } else {
            $response['success'] = false;
            $response['messages'][] = "Error al actualizar el estado de la propuesta: " . $update_stmt->error;
        }

        // Cerrar la declaración de actualización
        $update_stmt->close();
    }

    // Cerrar la declaración de inserción
    $stmt->close();
}

// Cerrar la conexión
$conexion_bull->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
