<?php
// filepath: chatphp/db.php
$host = 'localhost';
$user = 'jlopez';
$password = 'Noes3139';
$database = 'chat';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>