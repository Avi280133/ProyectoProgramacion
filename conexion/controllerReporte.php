<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE);

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['cedula']) || empty($_SESSION['cedula'])) {
  http_response_code(401);
  echo json_encode(['success' => false, 'error' => 'UNAUTHORIZED', 'message' => 'Sesión no iniciada']);
  exit;
}

require_once(__DIR__ . '/ClaseConexion.php');

$action = $_POST['action'] ?? '';
if ($action !== 'reportar') {
  echo json_encode(['success' => false, 'error' => 'UNKNOWN_ACTION']);
  exit;
}

$idreportador = $_SESSION['cedula'];
$idservicio   = isset($_POST['idservicio']) ? (int)$_POST['idservicio'] : 0;

// (Opcional) vienen del formulario, pero tu tabla reporte YA NO tiene estas columnas
$motivo  = trim($_POST['motivo']  ?? '');
$detalle = trim($_POST['detalle'] ?? '');

if ($idservicio <= 0) {
  echo json_encode(['success' => false, 'error' => 'INVALID_SERVICE', 'message' => 'Falta idservicio']);
  exit;
}

try {
  $cx = (new ClaseConexion())->getConexion();

  // Verificar que el servicio exista
  $q = $cx->prepare("SELECT idservicio FROM servicio WHERE idservicio=?");
  if (!$q) throw new Exception("Prepare failed: ".$cx->error);
  $q->bind_param("i", $idservicio);
  $q->execute();
  $exists = $q->get_result()->fetch_column();
  $q->close();

  if (!$exists) {
    echo json_encode(['success' => false, 'error' => 'NOT_FOUND', 'message' => 'Servicio inexistente']);
    exit;
  }

  // Insertar reporte (solo columnas vigentes)
  $st = $cx->prepare("INSERT INTO reporte (idservicio, idreportador) VALUES (?, ?)");
  if (!$st) throw new Exception("Prepare failed: ".$cx->error);
  $st->bind_param("is", $idservicio, $idreportador);
  $ok = $st->execute();
  $idreporte = $ok ? $cx->insert_id : null;
  $st->close();

  if (!$ok) {
    echo json_encode(['success' => false, 'error' => 'INSERT_FAIL']);
    exit;
  }

  // Importante:
  // El trigger trg_reporte_after_insert ya creará la notificación al proveedor.
  // (mensaje: "Tu servicio #X fue reportado.")
  // Si quisieras incluir motivo/detalle en la notificación, habría que:
  //   a) re-agregar esas columnas a reporte, o
  //   b) insertar la notificación acá manualmente con ese texto.
  // Por ahora respetamos tu esquema (sin motivo/detalle) y dejamos que el trigger notifique.

  echo json_encode(['success' => true, 'idreporte' => (int)$idreporte]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => 'SERVER_ERROR', 'message' => $e->getMessage()]);
}
?>