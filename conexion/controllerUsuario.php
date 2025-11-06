<?php
require_once('modelUsuario.php');  // Incluir el modelo Usuario
require_once('modelProveedor.php');
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
                $usuario = new Usuario($cedula, $nombre, $apellido, $username, $email, $contrasena,'', $edad, '', $tipo);
                $resultado = $usuario->registrar();
                echo "registrar -> resultado: ";
                var_dump($resultado);
            } else {
                echo "Faltan campos obligatorios para registrar.";
            }
        }
        break;

    case 'modificar':
  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y sanear valores enviados por POST
            if (session_status() === PHP_SESSION_NONE) session_start();
            $cedula = $_SESSION['cedula'] ?? null;
            if (!$cedula) {
                echo "No hay sesión activa (cedula).";
                break;
            }

            $username = isset($_POST['username']) ? trim($_POST['username']) : null;
            // Tomar fotoperfil desde POST (hidden) si viene, si no dejar cadena vacía

            $fotoperfil = $_FILES['foto']; //isset($_POST['foto']) ? trim($_POST['fotoperfil']) : '';
            $fotoNombre =  $fotoperfil['name'];
            $localidad = isset($_POST['localidad']) ? trim($_POST['localidad']) : '';

            $experiencia = isset($_POST['experiencia']) ? trim($_POST['experiencia']) : '';
            $habilidad = isset($_POST['habilidad']) ? trim($_POST['habilidad']) : '';

            // Crear objetos con la cédula tomada de la sesión
            $usuario = new Usuario($cedula, '', '', $username ?? '', '', '', $fotoNombre, '', $localidad, '');
            $resultado1 = $usuario->modificarUsuario();

            $proveedor = new Proveedor($cedula, $experiencia, $habilidad);
            $resultado2 = $proveedor->modificarProv();

            if(move_uploaded_file($fotoperfil['tmp_name'], '../img/' . $fotoNombre)){
                //echo "La imagen se ha subido correctamente.";
               
        // else {
              //  echo "Error al subir la imagen.";
            }
          //  print_r($_POST);
       include('../vistas/vistas-prov.php');
       //header('Location:'. $_SERVER['PHP_SELF']);
        
        }
        break;

    case 'eliminar':
        // Eliminar Usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
                $cedula = $_SESSION['cedula'];
                $resultado = Usuario::eliminar($cedula);
                if ($resultado > 0) {
                    include('../index.html');
                } else {
                    echo "Error al eliminar el usuario.";
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
            if (session_status() === PHP_SESSION_NONE) session_start();

            // <-- Reemplazado: uso de session_control para mayor seguridad
            require_once __DIR__ . '/session_control.php';
            set_session_on_login($usuario['cedula'] ?? null);

            // detectar rol mediante el modelo
            $role = Usuario::detectarRol($_SESSION['cedula'] ?? '');
            $_SESSION['role'] = $role;

          switch ($role) {
                case 'cliente':
                    include('../vistas/vistas-cliente.php');
                    break;
                case 'proveedor':
                    include('../vistas/vistas-prov.php');
                    break;
                case 'admin':
                    include('../vistas/panel.php');

                    break;
                default:
                     echo "❌ .";
           
                    break;
            }
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }
    }
    break;


 case 'mensaje':
        // Buscar Usuario por Cédula (GET o POST)
       // $cedula = null;
      //  if (isset($_GET['cedula']) && !empty(trim($_GET['cedula']))) $cedula = trim($_GET['cedula']);
       // if (isset($_POST['cedula']) && !empty(trim($_POST['cedula']))) $cedula = trim($_POST['cedula']);
      //  if ($cedula) {
         $usuario = Usuario::mensaje();
         //   if ($usuario) {
          //      echo "Usuario encontrado: <br>";
          //      echo "Cédula: " . $usuario['cedula'] . "<br>";
            //    echo "Nombre: " . $usuario['nombre'] . "<br>";
              //  echo "Apellido: " . $usuario['apellido'] . "<br>";
               // echo "Username: " . $usuario['username'] . "<br>";
               // echo "Calle: " . $usuario['calle'] . "<br>";
               // echo "Número Puerta: " . $usuario['numeropuerta'] . "<br>";
               // echo "Email: " . $usuario['email'] . "<br>";
              //  echo "Edad: " . $usuario['edad'] . "<br>";
         //   } else {
         //       echo "Usuario no encontrado.";
         //   }
     //   } else {
      //     echo "Falta parámetro 'cedula' para buscar.";
      //  }
        break;

    case 'cancelReservation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha'])) {
            $fecha = $_POST['fecha'];
            if (session_status() === PHP_SESSION_NONE) session_start();
            $idproveedor = $_SESSION['cedula'] ?? null;
            
            if ($idproveedor) {
                $cx = (new ClaseConexion())->getConexion();
                $sql = "UPDATE reserva r 
                        INNER JOIN servicio s ON r.idservicio = s.idservicio
                        INNER JOIN ofrece o ON s.idservicio = o.idservicio
                        SET r.estado = 'cancelada'
                        WHERE o.idproveedor = ? AND r.fecha = ?";
                
                $st = $cx->prepare($sql);
                $st->bind_param("ss", $idproveedor, $fecha);
                $success = $st->execute();
                
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
        break;

    default:
        echo "No se especificó una acción válida. Use el parámetro 'action' (registrar, modificar, eliminar, buscar, login).";
}
}
?>
