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
if ($action !== 'calificar') {
  echo json_encode(['success' => false, 'error' => 'UNKNOWN_ACTION']);
  exit;
}

$idcliente  = $_SESSION['cedula'];                             // quien califica
$idservicio = isset($_POST['idservicio']) ? (int)$_POST['idservicio'] : 0;
$puntaje    = isset($_POST['puntaje']) ? (int)$_POST['puntaje'] : 0;
$comentario = trim((string)($_POST['comentario'] ?? ''));

if ($idservicio <= 0) {
  echo json_encode(['success' => false, 'error' => 'INVALID_SERVICE', 'message' => 'Falta idservicio']);
  exit;
}
if ($puntaje < 1 || $puntaje > 5) {
  echo json_encode(['success' => false, 'error' => 'INVALID_SCORE', 'message' => 'El puntaje debe ser 1..5']);
  exit;
}

try {
  $cx = (new ClaseConexion())->getConexion();

  // 1) Verificar servicio
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

  // 2) Insertar calificación
  $st = $cx->prepare("INSERT INTO calificacion (idservicio, idcliente, puntaje, comentario) VALUES (?, ?, ?, ?)");
  if (!$st) throw new Exception("Prepare failed: ".$cx->error);
  $st->bind_param("isis", $idservicio, $idcliente, $puntaje, $comentario);
  $ok = $st->execute();
  $idcalificacion = $ok ? $cx->insert_id : null;
  $st->close();

  if (!$ok) {
    // Si querés evitar doble calificación por cliente, agregá un índice único (idservicio,idcliente)
    // y acá podrías capturar 1062 para hacer UPDATE en vez de INSERT.
    echo json_encode(['success' => false, 'error' => 'INSERT_FAIL']);
    exit;
  }

  // 3) (Opcional) calcular promedio actual del servicio
  $avg = null; $cant = null;
  if ($avgStmt = $cx->prepare("SELECT ROUND(AVG(puntaje),1) AS promedio, COUNT(*) AS cantidad FROM calificacion WHERE idservicio=?")) {
    $avgStmt->bind_param("i", $idservicio);
    $avgStmt->execute();
    $res = $avgStmt->get_result()->fetch_assoc();
    $avg = $res['promedio'] ?? null;
    $cant = (int)($res['cantidad'] ?? 0);
    $avgStmt->close();
  }

  // El trigger trg_calificacion_after_insert ya crea la notificación al proveedor.

  echo json_encode([
    'success' => true,
    'idcalificacion' => (int)$idcalificacion,
    'promedio' => $avg,
    'cantidad' => $cant
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => 'SERVER_ERROR', 'message' => $e->getMessage()]);
}
