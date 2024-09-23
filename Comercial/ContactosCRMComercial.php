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

// Array para almacenar todos los contactos
$todos_contactos = [];

// Consulta para obtener contactos de CRM
$sql = "SELECT * FROM contactos WHERE id_user = $id_CRM";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    if (mysqli_num_rows($resultado) > 0) {
        while ($contacto = mysqli_fetch_assoc($resultado)) {
            // Almacena el contacto original
            $contacto_completo = $contacto;
            
            // Obtén el ID del contacto
            $id_contacto = $contacto['id'];

            // Consulta adicional en la base de datos BullTrack filtrando por ID del contacto
            $sql2 = "SELECT contacto_crm.nit_contacto, contacto_crm.razon_social_contacto, contacto_crm.id_usuario, contacto_crm.id_contactos_CRM FROM contacto_crm WHERE id_contactos_CRM = $id_contacto";
            $resultado2 = mysqli_query($conexion_bull, $sql2);

            if ($resultado2) {
                if (mysqli_num_rows($resultado2) > 0) {
                    // Aquí asumimos que solo se espera un contacto coincidente
                    $contacto_bull = mysqli_fetch_assoc($resultado2);
                    // Combina la información de ambas consultas
                    $contacto_completo = array_merge($contacto, $contacto_bull);
                }
            } else {
                // Manejo de error para la segunda consulta
                $contacto_completo['error_bull'] = "Error en la consulta BullTrack: " . mysqli_error($conexion_bull);
            }
            
            // Agrega el contacto completo al array
            $todos_contactos[] = $contacto_completo;
        }
    } else {
        $todos_contactos['error'] = "No se encontraron contactos para el usuario.";
    }
} else {
    $todos_contactos['error'] = "Error en la consulta principal: " . mysqli_error($conexion);
}

//var_dump($todos_contactos); // Muestra todos los contactos completos
// Cierra las conexiones a las bases de datos
// mysqli_close($conexion);
// mysqli_close($conexion_bull);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./Funcionalidad/Funcionalidad-JS/FuncionalidadContactos.js" defer></script> 
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
            <div class="BotonSalir" onclick="RedirigirLogin()">
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
                                    <h3>Información Usuarios CRM</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <button class="BotonesFormulario" id="editarContactoBtn">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button>
                                    <button class="BotonesFormulario" id="agregarContactoBtn">
                                        <img src="../Media/Iconos/Agregar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Agregar</span>
                                    </button>
                                    <button class="BotonesFormulario" id="eliminarContactoBtn">
                                        <img src="../Media/Iconos/eliminar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </div>
                            
                            <form class="ParteFormulario">
                                <div class="form-row">
                                    <input type="hidden" id="id" name="id" value="">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" id="apellido" name="apellido" placeholder="Ingrese el apellido" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="cargo">Cargo</label>
                                        <input type="text" id="cargo" name="cargo" placeholder="Ingrese el cargo" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="tel" id="celular" name="celular" placeholder="Ingrese el celular" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="email" id="correo" name="correo" placeholder="Ingrese el correo" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="empresa">Empresa</label>
                                        <input type="text" id="empresa" name="empresa" placeholder="Ingrese la empresa" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="web">Web</label>
                                        <input type="text" id="web" name="web" placeholder="Ingrese la web" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="NIT">N.I.T</label>
                                        <input type="text" id="NIT" name="NIT" placeholder="Ingrese el NIT" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="razon_social">Razón Social</label>
                                        <input type="text" id="razon_social" name="razon_social" placeholder="Ingrese la Razon Social" readonly>
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
                            <div class="Lista">
                                <ul>
                                    <?php
                                    if (!isset($todos_contactos['error'])) {
                                        foreach ($todos_contactos as $contacto) {
                                            echo '<li>';
                                            echo '<div class="user-item" data-id="' . htmlspecialchars($contacto["id"]) . '" '
                                                . 'data-nombre="' . htmlspecialchars($contacto["nombre"]) . '" '
                                                . 'data-apellido="' . htmlspecialchars($contacto["apellido"]) . '" '
                                                . 'data-cargo="' . htmlspecialchars($contacto["cargo"]) . '" '
                                                . 'data-celular="' . htmlspecialchars($contacto["celular"]) . '" '
                                                . 'data-correo="' . htmlspecialchars($contacto["correo"]) . '" '
                                                . 'data-empresa="' . htmlspecialchars($contacto["empresa"]) . '" '
                                                . 'data-ciudad="' . htmlspecialchars($contacto["ciudad"]) . '" '
                                                . 'data-direccion="' . htmlspecialchars($contacto["direccion"]) . '" '
                                                . 'data-web="' . htmlspecialchars($contacto["web"]) . '" '
                                                . 'data-nit="' . htmlspecialchars($contacto["nit_contacto"] ?? 'N/A') . '" '
                                                . 'data-razon-social="' . htmlspecialchars($contacto["razon_social_contacto"] ?? 'N/A') . '">';
                                        
                                            echo '<div class="NombreContacto" style="font-size: 14px; font-weight: 600;">' . htmlspecialchars($contacto["nombre"]) . ' ' . htmlspecialchars($contacto["apellido"]) . '</div>';
                                            echo '<div class="CargoContacto" style="font-size: 13px; color: #262626;">' . htmlspecialchars($contacto["cargo"]) . '</div>';
                                            echo '<div class="EmpresaContacto" style="font-size: 13px; color: #262626;">' . htmlspecialchars($contacto["empresa"]) . '</div>';
                                            
                                            echo '</div>';
                                            echo '</li>';
                                        }
                                        
                                    } else {
                                        echo '<li>' . htmlspecialchars($todos_contactos['error']) . '</li>';
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

