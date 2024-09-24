<?php
session_start();

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


// Consulta para iterar por Contactos de CRM
include '../ConexionesBD/ConexcionDBcrm.php';
// Consulta para iterar por Contactos de BullTrack
include '../ConexionesBD/ConexionBDBullTrack.php';

// Consulta para obtener contactos de CRM
$sql = "SELECT * FROM contactos WHERE id_user = $id_CRM";
$resultado = mysqli_query($conexion, $sql);

$info_completa = []; // Asegúrate de inicializar el array

if ($resultado) {
    if (mysqli_num_rows($resultado) > 0) {
        while ($contacto = mysqli_fetch_assoc($resultado)) {
            // Almacena el contacto original
            $contacto_completo = $contacto;
            
            // Obtén el ID del contacto
            $id_contacto = $contacto['id'];

            // Consulta adicional en BullTrack para obtener información relacionada
            $sql_1 = "SELECT      
                SeguimientoComercial.id,
                SeguimientoComercial.id_user,
                SeguimientoComercial.id_unidadNegocio,
                SeguimientoComercial.dateCreated,
                SeguimientoComercial.nombreProyecto,
                SeguimientoComercial.descripcionProyecto,
                SeguimientoComercial.valorProyecto,
                SeguimientoComercial.estadoPropuesta,
                SeguimientoComercial.dateEntregaEconomicaCliente,
                SeguimientoComercial.medioContacto1,
                SeguimientoComercial.medioContacto2,
                SeguimientoComercial.observacionProyecto1,
                SeguimientoComercial.observacionProyecto2,
                SeguimientoComercial.archivosAdjuntos,
                SeguimientoComercial.id_contacto,
                SeguimientoComercial.formatoProceso,
                SeguimientoComercial.NecesitaOT,
                SeguimientoComercial.CiudadesImpacto,
                contacto_crm.nit_contacto, 
                contacto_crm.razon_social_contacto,
                contacto_crm.id_contactos_CRM,
                SeguimientoCreativo.dateEntrega,
                SeguimientoCreativo.nombreBrief,
                SeguimientoCreativo.objetivoBrief,
                SeguimientoCreativo.tipoEntregables,
                SeguimientoCreativo.id_liderProyectoOT,
                SeguimientoCreativo.id_creativoOT,
                SeguimientoCreativo.artesProyecto,
                SeguimientoCreativo.linkProyecto,
                SeguimientoCreativo.dateLinkProyecto,
                SeguimientoCreativo.datosAdicionalesBrief,
                SeguimientoCreativo.dateEntregaCliente,
                SeguimientoCreativo.id_archivoAdjuntoCreativo,
                SeguimientoCreativo.dateSocializacion,
                SeguimientoCreativo.TipoCliente
            FROM SeguimientoComercial 
            JOIN contacto_crm ON SeguimientoComercial.id_contacto = contacto_crm.id
            LEFT JOIN SeguimientoCreativo ON SeguimientoComercial.id = SeguimientoCreativo.id_comercial
            WHERE contacto_crm.id_contactos_CRM = $id_contacto AND SeguimientoComercial.isDeleted = 0 AND SeguimientoComercial.NecesitaOT = 'Si' ;";
            
            $resultado2 = mysqli_query($conexion_bull, $sql_1);

            if ($resultado2) {
                // Almacena toda la información de proyectos
                $proyectos = [];
                if (mysqli_num_rows($resultado2) > 0) {
                    while ($proyecto = mysqli_fetch_assoc($resultado2)) {
                        $proyectos[] = $proyecto; // Almacena cada proyecto en un array
                    }
                    // Agrega los proyectos al contacto completo
                    $contacto_completo['proyectos'] = $proyectos;
                } else {
                    $contacto_completo['proyectos'] = []; // Si no hay proyectos, asigna un array vacío
                }
            } else {
                // Manejo de error para la segunda consulta
                $contacto_completo['error_bull'] = "Error en la consulta BullTrack: " . mysqli_error($conexion_bull);
            }
            
            // Agrega el contacto completo al array
            $info_completa[] = $contacto_completo;
        }
    } else {
        $info_completa['error'] = "No se encontraron contactos para el usuario.";
    }
} else {
    $info_completa['error'] = "Error en la consulta principal: " . mysqli_error($conexion);
}

