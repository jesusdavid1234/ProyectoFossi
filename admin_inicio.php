<?php
include "controlador/controlador_login.php"; // Incluir el controlador donde se hacen las consultas

if (!isset($_SESSION["id"])){
    header("location: login.php");

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="stylos/styles.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#" onclick="mostrar_Registros()">Registros</a></li>
            <li><a href="#" onclick="mostrarUsuarios()">Usuarios</a></li>
            <li><a href="#" onclick="mostrar_procedimentos()">Procedimentos</a></li>
            <li><a href="#">Ajustes</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Gestión de coordinador</h1>
            <input type="text" id="search" placeholder="Buscar registros...">
        </header>

        <!-- Mensaje de bienvenida con información de sesión -->
        <div class="bienvenida">
            <p>Bienvenido, <?php echo $_SESSION["rol"] . " : " . $_SESSION["usuario"]; ?></p>
            <p>ID: <?php echo $_SESSION["id"]; ?></p>
            <a href="controlador/controlador_cerrar.php" class="btn salir">Salir</a>
        </div>

        <!-- Tabla de Computadores -->
        <div id="tabla-registros" style="display: block;">
            <h2>Lista de Computadores</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID_equipo</th>
                        <th>tipo_equipo</th>
                        <th>marca</th>
                        <th>estado_equipo</th>
                        <th>fecha_ingreso</th>
                        <th>fecha_entrega</th>
                        <th>observaciones</th>
                        <th>documento_tecnico</th>
                        <th>sede</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($computador = $computadoresQuery->fetch_object()) { ?>
                        <tr>
                            <td><?php echo $computador->ID_equipo; ?></td>
                            <td><?php echo $computador->tipo_equipo; ?></td>
                            <td><?php echo $computador->marca; ?></td>
                            <td><?php echo $computador->estado_equipo; ?></td>
                            <td><?php echo $computador->fecha_ingreso; ?></td>
                            <td><?php echo $computador->fecha_entrega; ?></td>
                            <td><?php echo $computador->observaciones; ?></td>
                            <td><?php echo $computador->documento_tecnico; ?></td>
                            <td><?php echo $computador->sede; ?></td>
                            <td>
                                <button name="botnmodificar" class="btn modificar" onclick="editarRegistro_equipos('<?php echo $computador->ID_equipo; ?>', '<?php echo $computador->marca; ?>', '<?php echo $computador->estado_equipo; ?>', '<?php echo $computador->fecha_ingreso; ?>', '<?php echo $computador->fecha_entrega; ?>', '<?php echo $computador->observaciones; ?>', '<?php echo $computador->sede; ?>')">Modificar</button>
                                <button class="btn eliminar" onclick="eliminarRegistro('<?php echo $computador->ID_equipo; ?>', 'equipo')">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Usuarios -->
        <div id="tabla-usuarios" style="display: none;">
            <h2>Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>documento</th>
                        <th>nombre_tecnico</th>
                        <th>ficha</th>
                        <th>Fk_usuario</th>
                        <th>sede</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $usuariosResult->fetch_object()) { ?>
                        <tr>
                            <td><?php echo $usuario->documento; ?></td>
                            <td><?php echo $usuario->nombre_tecnico; ?></td>
                            <td><?php echo $usuario->ficha; ?></td>
                            <td><?php echo $usuario->FK_usuario; ?></td>
                            <td><?php echo $usuario->sede; ?></td>
                            <td>
                                <button class="btn modificar" onclick="editarRegistro_tecnicos('<?php echo $usuario->documento; ?>', '<?php echo $usuario->ficha; ?>', '<?php echo $usuario->nombre_tecnico; ?>', '<?php echo $usuario->FK_usuario; ?>', '<?php echo $usuario->sede; ?>')">Modificar</button>
                                <button class="btn eliminar" onclick="eliminarRegistro('<?php echo $usuario->documento; ?>', 'tecnico')">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="tabla-procedimentos" style="display: none;">
            <h2>procedimentos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Id_procedimiento</th>
                        <th>descirpcion</th>
                        <th>fecha_procedimento</th>
                        <th>equipo</th>
                        <th>tecnico</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($proce = $proeceidmentos->fetch_object()) { ?>
                        <tr>
                            <td><?php echo $proce->ID; ?></td>
                            <td><?php echo $proce->descripcion_procedimiento; ?></td>
                            <td><?php echo $proce->fecha_procedimento; ?></td>
                            <td><?php echo $proce->equipo; ?></td>
                            <td><?php echo $proce->tecnico; ?></td>
                            <td>
                                <button name="botnmodificar" class="botnmodificar" onclick="admin_editar_procedimiento('<?php echo $proce->ID; ?>', '<?php echo $proce->descripcion_procedimiento; ?>', '<?php echo $proce->fecha_procedimento; ?>', '<?php echo $proce->equipo; ?>', '<?php echo $proce->tecnico; ?>')">Modificar</button>

                                <button class="btn eliminar" onclick="eliminarRegistro('<?php echo $proce->ID; ?>', 'procedimiento')">Eliminar</button>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
               

            </table>

        </div>

        <!-- FORMULARIO DE MODIFICACION PARA EQUIPOS -->
        <div id="tabla-modificacion-equipos" style="display: none;">
            <form action="controlador/controlador_CRUD.php" method="POST" id="equiposModificacion">
                <input type="hidden" name="form_type" value="modificar_equipo">
                <input type="hidden" name="ID_equipo" id="editar-ID_equipo">

                <label for="tipo_equipo">Tipo de equipo:</label>
                <input type="text" name="tipo_equipo" id="editar-tipo_equipo">
                <br>
                <label for="marca">Marca de equipo:</label>
                <input type="text" name="marca" id="editar-marca">
                <br>
                <label for="estado_equipo">estado de equipo:</label>
                <input type="text" name="estado_equipo" id="editar-estado_equipo">
                <br>
                <label for="fecha_ingreso">Fecha de ingreso:</label>
                <input type="date" name="fecha_ingreso" id="editar-fecha_ingreso">
                <br>
                <label for="fecha_entrega">Fecha de entrega:</label>
                <input type="date" name="fecha_entrega" id="editar-fecha_entrega">
                <br>
                <label for="observaciones">Observaciones:</label>
                <input type="text" name="observaciones" id="editar-observaciones">
                <br>
                <label for="sede">Sede:</label>
                <input type="text" name="sede" id="editar-sede">
                <br>
                <button type="submit" class="btn">Confirmar cambios</button>
                <button type="button" class="btn_cancelar" onclick="formularioCancelar('equipo')">Cancelar cambios</button>
            </form>
        </div>

        <!-- FORMULARIO DE MODIFICACION PARA TECNICOS -->
        <div id="tabla-modificacion-tecnicos" style="display: none;">
            <form action="controlador/controlador_CRUD.php" method="POST" id="tecnicosModificacion">
                <input type="hidden" name="form_type" value="modificar_tecnicos">
                <input type="hidden" name="documento" id="editar-documento">

                <label for="ficha">Ficha:</label>
                <input type="text" name="ficha" id="editar-ficha">
                <br>
                <label for="nombre_tecnico">Nombre tecnico:</label>
                <input type="text" name="nombre_tecnico" id="editar-nombre_tecnico">
                <br>
                <label for="FK_usuario">Foranea usuario:</label>
                <input type="text" name="FK_usuario" id="editar-FK_usuario">
                <br>
                <label for="sede">Sede:</label>
                <input type="text" name="sede" id="editar-sede">
                <br>
                <button type="submit" class="btn">Confirmar cambios</button>
                <button type="button" class="btn_cancelar" onclick="formularioCancelar('tecnico')">Cancelar cambios</button>
            </form>
        </div>

        <!-- FORMULARIO DE MODIFICACION PARA PROCEDIMIENTOS -->
        <div id='tabla-modificacion-procedimientos-admin' style="display: none;">
            <form action="controlador/controlador_CRUD.php" method="POST" id="procedimientosModificacion">
                <input type="hidden" name="form_type" value="modificar_procedimientos_admin">
                <input type="hidden" name="ID" id="editar-ID_procedimientos">

                <label for="descripcion_procedimiento">Ficha:</label>
                <input type="text" name="descripcion_procedimiento" id="editar-descripcion">
                <br>
                <label for="fecha_procedimiento">Nombre procedimiento:</label>
                <input type="date" name="fecha_procedimiento" id="editar-fecha">
                <br>
                <label for="equipo">Foranea equipo:</label>
                <input type="text" name="equipo" id="editar-equipo">
                <br>
                <label for="tecnico">Foranea tecnico:</label>
                <input type="text" name="tecnico" id="editar-tecnico">
                <br>
                <button type="submit" class="btn">Confirmar cambios</button>
                <button type="button" class="btn_cancelar" onclick="formularioCancelar('procedimiento')">Cancelar cambios</button>
            </form>
        </div>

       

    </div>

    <script src="js/app.js"></script>

</body>

</html>