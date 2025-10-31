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
$cx->begin_transaction();

try {
    $stmt = $cx->prepare("INSERT INTO mensaje (idemisor, idreceptor, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    $stmt1 = $cx->prepare("INSERT INTO notimsj (cedula, contenido, is_read) VALUES (?, ?, ?)");
    $notification_message = "Nuevo mensaje recibido";
    $is_read = 0;
    $stmt1->bind_param("isi", $receiver_id, $notification_message, $is_read);
    $stmt1->execute();

    $cx->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $cx->rollback();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
