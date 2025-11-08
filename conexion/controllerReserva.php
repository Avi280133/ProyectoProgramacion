<?php
require_once('modelPublicacion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {

        /* =====================================
           OBTENER RESERVAS POR SERVICIO
        ======================================*/
        case 'obtener_reservas':
            if (isset($_POST['idservicio'])) {
                $reservas = Servicio::obtenerReservasServicio($_POST['idservicio']);
                echo json_encode(['success' => true, 'reservas' => $reservas]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Falta idservicio']);
            }
        break;

        /* =====================================
           CREAR RESERVA
        ======================================*/
        case 'crear_reserva':
            $idservicio = $_POST['idservicio'] ?? null;
            $fecha = $_POST['fecha'] ?? null;
            $hora = $_POST['hora'] ?? null;
            $idcliente = $_SESSION['cedula'] ?? null;

            if (!$idcliente) {
                echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
                exit;
            }

            if ($idservicio && $fecha && $hora) {
                $resultado = Servicio::crearReserva($idservicio, $idcliente, $fecha, $hora);
                echo json_encode([
                    'success' => (bool)$resultado,
                    'debug' => [
                        'idservicio' => $idservicio,
                        'idcliente' => $idcliente,
                        'fecha' => $fecha,
                        'hora' => $hora
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Faltan datos para crear reserva']);
            }
        break;

        /* =====================================
           OBTENER RESERVAS POR PROVEEDOR
        ======================================*/
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
?>
