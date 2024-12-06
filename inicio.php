<?php

include "controlador/controlador_login.php";

if (!isset($_SESSION["id"])){
    header("location: login.php");

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Registros - Vista Técnico</title>
    <link rel="stylesheet" href="stylos/tecnico.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar de navegación -->
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <nav>
                <a href="#" onclick="mostrarFormulario()">Inicio</a>
                <a href="#" onclick="mostrarRegistros()">Registros</a>
                <a href="#" onclick="mostrarFormularioProcedimiento()">Procedimiento</a>
                <a href="#" onclick="mostrar_registro_procedimiento()">Registro_Procedimiento</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <header>
                <p>Bienvenido <?php echo $_SESSION["rol"] . " : " . $_SESSION["usuario"]; ?></p>
                <p>ID: <?php echo $_SESSION["id"]; ?></p>
                <a href="controlador/controlador_cerrar.php">Salir</a>
            </header>

            <!-- Formulario para agregar registros -->
            <section class="form-section" id="tabla-formulario" style="display: block;">
                <h2>Agregar Computador</h2>
                <form action="controlador/controlador_CRUD.php" method="POST" id="equiposAgregacion">
                    <input type="hidden" name="form_type" value="agregar_equipo">

                    <label for="ID_equipo">ID de equipo</label>
                    <input type="text" name="ID_equipo" id="agregar-ID_equipo" required>

                    <label for="tipo_equipo">Tipo de equipo:</label>
                    <input type="text" name="tipo_equipo" id="agregar-tipo_equipo">

                    <label for="marca">Marca:</label>
                    <input type="text" name="marca" id="agregar-marca">

                    <label for="estado_equipo">Estado del equipo:</label>
                    <input type="text" name="estado_equipo" id="agregar-estado_equipo">

                    <label for="fecha_ingreso">Fecha de ingreso:</label>
                    <input type="date" name="fecha_ingreso" id="agregar-fecha_ingreso">

                    <label for="fecha_entrega">Fecha de entrega:</label>
                    <input type="date" name="fecha_entrega" id="agregar-fecha_entrega">

                    <label for="observaciones">Observaciones:</label>
                    <input type="text" name="observaciones" id="agregar-observaciones">

                    <label for="documento_tecnico">Tecnico:</label>
                    <input type="text" name="documento_tecnico" id="agregar-documento_tecnico" required>

                    <label for="sede">Sede:</label>
                    <input type="text" name="sede" id="agregar-sede">

                    <button type="submit" class="btn">Confirmar cambios</button>
                </form>
            </section>

            <!-- Sección de lista de registros -->
            <div id="tabla-registros" style="display: none;">
                <h2>Lista de Computadores</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID_equipo</th>
                            <th>Tipo de equipo</th>
                            <th>Marca</th>
                            <th>Estado del equipo</th>
                            <th>Fecha de ingreso</th>
                            <th>Fecha de entrega</th>
                            <th>Observaciones</th>
                            <th>Documento Técnico</th>
                            <th>Sede</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($computadoresQuery) {
                            while ($computador = $computadoresQuery->fetch_object()) { // recorre los resultados
                        ?>
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
                                        <button name="botnmodificar" class="btn modificar" onclick="tecnicos_editarRegistro_equipos('<?php echo $computador->ID_equipo; ?>', '<?php echo $computador->marca; ?>', '<?php echo $computador->estado_equipo; ?>', '<?php echo $computador->fecha_ingreso; ?>', '<?php echo $computador->fecha_entrega; ?>', '<?php echo $computador->observaciones; ?>', '<?php echo $computador->sede; ?>')">Modificar</button>
                                        <button class="btn eliminar" onclick="eliminarRegistro('<?php echo $computador->ID_equipo; ?>', 'equipo', 'inicio')">Eliminar</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulario para agregar procedimientos -->
            <section class="form-section" id="tabla-procedimentos" style="display: none;">
                <h2>Agregar Procedimiento</h2>
                <form method="POST" action="controlador/controlador_CRUD.php" id="agregarProcedimientos">
                    <input type="hidden" name="form_type" value="agregar_procedimientos">

                    <label for="ID">ID procedimiento:</label>
                    <input type="text" name="ID" id="agregar-ID_procedimiento" required> <!-- Cambiado a ID_procedimiento -->

                    <label for="descripcion_procedimiento">Descripción del procedimiento:</label>
                    <input type="text" name="descripcion_procedimiento" id="agregar-descripcion_procedimiento" required> <!-- Cambiado a descripcion_procedimiento -->

                    <label for="fecha_procedimiento">Fecha del procedimiento:</label>
                    <input type="date" name="fecha_procedimiento" id="agregar-fecha_procedimiento" required> <!-- Asegúrate de que este nombre sea correcto -->

                    <label for="equipo">Equipo:</label>
                    <input type="text" name="equipo" id="agregar-FK_equipo" required>

                    <label for="tecnico">Técnico:</label>
                    <input type="text" name="tecnico" id="agregar-documento_tecnico" required>

                    <button type="submit" class="btn">Confirmar cambios</button>
                </form>
            </section>


            <div id="tabla-registros-procedimientos" style="display: none;">
                <h2>Lista de procedimientos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID_procedimiento</th>
                            <th>Descripcion_procedimento</th>
                            <th>Fecha_procedimento</th>
                            <th>Equipo</th>
                            <th>Documento_tecnico</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($proeceidmentos) {
                            while ($poce = $proeceidmentos->fetch_object()) { // recorre los resultados
                        ?>
                                <tr>
                                    <td><?php echo $poce->ID; ?></td>
                                    <td><?php echo $poce->descripcion_procedimiento; ?></td>
                                    <td><?php echo $poce->fecha_procedimento; ?></td>
                                    <td><?php echo $poce->equipo; ?></td>
                                    <td><?php echo $poce->tecnico; ?></td>
                                    <td>
                                        <button name ="botnmodificar"class="btnmodificar" onclick="tecnico_editar_procedimiento('<?php echo $poce->ID; ?>', '<?php echo $poce->descripcion_procedimiento; ?>', '<?php echo $poce->fecha_procedimento; ?>', '<?php echo $poce->equipo; ?>', '<?php echo $poce->tecnico; ?>')">Modificar</button>
                                        <button class="btneliminar">Eliminar</button>
                                    </td>


                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>

            <!-- FORMULARIO DE MODIFICACION PARA REGISTROS DE EQUIPOS -->
            <div id="tabla-modificacion-registros" style="display: none;">
                <form action="controlador/controlador_CRUD.php" method="POST" id="tecnico-registrosModificacion">
                    <input type="hidden" name="form_type" value="tecnico-modificar_registros">
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
                    <button type="button" class="btn_cancelar" onclick="formularioCancelar('tecnico-equipo')">Cancelar cambios</button>
                </form>
            </div>

             <!--formulario para editita prcedimentos -->
            <div id='tabla-modificacion-precedimeintos' style="display: none;">
                <form action="controlador/controlador_CRUD.php" method="POST" id="tecnico-precedimentoModificacion">
                    <input type="hidden" name="form_type" value="tecnico-modificar-procedimentos">
                    <input type="hidden" name="ID" id="editar-ID">

                    <label for="descripcion_procedimiento">Descripcion procedimiento :</label>
                    <input type="text" name="descripcion_procedimiento" id="editar-descripcion">
                    <br>
                    <label for="fecha_procedimento">Fecha procedimiento :</label>
                    <input type="date" name="fecha_procedimiento" id="editar-fecha">
                    <br>
                    <label for="equipo">equipo :</label>
                    <input type="text" name="equipo" id="editar-equipo">
                    <br>
                    <label for="tecnico">tecnico :</label>
                    <input type="text" name="tecnico" id="editar-tecnico">
                    <br>
                   
                    <button type="submit" class="btn">Confirmar cambios</button>
                    <button type="button" class="btn_cancelar" onclick="formularioCancelar('procedimiento')">Cancelar cambios</button>
                </form>
            </div>


        </main>
    </div>
    <script src="js/app.js"></script>
</body>

</html>