<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

$query = $base_datos->conectar()->prepare(
    "SELECT 
        m.id_muestra, 
        m.examen_id, 
        m.tipo, 
        m.fecha_toma, 
        m.estado,
        e.id_examen, e.fecha, e.estado
    FROM muestra m
    JOIN examen e ON e.id_examen = m.examen_id
    WHERE m.id_muestra = :id"
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
    <title>Impresión de Muestras</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <section class="imprimir"> <!-- Usando la clase de empleados -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        # <?= htmlspecialchars($arr['id_muestra']) ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="nombre-empleado"><?= htmlspecialchars($arr['tipo']) ?></span> <!-- Usando clase de empleados -->
                    </div>
                    <div class="col-12">
                        <br> 
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Fecha</span>
                        <span class="print-value"><?= date('d/m/Y', strtotime($arr['fecha_toma'])) ?></span>
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Fecha Examen</span>
                        <span class="print-value"><?= date('d/m/Y', strtotime($arr['fecha'])) ?></span>
                    </div>
                    <div class="col-6"> 
                        <span class="print-label">Estado</span>
                        <span class="print-value estado-badge <?= strtolower($arr['estado']) === 'activo' ? 'estado-activo' : (strtolower($arr['estado']) === 'pendiente' ? 'estado-pendiente' : 'estado-cancelado') ?>">
                            <?= htmlspecialchars($arr['estado']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Botón de impresión (opcional, oculto en print, como en empleados) -->
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Muestra
    </button>
</body>
</html>
