<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../../ConexionesBD/ConexionBDBullTrack.php';

function obtenerCreativos() {
    global $conexion_bull;
    $options = "";  // Inicializar la variable options como string vacío

    // Asegúrate de que el nombre de la columna es 'NombreUsuario' (en singular)
    $sql = "SELECT id, NombreUsuario FROM Usuarios WHERE id_rol = 2 OR id_rol = 4";
    $resultado = mysqli_query($conexion_bull, $sql);

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            // Generar etiquetas <option> con la información correcta
            $options .= "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['NombreUsuario']) . "</option>";
        }
        mysqli_free_result($resultado);
    } else {
        // Manejar el error si la consulta falla
        error_log("Error en la consulta SQL: " . mysqli_error($conexion_bull));
    }

    return $options;  // Retornar solo las opciones
}

echo obtenerCreativos();  // Imprimir solo las opciones para AJAX
header('Content-Type: application/json');
echo json_encode($respuesta);

?>
