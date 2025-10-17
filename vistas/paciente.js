function mostrarListarPaciente(){
    let contenido = dameContenido("paginas/paciente/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPaciente();
}

function guardarPaciente(){
    if ($("#nombre").val().trim().length === 0){
              alert("Debes ingresar una nombre");
              return;
    }
    if ($("#documento").val().trim().length === 0){
              alert("Debes ingresar una descripcion");
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
      documento : $("#documento").val(),
      telefono : $("#telefono").val(),
      email : $("#email").val(),
      estado : $("#estado").val()
      
  };
    console.log(data);
    
    if ($("#id_paciente").val() === "0") {
          let r = ejecutarAjax("controladores/paciente.php",
    "guardar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Guardar correctamente");
        cargarTablaPaciente();
    }else {
        alert("Error en "+r);
    }
    } else {
        data = {...data, id_paciente : $("#id_paciente").val()};
          let r = ejecutarAjax("controladores/paciente.php",
    "actualizar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Actualizado correctamente");
        cargarTablaPaciente();
    }else {
        alert("Error en "+r);
    }
    }
}

function cargarTablaPaciente(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
            data = ejecutarAjax("controladores/paciente.php", "leer=1");
    }else {
            data = ejecutarAjax("controladores/paciente.php", "leer_descripcion="+descripcion);
    }


    console.log(data);
    $("#paciente_tb").html("");
    if (data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        console.log(json_data);
        json_data.map(function (item) {
            $("#paciente_tb").append(`
            <tr>
            <td>${item.id_paciente}</td>
            <td>${item.documento}</td>
            <td>${item.nombre}</td>
            <td>${item.telefono}</td>
            <td>${item.email}</td>
            <td>${item.estado}</td>
         
           <td>
            <button class="btn btn-warning editar-paciente" >Editar</button>
            <button class="btn btn-danger eliminar-paciente" >Eliminar</button>
            <button class="btn btn-primary imprimir-paciente" >Imprimir</button>
            </td>
            </tr>
        `);
        });
    }
    
    
}
/////////////////////

$(document).on("click", ".editar-paciente", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    let data = ejecutarAjax("controladores/paciente.php", "leer_id="+id);
    console.log(data);
    
    let json_data = JSON.parse(data);
    console.log(json_data);
    console.log(json_data.nombre);
    $("#nombre").val(json_data.nombre);
    $("#documento").val(json_data.documento);
    $("#telefono").val(json_data.telefono);
    $("#email").val(json_data.email);
    $("#estado").val(json_data.estado);
    $("#id_paciente").val(json_data.id_paciente);

});


///////////////////////////////////////////////////////

$(document).on("click", ".eliminar-paciente" , function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       let r = ejecutarAjax("controladores/paciente.php", "eliminar="+id);
       console.log(r);
       alert("Eliminado correctamente");
       cargarTablaPaciente();
});


///////////////////////////////////////

$(document).on("keyup", "#b_paciente", function (evt) {
    cargarTablaPaciente($(this).val());
});

$(document).on("click", ".imprimir-paciente", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/paciente/print.php?id="+id);
});


