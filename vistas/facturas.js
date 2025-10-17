function cargarListaFacturas(componente){
    let data = ejecutarAjax("controladores/facturas.php", "leer_activo=1");
    console.log(data);
    if (data === "0") {
        $(componente).html(`<option value="0">Selecciona una factura</option>`);
    } else {
        let json_data = JSON.parse(data);
        $(componente).html(`<option value="0">Selecciona una factura</option>`);
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_factura}">   Nro ${item.id_factura} / Fecha : ${item.fecha} /Total: ${item.total}</option>`);
        });
    }
}