<?php
require_once '../conexion/MySQL.php';

if (isset($_POST['leer_activo'])) {
     $base_datos = new MySQL();
    
    $query = $base_datos->conectar()->prepare(
      "SELECT id_tipo_examen, nombre, estado
	FROM tipo_examen");
    
    $query->execute();    
    if($query->rowCount()){
        echo json_encode($query->fetchALL(PDO::FETCH_OBJ));
        $base_datos->cerrarsesion();
    }else{
        echo "0";
    }
}
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

