<?php
function get_conn() {
    $cx = new mysqli('localhost','root','','SkillMatch');
    if ($cx->connect_errno) throw new Exception('DB: '.$cx->connect_error);
    $cx->set_charset('utf8mb4');
    return $cx;
}

function addNotification(string $idusuario, string $tipo, ?int $referencia, string $mensaje): bool {
    // solo permitir tipos válidos
    $valid = ['reporte','solicitud','calificacion'];
    if (!in_array($tipo, $valid, true)) return false;
    try {
        $cx = get_conn();
        $stmt = $cx->prepare("INSERT INTO notificacion (idusuario, tipo, referencia, mensaje) VALUES (?,?,?,?)");
        if (!$stmt) throw new Exception($cx->error);
        $stmt->bind_param('siss', $idusuario, $tipo, $referencia, $mensaje);
        $ok = $stmt->execute();
        $stmt->close();
        $cx->close();
        return $ok;
    } catch (Exception $e) {
        error_log("addNotification error: ".$e->getMessage());
        return false;
    }
}

function fetchNotifications(string $idusuario, int $limit = 50): array {
    $cx = get_conn();
    $stmt = $cx->prepare("SELECT idnotificacion, tipo, referencia, mensaje, leida, fecha FROM notificacion WHERE idusuario = ? ORDER BY fecha DESC LIMIT ?");
    $stmt->bind_param('si', $idusuario, $limit);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $cx->close();
    return $rows;
}

function countUnread(string $idusuario): int {
    $cx = get_conn();
    $stmt = $cx->prepare("SELECT COUNT(*) AS cnt FROM notificacion WHERE idusuario = ? AND leida = 0");
    $stmt->bind_param('s', $idusuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    $cx->close();
    return (int)($row['cnt'] ?? 0);
}

function markAsRead(int $idnotificacion, string $idusuario): bool {
    $cx = get_conn();
    $stmt = $cx->prepare("UPDATE notificacion SET leida = 1 WHERE idnotificacion = ? AND idusuario = ?");
    $stmt->bind_param('is', $idnotificacion, $idusuario);
    $ok = $stmt->execute();
    $stmt->close();
    $cx->close();
    return $ok;
}
?>