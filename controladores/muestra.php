<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO muestra
	(examen_id, tipo, fecha_toma, estado)
	VALUES (:examen_id,  :tipo, :fecha_toma,  :estado)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT 
m.id_muestra, 
m.examen_id, 
m.tipo, 
m.fecha_toma, 
m.estado,
e.id_examen, e.fecha, e.paciente_id
	FROM muestra m
	JOIN examen e ON e.id_examen = m.examen_id
ORDER BY m.id_muestra DESC");
    
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
    
    $query = $base_datos->conectar()->prepare("SELECT id_muestra, examen_id, tipo, fecha_toma, estado
	FROM muestra
        WHERE id_muestra = :id
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
m.id_muestra, 
m.examen_id, 
m.tipo, 
m.fecha_toma, 
m.estado,
e.id_examen, e.fecha, e.paciente_id
	FROM muestra m
	JOIN examen e ON e.id_examen = m.examen_id
	WHERE CONCAT(m.id_muestra, m.examen_id, m.tipo, m.fecha_toma, m.estado) like '%".$_POST['leer_descripcion']."%'
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
      "UPDATE muestra SET
            examen_id = :examen_id,
            tipo = :tipo,
            fecha_toma = :fecha_toma,
            estado = :estado
    WHERE id_muestra = :id_muestra");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM muestra 
	where id_muestra= :id_muestra");
$query->execute(["id_muestra" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
