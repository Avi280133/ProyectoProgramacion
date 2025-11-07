<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - SkillMatch</title>
          <link rel="conexion" href="../conexion/controllerPublicacion.php">
           <link rel="conexion" href="../conexion/controllerUsuario.php">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="conexion" href="../conexion/controllerPublicacion.php">





<?php
require_once '../conexion/controllerUsuario.php';


  $cx=(new ClaseConexion())->getConexion();
        $sql1="SELECT COUNT(*) AS total_clientes FROM cliente;";
        $st=$cx->prepare($sql1);
        $st->execute(); 
        $res=$st->get_result()->fetch_assoc();
        $numeroClientes = $res['total_clientes'];

        $sql2="SELECT COUNT(*) AS total_proveedores FROM proveedor;";
        $st=$cx->prepare($sql2);
        $st->execute(); 
        $res=$st->get_result()->fetch_assoc();
        $numeroProveedores = $res['total_proveedores'];

        $sql3="SELECT COUNT(*) AS total_servicios FROM servicio;";
        $st=$cx->prepare($sql3);
        $st->execute(); 
        $res=$st->get_result()->fetch_assoc();
        $numeroServicios = $res['total_servicios'];
        
        $sql4=" SELECT COUNT(*) AS total_categorias FROM categoria;";
        $st=$cx->prepare($sql4);
        $st->execute(); 
        $res=$st->get_result()->fetch_assoc();
        $numeroCategorias = $res['total_categorias'];


require_once '../conexion/modelUsuario.php';
$clientes = Usuario::cargarPanelClientes();
$proveedores = Usuario::cargarPanelProveedores();
$servicios = Usuario::cargarPanelServicios();
$categorias = Usuario::cargarPanelCategorias();

