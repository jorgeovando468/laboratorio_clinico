<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO examen
	(tipo_examen_id, paciente_id, medico_id, fecha, estado)
	VALUES (:tipo_examen_id, :paciente_id, :medico_id, :fecha,  :estado)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT 
e.id_examen, 
e.tipo_examen_id, 
e.paciente_id, 
e.medico_id, 
e.fecha, 
e.estado,
p.nombre AS paciente,
m.nombre AS medico,
te.nombre AS tipo_examen
	FROM examen e
	JOIN paciente p ON p.id_paciente = e.paciente_id
	JOIN medico m ON m.id_medico = e.medico_id
	JOIN tipo_examen te ON te.id_tipo_examen = e.tipo_examen_id 
                        ORDER BY e.id_examen DESC");
    
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
    
    $query = $base_datos->conectar()->prepare("SELECT id_examen, tipo_examen_id, paciente_id, medico_id, fecha, estado
	FROM examen
        WHERE id_examen = :id
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
e.id_examen, 
e.tipo_examen_id, 
e.paciente_id, 
e.medico_id, 
e.fecha, 
e.estado,
p.nombre AS paciente,
m.nombre AS medico,
te.nombre AS tipo_examen
	FROM examen e
	JOIN paciente p ON p.id_paciente = e.paciente_id
	JOIN medico m ON m.id_medico = e.medico_id
	JOIN tipo_examen te ON te.id_tipo_examen = e.tipo_examen_id 
        WHERE concat(e.id_examen, 
e.tipo_examen_id, 
e.paciente_id, 
e.medico_id, 
e.fecha, 
e.estado, p.nombre, m.nombre, te.nombre) like '%".$_POST['leer_descripcion']."%'
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
      "UPDATE examen SET
            tipo_examen_id = :tipo_examen_id,
            paciente_id = :paciente_id,
            medico_id = :medico_id,
            fecha = :fecha,
            estado = :estado
    WHERE id_examen = :id_examen");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM examen 
	where id_examen = :id_examen");
$query->execute(["id_examen" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
