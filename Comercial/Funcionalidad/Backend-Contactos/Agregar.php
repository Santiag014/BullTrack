<?php

include '../../../ConexionesBD/ConexcionDBcrm.php';
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

    // Almacenar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
        'id_bull' => $id_BULL
    );
    //echo var_dump($_SESSION['datos_usuario'] );
}

// Inicializar la respuesta
$response = array('success' => false, 'message' => '');

// Verificar si se recibieron los datos a través de POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
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

    // Iniciar transacciones en ambas conexiones
    $conexion->begin_transaction();
    $conexion_bull->begin_transaction();

    // Preparar la primera consulta SQL para insertar el nuevo contacto en la primera base de datos
    $sql1 = "INSERT INTO contactos (nombre, apellido, cargo, celular, correo, empresa, ciudad, direccion, web, id_user) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la segunda consulta SQL para insertar NIT y razón social en la segunda base de datos
    $sql2 = "INSERT INTO contacto_crm (nit_contacto, razon_social_contacto, id_usuario, id_contactos_CRM) 
        VALUES (?, ?, ?, ?)";

    // Preparar la primera sentencia
    if ($stmt1 = $conexion->prepare($sql1)) {
        // Vincular parámetros para la primera consulta
        $stmt1->bind_param("sssssssssi", $nombre, $apellido, $cargo, $celular, $correo, $empresa, $ciudad, $direccion, $web, $id_CRM);

        // Ejecutar la primera consulta
        if ($stmt1->execute()) {
            // Obtener el ID del contacto recién insertado
            $id_contacto = $conexion->insert_id;

            // Muestra la consulta de la segunda inserción antes de ejecutarla
            "Consulta 2: INSERT INTO contacto_crm (nit_contacto, razon_social_contacto, id_usuario, id_contactos_CRM) 
            VALUES ('$nit', '$razon_social', '$id_BULL', '$id_contacto')<br/>";

            // Preparar la segunda sentencia en la segunda base de datos
            if ($stmt2 = $conexion_bull->prepare($sql2)) {
                // Vincular parámetros para la segunda consulta
                $stmt2->bind_param("ssii", $nit, $razon_social, $id_BULL, $id_contacto);

                // Ejecutar la segunda consulta
                if ($stmt2->execute()) {
                    // Ambas consultas se ejecutaron con éxito, confirmar las transacciones
                    $conexion->commit();
                    $conexion_bull->commit();
                    $response['success'] = true;
                    $response['message'] = 'Contacto y datos adicionales agregados con éxito';
                } else {
                    // Error en la segunda consulta, revertir ambas transacciones
                    $conexion->rollback();
                    $conexion_bull->rollback();
                    $response['message'] = 'Error al agregar datos adicionales: ' . $stmt2->error;
                }

                // Cerrar la segunda sentencia
                $stmt2->close();
            } else {
                // Error al preparar la segunda consulta
                $conexion->rollback();
                $conexion_bull->rollback();
                $response['message'] = 'Error al preparar la segunda consulta: ' . $conexion_bull->error;
            }
        } else {
            // Error al ejecutar la primera consulta, revertir la transacción
            $conexion->rollback();
            $conexion_bull->rollback();
            $response['message'] = 'Error al agregar el contacto: ' . $stmt1->error;
        }

        // Cerrar la primera sentencia
        $stmt1->close();
    } else {
        // Error al preparar la primera consulta
        $response['message'] = 'Error al preparar la primera consulta: ' . $conexion->error;
    }

    // Cerrar las conexiones
    $conexion->close();
    $conexion_bull->close();
} else {
    $response['message'] = 'Método de solicitud no válido';
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
