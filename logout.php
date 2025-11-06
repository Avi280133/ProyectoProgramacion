<?php
// Reemplaza el contenido por este para destruir la sesión correctamente y evitar redirecciones inesperadas.
session_start();

// Limpiar variables de sesión
$_SESSION = [];

// Borrar cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destruir
session_destroy();

// Redirigir al inicio (ajusta ruta si corresponde)
header('Location: ../index.php');
exit;
?>