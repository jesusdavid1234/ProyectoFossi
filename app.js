//funcion para mostrar el formulario de registro (Inicio)
function mostrarFormulario() {
    // Ocultar la tabla de registros y el formulario de procedimiento
    document.getElementById('tabla-registros').style.display = 'none';
    document.getElementById('tabla-procedimentos').style.display = 'none';
    document.getElementById('tabla-registros-procedimientos').style.display = 'none';
    // Mostrar el formulario de registros
    document.getElementById('tabla-formulario').style.display = 'block';
}

//funcion para mostrar la tabla de registros
function mostrarRegistros() {
    // Ocultar el formulario de registros y el formulario de procedimientos
    document.getElementById('tabla-formulario').style.display = 'none';
    document.getElementById('tabla-procedimentos').style.display = 'none';
    document.getElementById('tabla-registros-procedimientos').style.display = 'none';
    // Mostrar la tabla de registros
    document.getElementById('tabla-registros').style.display = 'block';
}

//funcion para mostrar el formulario de procedimiento
function mostrarFormularioProcedimiento() {
    // Ocultar el formulario de registros y la tabla de registros
    document.getElementById('tabla-formulario').style.display = 'none';
    document.getElementById('tabla-registros').style.display = 'none';
    document.getElementById('tabla-registros-procedimientos').style.display = 'none';
    
    // Mostrar el formulario de procedimientos
    document.getElementById('tabla-procedimentos').style.display = 'block';
}

//funcion para mostrar los registros del procedimento

function mostrar_registro_procedimiento() {
    document.getElementById('tabla-formulario').style.display = 'none';
    document.getElementById('tabla-registros').style.display = 'none';
    document.getElementById('tabla-procedimentos').style.display = 'none';
    document.getElementById('tabla-registros-procedimientos').style.display = 'block';
    
}


//funcion para mostrar la tabla de registros
function mostrar_Registros() {
    // Ocultar todas las secciones de contenido
    document.getElementById('tabla-usuarios').style.display = 'none';
    document.getElementById('tabla-procedimentos').style.display = 'none';
    // Mostrar la tabla de registros
    document.getElementById('tabla-registros').style.display = 'block';
}

//funcion para mostrar la tabla de usuarios
function mostrarUsuarios() {
    // Ocultar todas las secciones de contenido
    document.getElementById('tabla-registros').style.display = 'none';
    document.getElementById('tabla-procedimentos').style.display = 'none';
    // Mostrar la tabla de usuarios
    document.getElementById('tabla-usuarios').style.display = 'block';
}

//fincion para mostrar la tabla de procedimientos
function mostrar_procedimentos() {
    // Ocultar todas las secciones de contenido
    document.getElementById('tabla-registros').style.display = 'none';
    document.getElementById('tabla-usuarios').style.display = 'none';
    // Mostrar la tabla de procedimientos
    document.getElementById('tabla-procedimentos').style.display = 'block';
}



// EDICIONES DE LAS TABLAS admin
function editarRegistro_equipos(ID_equipo, marca, estado_equipo, fecha_ingreso, fecha_entrega, observaciones, sede) {
    document.getElementById('editar-ID_equipo').value = ID_equipo;
    document.getElementById('editar-marca').value = marca;
    document.getElementById('editar-estado_equipo').value = estado_equipo;
    document.getElementById('editar-fecha_ingreso').value = fecha_ingreso;
    document.getElementById('editar-fecha_entrega').value = fecha_entrega;
    document.getElementById('editar-observaciones').value = observaciones;
    document.getElementById('editar-sede').value = sede;

    document.getElementById('tabla-modificacion-equipos').style.display = 'block';
}

function editarRegistro_tecnicos(documento, ficha, nombre_tecnico, FK_usuario, sede) {
    document.getElementById('editar-documento').value = documento;
    document.getElementById('editar-ficha').value = ficha;
    document.getElementById('editar-nombre_tecnico').value = nombre_tecnico;
    document.getElementById('editar-FK_usuario').value = FK_usuario;
    document.getElementById('editar-sede').value = sede

    document.getElementById('tabla-modificacion-tecnicos').style.display = 'block';
}

