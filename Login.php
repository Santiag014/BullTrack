<?php
include './ConexionesBD/ConexionBDBullTrack.php';

$response = ['success' => false, 'error' => '', 'redirect' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correoUser = isset($_POST['emailUser']) ? $_POST['emailUser'] : null;
    $passwordUser = isset($_POST['ContraseñaUser']) ? $_POST['ContraseñaUser'] : null;

    if ($correoUser !== null && $passwordUser !== null) {
        $consultaLogin = "SELECT Usuarios.id, Usuarios.NombreUsuario, Usuarios.CorreoUsuario, Usuarios.PasswordUsuario, Usuarios.id_rol, Usuarios.id_CRM, Roles.NombreRol FROM Usuarios JOIN Roles ON Usuarios.id_rol = Roles.id WHERE correoUsuario = ? AND PasswordUsuario = ?";
        
        $stmt = $conexion_bull->prepare($consultaLogin);
        $stmt->bind_param("ss", $correoUser, $passwordUser);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $row = $resultado->fetch_assoc();
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['NombreUsuario'] = $row['NombreUsuario'];
            $_SESSION['CorreoUsuario'] = $row['CorreoUsuario'];
            $_SESSION['id_rol'] = $row['id_rol'];
            $_SESSION['NombreRol'] = $row['NombreRol'];
            $_SESSION['id_CRM'] = $row['id_CRM'];
            $_SESSION['id_user_bulltrack'] = $row['id'];

            $response['success'] = true;
            switch ($row['id_rol']) {
                case "3":
                case "1":
                case "6":
                    $response['redirect'] = "./Comercial/DashboardComercial.php";
                    break;
                case "5":
                    $response['redirect'] = "./Produccion/DashboardGerencia.php";
                    break;
                case "2":
                    $response['redirect'] = "./Creativo/ProyectosLideres.php";
                    break;
                case "4":
                    $response['redirect'] = "./Creativo/AsignarProyectos.php";
                    break; 
                default:
                    $response['error'] = "Rol de usuario no reconocido";
                    $response['success'] = false;
            }
        } else {
            $response['error'] = "Credenciales Incorrectas";
        }
    } else {
        $response['error'] = "Por favor, completa todos los campos";
    }
} else {
    $response['error'] = "Método de solicitud no válido";
}

echo json_encode($response);
?>