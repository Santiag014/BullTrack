<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="./Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="./EstilosFuncionalidad/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="background-section">
            <div class="logo-container">
                <img src="./Media/BullTrack.png" alt="BullMarketing Logo" class="logo">
            </div>
        </div>
        <div class="form-section">
            <form id="login-form" method="post" action="index.php">
                <h2 class="inicio-seccion">Inicia Sesión</h2>
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="emailUser" required>
                    <div id="email-error" class="error-message"></div>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="ContraseñaUser" required>
                    <div id="password-error" class="error-message"></div>
                </div>
                <div class="olvidar-contraseña">
                    <span id="forget-password" class="forget-contraseña">Olvidé Mi Contraseña</span>
                </div>
                <div class="button-group">
                    <button type="submit" class="signin-btn">Sign In</button>
                </div>
                <div id="reset-message" class="success-message"></div>
                
                <!-- Mensaje de error -->
                <?php if (!empty($errorLogin)): ?>
                    <div class='error-message'><?php echo $errorLogin; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>


</html>

<?php
$errorLogin = '';

include './ConexionesBD/ConexionBDBullTrack.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $correoUser = isset($_POST['emailUser']) ? $_POST['emailUser'] : null;
    $passwordUser = isset($_POST['ContraseñaUser']) ? $_POST['ContraseñaUser'] : null;

    // Verificar que los campos no estén vacíos
    if ($correoUser !== null && $passwordUser !== null) {

        // Consulta a la BD para verificar las credenciales
        $consultaLogin = "SELECT * FROM Usuarios JOIN Roles ON Usuarios.id_rol = Roles.id WHERE correoUsuario = '$correoUser' AND PasswordUsuario = '$passwordUser'" ;
        $resultadoConsultaLogin = $conexion_bull->query($consultaLogin);

        // Validar el resultado de la consulta
        if ($resultadoConsultaLogin->num_rows == 1) {
            $row = $resultadoConsultaLogin->fetch_assoc();
            //var_dump($row);
            // Almacenar varios datos del usuario en la sesión
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['NombreUsuario'] = $row['NombreUsuario'];
            $_SESSION['CorreoUsuario'] = $row['CorreoUsuario'];
            $_SESSION['id_rol'] = $row['id_rol'];
            $_SESSION['NombreRol'] = $row['NombreRol'];

            var_dump($_SESSION);
            // Redirigir según el rol del usuario
            if ($row['id_rol'] == '1') {
                header("Location: ./Comercial/DashboardComercial.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $errorLogin = "Credenciales Incorrectas";
        }
    } else {
        $errorLogin = "Por favor, completa todos los campos";
    }
}
?>



