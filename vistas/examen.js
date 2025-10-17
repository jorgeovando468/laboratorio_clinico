function mostrarListarExamen(){
    let contenido = dameContenido("paginas/examen/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaPacientes("#paciente_lst");
    cargarListaMedicos("#medico_lst");
    cargarListaTipoExamenes("#tipo_examen_lst");
    cargarTablaExamen();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarExamen(){
    if ($("#fecha").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#tipo_examen_lst").val() === "0"){
        alert("Debes ingresar un tipo de examen");
        return;
    }
    if ($("#paciente_lst").val() === "0"){
        alert("Debes seleccionar un paciente");
        return;
    }
    if ($("#medico_lst").val() === "0"){
        alert("Debes seleccionar un médico");
        return;
    }
    if ($("#estado_lst").val() === "0"){
        alert("Debes seleccionar un estado");
        return;
    }

    let data = {
        fecha: $("#fecha").val(),
        tipo_examen_id: $("#tipo_examen_lst").val(),
        paciente_id: $("#paciente_lst").val(),
        medico_id: $("#medico_lst").val(),
        estado: $("#estado_lst").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_examen").val() === "0") {
        let r = ejecutarAjax("controladores/examen.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Examen guardada correctamente");
            cargarTablaExamen();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_examen: $("#id_examen").val()};
        let r = ejecutarAjax("controladores/examen.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Examen actualizada correctamente");
            cargarTablaExamen();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaExamen(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/examen.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/examen.php", "leer_descripcion="+descripcion);
    }

    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay examens registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_examen}</td>
                    <td>${item.tipo_examen}</td>
                    <td>${item.paciente}</td>
                    <td>${item.medico}</td>
                    <td>${item.fecha}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-examen">Editar</button>
                        <button class="btn btn-danger eliminar-examen">Eliminar</button>
                        <button class="btn btn-primary imprimir-examen" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-examen", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/examen.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_examen").val(json_data.id_examen);
    $("#fecha").val(json_data.fecha);
    $("#hora").val(json_data.hora);
    $("#tipo_examen_lst").val(json_data.tipo_examen_id);
    $("#paciente_lst").val(json_data.paciente_id);
    $("#medico_lst").val(json_data.medico_id);
    $("#estado_lst").val(json_data.estado);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-examen", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta examen?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/examen.php", "eliminar="+id);
        alert("Examen eliminada correctamente");
        cargarTablaExamen();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_examen", function(){
    cargarTablaExamen($(this).val());
});

$(document).on("click", ".imprimir-examen", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/examen/print.php?id="+id);
});