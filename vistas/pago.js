function mostrarListarPago(){
    let contenido = dameContenido("paginas/pago/listar.php");
    $("#contenido-principal").html(contenido);
    cargarListaFacturas("#factura_lst");
    cargarTablaPago();
}

// ===============================
// GUARDAR O ACTUALIZAR CITA
// ===============================
function guardarPago(){
    if ($("#fecha").val().trim().length === 0){
        alert("Debes seleccionar una fecha");
        return;
    }
    if ($("#monto").val().trim().length === 0){
        alert("Debes ingresar un monto");
        return;
    }
    if ($("#factura_lst").val() === "0"){
        alert("Debes seleccionar un paciente");
        return;
    }

    if ($("#tipo_pago").val() === "0"){
        alert("Debes seleccionar un metodo de pago");
        return;
    }

    let data = {
        fecha: $("#fecha").val(),
        monto: $("#monto").val(),
        factura_id: $("#factura_lst").val(),
        tipo_pago: $("#tipo_pago").val()
    };

    console.log(data);

    // Guardar nuevo
    if ($("#id_pago").val() === "0") {
        let r = ejecutarAjax("controladores/pago.php", "guardar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Pago guardada correctamente");
            cargarTablaPago();
        } else {
            alert("Error al guardar: " + r);
        }
    } else {
        // Actualizar existente
        data = {...data, id_pago: $("#id_pago").val()};
        let r = ejecutarAjax("controladores/pago.php", "actualizar="+JSON.stringify(data));
        if (r.length === 0) {
            alert("Pago actualizada correctamente");
            cargarTablaPago();
        } else {
            alert("Error al actualizar: " + r);
        }
    }
}

// ===============================
// CARGAR TABLA DE CITAS
// ===============================
function cargarTablaPago(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
        data = ejecutarAjax("controladores/pago.php", "leer=1");
    } else {
        data = ejecutarAjax("controladores/pago.php", "leer_descripcion="+descripcion);
    }

    $("#datos_tb").html("");
    if (data === "0") {
        $("#datos_tb").html(`<tr><td colspan="7">No hay pagos registradas</td></tr>`);
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            $("#datos_tb").append(`
                <tr>
                    <td>${item.id_pago}</td>
                    <td>Nro ${item.id_factura} / Fecha : ${item.fecha} /Total: ${item.monto}</td>
                    <td>${item.fecha}</td>
                    <td>${item.monto}</td>
                    <td>${item.tipo_pago}</td>
                    <td>
                        <button class="btn btn-warning editar-pago">Editar</button>
                        <button class="btn btn-danger eliminar-pago">Eliminar</button>
                        <button class="btn btn-primary imprimir-pago" >Imprimir</button>
                    </td>
                </tr>
            `);
        });
    }
}

// ===============================
// EDITAR CITA
// ===============================
$(document).on("click", ".editar-pago", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let data = ejecutarAjax("controladores/pago.php", "leer_id="+id);
    let json_data = JSON.parse(data);

    $("#id_pago").val(json_data.id_pago);
    $("#fecha").val(json_data.fecha);
    $("#monto").val(json_data.monto);
    $("#factura_lst").val(json_data.factura_id);
    $("#tipo_pago").val(json_data.tipo_pago);
});

// ===============================
// ELIMINAR CITA
// ===============================
$(document).on("click", ".eliminar-pago", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let confirmar = confirm("¿Deseas eliminar esta pago?");
    if (confirmar) {
        let r = ejecutarAjax("controladores/pago.php", "eliminar="+id);
        alert("Pago eliminada correctamente");
        cargarTablaPago();
    }
});

// ===============================
// BUSCADOR
// ===============================
$(document).on("keyup", "#b_pago", function(){
    cargarTablaPago($(this).val());
});

$(document).on("click", ".imprimir-pago", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/pago/print.php?id="+id);
});