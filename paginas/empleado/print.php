<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

$query = $base_datos->conectar()->prepare(
    "SELECT id_empleado, nombre, cargo, email, estado
    FROM empleado WHERE id_empleado = :id"
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
    <title>Impresión de Empleados</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <section class="imprimir">
        <h2>Empleados</h2>
        <form>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            # <?= htmlspecialchars($arr['id_empleado']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="nombre-empleado"><?= htmlspecialchars($arr['nombre']) ?></span>
                        </div>
                        <div class="col-12">
                            <br> 
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Cargo</span>
                            <span class="print-value"><?= htmlspecialchars($arr['cargo']) ?></span>
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Email</span>
                            <span class="print-value"><?= htmlspecialchars($arr['email']) ?></span>
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Estado</span>
                            <span class="print-value estado-badge <?= strtolower($arr['estado']) === 'activo' ? 'estado-activo' : (strtolower($arr['estado']) === 'inactivo' ? 'estado-inactivo' : 'estado-pendiente') ?>">
                                <?= htmlspecialchars($arr['estado']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    
    <!-- Botón de imprimir (opcional, oculto en print) -->
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Empleado
    </button>
</body>
</html>
