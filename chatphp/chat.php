<?php
session_start();
include '../conexion/ClaseConexion.php';

//if (!isset($_SESSION['cedula'])) {
//    header("Location: login.php");
//    exit;
//}

$user_id = $_SESSION['cedula'];
//$user_name = $_SESSION['user_name'];
$user_name = 'VARIABLE_TEST';
//echo '<pre>';
//print_r($_SESSION); // Muestra el contenido de $_SESSION
//echo '</pre>';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Chat desde <?php echo $user_name; ?></h1>
    <div id="chat-box" style="border: 1px solid #000; height: 300px; overflow-y: scroll;">
        <!-- Mensajes se cargarán aquí -->
    </div>
    <form id="chat-form">
        <input type="text" id="message" placeholder="Escribe un mensaje" required>
        <button type="submit">Enviar</button>
    </form>

    <script>
        function loadMessages() {
            $.get('get_messages.php', function(data) {
                $('#chat-box').html(data);
            });
        }

        $('#chat-form').submit(function(e) {
            e.preventDefault();
            const message = $('#message').val();
            $.post('send_message.php', { message: message }, function() {
                $('#message').val('');
                loadMessages();
            });
        });

        setInterval(loadMessages, 1000); //Tiempo de refresh que consulta si tiene nuevos mensajes
        loadMessages();


    </script>
</body>
</html>