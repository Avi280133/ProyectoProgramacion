<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

/* Evitar que el navegador cachee páginas protegidas */
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

if (empty($_SESSION['cedula'])) {
  header('Location: ../vistas/login.php');
  exit;
}
