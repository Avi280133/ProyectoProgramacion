<?php
session_start();
$_SESSION = array(); // Limpia todas las variables de sesión

// Destruye la cookie de sesión si existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

session_destroy(); // Destruye la sesión

// Redirecciona al login.php
header('Location: ../vistas/login.php');
exit();

?>