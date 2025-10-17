<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO factura
	(paciente_id,  fecha, total, estado)
	VALUES (:paciente_id,  :fecha, :total,  :estado)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT f.id_factura, f.paciente_id, f.fecha, f.total, f.estado, p.nombre AS paciente
FROM factura f
JOIN paciente p ON p.id_paciente = f.paciente_id
ORDER BY f.id_factura DESC");
    
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
    
    $query = $base_datos->conectar()->prepare("SELECT id_factura, paciente_id, fecha, total, estado
	FROM factura
        WHERE id_factura = :id
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
    
    $query = $base_datos->conectar()->prepare("SELECT f.id_factura, f.paciente_id, f.fecha, f.total, f.estado, p.nombre AS paciente
FROM factura f
JOIN paciente p ON p.id_paciente = f.paciente_id
        WHERE concat(f.id_factura, f.paciente_id, f.fecha, f.total, f.estado, p.nombre) like '%".$_POST['leer_descripcion']."%'
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
      "UPDATE factura SET
            paciente_id = :paciente_id,
            fecha = :fecha,
            total = :total,
            estado = :estado
    WHERE id_factura = :id_factura");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM factura 
	where id_factura = :id_factura");
$query->execute(["id_factura" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
