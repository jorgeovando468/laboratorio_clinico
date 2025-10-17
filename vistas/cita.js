function mostrarListarCita(){
    let contenido = dameContenido("paginas/cita/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaPacientes("#paciente_lst");
    cargarListaMedicos("#medico_lst");
    cargarTablaCita();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarCita(){
    if ($("#fecha").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#hora").val().trim().length === 0){
        alert("Debes ingresar una hora");
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
        hora: $("#hora").val(),
        paciente_id: $("#paciente_lst").val(),
        medico_id: $("#medico_lst").val(),
        estado: $("#estado_lst").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_cita").val() === "0") {
        let r = ejecutarAjax("controladores/cita.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Cita guardada correctamente");
            cargarTablaCita();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_cita: $("#id_cita").val()};
        let r = ejecutarAjax("controladores/cita.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Cita actualizada correctamente");
            cargarTablaCita();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaCita(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/cita.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/cita.php", "leer_descripcion="+descripcion);
    }

    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay citas registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_cita}</td>
                    <td>${item.paciente}</td>
                    <td>${item.medico}</td>
                    <td>${item.fecha}</td>
                    <td>${item.hora}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-cita">Editar</button>
                        <button class="btn btn-danger eliminar-cita">Eliminar</button>
                        <button class="btn btn-primary imprimir-cita" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-cita", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/cita.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_cita").val(json_data.id_cita);
    $("#fecha").val(json_data.fecha);
    $("#hora").val(json_data.hora);
    $("#paciente_lst").val(json_data.paciente_id);
    $("#medico_lst").val(json_data.medico_id);
    $("#estado_lst").val(json_data.estado);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-cita", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta cita?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/cita.php", "eliminar="+id);
        alert("Cita eliminada correctamente");
        cargarTablaCita();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_cita", function(){
    cargarTablaCita($(this).val());
});

$(document).on("click", ".imprimir-cita", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/cita/print.php?id="+id);
});