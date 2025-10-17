function mostrarListarTipoExamen(){
    let contenido = dameContenido("paginas/tipo_examen/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaTipoExamen();
}

function guardarTipoExamen(){
    if ($("#nombre").val().trim().length === 0){
              alert("Debes ingresar una nombre");
              return;
    }

  let data = {
      nombre : $("#nombre").val(),
      estado : $("#estado").val()
      
  };
    console.log(data);
    
    if ($("#id_tipo_examen").val() === "0") {
          let r = ejecutarAjax("controladores/tipo_examen.php",
    "guardar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Guardar correctamente");
        cargarTablaTipoExamen();
    }else {
        alert("Error en "+r);
    }
    } else {
        data = {...data, id_tipo_examen : $("#id_tipo_examen").val()};
          let r = ejecutarAjax("controladores/tipo_examen.php",
    "actualizar="+JSON.stringify(data));
    
    console.log(r);
    
    if (r.length === 0) {
        alert("Actualizado correctamente");
        cargarTablaTipoExamen();
    }else {
        alert("Error en "+r);
    }
    }
}

function cargarTablaTipoExamen(descripcion = ""){
    let data = "0";
    if (descripcion.length === 0) {
            data = ejecutarAjax("controladores/tipo_examen.php", "leer=1");
    }else {
            data = ejecutarAjax("controladores/tipo_examen.php", "leer_descripcion="+descripcion);
    }


    console.log(data);
    $("#tipo_examen_tb").html("");
    if (data === "0"){
        
    }else{
        let json_data = JSON.parse(data);
        console.log(json_data);
        json_data.map(function (item) {
            $("#tipo_examen_tb").append(`
            <tr>
            <td>${item.id_tipo_examen}</td>
            <td>${item.nombre}</td>
            <td>${item.estado}</td>
         
           <td>
            <button class="btn btn-warning editar-tipo_examen" >Editar</button>
            <button class="btn btn-danger eliminar-tipo_examen" >Eliminar</button>
            <button class="btn btn-primary imprimir-tipo_examen" >Imprimir</button>
            </td>
            </tr>
        `);
        });
    }
    
    
}
/////////////////////

$(document).on("click", ".editar-tipo_examen", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    console.log(id);
    
    let data = ejecutarAjax("controladores/tipo_examen.php", "leer_id="+id);
    console.log(data);
    
    let json_data = JSON.parse(data);
    console.log(json_data);
    console.log(json_data.nombre);
    $("#nombre").val(json_data.nombre);
    $("#estado").val(json_data.estado);
    $("#id_tipo_examen").val(json_data.id_tipo_examen);

});


///////////////////////////////////////////////////////

$(document).on("click", ".eliminar-tipo_examen" , function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       let r = ejecutarAjax("controladores/tipo_examen.php", "eliminar="+id);
       console.log(r);
       alert("Eliminado correctamente");
       cargarTablaTipoExamen();
});


///////////////////////////////////////

$(document).on("keyup", "#b_tipo_examen", function (evt) {
    cargarTablaTipoExamen($(this).val());
});

$(document).on("click", ".imprimir-tipo_examen", function (evt) {
       let id = $(this).closest("tr").find("td:eq(0)").text();
       
       window.open("paginas/tipo_examen/print.php?id="+id);
});


