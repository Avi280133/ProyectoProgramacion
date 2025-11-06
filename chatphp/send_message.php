<?php
session_start();
require_once('../conexion/ClaseConexion.php');

if (!isset($_SESSION['cedula'], $_SESSION['receiver_id'], $_POST['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan datos']);
    exit;
}

$sender_id   = $_SESSION['cedula'];
$receiver_id = $_SESSION['receiver_id'];
$message     = trim($_POST['message'] ?? '');

if ($message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Mensaje vacío']);
    exit;
}

$cx = (new ClaseConexion())->getConexion();

try {
    $stmt = $cx->prepare("
        INSERT INTO mensaje (idemisor, idreceptor, contenido, tiempo) 
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("sss", $sender_id, $receiver_id, $message);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $cx->close();
}
?>
