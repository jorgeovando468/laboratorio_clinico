<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "INSERT INTO medico 
	(nombre, matricula, telefono, email, estado)
	VALUES (:nombre, :matricula,  :telefono, :email, :estado)
            ");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}
if (isset($_POST['leer'])){

    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_medico, nombre, matricula, telefono, email, estado
	FROM medico ORDER BY id_medico DESC");
    
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
            "SELECT id_medico, nombre, matricula, telefono, email, estado
	FROM medico WHERE id_medico = :id");
    
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
            "SELECT id_medico, nombre, matricula, telefono, email, estado
	FROM medico
        WHERE concat(id_medico ,matricula, nombre, telefono, email, estado ) LIKE  '%".$_POST['leer_descripcion']."%'"
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
            "UPDATE medico SET 
        nombre = :nombre,
        matricula = :matricula,
        telefono = :telefono, 
        email = :email, 
        estado = :estado
        WHERE id_medico = :id_medico
");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}

if (isset($_POST['eliminar'])){
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "DELETE FROM medico 
        WHERE id_medico = :id_medico
");
    
        $query->execute([
            "id_medico" => $_POST['eliminar']
        ]);
        $base_datos->cerrarsesion();
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

