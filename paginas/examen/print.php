<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

$query = $base_datos->conectar()->prepare(
    "SELECT 
        e.id_examen, 
        e.tipo_examen_id, 
        e.paciente_id, 
        e.medico_id, 
        e.fecha, 
        e.estado,
        p.nombre AS paciente,
        m.nombre AS medico,
        te.nombre AS tipo_examen
    FROM examen e
    JOIN paciente p ON p.id_paciente = e.paciente_id
    JOIN medico m ON m.id_medico = e.medico_id
    JOIN tipo_examen te ON te.id_tipo_examen = e.tipo_examen_id 
    WHERE e.id_examen = :id"
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
    <title>Impresión de Exámenes</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <div class="comprobante">
        <div class="card">
            <div class="header-comprobante">
                <h1>🏥 Comprobante de Examen</h1>
                <div class="row">
                    <div class="numero">
                        Examen N° <?= str_pad($arr['id_examen'], 6, '0', STR_PAD_LEFT) ?>
                    </div>
                </div>
            </div>
            <div class="body-comprobante">
                <div class="row">
                    <div class="col-12">
                        <div class="nombre-paciente"><?= htmlspecialchars($arr['paciente']) ?></div>
                    </div>
                    <div class="col-12">
                        <br> 
                    </div>
                    <div class="info-grid"> 
                        <div class="info-item">
                            <div class="label">Tipo de Examen</div>
                            <div class="value"><?= htmlspecialchars($arr['tipo_examen']) ?></div>
                        </div>
                    </div>
                    <div class="info-grid"> 
                        <div class="info-item"> 
                            <div class="label">Paciente</div>
                            <div class="value"><?= htmlspecialchars($arr['paciente']) ?></div>
                        </div>
                    </div>
                    <div class="info-grid"> 
                        <div class="info-item"> 
                            <div class="label">Médico</div>
                            <div class="value">Dr(a). <?= htmlspecialchars($arr['medico']) ?></div>
                        </div>
                    </div>
                    <div class="info-grid"> 
                        <div class="info-item"> 
                            <div class="fecha-destacada">
                                <div class="dia">
                                    <?php
                                    $fecha = new DateTime($arr['fecha']);
                                    echo $fecha->format('d');
                                    ?>
                                </div>
                                <div class="mes-ano">
                                    <?php
                                    $meses = [
                                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                    ];
                                    echo $meses[(int)$fecha->format('n')] . ' ' . $fecha->format('Y');
                                    ?>
                                </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="label">📋 Estado</div>
                        <div class="value">
                            <?php
                            $estado_lower = strtolower($arr['estado']);
                            $clase = 'estado-pendiente';

                            if (strpos($estado_lower, 'confirmado') !== false || strpos($estado_lower, 'confirmada') !== false) {
                                $clase = 'estado-confirmado';
                            } elseif (strpos($estado_lower, 'cancelado') !== false || strpos($estado_lower, 'cancelada') !== false) {
                                $clase = 'estado-cancelado';
                            }
                            ?>
                            <span class="estado-badge <?= $clase ?>">
                                <?= htmlspecialchars($arr['estado']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
                <div class="footer-comprobante">
            <p style="margin: 0;">
                📅 Comprobante generado el <?= date('d/m/Y') ?> a las <?= date('h:i A') ?>
            </p>
            <p style="margin: 5px 0 0 0; font-size: 12px;">
                Por favor, llegue 15 minutos antes de su examen
            </p>
        </div>
        </div>
    </div>
    
    <!-- Botón de imprimir (opcional, oculto en print) -->
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Examen
    </button>
</body>
</html>