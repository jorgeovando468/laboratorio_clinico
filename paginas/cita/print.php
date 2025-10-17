<?php   
include '../../conexion/MySQL.php';
$base_datos = new MySQL();
$query = $base_datos->conectar()->prepare(
    "SELECT
        c.id_cita, c.paciente_id, c.medico_id, c.fecha, c.hora,
        c.estado, p.nombre AS paciente, m.nombre
    FROM cita c
    JOIN paciente p ON p.id_paciente = c.paciente_id
    JOIN medico m ON m.id_medico = c.medico_id
    WHERE c.id_cita = :id"
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
    <title>Comprobante de Cita Médica</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <div class="comprobante">
        <div class="header-comprobante">
            <h1>🏥 Comprobante de Cita Médica</h1>
            <div class="numero">
                Cita N° <?= str_pad($arr['id_cita'], 6, '0', STR_PAD_LEFT) ?>
            </div>
        </div>
        
        <div class="body-comprobante">
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
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">⏰ Hora de la Cita</div>
                    <div class="value"><?= date('h:i A', strtotime($arr['hora'])) ?></div>
                </div>
                
                <div class="info-item">
                    <div class="label">👤 Paciente</div>
                    <div class="value"><?= htmlspecialchars($arr['paciente']) ?></div>
                </div>
                
                <div class="info-item">
                    <div class="label">🩺 Médico</div>
                    <div class="value">Dr(a). <?= htmlspecialchars($arr['nombre']) ?></div>
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
                Por favor, llegue 15 minutos antes de su cita
            </p>
        </div>
    </div>
    
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Comprobante
    </button>
</body>
</html>
