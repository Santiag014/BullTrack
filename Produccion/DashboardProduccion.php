<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];

    // Almacenar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <script src="../Produccion/Funcionalidad/FuncionalidadAsignacionCC/Funcionalidad.js"></script>
</head>
<body>
    <div class="background-image" style="background-image: url(../Media/FonfoDash.jpg);"></div>
    <div class="GridContanier">
    <div class="GridInformacionUsuario">
            <div class="Marca">
                <img src="../Media/LogoBull_2.png" alt="FotoBullMarketing" class="logo_image_Dashboard">
            </div>
            <div class="InformacionDashboar">
                <div class="FotoUsuarioDashboard">
                    <div class="TipoGrafia_App"> <strong>BullTrack</strong> <br/> App Seguimiento Interno</div>
                    <img src="../Media/fotoPerfil.jpg" alt="FotoBullMarketing" class="logo_image_Dashboard">
                    <div class="TipoGrafia"><?php echo $NombreUsuario; ?></div>
                    <div class="TipoGrafia"><?php echo $rol_user; ?></div>   
                </div>
                <div class="InformacionModulos">
                    <div class="ModulosDash" onclick="DashboardGerencial()">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Dashboard Gerencial</span>
                    </div>
                    <div class="ModulosDash" onclick="DashboardProduccion()">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Dashboard Producción</span>
                    </div>
                    <div class="ModulosDash" onclick="AsignaccionCC()">
                        <img src="../Media/Iconos/Avances.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Asignación de CC</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="GridHeaderApp">
            <!-- Breadcrumbs component will be rendered here -->
        </div>

        <div class="GridHeaderApp_2">
            <div class="BotonSalir" onclick="RedirigirLogin()">
                <img src="../Media/Iconos/Salir.png" alt="local-icon" width="20" height="20" class="local-icon">
                <span>Salir</span>
            </div>
        </div>
        
        <div class="GridContentApp">
            <div class="background-image_2">
                <div class="ContainerDashboradInicial">
                    <div class="ConatinerIframeInicial">
                        <div class="FormContactos">
                        <iframe 
                            title="Parisos-Corona-Promo-Corona-2024" 
                            width="600" 
                            height="373.5" 
                            src="https://app.powerbi.com/view?r=eyJrIjoiYzU4NGQ4ZGUtMWYwZi00MGI3LWEyZWYtOTIwNzcxNDE3ZjRkIiwidCI6Ijk2OWUxYWZhLTM2YWItNGQ5ZS1iYmM2LWU5Y2U3ZWE0N2U5OSIsImMiOjR9&navContentPaneEnabled=false&filterPaneEnabled=false&zoomSliderEnabled=false&setZoomLevel=100" 
                            frameborder="0" 
                            style="border: none;" 
                            allowFullScreen="true">
                        </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Creativo//JavaScript/FuncionalidadCreativo.js"></script>
</body>
</html>