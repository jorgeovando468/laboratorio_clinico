<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "INSERT INTO empleado 
	(nombre, cargo, email, estado)
	VALUES (:nombre, :cargo, :email, :estado)
            ");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}
if (isset($_POST['leer'])){

    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_empleado, nombre, cargo, email, estado
	FROM empleado ORDER BY id_empleado DESC");
    
        $query->execute();
        //$base_datos->cerrarsesion();
        
        if ($query->rowCount()) {
            echo json_encode($query->fetchAll(PDO::FETCH_OBJ));
        } else {
            echo "0";
        }
        
}
if (isset($_POST['leer_id'])){

    $base_datos = new MySQL();
    
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_empleado, nombre, cargo, email, estado
	FROM empleado WHERE id_empleado = :id");
    
        $query->execute([
            "id" => $_POST['leer_id']
        ]);
        //$base_datos->cerrarsesion();
        
        if ($query->rowCount()) {
            echo json_encode($query->fetch(PDO::FETCH_OBJ));
            
        } else {
            echo "0";
        }
        
}
if (isset($_POST['leer_descripcion'])){

    $base_datos = new MySQL();
    
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_empleado , nombre, cargo, email, estado
	FROM empleado
        WHERE concat(id_empleado , nombre, cargo, email, estado ) LIKE  '%".$_POST['leer_descripcion']."%'"
            );
    
        $query->execute();
        //$base_datos->cerrarsesion();
        
        if ($query->rowCount()) {
            echo json_encode($query->fetchAll(PDO::FETCH_OBJ));
            
        } else {
            echo "0";
        }
        
}
if (isset($_POST['actualizar'])){
    $json_datos = json_decode($_POST['actualizar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "UPDATE empleado SET 
        nombre = :nombre,
        cargo = :cargo, 
        email = :email, 
        estado = :estado
        WHERE id_empleado = :id_empleado
");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}

if (isset($_POST['eliminar'])){
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "DELETE FROM empleado 
        WHERE id_empleado = :id_empleado
");
    
        $query->execute([
            "id_empleado" => $_POST['eliminar']
        ]);
        $base_datos->cerrarsesion();
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

