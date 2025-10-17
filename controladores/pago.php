<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "INSERT INTO pago
	(factura_id, monto, fecha, tipo_pago)
	VALUES (:factura_id,  :monto, :fecha,  :tipo_pago)"      
    );
    $query->execute($json_datos);
    $base_datos->cerrarsesion();
}

if (isset($_POST['leer'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare("SELECT p.id_pago, p.factura_id, p.monto, p.fecha, p.tipo_pago, f.id_factura, f.fecha
	FROM pago p 
	JOIN factura f ON f.id_factura = p.factura_id
ORDER BY p.id_pago DESC");
    
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
    
    $query = $base_datos->conectar()->prepare("SELECT id_pago, factura_id, monto, fecha, tipo_pago
	FROM pago
        WHERE id_pago = :id
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
    
    $query = $base_datos->conectar()->prepare("SELECT p.id_pago, p.factura_id, p.monto, p.fecha, p.tipo_pago, f.id_factura, f.fecha
	FROM pago p 
	JOIN factura f ON f.id_factura = p.factura_id
	WHERE concat(p.id_pago, p.factura_id, p.monto, p.fecha, p.tipo_pago) like '%".$_POST['leer_descripcion']."%'
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
      "UPDATE pago SET
            factura_id = :factura_id,
            monto = :monto,
            fecha = :fecha,
            tipo_pago = :tipo_pago
    WHERE id_pago = :id_pago");
    $query->execute($json_datos);
    $base_datos->cerrarsesion();   
}

if (isset($_POST['eliminar'])) {
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "DELETE FROM pago 
	where id_pago= :id_pago");
$query->execute(["id_pago" => $_POST['eliminar']]);
    $base_datos->cerrarsesion();      
}
