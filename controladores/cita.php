<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO cita
	(paciente_id, medico_id, fecha, hora, estado)
	VALUES (:paciente_id, :medico_id, :fecha, :hora,  :estado)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT
c.id_cita, c.paciente_id, c.medico_id, c.fecha, c.hora,
c.estado, p.nombre AS paciente, m.nombre As medico
FROM cita c
JOIN paciente p ON p.id_paciente = c.paciente_id
JOIN medico m ON m.id_medico = c.medico_id
ORDER BY c.id_cita DESC");
    
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
    
    $query = $base_datos->conectar()->prepare("SELECT id_cita, paciente_id, medico_id, fecha, hora, estado
	FROM cita
        WHERE id_cita = :id
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
c.id_cita, c.paciente_id, c.medico_id, c.fecha, c.hora,
c.estado, p.nombre AS paciente, m.nombre As medico
FROM cita c
JOIN paciente p ON p.id_paciente = c.paciente_id
JOIN medico m ON m.id_medico = c.medico_id
        WHERE concat(c.id_cita, c.paciente_id, c.medico_id, c.fecha, c.hora,
c.estado, p.nombre, m.nombre) like '%".$_POST['leer_descripcion']."%'
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
      "UPDATE cita SET
            paciente_id = :paciente_id,
            medico_id = :medico_id,
            fecha = :fecha,
            hora = :hora,
            estado = :estado
    WHERE id_cita = :id_cita");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM cita 
	where id_cita = :id_cita");
$query->execute(["id_cita" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
