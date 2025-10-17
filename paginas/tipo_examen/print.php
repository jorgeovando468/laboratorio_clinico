<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

 $query = $base_datos->conectar()->prepare(
            "SELECT id_tipo_examen,  nombre,  estado
	FROM tipo_examen WHERE id_tipo_examen = :id");
    
        $query->execute([
            "id" => $_GET['id']
        ]);
        
 $arr = $query->fetch(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Impresion de Tipos de Examenes</title>
        <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    </head>
    <body>
        <section class="imprimir">
            <h2>Tipo Examen</h2>
            <form>
                <div class="card" style="max-width: 500px;
                    margin: 50px auto">
                   <div class="card-header">
                       <div class="row">
                           <div class="col-12">
                           # <?=$arr ['id_tipo_examen']?>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                        <div class="row">
                           <div class="col-12">
                               <b style="font-size: 30px;"><?=$arr ['nombre']?> </b>
                           </div>
                           <div class="col-12">
                               <br> 
                           </div>
                            <div class="col-6"> 
                                <b>Estado</b> <?=$arr ['estado']?>
                            </div>
                       </div>
                   </div>
               </div>
                
            </form>
            
        </section>
        

    </body>
</html>