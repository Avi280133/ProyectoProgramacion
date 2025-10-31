<?php
session_start();
require_once('../conexion/ClaseConexion.php');
if (!isset($_SESSION['cedula'])) {
    exit;
}

  $cx=(new ClaseConexion())->getConexion();
$user_id = $_SESSION['cedula'];
$receiver_id = $_SESSION['receiver_id'] ;



$stmt = $cx->prepare("SELECT * FROM mensaje WHERE (idemisor = ? AND idreceptor = ?) OR (idemisor = ? AND idreceptor = ?) ORDER BY tiempo");
$stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . ($row['idemisor'] == $user_id ? "Tú" : "Usuario") . ":</strong> " . $row['contenido'] . " <em>(" . $row['tiempo'] . ")</em></p>";
}

// Actualizar las notificaciones como leídas después de obtener los mensajes
//$updateStmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
//$updateStmt->bind_param("i", $user_id);
//$updateStmt->execute();
?>