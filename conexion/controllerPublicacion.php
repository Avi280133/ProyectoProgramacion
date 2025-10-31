<?php
//ControllerPublicacion.php
//echo "<pre>Datos recibidos:\n";
//print_r($_POST);
//echo "</pre>";

require_once('modelPublicacion.php');  // Incluir el modelo Usuario
require_once('ClaseConexion.php'); // Incluir la clase de conexión
// Registrar Publicacion


$action = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];}

switch ($action) {
    case 'publicar':
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobar si se han recibido los datos necesarios para el registro
    if  (isset($_POST['titulo']) && !empty($_POST['titulo']) &&
        isset($_POST['ubicacion']) && !empty($_POST['ubicacion']) &&
        isset($_POST['precio']) && !empty($_POST['precio']) &&
        isset($_POST['descripcion']) && !empty($_POST['descripcion']) &&
        isset($_POST['imagen']) && !empty($_POST['imagen'])) {

        // Obtener los valores del formulario
        $titulo = $_POST['titulo'];
        $ubicacion = $_POST['ubicacion'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $imagen= $_POST['imagen'];

        // Crear una nueva instancia de Usuario
        $servicio = new Servicio('', $titulo, $ubicacion, $precio, $descripcion, $imagen);

        // Registrar el usuario en la base de datos
        $resultado = $servicio->publicarServicio();
echo "entro a publicar";
       // if ($resultado > 0) {
         //   Header('Location: ../index.html');  // Redirigir al index si el registro fue exitoso
       // }
    }
}

break;
    case 'buscar':
// Registrar Publicacion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && !empty($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $resultados = Servicio::buscarPorTitulo($titulo);
   
    $servicio = $resultados; // Asignar el primer resultado a $serv
include('../vistas/busqueda.php');
}
 case 'cargarServicio':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idservicio'])) {
        $idservicio = (int) $_POST['idservicio'];

        // Llamada al modelo (devuelve fila asociativa o null)
        $resultados = Servicio::cargarServicio($idservicio);

        if ($resultados) {
            // $resultados contiene columnas del servicio (s.*) y aliases del proveedor (proveedor_*)
            // Separar datos de servicio y usuario para la vista
            $servicio = $resultados;

            $usuario = [
                'nombre'    => $servicio['proveedor_nombre'] ?? ($servicio['username'] ?? ''),
                'fotoperfil'=> $servicio['proveedor_fotoperfil'] ?? ($servicio['fotoperfil'] ?? ''),
                'cedula'    => $servicio['proveedor_cedula'] ?? ($servicio['cedula'] ?? ''),
                'localidad' => $servicio['proveedor_localidad'] ?? ($servicio['localidad'] ?? ''),
            ];

            // opcional: quitar las claves del proveedor del array $servicio para evitar duplicados en la vista
            unset($servicio['proveedor_nombre'], $servicio['proveedor_fotoperfil'], $servicio['proveedor_cedula'], $servicio['proveedor_localidad']);

            // incluir la vista; la vista podrá usar $servicio y $usuario
            include('../vistas/publicacion.php');
        } else {
            header('HTTP/1.1 404 Not Found');
            echo 'Servicio no encontrado.';
        }
    } else {
        echo 'Parámetro idservicio no recibido.';
    }


 
    break;
//include('../vistas/publicacion.php');

}