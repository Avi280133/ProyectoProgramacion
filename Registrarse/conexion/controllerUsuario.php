<?php
// ControllerUsuario.php
echo "<pre>Datos recibidos:\n";
print_r($_POST);
echo "</pre>";

require_once('modelUsuario.php');  // Incluir el modelo Usuario
require_once('ClaseConexion.php'); // Incluir la clase de conexión
// Registrar Usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobar si se han recibido los datos necesarios para el registro
    if (isset($_POST['cedula']) && !empty($_POST['cedula']) &&
        isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['apellido']) && !empty($_POST['apellido']) &&
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['contrasena']) && !empty($_POST['contrasena']) &&
        isset($_POST['edad']) && !empty($_POST['edad'])) {

        // Obtener los valores del formulario
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $edad = $_POST['edad'];

        // Crear una nueva instancia de Usuario
        $usuario = new Usuario($cedula, $nombre, $apellido, $username, '','', $email, $contrasena,'', $edad);

        // Registrar el usuario en la base de datos
        $resultado = $usuario->registrar();

       // if ($resultado > 0) {
         //   Header('Location: ../index.html');  // Redirigir al index si el registro fue exitoso
       // }
    }
}

// Modificar Usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula']) && !empty($_POST['cedula'])) {
    // Verificar que se recibieron los datos del formulario para modificar
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['apellido']) && !empty($_POST['apellido']) &&
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['calle']) && !empty($_POST['calle']) &&
        isset($_POST['numeropuerta']) && !empty($_POST['numeropuerta']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['contrasena']) && !empty($_POST['contrasena']) &&
        isset($_POST['edad']) && !empty($_POST['edad'])) {

        // Obtener los valores del formulario
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $username = $_POST['username'];
        $calle = $_POST['calle'];
        $numeropuerta = $_POST['numeropuerta'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $fotoperfil = isset($_FILES['fotoperfil']) ? $_FILES['fotoperfil']['tmp_name'] : null; // Si hay archivo de imagen
        $edad = $_POST['edad'];

        // Crear una nueva instancia de Usuario
        $usuario = new Usuario($cedula, $nombre, $apellido, $username, $calle, $numeropuerta, $email, $contrasena, $fotoperfil, $edad);

        // Llamar al método de modificación
        $resultado = $usuario->modificar();

        if ($resultado > 0) {
            Header('Location: index.html');  // Redirigir al index si la modificación fue exitosa
        } else {
            echo "Error al modificar el usuario.";
        }
    }
}

// Eliminar Usuario
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula']) && !empty($_POST['cedula'])) {
    // Obtener la cédula del formulario para eliminar
 //   $cedula = $_POST['cedula'];

    // Llamar al método eliminar
 //   $resultado = Usuario::eliminar($cedula);

  //  if ($resultado > 0) {
  //      Header('Location: index.html');  // Redirigir al index si la eliminación fue exitosa
   // } else {
  //      echo "Error al eliminar el usuario.";
   // }
//}

// Buscar Usuario por Cédula
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cedula']) && !empty($_GET['cedula'])) {
    // Obtener la cédula desde la URL
    $cedula = $_GET['cedula'];

    // Llamar al método buscar
    $usuario = Usuario::buscarPorCedula($cedula);

    if ($usuario) {
        // Mostrar los datos del usuario
        echo "Usuario encontrado: <br>";
        echo "Cédula: " . $usuario['cedula'] . "<br>";
        echo "Nombre: " . $usuario['nombre'] . "<br>";
        echo "Apellido: " . $usuario['apellido'] . "<br>";
        echo "Username: " . $usuario['username'] . "<br>";
        echo "Calle: " . $usuario['calle'] . "<br>";
        echo "Número Puerta: " . $usuario['numeropuerta'] . "<br>";
        echo "Email: " . $usuario['email'] . "<br>";
        echo "Edad: " . $usuario['edad'] . "<br>";
    } else {
        echo "Usuario no encontrado.";
    }
}
?>
