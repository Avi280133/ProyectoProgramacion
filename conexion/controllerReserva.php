<?php
require_once('modelPublicacion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {

        /* ==============================
           CREAR RESERVA
        ===============================*/
        case 'crear_reserva':
            if (isset($_POST['idservicio'], $_POST['fecha'], $_POST['hora'])) {
                $idservicio = $_POST['idservicio'];
                $fecha = $_POST['fecha'];
                $hora = $_POST['hora'];
                $idcliente = $_SESSION['cedula'] ?? null;

                if ($idcliente) {
                    $resultado = Servicio::crearReserva($idservicio, $idcliente, $fecha, $hora);
                    echo json_encode(['success' => $resultado]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
                }
            }
            break;

        /* ==============================
           OBTENER RESERVAS POR SERVICIO
        ===============================*/
        case 'obtener_reservas':
            if (isset($_POST['idservicio'])) {
                $reservas = Servicio::obtenerReservasServicio($_POST['idservicio']);
                echo json_encode(['success' => true, 'reservas' => $reservas]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Falta idservicio']);
            }
            break;

        /* ==============================
           OBTENER RESERVAS POR PROVEEDOR
           (para el calendario del panel)
        ===============================*/
        case 'obtener_reservas_proveedor':
            if (isset($_POST['idproveedor'])) {
                $reservas = Servicio::obtenerReservasProveedor($_POST['idproveedor']);
                echo json_encode(['success' => true, 'reservas' => $reservas]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Falta idproveedor']);
            }
            break;
    }

    exit;
}
