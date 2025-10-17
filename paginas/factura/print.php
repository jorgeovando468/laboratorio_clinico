<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

$query = $base_datos->conectar()->prepare(
    "SELECT f.id_factura, f.paciente_id, f.fecha, f.total, f.estado, p.nombre AS paciente
    FROM factura f
    JOIN paciente p ON p.id_paciente = f.paciente_id
    WHERE f.id_factura = :id"
);
    
$query->execute([
    "id" => $_GET['id']
]);
        
$arr = $query->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de Facturas</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <section class="imprimir"> <!-- Usando la clase de empleados -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        # <?= htmlspecialchars($arr['id_factura']) ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="nombre-empleado">Paciente: <?= htmlspecialchars($arr['paciente']) ?></span> <!-- Usando clase de empleados -->
                    </div>
                    <div class="col-12">
                        <br> 
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Fecha</span> <!-- Usando clase de empleados -->
                        <span class="print-value"><?= date('d/m/Y', strtotime($arr['fecha'])) ?></span> <!-- Usando clase de empleados -->
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Total</span>
                        <span class="print-value total">$ <?= number_format($arr['total'], 2) ?></span> <!-- Usando clase de empleados, con formato -->
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Estado</span>
                        <span class="print-value estado-badge <?= strtolower($arr['estado']) === 'pagado' ? 'estado-pagado' : (strtolower($arr['estado']) === 'pendiente' ? 'estado-pendiente' : 'estado-cancelado') ?>">
                            <?= htmlspecialchars($arr['estado']) ?>
                        </span> <!-- Usando clase de empleados -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Botón de imprimir (opcional, oculto en print, como en empleados) -->
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Factura
    </button>
</body>
</html>
