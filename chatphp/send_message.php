<?php
session_start();
require_once('../conexion/ClaseConexion.php');

if (!isset($_SESSION['cedula']) || !isset($_SESSION['idreceptor']) || !isset($_POST['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan datos necesarios']);
    exit;
}

$cx = (new ClaseConexion())->getConexion();
$sender_id = $_SESSION['cedula'];
$receiver_id = $_SESSION['idreceptor'];
$message = $_POST['message'];

$cx->begin_transaction();

try {
    // Primera inserción
    $stmt = $cx->prepare("INSERT INTO mensaje (idemisor, idreceptor, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    //Segunda inserción 
    $stmt1 = $cx->prepare("INSERT INTO notimsj (cedula, contenido, is_read) VALUES (?, ?, ?)");
    $notification_message = "Nuevo mensaje recibido";
    $is_read = 0;
    $stmt1->bind_param("isi", $sender_id, $message, $is_read);
    $stmt1->execute();

    // Confirma la transacción
    $cx->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
     //Si ocurre un error, deshace la transacción
     $cx->rollback();
     echo json_encode(['error' => $e->getMessage()]);
}

?>

