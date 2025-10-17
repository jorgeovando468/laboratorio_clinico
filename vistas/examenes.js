function cargarListaExamenes(componente){
    let data = ejecutarAjax("controladores/examenes.php", "leer_activo=1");
    console.log(data);
    if (data === "0") {
        $(componente).html(`<option value="0">Selecciona un examen</option>`);
    } else {
        let json_data = JSON.parse(data);
        $(componente).html(`<option value="0">Selecciona un examen</option>`);
        json_data.map(function(item){
            $(componente).append(`<option value="${item.id_examen}">Nro ${item.id_examen} / Fecha : ${item.fecha} /Paciente: ${item.paciente_id}</option>`);
        });
    }
}