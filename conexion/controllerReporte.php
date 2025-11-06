<?php
// Guardar reportes enviados desde publicacion.php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/notificaciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no soportado']);
    exit;
}

$action = $_POST['action'] ?? '';
if ($action !== 'reportar') {
    echo json_encode(['success' => false, 'error' => 'Acción inválida']);
    exit;
}

$idservicio = isset($_POST['idservicio']) ? (int)$_POST['idservicio'] : null;
$idreportador = $_SESSION['cedula'] ?? ($_POST['idreportador'] ?? null);

if (!$idservicio || !$idreportador) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos obligatorios']);
    exit;
}

try {
    $cx = get_conn();

    // Insertar reporte (ajusta columnas si tu tabla difiere)
    $stmt = $cx->prepare("INSERT INTO reporte (idservicio, idreportador) VALUES (?, ?)");
    if (!$stmt) throw new Exception("Prepare fallo: " . $cx->error);
    $stmt->bind_param('is', $idservicio, $idreportador);
    if (!$stmt->execute()) throw new Exception("Execute fallo: " . $stmt->error);
    $insertId = $stmt->insert_id;
    $stmt->close();

    // Buscar proveedor relacionado con ese servicio (tabla 'ofrece' que relacione idservicio -> idproveedor)
    $prov = null;
    $stmt = $cx->prepare("SELECT idproveedor FROM ofrece WHERE idservicio = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('i', $idservicio);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        if ($r && !empty($r['idproveedor'])) $prov = $r['idproveedor'];
        $stmt->close();
    }

    // Crear mensaje compacto
    $mensajeProv = "Tu publicación (ID {$idservicio}) ha sido reportada.";
    $mensajeAdmin = "Se recibió un reporte sobre publicación ID {$idservicio}.";

    // Notificar proveedor
    if ($prov) {
        addNotification($prov, 'reporte', $insertId, $mensajeProv);
    }

    // Notificar administradores
    $stmt = $cx->prepare("SELECT idadministrador FROM administrador");
    if ($stmt) {
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            addNotification($row['idadministrador'], 'reporte', $insertId, $mensajeAdmin);
        }
        $stmt->close();
    }

    $cx->close();

    echo json_encode(['success' => true, 'idreporte' => $insertId]);
} catch (Exception $e) {
    error_log("controllerReporte error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>