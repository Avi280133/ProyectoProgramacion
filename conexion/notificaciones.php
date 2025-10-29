<?php
$conexion = new mysqli("localhost", "root", "ar1adna99", "SkillMatch");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtenemos el parámetro
$tabla = $_GET['tabla'] ?? '';
// Validamos que sea una tabla permitida 
$tablas_permitidas = [ "notificacion", "usuario", "contrata", "comenta", "supervisa", "ofrece", "mensaje" ]; 

if (!in_array($tabla, $tablas_permitidas)) {
    die(json_encode(['error' => 'Tabla no permitida']));
}

// Ejecutamos la consulta segura
$resultado = $conexion->query("SELECT * FROM `$tabla`");

$datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
$conexion->close();
?>
