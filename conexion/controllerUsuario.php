<?php
require_once('modelUsuario.php');     // Modelo Usuario
require_once('modelProveedor.php');   // Modelo Proveedor
require_once('ClaseConexion.php');    // Clase de conexión

// Sesión global (varios casos usan $_SESSION)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Detectar acción preferentemente desde POST, si no, desde GET.
 */
$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {

    case 'registrar':
        // Registrar Usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $required = ['cedula','nombre','apellido','username','email','contrasena','edad','tipo'];
            $ok = true;
            foreach ($required as $f) {
                if (!isset($_POST[$f]) || trim($_POST[$f]) === '') { 
                    $ok = false; 
                    break; 
                }
            }
            if ($ok) {
                $cedula     = trim($_POST['cedula']);
                $nombre     = trim($_POST['nombre']);
                $apellido   = trim($_POST['apellido']);
                $username   = trim($_POST['username']);
                $email      = trim($_POST['email']);
                $contrasena = trim($_POST['contrasena']);
                $edad       = trim($_POST['edad']);
                $tipo       = $_POST['tipo'];
                $usuario    = new Usuario($cedula, $nombre, $apellido, $username, $email, $contrasena, '', $edad, '', $tipo);
                $resultado  = $usuario->registrar();
                echo "registrar -> resultado: ";
                var_dump($resultado);
            } else {
                echo "Faltan campos obligatorios para registrar.";
            }
        }
    break;

    case 'modificar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['cedula'])) { 
                echo "No hay sesión activa (cedula)."; 
                break; 
            }

            $cedula      = $_SESSION['cedula'];
            $username    = isset($_POST['username']) ? trim($_POST['username']) : null;
            $localidad   = isset($_POST['localidad']) ? trim($_POST['localidad']) : '';
            $experiencia = isset($_POST['experiencia']) ? trim($_POST['experiencia']) : '';
            $habilidad   = isset($_POST['habilidad']) ? trim($_POST['habilidad']) : '';

            // Foto (opcional)
            $fotoNombre = '';
            if (isset($_FILES['foto']) && is_array($_FILES['foto']) && ($_FILES['foto']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $fotoNombre = basename($_FILES['foto']['name']);
            } else {
                $fotoNombre = isset($_POST['fotoperfil']) ? trim($_POST['fotoperfil']) : '';
            }

            // Actualizar usuario
            $usuario    = new Usuario($cedula, '', '', $username ?? '', '', '', $fotoNombre, '', $localidad, '');
            $resultado1 = $usuario->modificarUsuario();

            // Actualizar proveedor (experiencia/habilidad)
            $proveedor  = new Proveedor($cedula, $experiencia, $habilidad);
            $resultado2 = $proveedor->modificarProv();

            // Subir imagen si vino archivo
            if (isset($_FILES['foto']) && is_array($_FILES['foto']) && ($_FILES['foto']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                @move_uploaded_file($_FILES['foto']['tmp_name'], '../img/' . $fotoNombre);
            }

            // Redirigir según el rol
            $role = Usuario::detectarRol($_SESSION['cedula'] ?? '');
            $_SESSION['role'] = $role;

            switch ($role) {
                case 'cliente':
                    include('../vistas/vistas-cliente.php');
                    break;
                case 'proveedor':
                    include('../vistas/vistas-prov.php');
                    break;
                default:
                    echo "❌ Rol no reconocido.";
                    break;
            }
        }
    break;  // ← faltaba este cierre del case 'modificar'

    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $cedula = $_SESSION['cedula'] ?? null;
            if (!$cedula) { header('Location: ../vistas/login.php'); exit; }

            $ok = Usuario::eliminar($cedula) > 0;

            if ($ok) {
                header('Location: ../index.php');
                exit;
            } else {
                header('Location: ../vistas/login.php?err=no_delete_fk');
                exit;
            }
        }
    break;

    case 'buscar':
        $cedula = $_POST['cedula'] ?? $_GET['cedula'] ?? null;
        if ($cedula) {
            $usuario = Usuario::buscarPorCedula($cedula);
            if ($usuario) {
                echo "Usuario encontrado:<br>";
                echo "Cédula: {$usuario['cedula']}<br>";
                echo "Nombre: {$usuario['nombre']}<br>";
                echo "Apellido: {$usuario['apellido']}<br>";
                echo "Username: {$usuario['username']}<br>";
                echo "Calle: {$usuario['calle']}<br>";
                echo "Número Puerta: {$usuario['numeropuerta']}<br>";
                echo "Email: {$usuario['email']}<br>";
                echo "Edad: {$usuario['edad']}<br>";
            } else {
                echo "Usuario no encontrado.";
            }
        } else {
            echo "Falta parámetro 'cedula' para buscar.";
        }
    break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email       = trim($_POST['email'] ?? '');
            $contrasena  = trim($_POST['contrasena'] ?? '');

            $modelo  = new Usuario('', '', '', '', '', '', '', '', '', '');
            $usuario = $modelo->login($email, $contrasena);

            if ($usuario) {
                $_SESSION['cedula'] = $usuario['cedula'] ?? null;

                $role = Usuario::detectarRol($_SESSION['cedula'] ?? '');
                $_SESSION['role'] = $role;

                if     ($role === 'cliente')  { header('Location: ../vistas/vistas-cliente.php'); exit; }
                elseif ($role === 'proveedor'){ header('Location: ../vistas/vistas-prov.php');    exit; }
                elseif ($role === 'admin')    { header('Location: ../vistas/panel.php');          exit; }
                else                          { header('Location: ../vistas/login.php');          exit; }
            } else {
                echo "❌ Usuario o contraseña incorrectos.";
            }
        }
    break;

    case 'mensaje':
        $usuario = Usuario::mensaje();
    break;

    case 'cancelReservation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha'])) {
            $fecha       = $_POST['fecha'];
            $idproveedor = $_SESSION['cedula'] ?? null;

            if ($idproveedor) {
                $cx  = (new ClaseConexion())->getConexion();
                $sql = "UPDATE reserva r 
                        INNER JOIN servicio s ON r.idservicio = s.idservicio
                        INNER JOIN ofrece o ON s.idservicio = o.idservicio
                        SET r.estado = 'cancelada'
                        WHERE o.idproveedor = ? AND r.fecha = ?";

                $st = $cx->prepare($sql);
                $st->bind_param("ss", $idproveedor, $fecha);
                $success = $st->execute();

                header('Content-Type: application/json');
                echo json_encode(['success' => (bool)$success]);
                exit;
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
        exit;
    break;
}
?>
