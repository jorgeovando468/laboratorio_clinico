function mostrarListarEmpleado(){
    let contenido = dameContenido("paginas/empleado/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaEmpleado();
}

function guardarEmpleado(){
    if ($("#nombre").val().trim().length === 0){
              alert("Debes ingresar una nombre");
              return;
    }
    if ($("#cargo").val().trim().length === 0){
              alert("Debes ingresar una cargo");
              return;
    }
    if ($("#email").val().trim().length === 0){
              alert("Debes ingresar un email");
              return;
    }
 
  
  let data = {
      nombre : $("#nombre").val(),
      cargo : $("#cargo").val(),
      email : $("#email").val(),
      estado : $("#estado").val()
      
  };
    console.log(data);
    
    if ($("#id_empleado").val() === "0") {
          let r = ejecutarAjax("controladores/empleado.php",
    "guardar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Guardar correctamente");
        cargarTablaEmpleado();
    }else {
        alert("Error en "+r);
    }
    } else {
        data = {...data, id_empleado : $("#id_empleado").val()};
          let r = ejecutarAjax("controladores/empleado.php",
    "actualizar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Actualizado correctamente");
        cargarTablaEmpleado();
    }else {
        alert("Error en "+r);
    }
    }
}

function cargarTablaEmpleado(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
            data = ejecutarAjax("controladores/empleado.php", "leer=1");
    }else {
            data = ejecutarAjax("controladores/empleado.php", "leer_descripcion="+descripcion);
    }


    console.log(data);
    $("#empleado_tb").html("");
    if (data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        console.log(json_data);
        json_data.map(function (item) {
            $("#empleado_tb").append(`
            <tr>
            <td>${item.id_empleado}</td>
            <td>${item.nombre}</td>
            <td>${item.cargo}</td>
            <td>${item.email}</td>
            <td>${item.estado}</td>
         
           <td>
            <button class="btn btn-warning editar-empleado" >Editar</button>
            <button class="btn btn-danger eliminar-empleado" >Eliminar</button>
            <button class="btn btn-primary imprimir-empleado" >Imprimir</button>
            </td>
            </tr>
        `);
        });
    }
    
    
}
/////////////////////

$(document).on("click", ".editar-empleado", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    let data = ejecutarAjax("controladores/empleado.php", "leer_id="+id);
    console.log(data);
    
    let json_data = JSON.parse(data);
    console.log(json_data);
    console.log(json_data.nombre);
    $("#nombre").val(json_data.nombre);
    $("#cargo").val(json_data.telefono);
    $("#email").val(json_data.email);
    $("#estado").val(json_data.estado);
    $("#id_empleado").val(json_data.id_empleado);

});


///////////////////////////////////////////////////////

$(document).on("click", ".eliminar-empleado" , function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       let r = ejecutarAjax("controladores/empleado.php", "eliminar="+id);
       console.log(r);
       alert("Eliminado correctamente");
       cargarTablaEmpleado();
});


///////////////////////////////////////

$(document).on("keyup", "#b_empleado", function (evt) {
    cargarTablaEmpleado($(this).val());
});

$(document).on("click", ".imprimir-empleado", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/empleado/print.php?id="+id);
});


