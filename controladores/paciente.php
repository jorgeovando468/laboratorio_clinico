<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "INSERT INTO paciente 
	(documento, nombre, telefono, email, estado)
	VALUES (:documento, :nombre, :telefono, :email, :estado)
            ");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}
if (isset($_POST['leer'])){

    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_paciente, documento, nombre, telefono, email, estado
	FROM paciente ORDER BY id_paciente DESC");
    
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
            "SELECT id_paciente, documento, nombre, telefono, email, estado
	FROM paciente WHERE id_paciente = :id");
    
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
            "SELECT id_paciente ,documento, nombre, telefono, email, estado
	FROM paciente
        WHERE concat(id_paciente ,documento, nombre, telefono, email, estado ) LIKE  '%".$_POST['leer_descripcion']."%'"
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
            "UPDATE paciente SET 
        documento = :documento,
        nombre = :nombre,
        telefono = :telefono, 
        email = :email, 
        estado = :estado
        WHERE id_paciente = :id_paciente
");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}

if (isset($_POST['eliminar'])){
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "DELETE FROM paciente 
        WHERE id_paciente = :id_paciente
");
    
        $query->execute([
            "id_paciente" => $_POST['eliminar']
        ]);
        $base_datos->cerrarsesion();
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

