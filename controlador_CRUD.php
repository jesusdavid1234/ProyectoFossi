<?php
include("../modelo/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_type = $_POST['form_type'];

    //modificacion de procedimientos admin
    if ($form_type == 'modificar_procedimientos_admin'){
        $ID = $_POST['ID'];
        $descripcion_procedimiento = $_POST['descripcion_procedimiento'];
        $fecha_procedimiento = $_POST['fecha_procedimiento'];
        $equipo = $_POST['equipo'];
        $tecnico =$_POST['tecnico'];
        $consulta = "UPDATE  procedimientos set descripcion_procedimiento=?, fecha_procedimento=?, equipo=?, tecnico=? WHERE ID=?";
        $stmconsu = $conexion->prepare($consulta);
        $stmconsu->bind_param("ssssi", $descripcion_procedimiento , $fecha_procedimiento , $equipo , $tecnico , $ID);
        if ($stmconsu->execute()){
            header("Location: ../admin_inicio.php");
            exit;


        } else{
            echo "hubo un error a la hora de actualizar los datos" . $conexion->error;
        }

        
    }


    // MODIFICACION PARA EQUIPOS PARA "controlador_CRUD.php"

    // MODIFICACION EQUIPOS admin
    if ($form_type == 'modificar_equipo') {
        $ID_equipo = $_POST['ID_equipo'];
        $tipo_equipo = $_POST['tipo_equipo'];
        $marca = $_POST['marca'];
        $estado_equipo = $_POST['estado_equipo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_entrega = $_POST['fecha_entrega'];
        $observaciones = $_POST['observaciones'];
        $sede = $_POST['sede'];

        $query = "UPDATE equipos SET tipo_equipo = ?, marca = ?, estado_equipo = ?, fecha_ingreso = ?, fecha_entrega = ?, observaciones = ?, sede = ? WHERE ID_equipo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssi", $tipo_equipo, $marca, $estado_equipo, $fecha_ingreso, $fecha_entrega, $observaciones, $sede, $ID_equipo);

        if ($stmt->execute()) {

            $query = "SELECT * FROM equipos WHERE ID_equipo = ?";
            $stmtSelect = $conexion->prepare($query);
            $stmtSelect->bind_param("i", $ID_equipo);
            $stmtSelect->execute();
            $result = $stmtSelect->get_result();
            $equipoActualizado = $result->fetch_assoc();

            echo json_encode($equipoActualizado);
            exit;

        } else {
            echo "Ocurrio un error al actualizar en la base de datos" . $conexion->error;
        }

        $stmt->close();

        //AGREGAR EQUIPOS tecnico
    } else if ($form_type == 'agregar_equipo') {
        $ID_equipo = $_POST['ID_equipo'];
        $tipo_equipo = $_POST['tipo_equipo'];
        $marca = $_POST['marca'];
        $estado_equipo = $_POST['estado_equipo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_entrega = $_POST['fecha_entrega'];
        $observaciones = $_POST['observaciones'];
        $sede = $_POST['sede'];
        $documento_tecnico = $_POST['documento_tecnico'];

        $checkQuery = "SELECT * FROM equipos WHERE ID_equipo = ?";
        $stmtCheck = $conexion->prepare($checkQuery);
        $stmtCheck->bind_param("s", $ID_equipo);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            echo "El ID de equipo ya existe. Por favor, elige un ID único.";
        } else {
            $checkDocQuery = "SELECT * FROM tecnicos WHERE documento = ?";
            $stmtDocCheck = $conexion->prepare($checkDocQuery);
            $stmtDocCheck->bind_param("s", $documento_tecnico);
            $stmtDocCheck->execute();
            $resultDocCheck = $stmtDocCheck->get_result();

            if ($resultDocCheck->num_rows == 0) {
                echo "El documento técnico no existe. Por favor, verifica el documento.";
            } else {
                $insertQuery = "INSERT INTO equipos (ID_equipo, tipo_equipo, marca, estado_equipo, fecha_ingreso, fecha_entrega, observaciones, sede, documento_tecnico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($insertQuery);
                $stmtInsert->bind_param("sssssssss", $ID_equipo, $tipo_equipo, $marca, $estado_equipo, $fecha_ingreso, $fecha_entrega, $observaciones, $sede, $documento_tecnico);
                if ($stmtInsert->execute()) {
                    header("Location: ../inicio.php");
                    exit;
                } else {
                    echo "Error al agregar el equipo: " . $conexion->error;
                }
            }
        }

        // MODIFICACION EQUIPOS tecnico
    } else if ($form_type == 'tecnico-modificar_registros') {
        $ID_equipo = $_POST['ID_equipo'];
        $tipo_equipo = $_POST['tipo_equipo'];
        $marca = $_POST['marca'];
        $estado_equipo = $_POST['estado_equipo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_entrega = $_POST['fecha_entrega'];
        $observaciones = $_POST['observaciones'];
        $sede = $_POST['sede'];

        $query = "UPDATE equipos SET tipo_equipo = ?, marca = ?, estado_equipo = ?, fecha_ingreso = ?, fecha_entrega = ?, observaciones = ?, sede = ? WHERE ID_equipo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssi", $tipo_equipo, $marca, $estado_equipo, $fecha_ingreso, $fecha_entrega, $observaciones, $sede, $ID_equipo);

        if ($stmt->execute()) {
            header("Location: ../inicio.php");
            exit;
        } else {
            echo "Ocurrio un error al actualizar en la base de datos" . $conexion->error;
        }

        $stmt->close();
    }

    //  MODIFICACION TECNICOS admin
    if ($form_type == 'modificar_tecnicos') {
        $documento = $_POST['documento'];
        $ficha = $_POST['ficha'];
        $nombre_tecnico = $_POST['nombre_tecnico'];
        $FK_usuario = $_POST['FK_usuario'];
        $sede = $_POST['sede'];

        $query = "UPDATE tecnicos SET ficha = ?, nombre_tecnico = ?, FK_usuario = ?, sede = ? WHERE documento = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssi", $ficha, $nombre_tecnico, $FK_usuario, $sede, $documento);

        if ($stmt->execute()) {
            $query = "SELECT * FROM tecnicos WHERE documento = ?";
            $stmtSelect = $conexion->prepare($query);
            $stmtSelect->bind_param("s", $documento);
            $stmtSelect->execute();
            $result = $stmtSelect->get_result();
            $tecnicoActualizado = $result->fetch_assoc();

            echo json_encode($tecnicoActualizado);
            exit;
        } else {
            echo "Ocurrió un error al actualizar en la base de datos: " . $conexion->error;
        }

        $stmt->close();
    }

    
    //agregar procdedimento
    if ($form_type == 'agregar_procedimientos'){
        $ID = $_POST['ID'];
        $descripcion_procedimiento = $_POST['descripcion_procedimiento'];
        $fecha_procedimiento = $_POST['fecha_procedimiento'];
        $equipo = $_POST['equipo'];
        $tecnico = $_POST['tecnico'];

        //validar si el id ya existe
        $proce="SELECT * FROM procedimientos WHERE ID= ?";
        $stmproce= $conexion ->prepare($proce); //aqui prepeared me esta permitiendo que no haiga una inyeccion de la aconsulta 
        $stmproce -> bind_param("s", $ID);
        $stmproce -> execute();
        $final_proce= $stmproce ->get_result();

        if ($final_proce -> num_rows >0){
            echo "El ID del prcedimiento ya existe, ingrese otro";


        }else{
            $valida_tecnico= "SELECT * FROM tecnicos WHERE documento= ?";
            $stemvalida= $conexion -> prepare($valida_tecnico);
            $stemvalida -> bind_param("s", $tecnico);
            $stemvalida -> execute();
            $vali_final= $stemvalida ->get_result();

            if ($vali_final->num_rows ==0){
                echo "el documento del tecnico no existe, ingrese un tecnico valido";

            }else{
                $inserproce = "INSERT INTO procedimientos(ID,descripcion_procedimiento,fecha_procedimento,equipo,tecnico)VALUES(?,?,?,?,?)";
                $istminser= $conexion ->prepare($inserproce);
                $istminser -> bind_param("sssss", $ID , $descripcion_procedimiento , $fecha_procedimiento , $equipo , $tecnico);
                if ($istminser -> execute()){
                    header("Location: ../inicio.php");
                    exit;
                    
                }else{
                    echo"error al algregar el procedimento" . $conexion -> error;
                }


            }



        }




    }else if($form_type =='tecnico-modificar-procedimentos'){
        $ID = $_POST['ID'];
        $descripcion_procedimiento = $_POST['descripcion_procedimiento'];
        $fecha_procedimiento = $_POST['fecha_procedimiento'];
        $equipo = $_POST['equipo'];
        $tecnico = $_POST['tecnico'];
        $consulta_modi = "UPDATE  procedimientos set descripcion_procedimiento=?, fecha_procedimento=?, equipo=?, tecnico=? WHERE ID=?";
        $consufi= $conexion -> prepare($consulta_modi);
        $consufi ->bind_param("ssssi", $descripcion_procedimiento , $fecha_procedimiento , $equipo , $tecnico , $ID);

        if ($consufi -> execute()){
            header("Location: ../inicio.php");
            exit;

        }else{
            echo "error a la hora de modificar procedimientos" .$conexion -> error; 
        }
        $consufi -> close();
    }

   


    
    // ELIMINACION DE EQUIPOS admin y tecnico
    if ($form_type == 'eliminar_equipo') {
        $ID_equipo = $_POST['ID_equipo'];

        $query = "DELETE FROM equipos WHERE ID_equipo = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $ID_equipo);

        if ($stmt->execute()) {
            if (isset($_POST['origen']) && $_POST['origen'] === 'inicio') {
                echo "¡Eliminación exitosa tecnico!";
            } else {
                echo "¡Eliminación exitosa admin!";
            }
        } else {
            echo "Ocurrió un error al eliminar el registro: " . $conexion->error;
        }

        $stmt->close();
    }

    // ELIMINACION DE TECNICO admin
    if ($form_type == 'eliminar_tecnico') {
        $documento = $_POST['documento'];

        $query = "DELETE FROM tecnicos WHERE documento = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $documento);

        if ($stmt->execute()) {
            echo "Eliminación exitosa";
        } else {
            echo "Ocurrió un error al eliminar el registro: " . $conexion->error;
        }

        $stmt->close();
    }

    // ELIMINACION DE PROCEDIMIENTOS admin
    if ($form_type == 'eliminar_procedimiento') {
        $ID_procedimiento = $_POST['ID_procedimiento'];

        $query = "DELETE FROM procedimientos WHERE ID = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $ID_procedimiento);

        if ($stmt->execute()) {
            echo "Eliminación exitosa";
        } else {
            echo "Ocurrió un error al eliminar el registro: " . $conexion->error;
        }

        $stmt->close();
    }

}
