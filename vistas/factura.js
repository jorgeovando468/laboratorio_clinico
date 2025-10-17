function mostrarListarFactura(){
    let contenido = dameContenido("paginas/factura/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaPacientes("#paciente_lst");
    cargarTablaFactura();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarFactura(){
    if ($("#fecha").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#total").val().trim().length === 0){
        alert("Debes ingresar un total");
        return;
    }
    if ($("#paciente_lst").val() === "0"){
        alert("Debes seleccionar un paciente");
        return;
    }

    if ($("#estado_lst").val() === "0"){
        alert("Debes seleccionar un estado");
        return;
    }

    let data = {
        fecha: $("#fecha").val(),
        total: $("#total").val(),
        paciente_id: $("#paciente_lst").val(),
        estado: $("#estado_lst").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_factura").val() === "0") {
        let r = ejecutarAjax("controladores/factura.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Factura guardada correctamente");
            cargarTablaFactura();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_factura: $("#id_factura").val()};
        let r = ejecutarAjax("controladores/factura.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Factura actualizada correctamente");
            cargarTablaFactura();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaFactura(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/factura.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/factura.php", "leer_descripcion="+descripcion);
    }

    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay facturas registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_factura}</td>
                    <td>${item.paciente}</td>
                    <td>${item.fecha}</td>
                    <td>${item.total}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="btn btn-warning editar-factura">Editar</button>
                        <button class="btn btn-danger eliminar-factura">Eliminar</button>
                        <button class="btn btn-primary imprimir-factura" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-factura", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/factura.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_factura").val(json_data.id_factura);
    $("#fecha").val(json_data.fecha);
    $("#total").val(json_data.total);
    $("#paciente_lst").val(json_data.paciente_id);
    $("#estado_lst").val(json_data.estado);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-factura", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta factura?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/factura.php", "eliminar="+id);
        alert("Factura eliminada correctamente");
        cargarTablaFactura();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_factura", function(){
    cargarTablaFactura($(this).val());
});

$(document).on("click", ".imprimir-factura", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/factura/print.php?id="+id);
});