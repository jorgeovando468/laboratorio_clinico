function mostrarListarMuestra(){
    let contenido = dameContenido("paginas/muestra/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaExamenes("#examen_lst");
    cargarTablaMuestra();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarMuestra(){
    if ($("#fecha").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#tipo").val().trim().length === 0){
        alert("Debes ingresar un tipo");
        return;
    }
    if ($("#examen_lst").val() === "0"){
        alert("Debes seleccionar un examen");
        return;
    }

    if ($("#estado_lst").val() === "0"){
        alert("Debes seleccionar un estado");
        return;
    }

    let data = {
        fecha_toma: $("#fecha").val(),
        tipo: $("#tipo").val(),
        examen_id: $("#examen_lst").val(),
        estado: $("#estado_lst").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_muestra").val() === "0") {
        let r = ejecutarAjax("controladores/muestra.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Muestra guardada correctamente");
            cargarTablaMuestra();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_muestra: $("#id_muestra").val()};
        let r = ejecutarAjax("controladores/muestra.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Muestra actualizada correctamente");
            cargarTablaMuestra();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaMuestra(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/muestra.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/muestra.php", "leer_descripcion="+descripcion);
    }
    console.log(data);
    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay muestras registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_muestra}</td>
                    <td>Nro ${item.id_examen} / Fecha : ${item.fecha} /Paciente: ${item.paciente_id}</td>
                    <td>${item.tipo}</td>
                    <td>${item.fecha_toma}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-muestra">Editar</button>
                        <button class="btn btn-danger eliminar-muestra">Eliminar</button>
                        <button class="btn btn-primary imprimir-muestra" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-muestra", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/muestra.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_muestra").val(json_data.id_muestra);
    $("#fecha").val(json_data.fecha_toma);
    $("#tipo").val(json_data.tipo);
    $("#examen_lst").val(json_data.examen_id);
    $("#estado_lst").val(json_data.estado);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-muestra", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta muestra?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/muestra.php", "eliminar="+id);
        alert("Muestra eliminada correctamente");
        cargarTablaMuestra();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_muestra", function(){
    cargarTablaMuestra($(this).val());
});

$(document).on("click", ".imprimir-muestra", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/muestra/print.php?id="+id);
});