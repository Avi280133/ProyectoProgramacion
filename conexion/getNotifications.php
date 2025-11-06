<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/notificaciones.php';

if (empty($_SESSION['cedula'])) {
    echo json_encode(['success'=>false, 'error'=>'No autenticado']);
    exit;
}

$action = $_REQUEST['action'] ?? 'list';
$user = $_SESSION['cedula'];

try {
    if ($action === 'list') {
        $list = fetchNotifications($user, 50);
        $unread = countUnread($user);
        echo json_encode(['success'=>true, 'notifications'=>$list, 'unread'=>$unread]);
        exit;
    }

    if ($action === 'mark' && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $ok = markAsRead($id, $user);
        echo json_encode(['success'=>$ok]);
        exit;
    }

    echo json_encode(['success'=>false, 'error'=>'Acción inválida']);
} catch (Exception $e) {
    echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}
?>