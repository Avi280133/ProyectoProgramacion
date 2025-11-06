<?php
session_start();
include '../conexion/ClaseConexion.php';

if (isset($_POST['emite']) && $_POST['emite'] !== '') {
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
$emisor   = $_SESSION['receiver_id'];
$user_name = '--';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chat | SkillMatch</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* ====== ESTILO GENERAL ====== */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .chat-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #0eb27c, #025939);
            color: white;
            padding: 15px 20px;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header span {
            font-weight: 300;
            font-size: 0.9rem;
        }

        #chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f9fdfb;
            display: flex;
            flex-direction: column;
            gap: 10px;
            scroll-behavior: smooth;
        }

        /* ====== BURBUJAS ====== */
        .msg-yo, .msg-otro {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 15px;
            font-size: 0.95rem;
            line-height: 1.4;
            word-wrap: break-word;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .msg-yo {
            align-self: flex-end;
            background: #0eb27c;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .msg-otro {
            align-self: flex-start;
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
        }

        .msg-time {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 4px;
            display: block;
            text-align: right;
        }

        /* ====== FORMULARIO ====== */
        #chat-form {
            display: flex;
            border-top: 1px solid #e5e5e5;
            background: #ffffff;
            padding: 10px 15px;
        }

        #message {
            flex: 1;
            border: 1px solid #dcdcdc;
            border-radius: 30px;
            padding: 10px 15px;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s ease;
        }

        #message:focus {
            border-color: #0eb27c;
            box-shadow: 0 0 0 3px rgba(14, 178, 124, 0.15);
        }

        button {
            background: #0eb27c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            margin-left: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 1.1rem;
        }

        button:hover {
            background: #049b6a;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 600px) {
            .chat-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
                max-width: none;
            }
            #chat-box {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <div>💬 Chat con usuario <span>(<?php echo htmlspecialchars($emisor); ?>)</span></div>
    </div>

    <div id="chat-box"></div>

    <form id="chat-form">
        <input type="text" id="message" placeholder="Escribe un mensaje..." required>
        <button type="submit">➤</button>
    </form>
</div>

<script>
$(document).ready(function() {
    const emisorId = '<?php echo $_SESSION['receiver_id']; ?>';

    function loadMessages() {
        $.get('get_messages.php', { emisor: emisorId })
            .done(function(data) {
                $('#chat-box').html(data);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            })
            .fail(function(xhr) {
                console.error('Error al cargar mensajes:', xhr.responseText);
            });
    }

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        const message = $('#message').val().trim();
        if (message === '') return;

        $.post('send_message.php', { message: message })
            .done(function(resp) {
                const data = JSON.parse(resp);
                if (data.success) {
                    $('#message').val('');
                } else {
                    alert('Error al enviar: ' + (data.error || 'Desconocido'));
                }
            })
            .fail(function(xhr) {
                alert('Error al enviar: ' + xhr.responseText);
            });
    });

    loadMessages();
    setInterval(loadMessages, 3000);
});
</script>
</body>
</html>
