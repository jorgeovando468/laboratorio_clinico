<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

 $query = $base_datos->conectar()->prepare(
            "SELECT p.id_pago, p.factura_id, p.monto, p.fecha, p.tipo_pago, f.estado AS estado_del_pago
	FROM pago p 
	JOIN factura f ON f.id_factura = p.factura_id
	WHERE p.id_pago = :id");
    
        $query->execute([
            "id" => $_GET['id']
        ]);
        
 $arr = $query->fetch(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Impresion de Pagos</title>
        <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="card" style="max-width: 500px;
             margin: 50px auto">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                    # <?=$arr ['id_pago']?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                 <div class="row">
                    <div class="col-12">
                        <b style="font-size: 30px;"><?=$arr ['estado_del_pago']?> </b>
                    </div>
                    <div class="col-12">
                        <br> 
                    </div>
                     <div class="col-6"> 
                         <b> Fecha</b><?=$arr ['fecha']?>
                     </div>
                     <div class="col-6"> 
                         <b>Monto</b> <?=$arr ['monto']?>
                     </div>
                     <div class="col-6"> 
                         <b>Tipo de Pago</b> <?=$arr ['tipo_pago']?>
                     </div>
                   
                </div>
            </div>
        </div>

    </body>
</html>