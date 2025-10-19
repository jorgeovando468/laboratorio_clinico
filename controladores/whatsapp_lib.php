<?php

require_once __DIR__ . '/../conexion/MySQL.php';

function get_whatsapp_config(PDO $pdo): ?array {
    $stmt = $pdo->prepare("SELECT id, phone_number_id, access_token, country_code, enabled FROM config_whatsapp ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return null;
    }
    return $row;
}

function normalize_phone_with_country(string $rawPhone, string $countryCode): string {
    $digitsOnly = preg_replace('/\D+/', '', $rawPhone);
    $countryDigits = preg_replace('/\D+/', '', $countryCode);
    if ($digitsOnly === '') {
        return '';
    }
    if (strpos($digitsOnly, $countryDigits) === 0) {
        return $digitsOnly; // already international format without '+'
    }
    // Remove leading zeros
    $digitsOnly = ltrim($digitsOnly, '0');
    return $countryDigits . $digitsOnly;
}

function send_whatsapp_text(PDO $pdo, string $toPhone, string $message): array {
    $config = get_whatsapp_config($pdo);
    if (!$config || intval($config['enabled']) !== 1) {
        return [false, 'WhatsApp not configured or disabled'];
    }

    $endpoint = 'https://graph.facebook.com/v20.0/' . $config['phone_number_id'] . '/messages';
    $payload = [
        'messaging_product' => 'whatsapp',
        'to' => $toPhone,
        'type' => 'text',
        'text' => [
            'preview_url' => false,
            'body' => $message
        ]
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $config['access_token']
    ];

    $body = json_encode($payload, JSON_UNESCAPED_UNICODE);

    // Prefer cURL; fallback to file_get_contents
    if (function_exists('curl_init')) {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($response === false) {
            return [false, 'cURL error: ' . $error];
        }
    } else {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $headers),
                'content' => $body,
                'ignore_errors' => true
            ]
        ]);
        $response = file_get_contents($endpoint, false, $context);
        $httpCode = 0;
        if (isset($http_response_header) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
            $httpCode = intval($m[1]);
        }
    }

    if ($httpCode >= 200 && $httpCode < 300) {
        return [true, $response];
    }
    return [false, 'HTTP ' . $httpCode . ' ' . $response];
}

function log_recordatorio(PDO $pdo, int $citaId, string $tipo, string $destinatario, string $estado): void {
    $stmt = $pdo->prepare("INSERT IGNORE INTO recordatorio_log (cita_id, tipo, destinatario, estado) VALUES (:cita_id, :tipo, :destinatario, :estado)");
    $stmt->execute([
        'cita_id' => $citaId,
        'tipo' => $tipo,
        'destinatario' => $destinatario,
        'estado' => $estado
    ]);
}

function build_confirmation_message(array $data): string {
    // $data keys: paciente, medico, fecha, hora
    $fecha = date('d/m/Y', strtotime($data['fecha']));
    $hora = date('H:i', strtotime($data['hora']));
    $paciente = $data['paciente'];
    $medico = $data['medico'];
    $line1 = "Hola $paciente, tu cita ha sido confirmada.";
    $line2 = "Fecha: $fecha a las $hora.";
    $line3 = "Médico: $medico.";
    $line4 = "Si necesitas reprogramar o cancelar, responde a este mensaje.";
    return $line1 . "\n" . $line2 . "\n" . $line3 . "\n" . $line4;
}

function build_reminder_message(array $data, string $tipo): string {
    $fecha = date('d/m/Y', strtotime($data['fecha']));
    $hora = date('H:i', strtotime($data['hora']));
    $paciente = $data['paciente'];
    $medico = $data['medico'];
    $prefijo = $tipo === '1h' ? 'Recordatorio: falta 1 hora para tu cita.' : 'Recordatorio: falta 1 día para tu cita.';
    $line1 = "Hola $paciente. $prefijo";
    $line2 = "Fecha: $fecha a las $hora.";
    $line3 = "Médico: $medico.";
    $line4 = "Por favor llega 10-15 minutos antes. Para reprogramar, responde a este mensaje.";
    return $line1 . "\n" . $line2 . "\n" . $line3 . "\n" . $line4;
}

function send_confirmation_for_cita(PDO $pdo, int $citaId): array {
    $stmt = $pdo->prepare(
        "SELECT c.id_cita, c.fecha, c.hora, p.nombre AS paciente, p.telefono AS telefono, m.nombre AS medico,
                cw.country_code AS country_code
         FROM cita c
         JOIN paciente p ON p.id_paciente = c.paciente_id
         JOIN medico m ON m.id_medico = c.medico_id
         LEFT JOIN config_whatsapp cw ON cw.enabled = 1
         WHERE c.id_cita = :id
         ORDER BY cw.id DESC LIMIT 1"
    );
    $stmt->execute(['id' => $citaId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return [false, 'No se encontró la cita'];
    }
    $countryCode = $row['country_code'] ?: '595';
    $to = normalize_phone_with_country($row['telefono'] ?? '', $countryCode);
    if (strlen($to) < 8) {
        return [false, 'Teléfono del paciente inválido'];
    }
    $message = build_confirmation_message($row);
    [$ok, $resp] = send_whatsapp_text($pdo, $to, $message);
    log_recordatorio($pdo, $citaId, 'confirmacion', $to, $ok ? 'enviado' : 'fallido');
    return [$ok, $resp];
}

function send_reminder_for_cita(PDO $pdo, int $citaId, string $tipo): array {
    if (!in_array($tipo, ['24h','1h'], true)) {
        return [false, 'Tipo de recordatorio inválido'];
    }
    $stmt = $pdo->prepare(
        "SELECT c.id_cita, c.fecha, c.hora, p.nombre AS paciente, p.telefono AS telefono, m.nombre AS medico,
                cw.country_code AS country_code
         FROM cita c
         JOIN paciente p ON p.id_paciente = c.paciente_id
         JOIN medico m ON m.id_medico = c.medico_id
         LEFT JOIN config_whatsapp cw ON cw.enabled = 1
         WHERE c.id_cita = :id
         ORDER BY cw.id DESC LIMIT 1"
    );
    $stmt->execute(['id' => $citaId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return [false, 'No se encontró la cita'];
    }
    $countryCode = $row['country_code'] ?: '595';
    $to = normalize_phone_with_country($row['telefono'] ?? '', $countryCode);
    if (strlen($to) < 8) {
        return [false, 'Teléfono del paciente inválido'];
    }
    $message = build_reminder_message($row, $tipo);
    [$ok, $resp] = send_whatsapp_text($pdo, $to, $message);
    log_recordatorio($pdo, $citaId, $tipo, $to, $ok ? 'enviado' : 'fallido');
    return [$ok, $resp];
}
