function cargarListaMedicos(componente){
    let data = ejecutarAjax("controladores/medicos.php", "leer_activo=1 ");
    if (data === "0") {
        $(componente).html(`<option value="0">Selecciona un médico</option>`);
    } else {
        let json_data = JSON.parse(data);
        $(componente).html(`<option value="0">Selecciona un médico</option>`);
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_medico}">${item.nombre}</option>`);
        });
    }
}