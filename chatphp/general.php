<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
//echo '<pre>';
//print_r($_SESSION); // Muestra el contenido de $_SESSION
//echo '</pre>';

//USADO PARA SABER CUANTAS NOTIFICACIONES HAY SIN LEER
$stmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$unread_count = $row['unread_count'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esta es una pagina generica</title>
</head>
<body>
    <div>
        <h1>Esta es una pagina generica</h1>
        <h2>Aqui se mostrarán las notificaciones : </h2>
    </div>

    <div class="notification-icon">
    <span class="icon">🔔</span>
   
</div>

<div>
    <span>Notificaciones</span>
    <span id="notification-badge" style="display: none; background: red; color: white; border-radius: 50%; padding: 5px;">0</span>
</div>
<button onclick="location.href='chat.php'">Ir al Chat</button>

<?php
//Generar dinamicamente la lista de chats
$stmt = $conn->prepare("
    SELECT DISTINCT 
        CASE 
            WHEN sender_id = ? THEN receiver_id
            ELSE sender_id
        END AS chat_user_id
    FROM messages
    WHERE sender_id = ? OR receiver_id = ?
");
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();


echo "<ul>";
while ($row = $result->fetch_assoc()) {
    $chat_user_id = $row['chat_user_id'];

    // Obtener el nombre del usuario con el que se está chateando
    $user_stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $chat_user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_row = $user_result->fetch_assoc();
    $chat_user_name = $user_row['name'];

    // Generar el enlace al chat
    echo "<li><a href='chat.php?user_id=$chat_user_id'>Chat con $chat_user_name</a></li>";
}
echo "</ul>";


?>


</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function checkNotifications() {
        $.get('check_notifications.php', function(data) {
            const response = JSON.parse(data);
            const unreadCount = response.unread_count;

            // Actualiza el contador de notificaciones en la página
            if (unreadCount > 0) {
                document.getElementById('notification-badge').innerText = unreadCount;
                document.getElementById('notification-badge').style.display = 'inline';
            } else {
                document.getElementById('notification-badge').style.display = 'none';
            }
        });
    }

    // Llama a la función cada 5 segundos
    setInterval(checkNotifications, 5000);

    // Llama a la función al cargar la página
    checkNotifications();
</script>
</html>