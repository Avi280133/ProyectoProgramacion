<?php
//ControllerUsuario.php
echo "<pre>Datos recibidos:\n";
print_r($_POST);
echo "</pre>";

require_once('modelPublicacion.php');  // Incluir el modelo Usuario
require_once('ClaseConexion.php'); // Incluir la clase de conexión
// Registrar Usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobar si se han recibido los datos necesarios para el registro
    if  (isset($_POST['titulo']) && !empty($_POST['titulo']) &&
        isset($_POST['ubicacion']) && !empty($_POST['ubicacion']) &&
        isset($_POST['precio']) && !empty($_POST['precio']) &&
        isset($_POST['descripcion']) && !empty($_POST['descripcion'])) {

        // Obtener los valores del formulario
        $titulo = $_POST['titulo'];
        $ubicacion = $_POST['ubicacion'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];

        // Crear una nueva instancia de Usuario
        $servicio = new Servicio('', $titulo, $ubicacion, $precio, $descripcion);

        // Registrar el usuario en la base de datos
        $resultado = $servicio->publicarServicio();
echo "entro a publicar";
       // if ($resultado > 0) {
         //   Header('Location: ../index.html');  // Redirigir al index si el registro fue exitoso
       // }
    }
}