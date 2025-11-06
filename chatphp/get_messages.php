<?php
session_start();
require_once('../conexion/ClaseConexion.php');

if (!isset($_SESSION['cedula']) || !isset($_SESSION['receiver_id'])) {
    exit('Error: sesión inválida');
}

$yo = $_SESSION['cedula'];
$otro = $_SESSION['receiver_id'];

$cx = (new ClaseConexion())->getConexion();

$sql = "SELECT idemisor, idreceptor, contenido, tiempo 
        FROM mensaje
        WHERE (idemisor = ? AND idreceptor = ?)
           OR (idemisor = ? AND idreceptor = ?)
        ORDER BY tiempo ASC";

$stmt = $cx->prepare($sql);
$stmt->bind_param("ssss", $yo, $otro, $otro, $yo);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $clase = ($row['idemisor'] === $yo) ? 'msg-yo' : 'msg-otro';
    echo "<div class='$clase'><strong>"
        . ($row['idemisor'] === $yo ? 'Tú' : 'Usuario')
        . ":</strong> " . htmlspecialchars($row['contenido'])
        . " <em>(" . $row['tiempo'] . ")</em></div>";
}

$stmt->close();
$cx->close();
?>
