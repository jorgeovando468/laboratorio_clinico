<?php

require_once __DIR__ . '/../conexion/MySQL.php';
require_once __DIR__ . '/whatsapp_lib.php';

$base = new MySQL();
$pdo = $base->conectar();

function fetch_due_citas(PDO $pdo, string $tipo, int $targetMinutes, int $windowMinutes): array {
    $minFrom = $targetMinutes - $windowMinutes;
    $minTo = $targetMinutes + $windowMinutes;
    $stmt = $pdo->prepare(
        "SELECT c.id_cita
         FROM cita c
         LEFT JOIN recordatorio_log r ON r.cita_id = c.id_cita AND r.tipo = :tipo
         WHERE r.id IS NULL
           AND c.estado IN ('Pendiente')
           AND TIMESTAMPDIFF(MINUTE, NOW(), CONCAT(c.fecha, ' ', c.hora)) BETWEEN :min_from AND :min_to"
    );
    $stmt->execute([
        'tipo' => $tipo,
        'min_from' => $minFrom,
        'min_to' => $minTo,
    ]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

function run_reminders(PDO $pdo, string $tipo, int $targetMinutes, int $windowMinutes): array {
    $ids = fetch_due_citas($pdo, $tipo, $targetMinutes, $windowMinutes);
    $sent = 0; $failed = 0; $errors = [];
    foreach ($ids as $citaId) {
        [$ok, $resp] = send_reminder_for_cita($pdo, (int)$citaId, $tipo);
        if ($ok) { $sent++; } else { $failed++; $errors[] = ['cita_id'=>$citaId,'error'=>$resp]; }
    }
    return ['tipo'=>$tipo, 'candidatas'=>count($ids), 'enviadas'=>$sent, 'fallidas'=>$failed, 'errores'=>$errors];
}

// Configuración por defecto: ejecutar ambos si no se especifica
$run24h = isset($_GET['run_24h']) || isset($_POST['run_24h']) || (!isset($_GET['run_1h']) && !isset($_POST['run_1h']));
$run1h = isset($_GET['run_1h']) || isset($_POST['run_1h']) || (!isset($_GET['run_24h']) && !isset($_POST['run_24h']));

$resultados = [];
if ($run24h) {
    $resultados[] = run_reminders($pdo, '24h', 24*60, 10);
}
if ($run1h) {
    $resultados[] = run_reminders($pdo, '1h', 60, 10);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok'=>true,'resultados'=>$resultados], JSON_UNESCAPED_UNICODE);
