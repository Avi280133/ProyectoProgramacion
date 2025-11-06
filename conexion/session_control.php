<?php

// Control de sesión y cabeceras anti-cache para evitar navegación "atrás" con páginas cacheadas.

function start_secure_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
        // Ajustar parámetros de cookie según entorno (en producción set 'secure' => true)
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();
    }
    // Evitar cache por navegador/proxy
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Expires: 0');
}

function set_session_on_login(string $cedula): void {
    start_secure_session();
    // Regenerar id de sesión para prevenir fijación
    session_regenerate_id(true);
    $_SESSION['cedula'] = $cedula;
    $_SESSION['logged_in'] = true;
    $_SESSION['session_token'] = bin2hex(random_bytes(16));
    $_SESSION['login_time'] = time();
}

function require_login(string $redirect = '../index.php'): void {
    start_secure_session();
    if (empty($_SESSION['cedula']) || empty($_SESSION['logged_in'])) {
        // Forzar redirección si no está autenticado
        header('Location: ' . $redirect);
        exit;
    }
    // Opcional: validaciones adicionales (tiempo de inactividad, token, rol, etc.)
}

function destroy_session_and_redirect(string $redirect = '../index.php'): void {
    start_secure_session();
    // Limpiar variables
    $_SESSION = [];
    // Borrar cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
    // Asegurar sin cache y redirigir
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Location: ' . $redirect);
    exit;
}
?>