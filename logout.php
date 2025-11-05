<?php
<?php
// Destruye la sesión de forma segura y redirige al índice (o login)
session_start();

// Limpiar todas las variables de sesión
$_SESSION = [];

// Borrar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al inicio (ajusta si tu página de login/landing es otra)
header('Location: index.php');
exit;
?>