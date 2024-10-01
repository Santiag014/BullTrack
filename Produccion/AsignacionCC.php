<?php
session_start();
include '../ConexionesBD/ConexcionDBcrm.php';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];


    // Almacenar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}

// Cargar los usuarios
$sql = "SELECT users.id, users.name FROM `users`
        JOIN roles_user ON users.rol = roles_user.id
        WHERE roles_user.id = 7;"; 
$resultado = $conexion->query($sql); 

// Inicializar el ID de usuario
$userId = null;

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Obtener el primer registro
    $primerRegistro = $resultado->fetch_assoc();
    $userId = intval($primerRegistro['id']); // Guardar el ID del primer usuario

    // También puedes mostrar la lista de usuarios aquí
    $resultado->data_seek(0); // Reiniciar el puntero del resultado
}


if (isset($_POST['userId']) && is_numeric($_POST['userId'])) {
    $userId = intval($_POST['userId']);
    
    // Consulta usando prepared statement para mayor seguridad
    $sql = "SELECT presupuesto_proyecto.id, presupuesto_proyecto.cod_cc, users.name  
            FROM `presupuesto_proyecto`
            JOIN users ON presupuesto_proyecto.productor = users.id
            WHERE users.id = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            echo "<div class='registroCC_1' style='color: #fff;' data-registro-id='" . htmlspecialchars($row['id']) . "'>";
            echo "Código CC: <span class='codigoCC_1'>" . htmlspecialchars($row['cod_cc']) . "</span>";
            echo "</div>";
        }
        exit; // Asegúrate de detener la ejecución aquí
    } else {
        echo "<div class='registroCC_1'>Este Usuario no Tiene Ningún Registro</div>";
        exit; // Detiene la ejecución
    }
} else {
    //echo "<div class='registroCC'>Error: No se recibió un ID de usuario válido.</div>";
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
    <script src="../Produccion/Funcionalidad/FuncionalidadAsignacionCC/Funcionalidad.js" defer></script>
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
                    <div class="TipoGrafia_Rol"><?php echo $rol_user; ?></div>   
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
                <div class="ContainerPropuestasComercial">
                    <div class="FormularioPropuestasComercial">
                        <div class="FormProduccion">
                            <div class="ParteSuperiorPropuesta">
                                <div class="InformacionProducccion">
                                    <h2>Asignacion Centro de Costos</h2>
                                </div>
                            </div>
                            <div class="ParteCentroCostosProduccion">
                                <div class="divCentroCostos1">
                                    <input type="text" class="InputCentroCostos_2" placeholder="Buscar por Códico CC">
                                    <div class="ResultadosCentroCostos_1">
                                        <div class="registroCC_1"></div>
                                    </div>
                                </div>

                                <div class="divBotonesCentroCostos">
                                    <div class="BotonCC" onclick="AsignarCC()">
                                        <img src="../Media/Iconos/asignar_boton.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Asignar</span>
                                    </div>
                                    <div class="BotonCC" onclick="LiberarCC()">
                                        <img src="../Media/Iconos/liberar.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Liberar</span>
                                    </div>
                                </div>

                                <div class="divCentroCostos2">
                                    <input type="text" class="InputCentroCostos_2" placeholder="Buscar por Código CC">
                                    <div class="ResultadosCentroCostos_2">
                                        <?php
                                            // Consulta usando prepared statement para mayor seguridad
                                            $sql = "SELECT presupuesto_proyecto.id, presupuesto_proyecto.cod_cc  
                                                    FROM presupuesto_proyecto
                                                    WHERE presupuesto_proyecto.productor IS NULL AND presupuesto_proyecto.cod_cc IS NOT NULL AND presupuesto_proyecto.estado_id = '1' ";

                                            // Prepara y ejecuta la consulta
                                            $stmt = $conexion->prepare($sql);
                                            $stmt->execute();
                                            $resultado = $stmt->get_result();

                                            // Verifica si hay resultados
                                            if ($resultado->num_rows > 0) {
                                                // Itera sobre los resultados y los muestra en el HTML
                                                while($row = $resultado->fetch_assoc()) {
                                                    echo "<div class='registroCC_2' data-registro-id='" . htmlspecialchars($row['id']) . "'>";
                                                    echo "Código CC: <span class='codigoCC_2'>" . htmlspecialchars($row['cod_cc']) . "</span>";
                                                    echo "</div>";
                                                }
                                            } else {
                                                // Muestra un mensaje si no hay registros
                                                echo "<div class='registroCC'>No se encontraron registros</div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" id="searchInput" placeholder="Buscar Productor...">
                            </div>
                                <div class="Lista">
                                    <ul>
                                    <?php   
                                        // Cargar los usuarios
                                        $sql = "SELECT users.id, users.name FROM `users`
                                                JOIN roles_user ON users.rol = roles_user.id
                                                WHERE roles_user.id = 7;"; 
                                        $resultado = $conexion->query($sql); 

                                        // Inicializar el ID de usuario
                                        $userId = null;

                                        // Verificar si hay resultados
                                        if ($resultado->num_rows > 0) {
                                            // Obtener el primer registro
                                            $primerRegistro = $resultado->fetch_assoc();
                                            $userId = intval($primerRegistro['id']); // Guardar el ID del primer usuario

                                            // También puedes mostrar la lista de usuarios aquí
                                            $resultado->data_seek(0); // Reiniciar el puntero del resultado
                                        }
                                    ?>
                                                <?php 
                                                // Iterar sobre los resultados de la consulta
                                                if ($resultado->num_rows > 0) {
                                                    while($row = $resultado->fetch_assoc()) {
                                                ?>
                                                    <li data-id="<?php echo $row['id']; ?>">
                                                        <div class="productor-item">
                                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">
                                                                <?php echo htmlspecialchars($row['name']); ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php 
                                                    }
                                                } else {
                                                    echo "<li>No se encontraron usuarios</li>";
                                                }
                                        ?>
                                    </ul>
                                </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>