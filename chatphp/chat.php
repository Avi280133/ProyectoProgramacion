<?php
session_start();
include '../conexion/ClaseConexion.php';

echo "<pre>DEBUG CHAT.PHP\n";
echo "SESSION:\n";
print_r($_SESSION);
echo "POST:\n";
print_r($_POST);
echo "</pre>";


//if (!isset($_SESSION['cedula'])) {
//    header("Location: login.php");
//    exit;
//}


if (isset($_POST['emite']) && $_POST['emite'] !== '') {
    // usar lo que vino por POST
    $_SESSION['receiver_id'] = $_POST['emite'];
}

if (!isset($_SESSION['cedula'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

if (!isset($_SESSION['receiver_id'])) {
    echo "Error: No se indicó con quién chatear.";
    exit;
}

$user_id  = $_SESSION['cedula'];
$emisor   = $_SESSION['receiver_id'];   // este es el otro
$user_name = '--';

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
       // 1. Hacemos que la variable PHP $emisor esté disponible en JavaScript
        const emisorId = '<?php echo $emisor; ?>'; 

        function loadMessages() {
        // 2. Pasamos emisorId como dato en la solicitud $.get
        $.get('get_messages.php', { emisor: emisorId }, function(data) {
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