<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['cedula'])) {
  header('Location: ../index.html');
  exit;
}

require_once('../conexion/modelPublicacion.php');
$idProveedor = $_SESSION['cedula'];

// Métricas
$stats = Servicio::statsProveedor($idProveedor);
// Lista de servicios del proveedor
$misServicios = Servicio::serviciosDeProveedor($idProveedor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkillMatch - Proveedores</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/vistas-prov.css">
  <style>
    /* ===== MENÚ DE PERFIL ===== */
    .profile-menu {
      position: absolute;
      top: 45px;
      right: 0;
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      display: none;
      flex-direction: column;
      min-width: 160px;
      overflow: hidden;
      z-index: 10000;
    }
    .profile-menu.active { display: flex; animation: fadeIn .2s ease; }
    .profile-menu a { padding: 10px 16px; text-decoration: none; color: #374151; transition: background .2s, color .2s; }
    .profile-menu a:hover { background: #f3f4f6; color: #10b981; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px);} to { opacity: 1; transform: translateY(0);} }

    /* Enlace para “Mensajes Nuevos” */
    .stat-link { text-decoration: none; color: inherit; }
    .stat-item.clickable { cursor: pointer; }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="header-logo">
      <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
      SkillMatch
    </div>

    <div class="header-actions">
      <!-- Notificaciones -->
      <div style="position: relative;">
        <div class="header-icon" id="notificationBell">
          <i class="fas fa-bell"></i>
          <span style="position: absolute; top: -5px; right: -8px; width: 20px; height: 20px; background: #ff6b6b; color: white; border-radius: 50%; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">3</span>
        </div>
        <div class="notification-modal" id="notificationModal">
          <div class="notification-header">
            <h3>Notificaciones</h3>
            <i class="fas fa-times" style="cursor: pointer; color: #7f8c8d;" id="closeNotifications"></i>
          </div>
          <div class="notification-list"></div>
        </div>
      </div>

      <!-- Ícono de Usuario + Menú -->
      <div class="header-icon" id="userMenuWrapper" style="position: relative;">
        <i class="fas fa-user" id="userIcon"></i>
        <div class="profile-menu" id="profileMenu">
          <a href="perfil.php"><i class="fa-solid fa-user"></i> Ver perfil</a>
          <a href="editar-perfil.php"><i class="fa-solid fa-pen"></i> Editar perfil</a>
          <a href="../conexion/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Quick Stats -->
  <section class="stats-bar">
    <div class="stats-container">
      <div class="stat-item">
        <div class="stat-icon"><i class="fa-solid fa-briefcase"></i></div>
        <div class="stat-number"><?php echo (int)$stats['activos']; ?></div>
        <div class="stat-label">Servicios Activos</div>
      </div>
      <div class="stat-item">
        <div class="stat-icon"><i class="fa-solid fa-eye"></i></div>
        <div class="stat-number"><?php echo number_format((int)$stats['vistas']); ?></div>
        <div class="stat-label">Visualizaciones</div>
      </div>
      <div class="stat-item">
        <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
        <div class="stat-number"><?php echo number_format((float)$stats['calificacion'], 1); ?></div>
        <div class="stat-label">Calificación</div>
      </div>

      <!-- MENSAJES NUEVOS -> chat.php -->
      <a class="stat-link" href="chat.php" title="Ir a Mensajes">
        <div class="stat-item clickable">
          <div class="stat-icon"><i class="fa-solid fa-comments"></i></div>
          <div class="stat-number"><?php echo (int)$stats['mensajes']; ?></div>
          <div class="stat-label">Mensajes Nuevos</div>
        </div>
      </a>
    </div>
  </section>

  <!-- Dashboard Actions -->
  <section class="dashboard-section">
    <h2 class="section-title">Panel de Control</h2>
    <p class="section-subtitle">Gestiona tus servicios y explora nuevas oportunidades</p>

    <div class="dashboard-grid">
      <div class="action-card" onclick="location.href='../vistas/publicar.php'">
        <div class="action-icon"><i class="fa-solid fa-plus-circle"></i></div>
        <h3 class="action-title">Publicar Servicio</h3>
        <p class="action-description">Crea una nueva publicación y llegá a miles de clientes potenciales.</p>
        <button class="action-btn"><i class="fa-solid fa-arrow-right"></i><span>Comenzar</span></button>
      </div>

      <div class="action-card" onclick="document.getElementById('mis-servicios').scrollIntoView({behavior:'smooth'})">
        <div class="action-icon"><i class="fa-solid fa-list-check"></i></div>
        <h3 class="action-title">Mis Servicios</h3>
        <p class="action-description">Administra, editá y monitoreá el rendimiento de tus publicaciones.</p>
        <button class="action-btn"><i class="fa-solid fa-arrow-right"></i><span>Ver Todos</span></button>
      </div>
    </div>
  </section>

  <!-- Mis Servicios -->
  <section class="my-services-section" id="mis-servicios">
    <h2 class="section-title">Mis Servicios Publicados</h2>
    <p class="section-subtitle">Gestioná y monitoreá tus publicaciones activas</p>

    <div class="services-grid">
      <?php if (empty($misServicios)): ?>
        <p style="padding:1rem 0; color:#555;">Todavía no publicaste servicios. ¡Empezá con “Publicar Servicio”! 🚀</p>
      <?php else: ?>
        <?php foreach ($misServicios as $svc): ?>
          <div class="service-card service-open"
               data-id="<?php echo (int)$svc['idservicio']; ?>"
               data-titulo="<?php echo htmlspecialchars($svc['titulo']); ?>"
               data-ubicacion="<?php echo htmlspecialchars($svc['ubicacion']); ?>"
               data-precio="<?php echo number_format((float)$svc['precio'], 2, '.', ''); ?>"
               data-descripcion="<?php echo htmlspecialchars($svc['descripcion']); ?>"
               data-imagen="<?php echo htmlspecialchars($svc['imagen_url'] ?? ''); ?>">
            <div class="service-header">
              <span class="service-status status-active">Activo</span>
            </div>
            <h3 class="service-title"><?php echo htmlspecialchars($svc['titulo']); ?></h3>
            <div class="service-stats">
              <span><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($svc['ubicacion']); ?></span>
              <span><i class="fa-solid fa-dollar-sign"></i> <?php echo number_format((float)$svc['precio'], 2); ?></span>
            </div>
            <p style="color:#6b7280; margin:8px 0 16px;">
              <?php echo nl2br(htmlspecialchars(mb_strimwidth($svc['descripcion'], 0, 180, '…'))); ?>
            </p>

            <div class="service-actions" style="display:flex; gap:8px; align-items:center;">
              <button type="button" class="btn-stats open-modal" style="background:#ecfdf5;color:#065f46;border:none;padding:.5rem .75rem;border-radius:10px;cursor:pointer">
                <i class="fa-solid fa-eye"></i> Ver detalle
              </button>

              <form action="../conexion/controllerPublicacion.php" method="POST" onsubmit="return confirm('¿Eliminar este servicio?');" style="margin:0">
                <input type="hidden" name="action" value="eliminar">
                <input type="hidden" name="id" value="<?php echo (int)$svc['idservicio']; ?>">
                <button type="submit" class="btn-delete" title="Eliminar">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>



  

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>SkillMatch</h3>
        <p style="color: rgba(255, 255, 255, 0.8); line-height: 1.6;">
          La plataforma que conecta profesionales con clientes.
        </p>
      </div>
      <div class="footer-section">
        <h3>Para Proveedores</h3>
        <a href="publicar.php">Publicar Servicio</a>
        <a href="#mis-servicios">Mis Servicios</a>
      </div>
      <div class="footer-section">
        <h3>Soporte</h3>
        <a href="html/ayuda.php">Centro de Ayuda</a>
      </div>
    </div>
    <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); color: rgba(255, 255, 255, 0.7);">
      <p>&copy; 2025 SkillMatch. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- JS -->
<script>
  // Menú perfil (permite pasar del ícono al menú sin que se cierre)
  const profileMenu = document.getElementById('profileMenu');
  const wrapper     = document.getElementById('userMenuWrapper');

  const showMenu = () => profileMenu.classList.add('active');
  const hideMenuIfOutside = () => {
    // pequeña espera para permitir el tránsito entre elementos
    setTimeout(() => {
      const overWrapper = wrapper.matches(':hover');
      const overMenu    = profileMenu.matches(':hover');
      if (!overWrapper && !overMenu) profileMenu.classList.remove('active');
    }, 80);
  };

  // Mostrar si el mouse entra al icono o al menú
  wrapper.addEventListener('mouseenter', showMenu);
  profileMenu.addEventListener('mouseenter', showMenu);

  // Ocultar solo cuando el mouse ya no está ni en el icono ni en el menú
  wrapper.addEventListener('mouseleave', hideMenuIfOutside);
  profileMenu.addEventListener('mouseleave', hideMenuIfOutside);

  // Cerrar al hacer click fuera
  document.addEventListener('click', (e) => {
    if (!wrapper.contains(e.target)) profileMenu.classList.remove('active');
  });

  // Notificaciones (mock)
  const bell = document.getElementById('notificationBell');
  const modalNotif = document.getElementById('notificationModal');
  const closeBtnNotif = document.getElementById('closeNotifications');
  bell?.addEventListener('click',()=> modalNotif.classList.toggle('active'));
  closeBtnNotif?.addEventListener('click',()=> modalNotif.classList.remove('active'));
  document.addEventListener('click', (e) => {
    if (!bell.contains(e.target) && !modalNotif.contains(e.target)) modalNotif.classList.remove('active');
  });
</script>

</body>
</html>