function admin_editar_procedimiento(ID, descripcion_procedimiento, fecha_procedimiento, equipo, tecnico) {
    // Asigna los valores recibidos en los campos del formulario
    document.getElementById('editar-ID_procedimientos').value = ID; // Usa 'editar-ID_procedimientos' en lugar de 'editar-ID'
    document.getElementById('editar-descripcion').value = descripcion_procedimiento;
    
    // Asegúrate de que la fecha esté en el formato 'YYYY-MM-DD' para el input tipo date
    let fechaFormateada = new Date(fecha_procedimiento).toISOString().split('T')[0]; 
    document.getElementById('editar-fecha').value = fechaFormateada;

    document.getElementById('editar-equipo').value = equipo;
    document.getElementById('editar-tecnico').value = tecnico;

    // Muestra el formulario de modificación
    document.getElementById('tabla-modificacion-procedimientos-admin').style.display = 'block';
}

// ELIMINACION DE REGISTROS EN LAS TABLAS admin y tecnico
function eliminarRegistro(id, tipo, origen) {
    let formType = tipo === 'equipo' ? 'eliminar_equipo' : 
                   tipo === 'tecnico' ? 'eliminar_tecnico' : 
                   'eliminar_procedimiento'; 
    let idField = tipo === 'equipo' ? 'ID_equipo=' + id : 
                  tipo === 'tecnico' ? 'documento=' + id : 
                  'ID=' + id; 

    if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        fetch('controlador/controlador_CRUD.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'form_type=' + formType + '&' + idField + '&origen=' + origen // Agregar el parámetro de origen
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Muestra el mensaje de éxito o error

            // Redirigir según el origen
            if (origen === 'inicio') {
                window.location.href = 'inicio.php';
            } else {
                window.location.href = 'admin_inicio.php';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Ocurrió un error al intentar eliminar el registro.");
        });
    }
}

// MODIFICACIONES Y AGRECACIONES DE LAS TABLAS tenicos
function tecnicos_editarRegistro_equipos(ID_equipo, marca, estado_equipo, fecha_ingreso, fecha_entrega, observaciones, sede) {
    document.getElementById('editar-ID_equipo').value = ID_equipo;
    document.getElementById('editar-marca').value = marca;
    document.getElementById('editar-estado_equipo').value = estado_equipo;
    document.getElementById('editar-fecha_ingreso').value = fecha_ingreso;
    document.getElementById('editar-fecha_entrega').value = fecha_entrega;
    document.getElementById('editar-observaciones').value = observaciones;
    document.getElementById('editar-sede').value = sede;

    document.getElementById('tabla-modificacion-registros').style.display = 'block';
}


function tecnicos_agregarProcedimientos(ID, descripcion_procedimiento, fecha_procedimiento,equipo, tecnico) {
    document.getElementById('agregar-ID_procedimiento'). value = ID;
    document.getElementById('agregar-descripcion_procedimiento').value = descripcion_procedimiento;
    document.getElementById('agregar-fecha_procedimiento').value = fecha_procedimiento;
    document.getElementById('agregar-FK_equipo').value = equipo;
    document.getElementById('agregar-documento_tecnico').value =tecnico;
}

function tecnico_editar_procedimiento(ID, descripcion_procedimiento, fecha_procedimiento, equipo, tecnico) {
    // Asigna los valores recibidos en los campos del formulario
    document.getElementById('editar-ID').value = ID;
    document.getElementById('editar-descripcion').value = descripcion_procedimiento;
    
    // Asegúrate de que la fecha esté en el formato 'YYYY-MM-DD' para el input tipo date
    let fechaFormateada = new Date(fecha_procedimiento).toISOString().split('T')[0]; 
    document.getElementById('editar-fecha').value = fechaFormateada;

    document.getElementById('editar-equipo').value = equipo;
    document.getElementById('editar-tecnico').value = tecnico;
    e
    // Muestra el formulario d modificación
    document.getElementById('tabla-modificacion-precedimeintos').style.display = 'block';
}


// FUNCION DEL BOTON "CANCELAR" EN LOS FORMULARIOS DE MODIFICACION admin y tecnico
function formularioCancelar(tipo) {
    if (tipo === 'equipo') {
        document.getElementById('tabla-modificacion-equipos').style.display = 'none';
        mostrar_Registros(); 

    } else if (tipo === 'tecnico') {
        document.getElementById('tabla-modificacion-tecnicos').style.display = 'none';
        mostrarUsuarios(); 

    } else if (tipo === 'procedimiento') {
        // Ocultamos el formulario de modificación
        document.getElementById('tabla-modificacion-precedimeintos').style.display = 'none';
        mostrar_procedimentos();

    } else if (tipo === 'tecnico-equipo') {
        document.getElementById('tabla-modificacion-registros').style.display = 'none';
        mostrar_Registros();
    }
}
