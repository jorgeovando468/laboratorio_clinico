<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO resultado
	(examen_id, parametro, valor, unidad, referencia, observacion)
	VALUES (:examen_id, :parametro, :valor, :unidad,  :referencia, :observacion)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT 
    r.id_resultado, r.parametro, r.valor, r.unidad, r.referencia, r.observacion,
   e.id_examen, e.fecha, e.paciente_id
FROM resultado r
JOIN examen e ON e.id_examen = r.examen_id
ORDER BY r.id_resultado DESC");
    
    $query->execute();    
    if($query->rowCount()){
        echo json_encode($query->fetchAll(PDO::FETCH_OBJ));
    }else{
        echo "0";
        $base_datos->cerrarsesion(); 
    }
}

//--------------------------------------
//--------------------------------------

if (isset($_POST['leer_id'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT id_resultado, examen_id, parametro, valor, unidad, referencia, observacion
	FROM resultado
        WHERE id_resultado = :id
");
    
    $query->execute([
        "id" => $_POST['leer_id']
        
    ]);    
    if($query->rowCount()){
        echo json_encode($query->fetch(PDO::FETCH_OBJ));
    }else{
        echo "0";
    }
}

if (isset($_POST['leer_descripcion'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT 
    r.id_resultado, r.parametro, r.valor, r.unidad, r.referencia, r.observacion,
    e.id_examen, e.fecha, e.paciente_id
FROM resultado r
JOIN examen e ON e.id_examen = r.examen_id
        WHERE concat(r.id_resultado, r.parametro, r.valor, r.unidad, r.referencia, r.observacion) like '%".$_POST['leer_descripcion']."%'
");
    
    $query->execute();    
    if($query->rowCount()){
        echo json_encode($query->fetchAll(PDO::FETCH_OBJ));
    }else{
        echo "0";
    }
}


if (isset($_POST['actualizar'])) {
     $json_datos = json_decode($_POST['actualizar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "UPDATE resultado SET
            examen_id = :examen_id,
            parametro = :parametro,
            valor = :valor,
            unidad = :unidad,
            referencia = :referencia,
            observacion = :observacion
    WHERE id_resultado = :id_resultado");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM resultado 
	where id_resultado = :id_resultado");
$query->execute(["id_resultado" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