?>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5f1 100%);
            min-height: 100vh;
        }

        header {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(14, 178, 124, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-actions {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0eb27c;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .admin-details {
            color: white;
        }

        .admin-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .admin-role {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: white;
            color: #0eb27c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:focus {
            outline: none;
        }

        .logout-btn:active {
            text-decoration: none;
        }

        .logout-btn:visited {
            color: white;
        }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .dashboard-title {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard-title i {
            color: #0eb27c;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-card.active {
            border: 3px solid #0eb27c;
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: white;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon.providers {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-icon.services {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-icon.categories {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .content-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-title {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-create {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            color: white;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(14, 178, 124, 0.3);
        }

        .btn-edit {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Listas */
        .cards-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .item-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .item-card:hover {
            border-color: #0eb27c;
            box-shadow: 0 4px 12px rgba(14, 178, 124, 0.1);
            transform: translateX(5px);
        }

        .item-card.selected {
            border: 3px solid #0eb27c;
            background: linear-gradient(135deg, #e8f5f1 0%, #d1f0e5 100%);
            box-shadow: 0 4px 12px rgba(14, 178, 124, 0.2);
            transform: translateX(5px);
        }

        .item-card .card-icon-container {
            width: 60px;
            height: 60px;
            min-width: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .item-card .card-icon-container.provider-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .item-card .card-icon-container.service-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .item-card .card-icon-container.category-icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .item-card .card-main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-card .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.3rem;
        }

        .item-card .card-id {
            background: #e0e0e0;
            color: #7f8c8d;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .item-card.selected .card-id {
            background: #0eb27c;
            color: white;
        }

        .item-card .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .item-card .card-subtitle {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .item-card .card-info {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .item-card .info-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .item-card .info-row i {
            width: 16px;
            color: #0eb27c;
        }

        .item-card .card-badges {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-provider {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .badge-client {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .badge-active {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            color: white;
        }

        .price-badge {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* estilos para los modales generales */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(-20px);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f0f0f0;
            color: #7f8c8d;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .modal-close:hover {
            background: #e74c3c;
            color: white;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #0eb27c;
            box-shadow: 0 0 0 3px rgba(14, 178, 124, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-hint {
            color: #7f8c8d;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 2px solid #f0f0f0;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #7f8c8d;
        }

        .btn-cancel:hover {
            background: #d0d0d0;
            transform: translateY(-2px);
        }

        .btn-save {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(14, 178, 124, 0.3);
        }

        /* modal de confirmación para eliminar */
        .delete-modal {
            max-width: 450px;
            text-align: center;
        }

        .delete-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2.5rem;
        }

        .delete-text {
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .delete-subtext {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .btn-confirm-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-confirm-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        /* notificación que aparece arriba a la derecha */
        .notification-toast {
            position: fixed;
            top: 100px;
            right: 30px;
            background: white;
            border-radius: 15px;
            padding: 1.2rem 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 3000;
            opacity: 0;
            transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 320px;
            max-width: 450px;
        }

        .notification-toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification-toast.hide {
            opacity: 0;
            transform: translateX(400px);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .notification-toast.success .notification-icon {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            color: white;
        }

        .notification-toast.error .notification-icon {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .notification-toast.info .notification-icon {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .notification-message {
            color: #7f8c8d;
            font-size: 0.85rem;
        }

        .notification-close {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: #f0f0f0;
            color: #7f8c8d;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .notification-close:hover {
            background: #e0e0e0;
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .admin-info {
                display: none;
            }

            .modal {
                width: 95%;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .notification-toast {
                right: 15px;
                left: 15px;
                min-width: auto;
                max-width: none;
            }
        }

        /* ====== Crear Usuario – Ajustes visuales ====== */
#createUserModal .modal {
  border-radius: 20px;
  overflow: hidden;
}

#createUserModal .modal-header {
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
  color: #fff;
}

#createUserModal .modal-header h3 i {
  color: #fff;
}

#createUserModal .modal-body {
  background: #ffffff;
}

#createUserModal .form-input,
#createUserModal .form-select {
  border: 2px solid #e0e0e0;
  background: #fff;
}

#createUserModal .form-input:focus,
#createUserModal .form-select:focus {
  border-color: #0eb27c;
  box-shadow: 0 0 0 3px rgba(14,178,124,0.12);
}

/* Marcado de error suave */
#createUserModal .cu-error {
  border-color: #e74c3c !important;
  box-shadow: 0 0 0 3px rgba(231,76,60,0.12) !important;
}

/* Grid 2 columnas en desktop */
#createUserModal .cu-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(220px, 1fr));
  gap: 1rem 1.25rem;
}

/* Responsive */
@media (max-width: 720px) {
  #createUserModal .cu-grid {
    grid-template-columns: 1fr;
  }
}

    </style>
</head>
<body>
    <header>
        <div class="header-logo">
            <i class="fas fa-handshake"></i>
            SkillMatch
        </div>
        <div class="header-actions">
            <div class="admin-info">
                <div class="admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="admin-details">
                    <div class="admin-name">Administrador</div>
                </div>
            </div>
            <a href="../conexion/logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Cerrar Sesión
            </a>
        </div>
    </header>

    <div class="container">
        <h1 class="dashboard-title">
            <i class="fas fa-tachometer-alt"></i>
            Panel de Administración
        </h1>

<form id="formAction" action="../conexion/controllerUsuario.php" method="POST" style="display:none;">
  <input type="hidden" name="action" id="actionField">
</form>

<script>
function enviarAction(valor) {
  document.getElementById('actionField').value = valor;
  document.getElementById('formAction').submit();
}
</script>



       <div class="stats-grid">
    <div class="stat-card active" onclick="showSection('users', this);">
        <div class="stat-icon users">
            <i class="fas fa-users"></i></i>
                </div>
         <div class="stat-number"><?php echo $numeroClientes; ?></div>
        <div class="stat-label">Clientes</div>
    </div>
   


              <div class="stat-card" onclick="showSection('providers', this);">
        <div class="stat-icon providers">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="stat-number"><?php echo $numeroProveedores; ?></div>
        <div class="stat-label">Proveedores</div>
    </div>

    <div class="stat-card" onclick="showSection('services', this);">
        <div class="stat-icon services">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-number"><?php echo $numeroServicios; ?></div>
        <div class="stat-label">Servicios Activos</div>
    </div>

    <div class="stat-card" onclick="showSection('categories', this);">
        <div class="stat-icon categories">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-number"><?php echo $numeroCategorias; ?></div>
        <div class="stat-label">Categorías</div>
    </div>
</div>

        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title" id="sectionTitle">Gestión de Clientes</h2>
                <div class="action-buttons">
                    <button class="btn btn-create" onclick="createItem()">
                        <i class="fas fa-plus"></i>
                        Crear Nuevo
                    </button>
                    <button class="btn btn-edit" id="editBtn" onclick="editItem()" disabled>
                        <i class="fas fa-edit"></i>
                        Modificar
                    </button>
                    <button class="btn btn-delete" id="deleteBtn" onclick="deleteItem()" disabled>
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </button>
                </div>
            </div>

            <!-- aquí va el listado de usuarios -->
   <div id="usersContainer" class="cards-grid">
<?php  
if (!empty($clientes)) {
    foreach ($clientes as $c) {
        echo '<div class="item-card" data-id="' . htmlspecialchars($c['cedula']) . '" onclick="selectCard(this, \'users\')">';
        echo '  <div class="card-icon-container"><i class="fas fa-user"></i></div>';
        echo '  <div class="card-main-content">';
        echo '      <div class="card-header">';
        echo '          <div class="card-id">ID: ' . htmlspecialchars($c['cedula']) . '</div>';
        echo '      </div>';
        echo '      <div class="card-title">' . htmlspecialchars($c['nombre']) . ' ' . htmlspecialchars($c['apellido']) . '</div>';
        echo '      <div class="card-info">';
        echo '          <div class="info-row">';
        echo '              <i class="fas fa-envelope"></i>';
        echo '              <span>' . htmlspecialchars($c['email']) . '</span>';
        echo '          </div>';
        echo '          <div class="info-row">';
        echo '              <i class="fas fa-circle-check"></i>';
        echo '              <span>' . htmlspecialchars($c['estado'] ?? " ") . '</span>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
}
?>
</div>




            <!-- aquí va el listado de proveedores -->
            <div id="providersContainer" class="cards-grid" style="display: none;">

            <?php  
if (!empty($proveedores)) {
    foreach ($proveedores as $p) {
        echo '<div class="item-card" data-id="' . htmlspecialchars($p['cedula']) . '" onclick="selectCard(this, \'providers\')">';
        echo '  <div class="card-icon-container"><i class="fas fa-user"></i></div>';
        echo '  <div class="card-main-content">';
        echo '      <div class="card-header">';
        echo '          <div class="card-id">ID: ' . htmlspecialchars($p['cedula']) . '</div>';
        echo '      </div>';
        echo '      <div class="card-title">' . htmlspecialchars($p['nombre']) . ' ' . htmlspecialchars($p['apellido']) . '</div>';
        echo '      <div class="card-info">';
        echo '          <div class="info-row">';
        echo '              <i class="fas fa-envelope"></i>';
        echo '              <span>' . htmlspecialchars($p['email']) . '</span>';
        echo '          </div>';
        echo '          <div class="info-row">';
        echo '              <i class="fas fa-circle-check"></i>';
        echo '              <span>' . htmlspecialchars($p['estado'] ?? " ") . '</span>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
}
?>
</div>

            <!-- aquí va el listado de categorías -->
            <div id="categoriesContainer" class="cards-grid" style="display: none;">
                           <?php  
if (!empty($categorias)) {
    foreach ($categorias as $c) {
        echo '<div class="item-card" data-id="' . htmlspecialchars($c['idcategoria']) . '" onclick="selectCard(this, \'categories\')">';
        echo '  <div class="card-icon-container"><i class="fas fa-user"></i></div>';
        echo '  <div class="card-main-content">';

     echo '<div class="card-title">' . htmlspecialchars($p['nombre']) . '</div>';

        echo '      <div class="card-title">' . htmlspecialchars($c['nombre']) . '</div>';
        echo '      <div class="card-info">'; 
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
}
?>
        </div>





                  <div id="servicesContainer" class="cards-grid" style="display: none;">
                           <?php  
if (!empty($servicios)) {
    foreach ($servicios as $s) {
        echo '<div class="item-card" data-id="' . htmlspecialchars($s['idservicio']) . '" onclick="selectCard(this, \'services\')">';
        echo '  <div class="card-icon-container"><i class="fas fa-user"></i></div>';
        echo '  <div class="card-main-content">';

        echo '          <div class="card-title">' . htmlspecialchars($s['titulo']) . '</div>';

        echo '      <div class="card-title">$ ' . htmlspecialchars($s['precio']) . '</div>';
        echo '      <div class="card-info">'; 
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
}
?>
        </div>  
    

    <!-- crear usuario-->
<div class="modal-overlay" id="createUserModal">
  <div class="modal">
    <div class="modal-header">
      <h3>
        <i class="fas fa-user-plus"></i>
        Crear Usuario
      </h3>
      <button class="modal-close" onclick="closeModal('createUserModal')">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="formCrearUsuario"
          class="modal-body"
          action="../conexion/controllerUsuario.php"
          method="POST" novalidate>
      <input type="hidden" name="action" value="registrar">

      <!-- Grid 2 columnas en desktop -->
      <div class="cu-grid">
        <div class="form-group">
          <label class="form-label" for="cedula">Cédula *</label>
          <input type="text" class="form-input" id="cedula" name="cedula"
                 placeholder="Ej: 4.123.456-7" required>
          <div class="form-hint">Sin puntos ni guiones también funciona.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="edad">Edad *</label>
          <input type="number" class="form-input" id="edad" name="edad"
                 min="18" max="120" placeholder="Ej: 28" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="nombre">Nombre *</label>
          <input type="text" class="form-input" id="nombre" name="nombre"
                 placeholder="Ej: María" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="apellido">Apellido *</label>
          <input type="text" class="form-input" id="apellido" name="apellido"
                 placeholder="Ej: González" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="username">Usuario *</label>
          <input type="text" class="form-input" id="username" name="username"
                 placeholder="Ej: mgonzalez" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email *</label>
          <input type="email" class="form-input" id="email" name="email"
                 placeholder="usuario@email.com" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="contrasena">Contraseña *</label>
          <input type="password" class="form-input" id="contrasena" name="contrasena"
                 placeholder="Mínimo 8 caracteres" minlength="8" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-cancel" onclick="closeModal('createUserModal')">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-save">
          <i class="fas fa-check"></i> Guardar
        </button>
      </div>
    </form>
  </div>
</div>

<!-- JS: validación simple y feedback -->
<script>
  (function(){
    const f = document.getElementById('formCrearUsuario');
    if (!f) return;

    function showToastOk() {
      // Re-usa tu toast ya definido
      if (typeof showNotification === 'function') {
        showNotification('success', 'Usuario creado', 'El usuario fue creado correctamente');
      }
    }

    f.addEventListener('submit', function(e){
      // validación mínima en cliente
      const required = ['cedula','nombre','apellido','username','email','contrasena','edad','tipo'];
      let ok = true;
      required.forEach(id => {
        const el = f.querySelector(`[name="${id}"]`);
        if (!el) return;
        const v = (el.value || '').trim();
        if (!v) {
          ok = false;
          el.classList.add('cu-error');
        } else {
          el.classList.remove('cu-error');
        }
      });

      const pass = f.querySelector('#contrasena');
      if (pass && pass.value.length < 8) { ok = false; pass.classList.add('cu-error'); }

      if (!ok) {
        e.preventDefault();
        if (typeof showNotification === 'function') {
          showNotification('error', 'Campos faltantes', 'Completá los campos obligatorios.');
        } else {
          alert('Completá los campos obligatorios.');
        }
        return;
      }

      // Si querés feedback antes de enviar (opcional)
      // showToastOk();
      // Se envía al controller con action=registrar
    });
  })();
</script>


    <!-- este es el modal para modificar un usuario existente -->
    <div class="modal-overlay" id="editUserModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-user-edit"></i>
                    Editar Usuario
                </h3>
                <button class="modal-close" onclick="closeModal('editUserModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-input" id="editUserName" placeholder="Ej: María González" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-input" id="editUserEmail" placeholder="usuario@email.com" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('editUserModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveUser('edit')">
                    <i class="fas fa-check"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- este es el modal para crear un nuevo proveedor -->
    <div class="modal-overlay" id="createProviderModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-user-tie"></i>
                    Crear Proveedor
                </h3>
                <button class="modal-close" onclick="closeModal('createProviderModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-input" id="createProviderName" placeholder="Ej: Juan Pérez" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-input" id="createProviderEmail" placeholder="Ej: juan.perez@email.com" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('createProviderModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveProvider('create')">
                    <i class="fas fa-check"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- este es el modal para modificar un proveedor existente -->
    <div class="modal-overlay" id="editProviderModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-user-tie"></i>
                    Editar Proveedor
                </h3>
                <button class="modal-close" onclick="closeModal('editProviderModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-input" id="editProviderName" placeholder="Ej: Juan Pérez" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-input" id="editProviderEmail" placeholder="Ej: juan.perez@email.com" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('editProviderModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveProvider('edit')">
                    <i class="fas fa-check"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- este es el modal para crear un nuevo servicio -->
    <div class="modal-overlay" id="createServiceModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-briefcase"></i>
                    Crear Servicio
                </h3>
                <button class="modal-close" onclick="closeModal('createServiceModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Título del Servicio *</label>
                    <input type="text" class="form-input" id="createServiceTitle" placeholder="Ej: Desarrollo Web Completo" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Proveedor *</label>
                    <input type="text" class="form-input" id="createServiceProvider" placeholder="Nombre del proveedor" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Categoría *</label>
                    <select class="form-select" id="createServiceCategory" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Hogar">Hogar</option>
                        <option value="Diseño">Diseño</option>
                        <option value="Educación">Educación</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Precio (USD) *</label>
                    <input type="number" class="form-input" id="createServicePrice" min="0" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-textarea" id="createServiceDescription" placeholder="Describe el servicio en detalle..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('createServiceModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveService('create')">
                    <i class="fas fa-check"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- este es el modal para modificar un servicio existente -->
    <div class="modal-overlay" id="editServiceModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-briefcase"></i>
                    Editar Servicio
                </h3>
                <button class="modal-close" onclick="closeModal('editServiceModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Título del Servicio *</label>
                    <input type="text" class="form-input" id="editServiceTitle" placeholder="Ej: Desarrollo Web Completo" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Categoría *</label>
                    <select class="form-select" id="editServiceCategory" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Hogar">Hogar</option>
                        <option value="Diseño">Diseño</option>
                        <option value="Educación">Educación</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Precio (USD) *</label>
                    <input type="number" class="form-input" id="editServicePrice" min="0" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-textarea" id="editServiceDescription" placeholder="Describe el servicio en detalle..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('editServiceModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveService('edit')">
                    <i class="fas fa-check"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- este es el modal para crear una nueva categoría -->
     
    <div class="modal-overlay" id="createCategoryModal">
        <div class="modal">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-tags"></i>
                    Crear Categoría
                </h3>
                <button class="modal-close" onclick="closeModal('createCategoryModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
           
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre de la Categoría *</label>
                     <form id="formCategoria" action="../conexion/controllerPublicacion.php" method="POST">
                    <input type="text" class="form-input" id="nombre" name="nombre"  value="nombre" placeholder="Ej: Tecnología" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('createCategoryModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                
                <button type="submit" name="action" value="crearCategoria"  onclick="saveCategory('create')" class="btn btn-save">
                        <a href="../vistas/panel.php" style="text-decoration:none;">
                        <i class="fas fa-check"></i>
                        Guardar
                    </a>        
                    </button>
            </div>
        </div>
    </div>
    </form>

   <!-- este es el modal para crear una nueva categoría -->
<div class="modal-overlay" id="createCategoryModal">
  <div class="modal">
    <div class="modal-header">
      <h3>
        <i class="fas fa-tags"></i>
        Crear Categoría
      </h3>
      <button class="modal-close" onclick="closeModal('createCategoryModal')">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="formCategoria" action="../conexion/controllerPublicacion.php" method="POST" class="modal-body">
      <input type="hidden" name="action" value="crearCategoria">
      <div class="form-group">
        <label class="form-label">Nombre de la Categoría *</label>
        <input type="text" class="form-input" name="nombre" placeholder="Ej: Tecnología, Hogar, Diseño..." required>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-cancel" onclick="closeModal('createCategoryModal')">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-save">
          <i class="fas fa-check"></i> Guardar
        </button>
      </div>
    </form>
  </div>
</div>


    <!-- este es el modal que pregunta si realmente querés eliminar algo -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal delete-modal">
            <div class="modal-body">
                <div class="delete-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="delete-text">¿Estás seguro?</div>
                <div class="delete-subtext" id="deleteMessage">
                    Esta acción no se puede deshacer. El elemento será eliminado permanentemente.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-confirm-delete" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- esta es la notificación que aparece cuando hacés algo -->
    <div class="notification-toast" id="notificationToast">
        <div class="notification-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title" id="notificationTitle">Operación exitosa</div>
            <div class="notification-message" id="notificationMessage">La acción se completó correctamente</div>
        </div>
        <button class="notification-close" onclick="hideNotification()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script>
    let currentSection = 'users';
    let selectedItem = null;
    let selectedItemName = '';

    function showSection(section, el) {
        currentSection = section;
        selectedItem = null;

        // 1) quitar "active" de todas las cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.classList.remove('active');
        });

        // 2) marcar la que se clickeó
        if (el) {
            el.classList.add('active');
        }

        // 3) cambiar título
        const titles = {
            users: 'Gestión de Usuarios',
            providers: 'Gestión de Proveedores',
            services: 'Gestión de Servicios',
            categories: 'Gestión de Categorías'
        };
        document.getElementById('sectionTitle').textContent = titles[section];

        // 4) ocultar todos los contenedores
        document.getElementById('usersContainer').style.display = 'none';
        document.getElementById('providersContainer').style.display = 'none';

        const serv = document.getElementById('servicesContainer');
        if (serv) serv.style.display = 'none';

        document.getElementById('categoriesContainer').style.display = 'none';

        // 5) mostrar el contenedor de la sección actual
        const toShow = document.getElementById(section + 'Container');
        if (toShow) {
            // tus listas usan flex
            toShow.style.display = 'flex';
        }

        // 6) deshabilitar botones hasta que elijan una card
        document.getElementById('editBtn').disabled = true;
        document.getElementById('deleteBtn').disabled = true;
    }
        // esta función selecciona una tarjeta cuando hacés click en ella
        function selectCard(card, section) {
            // quitamos la selección de todas las tarjetas en esta sección
            const container = document.getElementById(section + 'Container');
            container.querySelectorAll('.item-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // agregamos la clase selected a la tarjeta clickeada
            card.classList.add('selected');
            
            // guardamos el id y nombre del elemento seleccionado
            selectedItem = card.dataset.id;
            selectedItemName = card.querySelector('.card-title').textContent;
            
            // ahora sí habilitamos los botones de editar y eliminar
            document.getElementById('editBtn').disabled = false;
            document.getElementById('deleteBtn').disabled = false;
        }

        // esta función abre el modal correspondiente para crear algo nuevo
        function createItem() {
            const modals = {
                users: 'createUserModal',
                providers: 'createProviderModal',
                services: 'createServiceModal',
                categories: 'createCategoryModal'
            };
            openModal(modals[currentSection]);
        }

        // esta función abre el modal correspondiente para editar algo que ya existe
        function editItem() {
            if (!selectedItem) return;
            
            const modals = {
                users: 'editUserModal',
                providers: 'editProviderModal',
                services: 'editServiceModal',
                categories: 'editCategoryModal'
            };
            openModal(modals[currentSection]);
        }

        // esta función abre el modal de confirmación antes de eliminar
        function deleteItem() {
            if (!selectedItem) return;
            
            const deleteMsg = document.getElementById('deleteMessage');
            
            // cambiamos el mensaje según lo que vayamos a eliminar
            const messages = {
                users: `¿Estás seguro de eliminar al usuario "${selectedItemName}"? Esta acción no se puede deshacer.`,
                providers: `¿Estás seguro de eliminar al proveedor "${selectedItemName}"? Se eliminarán también todos sus servicios asociados.`,
                services: `¿Estás seguro de eliminar el servicio "${selectedItemName}"? Esta acción no se puede deshacer.`,
                categories: `¿Estás seguro de eliminar la categoría "${selectedItemName}"? Esto afectará a los servicios asociados.`
            };
            
            deleteMsg.textContent = messages[currentSection];
            openModal('deleteModal');
        }

        // esta función elimina definitivamente el elemento después de confirmar
        function confirmDelete() {
            const container = document.getElementById(currentSection + 'Container');
            const cardToDelete = container.querySelector(`.item-card[data-id="${selectedItem}"]`);
            
            if (cardToDelete) {
                cardToDelete.remove();
            }
            
            closeModal('deleteModal');
            
            // mostramos notificación de éxito según lo que hayamos eliminado
            const messages = {
                users: { title: 'Usuario eliminado', message: 'El usuario ha sido eliminado correctamente' },
                providers: { title: 'Proveedor eliminado', message: 'El proveedor ha sido eliminado correctamente' },
                services: { title: 'Servicio eliminado', message: 'El servicio ha sido eliminado correctamente' },
                categories: { title: 'Categoría eliminada', message: 'La categoría ha sido eliminada correctamente' }
            };
            
            showNotification('success', messages[currentSection].title, messages[currentSection].message);
            
            // limpiamos la selección
            selectedItem = null;
            selectedItemName = '';
            document.getElementById('editBtn').disabled = true;
            document.getElementById('deleteBtn').disabled = true;
        }

        // acá están las funciones que guardan los cambios de usuarios
        function saveUser(mode) {
            if (mode === 'create') {
                closeModal('createUserModal');
                showNotification('success', 'Usuario creado', 'El usuario ha sido creado correctamente');
            } else {
                closeModal('editUserModal');
                showNotification('success', 'Usuario actualizado', 'El usuario ha sido actualizado correctamente');
            }
        }

        // acá están las funciones que guardan los cambios de proveedores
        function saveProvider(mode) {
            if (mode === 'create') {
                closeModal('createProviderModal');
                showNotification('success', 'Proveedor creado', 'El proveedor ha sido creado correctamente');
            } else {
                closeModal('editProviderModal');
                showNotification('success', 'Proveedor actualizado', 'El proveedor ha sido actualizado correctamente');
            }
        }

        // acá están las funciones que guardan los cambios de servicios
        function saveService(mode) {
            if (mode === 'create') {
                closeModal('createServiceModal');
                showNotification('success', 'Servicio creado', 'El servicio ha sido creado correctamente');
            } else {
                closeModal('editServiceModal');
                showNotification('success', 'Servicio actualizado', 'El servicio ha sido actualizado correctamente');
            }
        }

        // acá están las funciones que guardan los cambios de categorías
        function saveCategory(mode) {
            if (mode === 'create') {
                closeModal('createCategoryModal');
                showNotification('success', 'Categoría creada', 'La categoría ha sido creada correctamente');
            } else {
                closeModal('editCategoryModal');
                showNotification('success', 'Categoría actualizada', 'La categoría ha sido actualizada correctamente');
            }
        }

        // esta función muestra la notificación tipo toast
        function showNotification(type, title, message) {
            const toast = document.getElementById('notificationToast');
            const toastTitle = document.getElementById('notificationTitle');
            const toastMessage = document.getElementById('notificationMessage');
            const icon = toast.querySelector('.notification-icon i');
            
            // configuramos el título y mensaje
            toastTitle.textContent = title;
            toastMessage.textContent = message;
            
            // cambiamos el ícono según el tipo de notificación
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle'
            };
            
            icon.className = `fas ${icons[type] || icons.success}`;
            
            // agregamos la clase del tipo de notificación (success, error, info)
            toast.className = `notification-toast ${type}`;
            
            // mostramos la notificación con un pequeño delay
            setTimeout(() => toast.classList.add('show'), 100);
            
            // la ocultamos automáticamente después de 4 segundos
            setTimeout(() => hideNotification(), 4000);
        }

        // esta función oculta la notificación
        function hideNotification() {
            const toast = document.getElementById('notificationToast');
            toast.classList.remove('show');
            toast.classList.add('hide');
            
            setTimeout(() => {
                toast.classList.remove('hide');
            }, 400);
        }

        // función simple para abrir cualquier modal
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        // función simple para cerrar cualquier modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // si hacés click afuera del modal, se cierra automáticamente
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
    </script>
</body>
</html>