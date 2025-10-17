<?php   
include '../../conexion/MySQL.php';

$base_datos = new MySQL();

$query = $base_datos->conectar()->prepare(
    "SELECT id_medico, nombre, matricula, telefono, email, estado
    FROM medico WHERE id_medico = :id"
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
    <title>Impresión de Medicos</title>
    <link rel="stylesheet" href="../../bootstrap-5.3.6-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/print-styles.css"/> <!-- Enlace al CSS externo reutilizable -->
</head>
<body>
    <section class="imprimir"> <!-- Usando la clase de empleados -->
        <h2>Medicos</h2>
        <form>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            # <?= htmlspecialchars($arr['id_medico']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="nombre-empleado"><?= htmlspecialchars($arr['nombre']) ?></span> <!-- Usando clase de empleados -->
                        </div>
                        <div class="col-12">
                            <br> 
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Matricula</span> <!-- Usando clase de empleados -->
                            <span class="print-value"><?= htmlspecialchars($arr['matricula']) ?></span>
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Telefono</span>
                            <span class="print-value"><?= htmlspecialchars($arr['telefono']) ?></span>
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Email</span>
                            <span class="print-value"><?= htmlspecialchars($arr['email']) ?></span>
                        </div>
                        <div class="col-6"> 
                            <span class="print-label">Estado</span>
                            <span class="print-value estado-badge <?= strtolower($arr['estado']) === 'activo' ? 'estado-activo' : (strtolower($arr['estado']) === 'inactivo' ? 'estado-inactivo' : 'estado-pendiente') ?>">
                                <?= htmlspecialchars($arr['estado']) ?>
                            </span> <!-- Usando clase de empleados -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    
    <!-- Botón de impresión (opcional, oculto en print, como en empleados) -->
    <button class="btn-imprimir print-no-print" onclick="window.print()">
        🖨️ Imprimir Medico
    </button>
</body>
</html>