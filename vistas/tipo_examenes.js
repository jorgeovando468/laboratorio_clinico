function cargarListaTipoExamenes(componente){
    let data = ejecutarAjax("controladores/tipo_examenes.php", "leer_activo=1");
    console.log(data);
    if (data === "0") {
        $(componente).html(`<option value="0">Selecciona un tipo examen</option>`);
    } else {
        let json_data = JSON.parse(data);
        $(componente).html(`<option value="0">Selecciona tipo examen</option>`);
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_tipo_examen}"> ${item.nombre}</option>`);
        });
    }
}