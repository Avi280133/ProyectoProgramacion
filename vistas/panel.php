<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Panel de Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Abel", sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .admin-header {
            background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
        }

        .admin-user i {
            font-size: 1.5rem;
        }

        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 2rem 0;
        }

        .sidebar-item {
            padding: 1rem 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #333;
            border-left: 4px solid transparent;
        }

        .sidebar-item:hover {
            background: #f0fdf4;
            border-left-color: #0eb27c;
        }

        .sidebar-item.active {
            background: linear-gradient(90deg, #ecfdf5 0%, #d1fae5 100%);
            border-left-color: #0eb27c;
            font-weight: 600;
        }

        .sidebar-item i {
            font-size: 1.2rem;
            color: #0eb27c;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #2563eb;
        }

        .stat-icon.services {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
        }

        .stat-icon.categories {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #d97706;
        }

        .stat-icon.active {
            background: linear-gradient(135deg, #fae8ff 0%, #f3e8ff 100%);
            color: #9333ea;
        }

        .stat-info h3 {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
        }

        .stat-info p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.8rem;
            color: #025939;
            font-weight: 700;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 178, 124, 0.4);
        }

        .data-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
            color: white;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #025939;
            font-weight: 700;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #334155;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0eb27c;
            box-shadow: 0 0 0 3px rgba(14, 178, 124, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-active {
            background: #d1fae5;
            color: #059669;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                height: 100%;
                z-index: 100;
                transition: left 0.3s ease;
            }

            .sidebar.open {
                left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .data-table {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1><i class="fas fa-shield-alt"></i> Panel de Administrador - SkillMatch</h1>
        <div class="admin-user">
            <span>Admin</span>
            <i class="fas fa-user-circle"></i>
        </div>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-item active" onclick="showSection('dashboard')">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </div>
            <div class="sidebar-item" onclick="showSection('users')">
                <i class="fas fa-users"></i>
                <span>Usuarios</span>
            </div>
            <div class="sidebar-item" onclick="showSection('services')">
                <i class="fas fa-briefcase"></i>
                <span>Servicios</span>
            </div>
            <div class="sidebar-item" onclick="showSection('categories')">
                <i class="fas fa-tags"></i>
                <span>Categorías</span>
            </div>
        </aside>

        <main class="main-content">
            <!-- Dashboard Section -->
            <div id="dashboard" class="section active">
                <h2 class="section-title">Resumen General</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>1,234</h3>
                            <p>Usuarios Totales</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon services">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-info">
                            <h3>567</h3>
                            <p>Servicios Publicados</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon categories">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Categorías</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>892</h3>
                            <p>Usuarios Activos</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            <div id="users" class="section">
                <div class="section-header">
                    <h2 class="section-title">Gestión de Usuarios</h2>
                    <button class="btn-primary" onclick="openModal('userModal')">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan@example.com</td>
                                <td>Usuario</td>
                                <td><span class="badge badge-active">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editUser(1)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteUser(1)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>María García</td>
                                <td>maria@example.com</td>
                                <td>Proveedor</td>
                                <td><span class="badge badge-active">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editUser(2)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteUser(2)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Services Section -->
            <div id="services" class="section">
                <div class="section-header">
                    <h2 class="section-title">Gestión de Servicios</h2>
                    <button class="btn-primary" onclick="openModal('serviceModal')">
                        <i class="fas fa-plus"></i> Nuevo Servicio
                    </button>
                </div>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Proveedor</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="servicesTableBody">
                            <tr>
                                <td>1</td>
                                <td>Albañilería Profesional</td>
                                <td>Construcción</td>
                                <td>Juan Pérez</td>
                                <td><span class="badge badge-active">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editService(1)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteService(1)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Costura y Arreglos</td>
                                <td>Textil</td>
                                <td>María García</td>
                                <td><span class="badge badge-active">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editService(2)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteService(2)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Categories Section -->
            <div id="categories" class="section">
                <div class="section-header">
                    <h2 class="section-title">Gestión de Categorías</h2>
                    <button class="btn-primary" onclick="openModal('categoryModal')">
                        <i class="fas fa-plus"></i> Nueva Categoría
                    </button>
                </div>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Servicios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                            <tr>
                                <td>1</td>
                                <td>Construcción</td>
                                <td>Servicios relacionados con construcción y albañilería</td>
                                <td>45</td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editCategory(1)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteCategory(1)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Textil</td>
                                <td>Costura, arreglos y confección</td>
                                <td>32</td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editCategory(2)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteCategory(2)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- User Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nuevo Usuario</h3>
                <button class="close-modal" onclick="closeModal('userModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form>
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" placeholder="Ingrese el nombre completo">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="usuario@ejemplo.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select>
                        <option>Usuario</option>
                        <option>Proveedor</option>
                        <option>Administrador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('userModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Service Modal -->
    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nuevo Servicio</h3>
                <button class="close-modal" onclick="closeModal('serviceModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form>
                <div class="form-group">
                    <label>Título del Servicio</label>
                    <input type="text" placeholder="Ingrese el título">
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea placeholder="Describa el servicio..."></textarea>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <select>
                        <option>Construcción</option>
                        <option>Textil</option>
                        <option>Mecánica</option>
                        <option>Programación</option>
                        <option>Limpieza</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Proveedor</label>
                    <select>
                        <option>Juan Pérez</option>
                        <option>María García</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('serviceModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        Guardar Servicio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nueva Categoría</h3>
                <button class="close-modal" onclick="closeModal('categoryModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form>
                <div class="form-group">
                    <label>Nombre de la Categoría</label>
                    <input type="text" placeholder="Ingrese el nombre">
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea placeholder="Describa la categoría..."></textarea>
                </div>
                <div class="form-group">
                    <label>Icono (clase Font Awesome)</label>
                    <input type="text" placeholder="fa-hammer">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('categoryModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            
            sections.forEach(section => section.classList.remove('active'));
            sidebarItems.forEach(item => item.classList.remove('active'));
            
            document.getElementById(sectionId).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function editUser(id) {
            openModal('userModal');
            console.log('Editando usuario:', id);
        }

        function deleteUser(id) {
            if (confirm('¿Está seguro de eliminar este usuario?')) {
                console.log('Eliminando usuario:', id);
            }
        }

        function editService(id) {
            openModal('serviceModal');
            console.log('Editando servicio:', id);
        }

        function deleteService(id) {
            if (confirm('¿Está seguro de eliminar este servicio?')) {
                console.log('Eliminando servicio:', id);
            }
        }

        function editCategory(id) {
            openModal('categoryModal');
            console.log('Editando categoría:', id);
        }

        function deleteCategory(id) {
            if (confirm('¿Está seguro de eliminar esta categoría?')) {
                console.log('Eliminando categoría:', id);
            }
        }

        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>