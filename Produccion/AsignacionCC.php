<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="./Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <?php include '../ConexionesBD/ConexcionDBcrm.php'?>
    <script src="./FuncionalidadProduccion/Funcionalidad.js"></script>
</head>
<body>
                            <?php
                                if (isset($_POST['userId']) && is_numeric($_POST['userId'])) {
                                    $userId = intval($_POST['userId']);
                                    
                                    // Consulta usando prepared statement para mayor seguridad
                                    $sql = "SELECT presupuesto_proyecto.cod_cc, users.name  
                                            FROM `presupuesto_proyecto`
                                            JOIN users ON presupuesto_proyecto.productor = users.id
                                            WHERE users.id = ?";
                                    
                                    $stmt = $conexion->prepare($sql);
                                    $stmt->bind_param("i", $userId);
                                    $stmt->execute();
                                    $resultado = $stmt->get_result();
                                
                                    if ($resultado->num_rows > 0) {
                                        while($row = $resultado->fetch_assoc()) {
                                            echo "<div class='registroCC' style='color: #000;'>";
                                            echo "Código CC: " . htmlspecialchars($row['cod_cc']) . " - Nombre: " . htmlspecialchars($row['name']);
                                            echo "</div>";
                                        }
                                        exit; // Asegúrate de detener la ejecución aquí
                                    } else {
                                        exit; // Detiene la ejecución
                                    }
                                } else {
                                    //echo "<div class='registroCC'>Error: No se recibió un ID de usuario válido.</div>";
                                }
                            ?>

                            <!-- <?php
                                if (isset($_POST['userId']) && is_numeric($_POST['userId'])) {
                                    $userId = intval($_POST['userId']);
                                    
                                    // Consulta usando prepared statement
                                    $sql = "SELECT presupuesto_proyecto.cod_cc, users.name, presupuesto_proyecto.notas, CAST(presupuesto_proyecto.venta_proy AS INTEGER) AS precio_venta  
                                            FROM `presupuesto_proyecto`
                                            JOIN users ON presupuesto_proyecto.productor = users.id
                                            WHERE users.id = ?";
                                    
                                    $stmt = $conexion->prepare($sql);
                                    $stmt->bind_param("i", $userId);
                                    $stmt->execute();
                                    $resultado = $stmt->get_result();
                                    
                                    if ($resultado->num_rows > 0) {
                                        echo "<div class='TablaInformacionPropuesta'>";
                                        echo "<table>";
                                        echo "<thead><tr><th>Código CC</th><th>Nombre</th><th>Precio Venta</th><th>Notas Proyecto</th></tr></thead><tbody>";
                                        
                                        while ($row = $resultado->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars(string: $row['cod_cc']) . "</td>";
                                            echo "<td>" . htmlspecialchars(string: $row['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars(string: $row['precio_venta']) . "</td>";
                                            echo "<td>" . htmlspecialchars(string: $row['notas']) . "</td>";
                                            echo "</tr>";
                                        }                                       
                                        echo "</tbody></table></div>";
                                    } else {
                                        echo "<div class='registroCC'>No se encontraron registros para este usuario.</div>";
                                    }
                                } else {
                                    echo "<div class='registroCC'>Error: No se recibió un ID de usuario válido.</div>";
                                }
                            ?> -->

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
                    <div class="TipoGrafia">Nombre Del Usuario</div>
                    <div class="TipoGrafia">Cargo</div>
                    <div class="TipoGrafia">Rol</div>    
                </div>
                <div class="InformacionModulos">
                    <div class="ModulosDash">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Dashboard Gerencial</span>
                    </div>
                    <div class="ModulosDash">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Dashboard Producción</span>
                    </div>
                    <div class="ModulosDash">
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
            <div class="BotonSalir">
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
                                <input type="text" class="InputCentroCostos">
                                <div class="ResultadosCentroCostos">
                                    <div class="registroCC"></div>
                                </div>
                            </div>

                                <div class="divBotonesCentroCostos">
                                    <div class="BotonCC" > Asignar </div>
                                    <div class="BotonCC" > Liberar </div>
                                </div>
                                <div class="divCentroCostos2">
                                    <input type="text" class="InputCentroCostos">

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

                                    <div class="ResultadosCentroCostos">
                                        <div class="registroCC">dasdasdasd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="TablaInformacionPropuesta">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Código CC</th>
                                            <th>Nombre</th>
                                            <th>Precio Venta</th>
                                            <th>Notas Proyecto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" id="searchInput" placeholder="Buscar Propuestas...">
                            </div>
                                <div class="Lista_produccion">
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