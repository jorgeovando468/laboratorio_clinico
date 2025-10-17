function mostrarListarResultado(){
    let contenido = dameContenido("paginas/resultado/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaExamenes("#examen_lst");
    cargarTablaResultado();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarResultado(){
    if ($("#valor").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#parametro").val().trim().length === 0){
        alert("Debes ingresar un total");
        return;
    }
    if ($("#referencia").val().trim().length === 0){
        alert("Debes ingresar un total");
        return;
    }
    if ($("#observacion").val().trim().length === 0){
        alert("Debes ingresar un total");
        return;
    }
    if ($("#examen_lst").val() === "0"){
        alert("Debes seleccionar un paciente");
        return;
    }

    if ($("#unidad_lst").val() === "0"){
        alert("Debes seleccionar un estado");
        return;
    }

    let data = {
        parametro: $("#parametro").val(),
        valor: $("#valor").val(),
        unidad: $("#unidad_lst").val(),
        referencia: $("#referencia").val(),
        examen_id: $("#examen_lst").val(),
        observacion: $("#observacion").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_resultado").val() === "0") {
        let r = ejecutarAjax("controladores/resultado.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Resultado guardada correctamente");
            cargarTablaResultado();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_resultado: $("#id_resultado").val()};
        let r = ejecutarAjax("controladores/resultado.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Resultado actualizada correctamente");
            cargarTablaResultado();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaResultado(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/resultado.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/resultado.php", "leer_descripcion="+descripcion);
    }

    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay resultados registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_resultado}</td>
                    <td>Nro ${item.id_examen} / Fecha : ${item.fecha} /Paciente: ${item.paciente_id}</td>
                    <td>${item.parametro}</td>
                    <td>${item.valor}</td>
                    <td>${item.unidad}</td>
                    <td>${item.referencia}</td>
                    <td>${item.observacion}</td>
                    <td>
                        <button class="btn btn-warning editar-resultado">Editar</button>
                        <button class="btn btn-danger eliminar-resultado">Eliminar</button>
                        <button class="btn btn-primary imprimir-resultado" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-resultado", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/resultado.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_resultado").val(json_data.id_resultado);
    $("#parametro").val(json_data.parametro);
    $("#valor").val(json_data.valor);
    $("#referencia").val(json_data.referencia);
    $("#observacion").val(json_data.observacion);
    $("#examen_lst").val(json_data.examen_id);
    $("#unidad_lst").val(json_data.unidad);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-resultado", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta resultado?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/resultado.php", "eliminar="+id);
        alert("Resultado eliminada correctamente");
        cargarTablaResultado();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_resultado", function(){
    cargarTablaResultado($(this).val());
});

$(document).on("click", ".imprimir-resultado", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/resultado/print.php?id="+id);
});