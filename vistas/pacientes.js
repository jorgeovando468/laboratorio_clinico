function cargarListaPacientes(componente){
    let data = ejecutarAjax("controladores/pacientes.php", "leer_activo=1");
    console.log(data);
    if (data === "0") {
        $(componente).html(`<option value="0">Selecciona un paciente</option>`);
    } else {
        let json_data = JSON.parse(data);
        $(componente).html(`<option value="0">Selecciona un paciente</option>`);
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_paciente}">${item.nombre}</option>`);
        });
    }
}