// Mostrar resultados
//var_dump($info_completa);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <script src="./Funcionalidad/Funcionalidad-JS/FuncionalidadAvancesOT.js" defer></script>
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
                <div class="ModulosDash" onclick="RedirigirHome(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Home.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Home</span>
                    </div>
                    <div class="ModulosDash" onclick="ContactosCRM(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Contactos CRM</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirPropuestas(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Propuestas</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirAvancesOT(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Avances.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Avances OT</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="GridHeaderApp">
            <!-- Breadcrumbs component will be rendered here -->
        </div>
        <div class="GridHeaderApp_2">
            <div class="BotonSalir">
                <img src="../Media/Iconos/Salir.png" alt="local-icon" width="20" height="20" class="local-icon">
                <span>Salir</span>
            </div>
        </div>
        
        <div class="GridContentApp">
            <div class="background-image_2">
                <div class="ContainerContactosCRM">
                    <div class="FormularioContactos">
                        <div class="FormContactos">
                            <div class="ParteSuperiorContacto">
                                <div class="InformacionCliente">
                                    <h3>Información Avance OT</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <!-- <button class="BotonesFormulario">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button> -->
                                </div>
                            </div>
                            <form class="ParteFormularioOT">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="LiderProyecto">Lider Proyecto</label>
                                        <input 
                                            type="text" 
                                            id="LiderProyecto" 
                                            name="LiderProyecto"   
                                            readonly
                                            placeholder="Lider del Proyecto"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="CreativoProyecto">Creativo</label>
                                        <input 
                                            type="text" 
                                            id="CreativoProyecto" 
                                            name="CreativoProyecto" 
                                            readonly
                                            placeholder="Creativos del Proyecto"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Brief">Brief</label>
                                        <input 
                                            type="text" 
                                            id="Brief" 
                                            name="Brief"  
                                            readonly
                                            placeholder="Brief del Proyecto"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="ObjetivosBrief">Objetivo del Brief</label>
                                        <input 
                                            type="text" 
                                            id="ObjetivosBrief" 
                                            name="ObjetivosBrief"
                                            readonly
                                            placeholder="Objetivo del Brief"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="Link">Link</label>
                                        <input 
                                            type="text" 
                                            id="linkProyecto" 
                                            name="linkProyecto"
                                            readonly
                                            placeholder="Link del Proyecto"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="TipoCliente">Tipo de Cliente</label>
                                        <input 
                                            type="text" 
                                            id="TipoCliente" 
                                            name="TipoCliente"
                                            readonly
                                            placeholder="Tipo de Cliente"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="Entregables">Entregables</label>
                                        <input 
                                            type="text" 
                                            id="Entregables" 
                                            name="Entregables"
                                            readonly
                                            placeholder="Entregables"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DateEntregaComercial">Fecha Entrega Comercial</label>
                                        <input 
                                            type="datetime-local" 
                                            id="DateEntregaComercial" 
                                            name="DateEntregaComercial"
                                            readonly
                                            placeholder="Fecha de Entrega Comercial"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFechaSocializacion">Fecha Socialización</label>
                                        <input 
                                            type="datetime-local" 
                                            id="DateFechaSocializacion" 
                                            name="DateFechaSocializacion"
                                            readonly
                                            placeholder="Fecha de Socialización"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaLink">Fecha Entrega Link</label>
                                        <input 
                                            type="datetime-local" 
                                            id="DateEntregaLink" 
                                            name="DateEntregaLink"
                                            readonly
                                            placeholder="Fehca Entrga del Link"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DateEntregaComercial">Datos Adicionales</label>
                                        <input 
                                            type="text" 
                                            id="ArchivosAdjuntosBrief" 
                                            name="ArchivosAdjuntosBrief"
                                            readonly
                                            placeholder="Fecha de Entrega Comercial"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFechaSocializacion">Artes</label>
                                        <input 
                                            type="text" 
                                            id="artesCreativo" 
                                            name="artesCreativo"
                                            readonly
                                            placeholder="Fecha de Socialización"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="ObservacionesOT">Observaciones OT - Comercial</label>
                                        <input 
                                            type="text" 
                                            id="ObservacionesOT" 
                                            name="ObservacionesOT"
                                            readonly
                                            placeholder="Observaciones OT"
                                        />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" placeholder="Buscar contactos...">
                            </div>
                            <div class="Lista" id="listaProyectos">
                                <ul>
                                    <?php
                                    // Verificar si la consulta se realizó correctamente
                                    if (!empty($info_completa)) {
                                        // Usar un bucle foreach para recorrer los contactos
                                        foreach ($info_completa as $contacto) {
                                            // Comprobar si hay proyectos
                                            if (!empty($contacto['proyectos'])) {
                                                // Iterar sobre cada proyecto
                                                foreach ($contacto['proyectos'] as $fila) {
                                                    echo '<li>';
                                                    echo '<div class="propuesta-item data-estadoPropuesta="inactivo"" '
                                                        . 'data-id_proyecto="' . htmlspecialchars($fila["id"]) . '" '
                                                        . 'data-nombre-proyecto="' . htmlspecialchars($fila["nombreProyecto"] ?? 'N/A') . '" '
                                                        . 'data-userBull="' . htmlspecialchars($fila["id_user"] ?? 'N/A') . '" '
                                                        . 'data-unidadNegocio="' . htmlspecialchars($fila["id_unidadNegocio"] ?? 'N/A') . '" '
                                                        . 'data-fechaInicio="' . htmlspecialchars($fila["dateCreated"] ?? 'N/A') . '" '
                                                        . 'data-descripcionProyecto="' . htmlspecialchars($fila["descripcionProyecto"] ?? 'N/A') . '" '
                                                        . 'data-valorProyecto="' . htmlspecialchars($fila["valorProyecto"] ?? 'N/A') . '" '
                                                        . 'data-estadoPropuesta="' . htmlspecialchars($fila["estadoPropuesta"] ?? 'N/A') . '" '
                                                        . 'data-dateEntregaEconomicaCliente="' . htmlspecialchars($fila["dateEntregaEconomicaCliente"] ?? 'N/A') . '" '
                                                        . 'data-medioContacto_1="' . htmlspecialchars($fila["medioContacto1"] ?? 'N/A') . '" '
                                                        . 'data-medioContacto_2="' . htmlspecialchars($fila["medioContacto2"] ?? 'N/A') . '" '
                                                        . 'data-observacionProyecto_1="' . htmlspecialchars($fila["observacionProyecto1"] ?? 'N/A') . '" '
                                                        . 'data-observacionProyecto_2="' . htmlspecialchars($fila["observacionProyecto2"] ?? 'N/A') . '" '
                                                        . 'data-linkArchivosAdjuntos="' . htmlspecialchars($fila["archivosAdjuntos"] ?? 'N/A') . '" '
                                                        . 'data-formatoProceso="' . htmlspecialchars($fila["formatoProceso"] ?? 'N/A') . '" '
                                                        . 'data-idCliente="' . htmlspecialchars($fila["idCliente"] ?? 'N/A') . '" '
                                                        . 'data-isDeleted="' . htmlspecialchars($fila["isDeleted"] ?? 'N/A') . '" '
                                                        . 'data-nitCliente="' . htmlspecialchars($fila["nit_contacto"] ?? 'N/A') . '" '
                                                        . 'data-razonSocialCliente="' . htmlspecialchars($fila["razon_social_contacto"] ?? 'N/A') . '" '
                                                        . 'data-nombreCliente="' . htmlspecialchars($contacto["nombre"] ?? 'N/A') . '" '
                                                        . 'data-apellidoCliente="' . htmlspecialchars($contacto["apellido"] ?? 'N/A') . '" '
                                                        . 'data-apellidoCliente="' . htmlspecialchars($contacto["apellido"] ?? 'N/A') . '" '
                                                        . 'data-ciudadesImpacto="' . htmlspecialchars($fila["CiudadesImpacto"] ?? 'N/A') . '" '
                                                        . 'data-NecesitaOT="' . htmlspecialchars($fila["NecesitaOT"] ?? 'N/A') . '" '

                                                        . 'data-nombreBrief="' . htmlspecialchars($fila["nombreBrief"] ?? 'N/A') . '" '
                                                        . 'data-objetivoBrief="' . htmlspecialchars($fila["objetivoBrief"] ?? 'N/A') . '" '
                                                        . 'data-tipoEntregable="' . htmlspecialchars($fila["tipoEntregables"] ?? 'N/A') . '" '
                                                        . 'data-tipoCliente="' . htmlspecialchars($fila["TipoCliente"] ?? 'N/A') . '" '
                                                        . 'data-dateEntregaComercial="' . htmlspecialchars($fila["dateEntrega"] ?? 'N/A') . '" '

                                                        . 'data-liderProyecto="' . htmlspecialchars($fila["id_liderProyectoOT"] ?? 'N/A') . '" '
                                                        . 'data-creativosOT="' . htmlspecialchars($fila["id_creativoOT"] ?? 'N/A') . '" '
                                                        . 'data-artesProyecto="' . htmlspecialchars($fila["artesProyecto"] ?? 'N/A') . '" '
                                                        . 'data-linkProyecto="' . htmlspecialchars($fila["linkProyecto"] ?? 'N/A') . '" '
                                                        . 'data-dateLinkProyecto="' . htmlspecialchars($fila["dateLinkProyecto"] ?? 'N/A') . '" '
                                                        . 'data-datosAdicionalesBrief="' . htmlspecialchars($fila["datosAdicionalesBrief"] ?? 'N/A') . '" '
                                                        . 'data-dateEntregaCliente="' . htmlspecialchars($fila["dateEntregaCliente"] ?? 'N/A') . '" '
                                                        . 'data-dateSocializacion="' . htmlspecialchars($fila["dateSocializacion"] ?? 'N/A') . '" '
                                                        . 'data-tipoCliente="' . htmlspecialchars($fila["tipoCliente"] ?? 'N/A') . '" '
                                                        . '>';

                                                    // Mostrar información del proyecto
                                                    echo '<div class="NombreProyecto" id="NombreProyecto" style="font-size: 14px; font-weight: 600;">'
                                                        . htmlspecialchars($fila["nombreProyecto"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="ClienteProyecto"  style="font-size: 14px; font-weight: 600;">'
                                                        . htmlspecialchars($contacto["nombre"] ?? 'No disponible') . ' - ' 
                                                        . htmlspecialchars($contacto["apellido"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="NombreEmpresa" style="font-size: 14px; color: #262626;">'
                                                        . htmlspecialchars($contacto["empresa"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="EstadoProyecto" style="font-size: 13px; color: #262626;">'
                                                        . htmlspecialchars($fila["estadoPropuesta"] ?? 'No disponible') . '</div>';
                                                    
                                                    // echo '<div class="FechaInicio" style="Sfont-size: 9px; color: #262626;">'
                                                    //     . htmlspecialchars($fila["dateCreated"] ?? 'No disponible') . '</div>';

                                                    echo '</div>'; // Cerrar propuesta-item
                                                    echo '</li>'; // Cerrar li
                                                }
                                            } else {
                                                echo '<li>No hay proyectos para el contacto ' . htmlspecialchars($contacto['razon_social_contacto'] ?? 'No disponible') . '.</li>';
                                            }
                                        }
                                    } else {
                                        echo '<li>No se encontraron resultados.</li>';
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
    <script src="./Funcionalidad/FuncionalidadComercial.js"></script> 
</body>
</html>