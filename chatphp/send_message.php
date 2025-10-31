<?php
session_start();
require_once('../conexion/ClaseConexion.php');

//if (!isset($_SESSION['cedula'])) {
//    exit;
//}

 $cx=(new ClaseConexion())->getConexion();
//$sender_id = $_SESSION['cedula'];
//$receiver_id = $_SESSION['idreceptor'];
//$message = $_POST['message'];

echo '<script>console.log("Sender ID: ' . $sender_id . '");</script>';
$cx->begin_transaction();

//try {
    // Primera inserción
    $stmt = $cx->prepare("INSERT INTO mensaje (idemisor, idreceptor, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    // Segunda inserción 
   // $stmt1 = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (?, ?, ?)");
   // $notification_message = "Nuevo mensaje recibido";
   // $is_read = 0;
   // $stmt1->bind_param("isi", $receiver_id, $message, $is_read);
   // $stmt1->execute();

    // Confirma la transacción
    //$cx->commit();
//} catch (Exception $e) {
    // Si ocurre un error, deshace la transacción
  //  $cx->rollback();
   // echo "Error: " . $e->getMessage();
//}

?>

