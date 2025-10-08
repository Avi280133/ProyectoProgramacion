<?php
// ControllerUsuario.php
// Este controlador ahora usa un switch en función del parámetro 'action'
// para elegir la operación a ejecutar (registrar, modificar, eliminar, buscar, login).
// En el formulario HTML puede usar múltiples botones submit:
// <button type="submit" name="action" value="registrar">Registrar</button>
// <button type="submit" name="action" value="modificar">Modificar</button>
// <button type="submit" name="action" value="eliminar">Eliminar</button>
// <button type="submit" name="action" value="login">Iniciar sesión</button>
// Para búsqueda por GET: ?action=buscar&cedula=...

require_once('modelUsuario.php');  // Incluir el modelo Usuario
require_once('ClaseConexion.php'); // Incluir la clase de conexión

// Detectar la acción: preferir POST (botones submit con name="action"), si no existe buscar en GET
$action = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];


switch ($action) {
    case 'registrar':
        // Registrar Usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $required = ['cedula','nombre','apellido','username','email','contrasena','edad','tipo'];
            $ok = true;
            foreach ($required as $f) {
                if (!isset($_POST[$f]) || empty(trim($_POST[$f]))) { $ok = false; break; }
            }
            if ($ok) {
                $cedula = trim($_POST['cedula']);
                $nombre = trim($_POST['nombre']);
                $apellido = trim($_POST['apellido']);
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $contrasena = trim($_POST['contrasena']);
                $edad = trim($_POST['edad']);
                $tipo = $_POST['tipo'];
                $usuario = new Usuario($cedula, $nombre, $apellido, $username, '','', $email, $contrasena,'', $edad, $tipo);
                $resultado = $usuario->registrar();
                echo "registrar -> resultado: ";
                var_dump($resultado);
            } else {
                echo "Faltan campos obligatorios para registrar.";
            }
        }
        break;

    case 'modificar':
        // Modificar Usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $required = ['cedula','nombre','apellido','username','calle','numeropuerta','email','contrasena','edad'];
            $ok = true;
            foreach ($required as $f) {
                if (!isset($_POST[$f]) || empty(trim($_POST[$f]))) { $ok = false; break; }
            }
            if ($ok) {
                $cedula = trim($_POST['cedula']);
                $nombre = trim($_POST['nombre']);
                $apellido = trim($_POST['apellido']);
                $username = trim($_POST['username']);
                $calle = trim($_POST['calle']);
                $numeropuerta = trim($_POST['numeropuerta']);
                $email = trim($_POST['email']);
                $contrasena = trim($_POST['contrasena']);
                $fotoperfil = isset($_FILES['fotoperfil']) ? $_FILES['fotoperfil']['tmp_name'] : null;
                $edad = trim($_POST['edad']);

                $usuario = new Usuario($cedula, $nombre, $apellido, $username, $calle, $numeropuerta, $email, $contrasena, $fotoperfil, $edad);
                $resultado = $usuario->modificar();
                if ($resultado > 0) {
                    Header('Location: ../index.html');
                } else {
                    echo "Error al modificar el usuario.";
                }
            } else {
                echo "Faltan campos obligatorios para modificar.";
            }
        }
        break;

    case 'eliminar':
        // Eliminar Usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['cedula']) && !empty(trim($_POST['cedula']))) {
                $cedula = trim($_POST['cedula']);
                $resultado = Usuario::eliminar($cedula);
                if ($resultado > 0) {
                    Header('Location: ../index.html');
                } else {
                    echo "Error al eliminar el usuario.";
                }
            } else {
                echo "Se requiere 'cedula' para eliminar.";
            }
        }
        break;

    case 'buscar':
        // Buscar Usuario por Cédula (GET o POST)
        $cedula = null;
        if (isset($_GET['cedula']) && !empty(trim($_GET['cedula']))) $cedula = trim($_GET['cedula']);
        if (isset($_POST['cedula']) && !empty(trim($_POST['cedula']))) $cedula = trim($_POST['cedula']);
        if ($cedula) {
            $usuario = Usuario::buscarPorCedula($cedula);
            if ($usuario) {
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
        } else {
            echo "Falta parámetro 'cedula' para buscar.";
        }
        break;

  case 'login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $contrasena = trim($_POST['contrasena'] ?? '');

        $modelo = new Usuario('', '', '', '', '', '', '', '', '', '');
        $usuario = $modelo->login($email, $contrasena);

        if ($usuario) {
            // 🔹 Pasamos los datos a perfil.php usando include
            include('../html/perfil.php');
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }
    }
    break;

        //include('../html/perfil.html');

      //  if ($datos) {
        //    $payload = [
          //      'cedula'   => $datos['cedula'],
            //    'nombre'   => trim($datos['nombre'].' '.$datos['apellido']),
              //  'email'    => $datos['email'],
                //'username' => $datos['username'],
               // 'edad'     => $datos['edad']
            //];

            //$json = json_encode($payload, JSON_UNESCAPED_UNICODE);
            //$encoded = urlencode($json);  // o base64 si prefieres

            //header("Location: ../html/perfil.html#d=$encoded");
            //exit;
        //} else {
          //  echo "❌ Usuario o contraseña incorrectos.";
       // }
    
    break;


    default:
        echo "No se especificó una acción válida. Use el parámetro 'action' (registrar, modificar, eliminar, buscar, login).";
}
}
?>
