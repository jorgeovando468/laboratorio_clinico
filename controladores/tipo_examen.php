<?php

require_once '../conexion/MySQL.php';

if (isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "INSERT INTO tipo_examen
	(nombre, estado)
	VALUES (:nombre, :estado)
            ");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}
if (isset($_POST['leer'])){

    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "SELECT id_tipo_examen, nombre,  estado
	FROM tipo_examen ORDER BY id_tipo_examen DESC");
    
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
            "SELECT id_tipo_examen, nombre, estado
	FROM tipo_examen WHERE id_tipo_examen= :id");
    
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
            "SELECT id_tipo_examen, nombre,  estado
	FROM tipo_examen
        WHERE concat(id_tipo_examen, nombre, estado ) LIKE  '%".$_POST['leer_descripcion']."%'"
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
            "UPDATE tipo_examen SET 
        nombre = :nombre,
        estado = :estado
        WHERE id_tipo_examen= :id_tipo_examen
");
    
        $query->execute($json_datos);
        $base_datos->cerrarsesion();
}

if (isset($_POST['eliminar'])){
    $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
            "DELETE FROM tipo_examen
        WHERE id_tipo_examen = :id_tipo_examen
");
    
        $query->execute([
            "id_tipo_examen" => $_POST['eliminar']
        ]);
        $base_datos->cerrarsesion();
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

