<?php
// conexion/getNotifications.php
declare(strict_types=1);

// ---- Salida siempre JSON y sin notices que rompan el parse ----
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE);

// ---- Sesión ----
if (session_status() === PHP_SESSION_NONE) session_start();

// ---- Si NO hay user logueado, NO redirigir: responder JSON 401 ----
if (!isset($_SESSION['cedula']) || empty($_SESSION['cedula'])) {
  http_response_code(401);
  echo json_encode([
    'success' => false,
    'error'   => 'UNAUTHORIZED',
    'message' => 'Sesión no iniciada'
  ]);
  exit;
}

require_once(__DIR__ . '/ClaseConexion.php');

$action = $_GET['action'] ?? '';
$cedula = $_SESSION['cedula'];

try {
  $cx = (new ClaseConexion())->getConexion();

  if ($action === 'list') {
    // Trae notificaciones del usuario receptor
    $sql = "SELECT idnotificacion, tipo, referencia, actor, mensaje, url, leida, fecha
            FROM notificacion
            WHERE idusuario_receptor = ?
            ORDER BY fecha DESC
            LIMIT 100";
    $st = $cx->prepare($sql);
    if (!$st) throw new Exception("Prepare failed: ".$cx->error);
    $st->bind_param("s", $cedula);
    $st->execute();
    $rs = $st->get_result();
    $rows = [];
    while ($r = $rs->fetch_assoc()) { $rows[] = $r; }
    $st->close();

    // Contador de no leídas
    $sqlU = "SELECT COUNT(*) AS unread
             FROM notificacion
             WHERE idusuario_receptor = ? AND leida = 0";
    $stU = $cx->prepare($sqlU);
    if (!$stU) throw new Exception("Prepare U failed: ".$cx->error);
    $stU->bind_param("s", $cedula);
    $stU->execute();
    $unread = ($stU->get_result()->fetch_assoc()['unread'] ?? 0);
    $stU->close();

    echo json_encode([
      'success'       => true,
      'notifications' => $rows,
      'unread'        => (int)$unread
    ]);
    exit;
  }

  if ($action === 'mark') {
    // Marcar como leída (segura: solo las del usuario logueado)
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      echo json_encode(['success' => false, 'error' => 'METHOD_NOT_ALLOWED']);
      exit;
    }
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id <= 0) {
      echo json_encode(['success' => false, 'error' => 'INVALID_ID']);
      exit;
    }
    $sql = "UPDATE notificacion
            SET leida = 1
            WHERE idnotificacion = ? AND idusuario_receptor = ?";
    $st = $cx->prepare($sql);
    if (!$st) throw new Exception("Prepare failed: ".$cx->error);
    $st->bind_param("is", $id, $cedula);
    $ok = $st->execute();
    $st->close();

    echo json_encode(['success' => (bool)$ok]);
    exit;
  }

  // Acción desconocida
  echo json_encode(['success' => false, 'error' => 'UNKNOWN_ACTION']);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => 'SERVER_ERROR', 'message' => $e->getMessage()]);
}
