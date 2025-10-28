<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - SkillMatch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="conexion" href="../conexion/controllerPublicacion.php">

<?php
require_once '../conexion/controllerUsuario.php';
  $cx=(new ClaseConexion())->getConexion();
        $sql1="SELECT COUNT(*) AS total_usuarios FROM usuario;";
        $st=$cx->prepare($sql1);
        $st->execute(); 
        $res=$st->get_result()->fetch_assoc();
        $numeroUsuarios = $res['total_usuarios'];

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

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .data-table th {
            padding: 1rem;
            text-align: left;
            color: #2c3e50;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            color: #7f8c8d;
        }

        .data-table tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        .data-table tr.selected {
            background: linear-gradient(135deg, #e8f5f1 0%, #d1f0e5 100%);
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

        .badge-available {
            background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
            color: white;
        }

        .badge-expired {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
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

        /* Modal Styles */
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

        /* Delete Confirmation Modal */
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

            .data-table {
                font-size: 0.85rem;
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
        }
    </style>
</head>
<body>
    <header>
        <div class="header-logo">
            <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
            SkillMatch
        </div>
        <div class="header-actions">
            <div class="admin-info">
                <div class="admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="admin-details">
                    <div class="admin-name">Admin Juan</div>
                    <div class="admin-role">Administrador</div>
                </div>
            </div>
            <a href="../index.php" class="logout-btn">
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

        <div class="stats-grid">
            <div class="stat-card active" onclick="showSection('users')">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
               <?php
               echo '<div class="stat-number">' .  $numeroUsuarios ;
               echo '</div>';
               ?>
                <div class="stat-label">Total Usuarios</div>
            </div>

            <div class="stat-card" onclick="showSection('providers')">
                <div class="stat-icon providers">
                    <i class="fas fa-user-tie"></i>
                </div>
                  <?php
               echo '<div class="stat-number">' .  $numeroProveedores ;
               echo '</div>';
               ?>
                <div class="stat-label">Proveedores</div>
            </div>

            <div class="stat-card" onclick="showSection('services')">
                <div class="stat-icon services">
                    <i class="fas fa-briefcase"></i>
                </div>
                    <?php
               echo '<div class="stat-number">' .  $numeroServicios ;
               echo '</div>';
               ?>
                <div class="stat-label">Servicios Activos</div>
            </div>

            <div class="stat-card" onclick="showSection('categories')">
                <div class="stat-icon categories">
                    <i class="fas fa-tags"></i>
                </div>
                 <?php
               echo '<div class="stat-number">' .  $numeroCategorias ;
               echo '</div>';
               ?>
                <div class="stat-label">Categorías</div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title" id="sectionTitle">Gestión de Usuarios</h2>
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

            <div id="tableContainer">
                <!-- La tabla se generará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Modal de Creación/Edición -->
    <div class="modal-overlay" id="formModal">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalTitle">
                    <i class="fas fa-plus-circle"></i>
                    Crear Usuario
                </h3>
                <button class="modal-close" onclick="closeModal('formModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalFormContent">
                <!-- El formulario se generará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeModal('formModal')">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button class="btn btn-save" onclick="saveItem()">
                    <i class="fas fa-check"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
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

    <script>
        let currentSection = 'users';
        let selectedItem = null;
        let isEditMode = false;

        const data = {
            users: [
                { id: 1, name: 'María González', email: 'maria@email.com', type: 'Cliente', status: 'Activo' },
                { id: 2, name: 'Juan Pérez', email: 'juan@email.com', type: 'Proveedor', status: 'Activo' },
                { id: 3, name: 'Ana Rodríguez', email: 'ana@email.com', type: 'Cliente', status: 'Activo' },
                { id: 4, name: 'Carlos López', email: 'carlos@email.com', type: 'Proveedor', status: 'Activo' },
                { id: 5, name: 'Laura Martínez', email: 'laura@email.com', type: 'Cliente', status: 'Activo' }
            ],
            providers: [
                { id: 1, name: 'Juan Pérez', service: 'Desarrollo Web', rating: 4.8, jobs: 45 },
                { id: 2, name: 'Carlos López', service: 'Reparación del Hogar', rating: 4.9, jobs: 67 },
                { id: 3, name: 'Pedro Sánchez', service: 'Diseño Gráfico', rating: 4.7, jobs: 32 },
                { id: 4, name: 'Diego Fernández', service: 'Plomería', rating: 4.6, jobs: 28 }
            ],
            services: [
                { id: 1, title: 'Desarrollo Web Completo', provider: 'Juan Pérez', category: 'Tecnología', availability: 'Disponible' },
                { id: 2, title: 'Reparación de Plomería', provider: 'Carlos López', category: 'Hogar', availability: 'Disponible' },
                { id: 3, title: 'Diseño de Logotipo', provider: 'Pedro Sánchez', category: 'Diseño', availability: 'Vencido' },
                { id: 4, title: 'Instalación Eléctrica', provider: 'Diego Fernández', category: 'Hogar', availability: 'Disponible' }
            ],
            categories: [
                { id: 1, name: 'Tecnología', services: 23, icon: 'fa-laptop-code' },
                { id: 2, name: 'Hogar', services: 34, icon: 'fa-home' },
                { id: 3, name: 'Diseño', services: 18, icon: 'fa-palette' },
                { id: 4, name: 'Educación', services: 14, icon: 'fa-graduation-cap' }
            ]
        };

        function showSection(section) {
            currentSection = section;
            selectedItem = null;
            
            // Update active stat card
            document.querySelectorAll('.stat-card').forEach(card => {
                card.classList.remove('active');
            });
            event.currentTarget.classList.add('active');

            // Update section title
            const titles = {
                users: 'Gestión de Usuarios',
                providers: 'Gestión de Proveedores',
                services: 'Gestión de Servicios',
                categories: 'Gestión de Categorías'
            };
            document.getElementById('sectionTitle').textContent = titles[section];

            // Disable buttons
            document.getElementById('editBtn').disabled = true;
            document.getElementById('deleteBtn').disabled = true;

            // Render table
            renderTable();
        }

        function renderTable() {
            const container = document.getElementById('tableContainer');
            const sectionData = data[currentSection];

            if (!sectionData || sectionData.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>No hay datos disponibles</p>
                    </div>
                `;
                return;
            }

            let tableHTML = '<table class="data-table"><thead><tr>';

            // Generate headers based on section
            if (currentSection === 'users') {
                tableHTML += '<th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th><th>Estado</th>';
            } else if (currentSection === 'providers') {
                tableHTML += '<th>ID</th><th>Nombre</th><th>Servicio</th><th>Calificación</th><th>Trabajos</th>';
            } else if (currentSection === 'services') {
                tableHTML += '<th>ID</th><th>Título</th><th>Proveedor</th><th>Categoría</th><th>Disponibilidad</th>';
            } else if (currentSection === 'categories') {
                tableHTML += '<th>ID</th><th>Nombre</th><th>Servicios</th><th>Ícono</th>';
            }

            tableHTML += '</tr></thead><tbody>';

            // Generate rows
            sectionData.forEach(item => {
                tableHTML += `<tr onclick="selectItem(${item.id})">`;
                
                if (currentSection === 'users') {
                    tableHTML += `
                        <td>${item.id}</td>
                        <td><strong>${item.name}</strong></td>
                        <td>${item.email}</td>
                        <td><span class="badge ${item.type === 'Proveedor' ? 'badge-provider' : 'badge-client'}">${item.type}</span></td>
                        <td><span class="badge badge-active">${item.status}</span></td>
                    `;
                } else if (currentSection === 'providers') {
                    tableHTML += `
                        <td>${item.id}</td>
                        <td><strong>${item.name}</strong></td>
                        <td>${item.service}</td>
                        <td><i class="fas fa-star" style="color: #f39c12;"></i> ${item.rating}</td>
                        <td>${item.jobs} trabajos</td>
                    `;
                } else if (currentSection === 'services') {
                    tableHTML += `
                        <td>${item.id}</td>
                        <td><strong>${item.title}</strong></td>
                        <td>${item.provider}</td>
                        <td>${item.category}</td>
                        <td><span class="badge ${item.availability === 'Disponible' ? 'badge-available' : 'badge-expired'}">${item.availability}</span></td>
                    `;
                } else if (currentSection === 'categories') {
                    tableHTML += `
                        <td>${item.id}</td>
                        <td><strong>${item.name}</strong></td>
                        <td>${item.services} servicios</td>
                        <td><i class="fas ${item.icon}" style="color: #0eb27c; font-size: 1.2rem;"></i></td>
                    `;
                }
                
                tableHTML += '</tr>';
            });

            tableHTML += '</tbody></table>';
            container.innerHTML = tableHTML;
        }

        function selectItem(id) {
            selectedItem = id;
            
            // Remove previous selection
            document.querySelectorAll('.data-table tr').forEach(row => {
                row.classList.remove('selected');
            });
            
            // Add selection to clicked row
            event.currentTarget.classList.add('selected');
            
            // Enable buttons
            document.getElementById('editBtn').disabled = false;
            document.getElementById('deleteBtn').disabled = false;
        }

        function createItem() {
            isEditMode = false;
            const modalTitle = document.getElementById('modalTitle');
            const formContent = document.getElementById('modalFormContent');
            
            // Update modal title
            const titles = {
                users: 'Crear Usuario',
                providers: 'Crear Proveedor',
                services: 'Crear Servicio',
                categories: 'Crear Categoría'
            };
            modalTitle.innerHTML = `<i class="fas fa-plus-circle"></i> ${titles[currentSection]}`;
            
            // Generate form based on section
            formContent.innerHTML = generateForm();
            
            // Show modal
            document.getElementById('formModal').classList.add('active');
        }

        function editItem() {
            if (!selectedItem) return;
            
            isEditMode = true;
            const modalTitle = document.getElementById('modalTitle');
            const formContent = document.getElementById('modalFormContent');
            
            // Update modal title
            const titles = {
                users: 'Editar Usuario',
                providers: 'Editar Proveedor',
                services: 'Editar Servicio',
                categories: 'Editar Categoría'
            };
            modalTitle.innerHTML = `<i class="fas fa-edit"></i> ${titles[currentSection]}`;
            
            // Generate form with existing data
            formContent.innerHTML = generateForm(true);
            
            // Fill form with selected item data
            fillFormData();
            
            // Show modal
            document.getElementById('formModal').classList.add('active');
        }

        function generateForm(isEdit = false) {
            let formHTML = '';
            
            if (currentSection === 'users') {
                formHTML = `
                    <div class="form-group">
                        <label class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-input" id="userName" placeholder="Ej: María González" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-input" id="userEmail" placeholder="usuario@email.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipo de Usuario *</label>
                        <select class="form-select" id="userType" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="Cliente">Cliente</option>
                            <option value="Proveedor">Proveedor</option>
                        </select>
                    </div>
                    ${!isEdit ? `
                    <div class="form-group">
                        <label class="form-label">Contraseña *</label>
                        <input type="password" class="form-input" id="userPassword" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    ` : ''}
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="userStatus">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                `;
            } else if (currentSection === 'providers') {
                formHTML = `
                    <div class="form-group">
                        <label class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-input" id="providerName" placeholder="Ej: Juan Pérez" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Servicio Principal *</label>
                        <input type="text" class="form-input" id="providerService" placeholder="Ej: Desarrollo Web" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Calificación</label>
                        <input type="number" class="form-input" id="providerRating" min="0" max="5" step="0.1" placeholder="0.0" value="5.0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Trabajos Completados</label>
                        <input type="number" class="form-input" id="providerJobs" min="0" placeholder="0" value="0">
                    </div>
                `;
            } else if (currentSection === 'services') {
                formHTML = `
                    <div class="form-group">
                        <label class="form-label">Título del Servicio *</label>
                        <input type="text" class="form-input" id="serviceTitle" placeholder="Ej: Desarrollo Web Completo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Proveedor *</label>
                        <input type="text" class="form-input" id="serviceProvider" placeholder="Nombre del proveedor" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoría *</label>
                        <select class="form-select" id="serviceCategory" required>
                            <option value="">Seleccionar categoría</option>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Hogar">Hogar</option>
                            <option value="Diseño">Diseño</option>
                            <option value="Educación">Educación</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Disponibilidad *</label>
                        <select class="form-select" id="serviceAvailability" required>
                            <option value="Disponible">Disponible</option>
                            <option value="Vencido">Vencido</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" id="serviceDescription" placeholder="Describe el servicio en detalle..."></textarea>
                    </div>
                `;
            } else if (currentSection === 'categories') {
                formHTML = `
                    <div class="form-group">
                        <label class="form-label">Nombre de la Categoría *</label>
                        <input type="text" class="form-input" id="categoryName" placeholder="Ej: Tecnología" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ícono (Font Awesome) *</label>
                        <input type="text" class="form-input" id="categoryIcon" placeholder="fa-laptop-code" required>
                        <small style="color: #7f8c8d; font-size: 0.8rem;">Visita fontawesome.com para ver íconos disponibles</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número de Servicios</label>
                        <input type="number" class="form-input" id="categoryServices" min="0" placeholder="0" value="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" id="categoryDescription" placeholder="Describe la categoría..."></textarea>
                    </div>
                `;
            }
            
            return formHTML;
        }

        function fillFormData() {
            const item = data[currentSection].find(i => i.id === selectedItem);
            if (!item) return;
            
            if (currentSection === 'users') {
                document.getElementById('userName').value = item.name;
                document.getElementById('userEmail').value = item.email;
                document.getElementById('userType').value = item.type;
                document.getElementById('userStatus').value = item.status;
            } else if (currentSection === 'providers') {
                document.getElementById('providerName').value = item.name;
                document.getElementById('providerService').value = item.service;
                document.getElementById('providerRating').value = item.rating;
                document.getElementById('providerJobs').value = item.jobs;
            } else if (currentSection === 'services') {
                document.getElementById('serviceTitle').value = item.title;
                document.getElementById('serviceProvider').value = item.provider;
                document.getElementById('serviceCategory').value = item.category;
                document.getElementById('serviceAvailability').value = item.availability;
            } else if (currentSection === 'categories') {
                document.getElementById('categoryName').value = item.name;
                document.getElementById('categoryIcon').value = item.icon;
                document.getElementById('categoryServices').value = item.services;
            }
        }

        function saveItem() {
            // Aquí iría la lógica para guardar en el backend
            if (isEditMode) {
                alert(`${currentSection.slice(0, -1)} actualizado correctamente`);
            } else {
                alert(`Nuevo ${currentSection.slice(0, -1)} creado correctamente`);
            }
            closeModal('formModal');
            renderTable();
        }

        function deleteItem() {
            if (!selectedItem) return;
            
            const item = data[currentSection].find(i => i.id === selectedItem);
            const deleteMsg = document.getElementById('deleteMessage');
            
            // Customize delete message based on section
            if (currentSection === 'users') {
                deleteMsg.textContent = `¿Estás seguro de eliminar al usuario "${item.name}"? Esta acción no se puede deshacer.`;
            } else if (currentSection === 'providers') {
                deleteMsg.textContent = `¿Estás seguro de eliminar al proveedor "${item.name}"? Se eliminarán también todos sus servicios asociados.`;
            } else if (currentSection === 'services') {
                deleteMsg.textContent = `¿Estás seguro de eliminar el servicio "${item.title}"? Esta acción no se puede deshacer.`;
            } else if (currentSection === 'categories') {
                deleteMsg.textContent = `¿Estás seguro de eliminar la categoría "${item.name}"? Esto afectará a ${item.services} servicios.`;
            }
            
            document.getElementById('deleteModal').classList.add('active');
        }

        function confirmDelete() {
            // Aquí iría la lógica para eliminar en el backend
            const item = data[currentSection].find(i => i.id === selectedItem);
            
            // Remove from data array
            const index = data[currentSection].findIndex(i => i.id === selectedItem);
            if (index > -1) {
                data[currentSection].splice(index, 1);
            }
            
            alert(`${currentSection.slice(0, -1)} eliminado correctamente`);
            closeModal('deleteModal');
            
            // Reset selection
            selectedItem = null;
            document.getElementById('editBtn').disabled = true;
            document.getElementById('deleteBtn').disabled = true;
            
            renderTable();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Initialize
        renderTable();
    </script>
</body>
</html>