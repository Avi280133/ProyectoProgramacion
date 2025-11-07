<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

/* Evitar que el navegador use historial para “adelantar” a protegidas */
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

if (!empty($_SESSION['cedula'])) {
  $role = $_SESSION['role'] ?? null;
  if ($role === 'cliente') {
    header('Location: ../vistas/vistas-cliente.php'); exit;
  } elseif ($role === 'proveedor') {
    header('Location: ../vistas/vistas-prov.php'); exit;
  } elseif ($role === 'admin') {
    header('Location: ../vistas/panel.php'); exit;
  } else {
    header('Location: ../index.html'); exit;
  }
}
