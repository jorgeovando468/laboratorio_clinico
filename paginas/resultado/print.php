<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

 $query = $base_datos->conectar()->prepare(
            "SELECT 
    r.id_resultado, r.parametro, r.valor, r.unidad, r.referencia, r.observacion,
   e.id_examen, e.fecha, e.paciente_id
FROM resultado r
JOIN examen e ON e.id_examen = r.examen_id
WHERE r.id_resultado = :id");
    
        $query->execute([
            "id" => $_GET['id']
        ]);
        
 $arr = $query->fetch(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Impresion de Resultados</title>
        <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="card" style="max-width: 500px;
             margin: 50px auto">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                    # <?=$arr ['id_resultado']?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                 <div class="row">
                    <div class="col-12">
                        <b style="font-size: 30px;">Fecha Examen: <?=$arr ['fecha']?> </b>
                    </div>
                    <div class="col-12">
                        <br> 
                    </div>
                     <div class="col-6"> 
                         <b> Paciente</b><?=$arr ['paciente_id']?>
                     </div>
                     <div class="col-6"> 
                         <b> Parametro</b><?=$arr ['parametro']?>
                     </div>
                     <div class="col-6"> 
                         <b> Valor</b><?=$arr ['valor']?>
                     </div>
                     <div class="col-6"> 
                         <b> Unidad</b><?=$arr ['unidad']?>
                     </div>
                     <div class="col-6"> 
                         <b> Referencia</b><?=$arr ['referencia']?>
                     </div>
                     <div class="col-6"> 
                         <b>Observacion</b> <?=$arr ['observacion']?>
                     </div>
                   
                </div>
            </div>
        </div>

    </body>
</html>