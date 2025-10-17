function mostrarListarMedico(){
    let contenido = dameContenido("paginas/medico/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaMedico();
}

function guardarMedico(){
    if ($("#nombre").val().trim().length === 0){
              alert("Debes ingresar una nombre");
              return;
    }
    if ($("#matricula").val().trim().length === 0){
              alert("Debes ingresar una matricula");
              return;
    }
    if ($("#telefono").val().trim().length === 0){
              alert("Debes ingresar un salario");
              return;
    }
    if ($("#email").val().trim().length === 0){
              alert("Debes ingresar un salario");
              return;
    }
 
  
  let data = {
      nombre : $("#nombre").val(),
      matricula : $("#matricula").val(),
      telefono : $("#telefono").val(),
      email : $("#email").val(),
      estado : $("#estado").val()
      
  };
    console.log(data);
    
    if ($("#id_medico").val() === "0") {
          let r = ejecutarAjax("controladores/medico.php",
    "guardar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Guardar correctamente");
        cargarTablaMedico();
    }else {
        alert("Error en "+r);
    }
    } else {
        data = {...data, id_medico : $("#id_medico").val()};
          let r = ejecutarAjax("controladores/medico.php",
    "actualizar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Actualizado correctamente");
        cargarTablaMedico();
    }else {
        alert("Error en "+r);
    }
    }
}

function cargarTablaMedico(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
            data = ejecutarAjax("controladores/medico.php", "leer=1");
    }else {
            data = ejecutarAjax("controladores/medico.php", "leer_descripcion="+descripcion);
    }


    console.log(data);
    $("#medico_tb").html("");
    if (data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        console.log(json_data);
        json_data.map(function (item) {
            $("#medico_tb").append(`
            <tr>
            <td>${item.id_medico}</td>
            <td>${item.matricula}</td>
            <td>${item.nombre}</td>
            <td>${item.telefono}</td>
            <td>${item.email}</td>
            <td>${item.estado}</td>
         
           <td>
            <button class="btn btn-warning editar-medico" >Editar</button>
            <button class="btn btn-danger eliminar-medico" >Eliminar</button>
            <button class="btn btn-primary imprimir-medico" >Imprimir</button>
            </td>
            </tr>
        `);
        });
    }
    
    
}
/////////////////////

$(document).on("click", ".editar-medico", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    let data = ejecutarAjax("controladores/medico.php", "leer_id="+id);
    console.log(data);
    
    let json_data = JSON.parse(data);
    console.log(json_data);
    console.log(json_data.nombre);
    $("#nombre").val(json_data.nombre);
    $("#matricula").val(json_data.matricula);
    $("#telefono").val(json_data.telefono);
    $("#email").val(json_data.email);
    $("#estado").val(json_data.estado);
    $("#id_medico").val(json_data.id_medico);

});


///////////////////////////////////////////////////////

$(document).on("click", ".eliminar-medico" , function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       let r = ejecutarAjax("controladores/medico.php", "eliminar="+id);
       console.log(r);
       alert("Eliminado correctamente");
       cargarTablaMedico();
});


///////////////////////////////////////

$(document).on("keyup", "#b_medico", function (evt) {
    cargarTablaMedico($(this).val());
});

$(document).on("click", ".imprimir-medico", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/medico/print.php?id="+id);
});


