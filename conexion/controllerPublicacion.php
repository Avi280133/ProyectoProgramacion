<?php
//ControllerPublicacion.php
//echo "<pre>Datos recibidos:\n";
//print_r($_POST);
//echo "</pre>";
require_once('modelUsuario.php');  
require_once('modelPublicacion.php');  // Incluir el modelo Usuario
require_once('ClaseConexion.php'); // Incluir la clase de conexión
// Registrar Publicacion
if (session_status() === PHP_SESSION_NONE) session_start();

$action = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];}

switch ($action) {
   case 'publicar':
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      echo "Método no permitido";
      exit;
    }

    // Validar sesión (debe haber proveedor logueado)
    if (!isset($_SESSION['cedula'])) {
      echo "Debés iniciar sesión como proveedor.";
      exit;
    }

    // Campos obligatorios
    $required = ['titulo','ubicacion','precio','descripcion'];
    foreach ($required as $f) {
      if (!isset($_POST[$f]) || trim($_POST[$f]) === '') {
        echo "Falta el campo: $f";
        exit;
      }
    }

// Sanitizar
$titulo      = trim($_POST['titulo']);
$ubicacion   = trim($_POST['ubicacion']);
$categoria   = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
$precioRaw   = str_replace(['.', ','], ['', '.'], trim($_POST['precio']));
$precio      = (float)$precioRaw;
$descripcion = trim($_POST['descripcion']);

// Subir imagen (opcional)
$imagen = '';
if (isset($_FILES['imagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
    $base = realpath(__DIR__ . '/../img/servicios');
    if ($base === false) {
        $base = __DIR__ . '/../img/servicios';
        @mkdir($base, 0775, true);
    }

    $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
    $safe = 'svc_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . ($ext ? ".{$ext}" : '');
    @move_uploaded_file($_FILES['imagen']['tmp_name'], rtrim($base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $safe);

    $imagen = $safe;
}


    // Publicar usando el modelo
    $servicio   = new Servicio('', $titulo, $ubicacion, $precio, $descripcion,$imagen, $categoria);
    $ok         = $servicio->publicarServicio();

    if ($ok > 0) {
      // Volver al panel del proveedor con aviso
     // header('Location: ../vistas/vistas-prov.php?service=published');
    

   $role = Usuario::detectarRol($_SESSION['cedula'] ?? '');
            $_SESSION['role'] = $role;

            switch ($role) {
                case 'admin':
                    include('../vistas/panel.php');
                    break;
                case 'proveedor':
                    include('../vistas/vistas-prov.php');
                    break;
                default:
                    echo "❌ Rol no reconocido.";
                    break;
            }


      exit;
    } else {
      echo "No se pudo publicar el servicio. Intentá nuevamente.";
      exit;
    }
    break;

    case 'crearCategoria':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
        $nombreCategoria = trim($_POST['nombre']);

        $categoria = new Servicio('', '', '', '', '', '', $nombreCategoria);
        $ok = $categoria->crearCategoria();

        if ($ok > 0) {
            // Redirigir al panel con mensaje
            header('Location: ../vistas/panel.php?cat=ok');
            exit;
        } else {
            echo "❌ No se pudo crear la categoría.";
        }
    } else {
        echo "⚠️ Faltó el nombre de la categoría.";
    }
    break;





  /* ======================
     ELIMINAR SERVICIO
     ====================== */
  case 'eliminar':
    // Puede venir por POST o GET
    $id = 0;
    if (isset($_POST['id'])) $id = (int)$_POST['id'];
    if (isset($_GET['id']))  $id = (int)$_GET['id'];

    if ($id <= 0) {
      echo "ID de servicio inválido.";
      exit;
    }
    if (!isset($_SESSION['cedula'])) {
      echo "Debés iniciar sesión.";
      exit;
    }

    $done = Servicio::eliminarSiEsDelProveedor($id, $_SESSION['cedula']);
    $qs   = $done ? 'deleted=1' : 'deleted=0';
    header('Location: ../vistas/vistas-prov.php?' . $qs);
    exit;
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