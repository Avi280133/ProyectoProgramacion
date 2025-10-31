<?php
session_start();
include 'db.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['unread_count' => 0]);
    exit;
}

// Obtiene el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Prepara la consulta para contar las notificaciones no leídas
$stmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Devuelve el conteo de notificaciones no leídas en formato JSON
echo json_encode(['unread_count' => $row['unread_count']]);
?>