<?php
require_once('../conexion/guards/auth_guard.php');
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

    /* Enlace para "Mensajes Nuevos" */
    .stat-link { text-decoration: none; color: inherit; }
    .stat-item.clickable { cursor: pointer; }

    /* Calendario: estilos autocontenidos para evitar conflictos */
    #calendario-section .calendar-wrap {
      max-width: 960px;
      margin: 0 auto;
      background:#fff;
      border-radius:16px;
      box-shadow:0 8px 30px rgba(2,6,23,0.08);
      display:grid;
      grid-template-columns: 340px 1fr;
      overflow:hidden;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    #calendario-section .left {
      background: linear-gradient(135deg,#10b981 0%,#059669 100%);
      color:#fff;
      padding:24px;
      display:flex;
      flex-direction:column;
      gap:18px;
      align-items:flex-start;
    }
    #calendario-section .left h3 { margin:0; font-size:1.15rem; }
    #calendario-section .calendar-container {
      background: rgba(255,255,255,0.12);
      border-radius:12px;
      padding:12px;
      width:100%;
    }
    #calendario-section .calendar-header {
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:8px;
    }
    #calendario-section .calendar-nav button {
      background: rgba(255,255,255,0.18);
      border: none;
      color: #fff;
      width:36px;
      height:36px;
      border-radius:8px;
      cursor:pointer;
    }
    #calendario-section .calendar-weekdays,
    #calendario-section .calendar-days {
      display:grid;
      grid-template-columns: repeat(7,1fr);
      gap:6px;
    }
    #calendario-section .weekday {
      text-align:center;
      font-size:0.75rem;
      opacity:0.9;
      font-weight:700;
    }
    #calendario-section .day {
      aspect-ratio:1;
      display:flex;
      align-items:center;
      justify-content:center;
      border-radius:8px;
      background: rgba(255,255,255,0.06);
      color:#fff;
      cursor:pointer;
      font-weight:600;
    }
    #calendario-section .day.other-month { opacity:0.35; }
    #calendario-section .day.disabled { opacity:0.25; cursor:not-allowed; }
    #calendario-section .day.selected {
      background:#fff;
      color:#059669;
      transform:translateY(-4px);
      box-shadow:0 8px 20px rgba(5,150,105,0.12);
    }

    /* Día especial: 3 de diciembre */
    #calendario-section .day.highlight-red {
      background: #ef4444 !important;
      color: #fff !important;
      box-shadow: 0 8px 20px rgba(239, 68, 68, 0.25);
      transform: translateY(-2px);
    }

    /* Si el usuario lo selecciona, mantené el rojo (un poco más oscuro) */
    #calendario-section .day.highlight-red.selected {
      background: #b91c1c !important;
      color: #fff !important;
    }

    /* Right panel */
    #calendario-section .right {
      padding:20px;
    }
    #calendario-section .selected-info {
      display:flex;
      gap:12px;
      align-items:center;
      margin-bottom:12px;
    }
    #calendario-section .selected-info .dot {
      width:46px;
      height:46px;
      border-radius:10px;
      background:linear-gradient(135deg,#0eb27c,#047857);
      display:flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-size:1.1rem;
    }
    #calendario-section .selected-text { font-weight:700; color:#0f172a; }
    @media (max-width:900px){
      #calendario-section .calendar-wrap { grid-template-columns: 1fr; }
    }

    /* Estilos para estado "Buzón vacío" en notificaciones */
    .notification-empty {
      padding: 18px;
      text-align: center;
      color: #6b7280;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
    .notification-empty .icon {
      width: 56px;
      height: 56px;
      border-radius: 12px;
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      color: #64748b;
      box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    }
    .notification-empty .title {
      font-weight: 700;
      color: #374151;
    }
    .notification-empty .desc {
      font-size: 0.92rem;
      max-width: 260px;
      line-height: 1.3;
      color: #6b7280;
    }
    .notification-empty .btn-refresh {
      background: linear-gradient(135deg,#10b981,#059669);
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
    }

    .notification-modal{
      position: absolute;
      right: 0;
      top: 40px;
      width: 360px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      box-shadow: 0 12px 30px rgba(0,0,0,.12);
      display: none;         /* oculto por defecto */
      z-index: 10000;
    }
    .notification-modal.active{
      display: block;        /* se muestra al activar */
    }
    .notification-list{ max-height: 420px; overflow: auto; }
    .notification-item.unread{ background: #f9fafb; }
    .notification-icon{
      width: 40px; height: 40px; border-radius: 10px; display:flex;align-items:center;justify-content:center; color:#fff;
    }

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
        <div class="header-icon" id="notificationBell" style="position:relative; cursor:pointer;">
          <i class="fas fa-bell"></i>
          <span id="notifBadge" style="position: absolute; top: -6px; right: -10px; min-width: 20px; height: 20px; background: #ff6b6b; color: white; border-radius: 50%; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold; padding:0 6px;"></span>
        </div>

        <div class="notification-modal" id="notificationModal">
          <div class="notification-header">
            <h3>Notificaciones</h3>
            <i class="fas fa-times" id="closeNotifications" style="cursor:pointer;color:#7f8c8d;"></i>
          </div>
          <div class="notification-list"></div>
        </div>
      </div>

      <!-- Ícono de Usuario + Menú -->
      <div class="header-icon" id="userMenuWrapper" style="position: relative;">
        <a href="../vistas/perfil.php" style="color: inherit; text-decoration: none;">
          <i class="fas fa-user" id="userIcon"></i>
        </a>
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
        <p style="padding:1rem 0; color:#555;">Todavía no publicaste servicios. ¡Empezá con "Publicar Servicio"! 🚀</p>
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

  <section id="calendario-section" style="padding: 4rem 2rem; background: #f8f9fa;">
  <div style="max-width: 1000px; margin: 0 auto; display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
    
    <!-- Calendario -->
    <div id="calendar" style="flex: 1; min-width: 300px; background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <button id="prevMonth" class="btn btn-cancel"><i class="fas fa-chevron-left"></i></button>
        <h3 id="monthYear" style="color: #2c3e50; text-align: center; flex: 1;">Mes Año</h3>
        <button id="nextMonth" class="btn btn-cancel"><i class="fas fa-chevron-right"></i></button>
      </div>
      <div id="calendarDays" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: .5rem; margin-top: 1rem; text-align: center;"></div>
    </div>

    <!-- Panel de reservas -->
    <div id="reservasInfo" style="flex: 1; min-width: 300px; background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
      <h3 style="color:#0eb27c;">Reservas del día</h3>
      <div id="listaReservas" style="margin-top: 1rem; color: #2c3e50;">
        <p>Seleccioná una fecha en el calendario para ver las reservas.</p>
      </div>
    </div>
  </div>
</section>

<script>
let currentDate = new Date();
const allowedHours = ["10:00:00", "12:00:00", "15:00:00", "18:00:00"];
let reservasGlobal = [];

document.addEventListener("DOMContentLoaded", () => {
  loadReservas();
  renderCalendar();
  document.getElementById("prevMonth").onclick = () => changeMonth(-1);
  document.getElementById("nextMonth").onclick = () => changeMonth(1);
});

function changeMonth(delta) {
  currentDate.setMonth(currentDate.getMonth() + delta);
  renderCalendar();
}

function loadReservas() {
  const idProveedor = "<?php echo $idProveedor; ?>";
  
  fetch("../conexion/controllerReserva.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "action=obtener_reservas_proveedor&idproveedor=" + encodeURIComponent(idProveedor)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      reservasGlobal = data.reservas;
      renderCalendar();
    } else {
      console.error("Error al obtener reservas", data);
    }
  })
  .catch(err => console.error("Error de conexión:", err));
}

function renderCalendar() {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const daysContainer = document.getElementById("calendarDays");
  const monthYear = document.getElementById("monthYear");

  monthYear.textContent = `${firstDay.toLocaleString("es-ES", {month:"long"})} ${year}`;
  daysContainer.innerHTML = "";

  const start = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
  for (let i = 0; i < start; i++) {
    const empty = document.createElement("div");
    daysContainer.appendChild(empty);
  }

  function mostrarReservas(fecha) {
    const reservasDia = reservasGlobal.filter(r => r.fecha === fecha);
    const contenedor = document.getElementById("listaReservas");
    // Ajuste manual de zona horaria (corrige el -1 día)
    const fechaLocal = new Date(fecha + "T00:00:00");
    fechaLocal.setMinutes(fechaLocal.getMinutes() + fechaLocal.getTimezoneOffset());
    contenedor.innerHTML = `<h4>${fechaLocal.toLocaleDateString("es-ES")}</h4>`;


    if (reservasDia.length === 0) {
      contenedor.innerHTML += `<p>No hay reservas para este día.</p>`;
    } else {
      reservasDia.forEach(r => {
        contenedor.innerHTML += `
          <div style="border:1px solid #ddd; padding:10px; border-radius:10px; margin-bottom:10px;">
            <strong>${r.titulo || "Servicio #" + r.idservicio}</strong><br>
            <span>${r.hora.slice(0,5)} hs — ${r.estado}</span>
          </div>
        `;
      });
    }
  }

  for (let d = 1; d <= lastDay.getDate(); d++) {
    const date = new Date(year, month, d);
    const isoDate = date.toLocaleDateString("en-CA");  // ✅ fecha local sin desfase
    const reservasDia = reservasGlobal.filter(r => r.fecha === isoDate);
    const hasReserva = reservasDia.length > 0;

    const div = document.createElement("div");
    div.textContent = d;
    div.style.padding = "10px";
    div.style.borderRadius = "10px";
    div.style.cursor = "pointer";
    div.style.transition = "0.2s";
    div.style.background = hasReserva ? "#ef4444" : "#e0e0e0";
    div.style.color = hasReserva ? "white" : "#2c3e50";
    div.onclick = () => mostrarReservas(isoDate);
    daysContainer.appendChild(div);
  }
}


</script>

  
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
  // --- Reemplazar el manejador del menú de perfil por este más robusto ---
  (function(){
    const profileMenu = document.getElementById('profileMenu');
    const wrapper     = document.getElementById('userMenuWrapper');

    if (!wrapper || !profileMenu) return;

    wrapper.addEventListener('click', function (e) {
      e.stopPropagation();
      profileMenu.classList.toggle('active');
    });

    profileMenu.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    document.addEventListener('click', function () {
      profileMenu.classList.remove('active');
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') profileMenu.classList.remove('active');
    });
  })();

  // notis
  (function(){
    const bell  = document.getElementById('notificationBell');
    const modal = document.getElementById('notificationModal');
    const closeBtn = document.getElementById('closeNotifications');
    const listEl = modal ? modal.querySelector('.notification-list') : null;
    const badge  = document.getElementById('notifBadge');

    function escapeHtml(s){ return String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

    // Ícono + color por tipo
    function iconFor(type){
      if (type === 'reporte')      return { icon: 'fa-flag',            grad: '#ef4444, #b91c1c' };
      if (type === 'solicitud')    return { icon: 'fa-file-signature',  grad: '#0ea5e9, #0369a1' };
      if (type === 'calificacion') return { icon: 'fa-star',            grad: '#f59e0b, #b45309' };
      return { icon: 'fa-bell', grad: '#10b981, #059669' };
    }

    function emptyState(title, desc){
      desc = desc || 'No hay notificaciones por ahora.';
      return `
        <div class="notification-empty">
          <div class="icon"><i class="fas fa-inbox"></i></div>
          <div class="title">${escapeHtml(title)}</div>
          <div class="desc">${escapeHtml(desc)}</div>
          <button class="btn-refresh" id="notifRefresh">Actualizar</button>
        </div>
      `;
    }

    async function loadNotifications() {
      if (!listEl) return;
      try {
        const res = await fetch('../conexion/getNotifications.php?action=list', { credentials: 'same-origin' });
        const json = await res.json();

        if (!json.success) {
          listEl.innerHTML = emptyState('Error al cargar', 'Reintentá en unos segundos.');
          const btn = document.getElementById('notifRefresh');
          if (btn) btn.addEventListener('click', loadNotifications);
          return;
        }

        const list   = json.notifications || [];
        const unread = json.unread || 0;
        badge.textContent = unread > 0 ? unread : '';

        if (list.length === 0) {
          listEl.innerHTML = emptyState('Buzón vacío', 'No hay notificaciones nuevas.');
          const btn = document.getElementById('notifRefresh');
          if (btn) btn.addEventListener('click', loadNotifications);
          return;
        }

        listEl.innerHTML = '';
        list.forEach(n => {
          // Tipos visibles
          if (!['reporte','solicitud','calificacion'].includes(n.tipo)) return;

          const {icon, grad} = iconFor(n.tipo);
          const item = document.createElement('div');
          item.className = 'notification-item' + (Number(n.leida) === 0 ? ' unread' : '');
          item.style.display = 'flex';
          item.style.padding = '10px';
          item.style.borderBottom = '1px solid #eef2f7';
          item.style.gap = '10px';

          item.innerHTML = `
            <div class="notification-icon" style="background: linear-gradient(135deg, ${grad});">
              <i class="fas ${icon}"></i>
            </div>
            <div class="notification-content" style="flex:1;">
              <div class="notification-title" style="font-weight:600">${escapeHtml(n.mensaje)}</div>
              <div class="notification-time" style="font-size:12px;color:#6b7280">${new Date(n.fecha).toLocaleString()}</div>
            </div>
          `;

          // Click: solo marcar como leída (sin navegar)
          item.addEventListener('click', async () => {
            if (item.classList.contains('unread')) {
              const ok = await markAsRead(n.idnotificacion);
              if (ok) item.classList.remove('unread');
            }
          });

          listEl.appendChild(item);
        });
      } catch (err) {
        console.error('loadNotifications', err);
        listEl.innerHTML = emptyState('Error al cargar', 'No se pudieron cargar las notificaciones.');
        const btn = document.getElementById('notifRefresh');
        if (btn) btn.addEventListener('click', loadNotifications);
      }
    }

    async function markAsRead(id) {
      try {
        const res = await fetch('../conexion/getNotifications.php?action=mark', {
          method: 'POST',
          credentials: 'same-origin',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        });
        const j = await res.json();
        if (j.success) {
          // refrescar badge
          const resList = await fetch('../conexion/getNotifications.php?action=list', { credentials: 'same-origin' });
          const json = await resList.json();
          if (json.success) {
            const unread = json.unread || 0;
            badge.textContent = unread > 0 ? unread : '';
          }
        }
        return j.success;
      } catch (e) {
        console.error('markAsRead', e);
        return false;
      }
    }

    // Toggle modal y carga
    if (bell && modal) {
      bell.addEventListener('click', async () => {
        modal.classList.toggle('active');
        if (modal.classList.contains('active')) await loadNotifications();
      });
    }
    if (closeBtn && modal) closeBtn.addEventListener('click', () => modal.classList.remove('active'));

    // Cerrar al hacer click fuera
    document.addEventListener('click', (e) => {
      if (!modal || !bell) return;
      if (!bell.contains(e.target) && !modal.contains(e.target)) modal.classList.remove('active');
    });

    // Carga inicial y polling
    loadNotifications();
    setInterval(loadNotifications, 45000);
  })();
</script>
<script>
const monthYear = document.getElementById('monthYear');
const calendarDays = document.getElementById('calendarDays');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');
const selectedDateText = document.getElementById('selectedDateText');
const fechaSeleccionadaInput = document.getElementById('fechaSeleccionada');

let currentDate = new Date();
let selectedDate = null;
let reservasExistentes = [];
const monthNames = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

// Obtener idservicio desde la URL
const idservicio = <?php echo $_GET['idservicio'] ?? 'null'; ?>;

// === Cargar reservas existentes ===
function cargarReservasExistentes() {
  if (!idservicio) return;
  fetch('../conexion/controllerReserva.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=obtener_reservas&idservicio=${idservicio}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.success && Array.isArray(data.reservas)) {
      reservasExistentes = data.reservas;
    }
    renderCalendar();
  })
  .catch(err => console.error("Error cargando reservas:", err));
}

// === Renderizar calendario ===
function renderCalendar() {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  monthYear.textContent = `${monthNames[month]} ${year}`;
  calendarDays.innerHTML = '';

  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const startDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;

  // Días vacíos del mes anterior
  for (let i = 0; i < startDay; i++) {
    const dayBtn = document.createElement('button');
    dayBtn.className = 'calendar-day other-month';
    dayBtn.textContent = '';
    calendarDays.appendChild(dayBtn);
  }

  const today = new Date();
  today.setHours(0,0,0,0);

  // Días del mes actual
  for (let d = 1; d <= lastDay.getDate(); d++) {
    const date = new Date(year, month, d);
    const isoDate = date.toLocaleDateString('en-CA'); // YYYY-MM-DD local
    const dayBtn = document.createElement('button');
    dayBtn.className = 'calendar-day';
    dayBtn.textContent = d;
    dayBtn.type = 'button';

    // Marcar días pasados
    if (date < today) {
      dayBtn.classList.add('disabled');
      dayBtn.disabled = true;
    }

    // Marcar fechas reservadas
    const reservada = reservasExistentes.some(r => r.fecha === isoDate);
    if (reservada) {
      dayBtn.style.background = '#ef4444';
      dayBtn.style.color = 'white';
      dayBtn.title = 'Fecha ya reservada';
      dayBtn.disabled = true;
    }

    // Marcar fecha seleccionada
    if (selectedDate && date.getTime() === selectedDate.getTime()) {
      dayBtn.classList.add('selected');
    }

    // Click
    if (!reservada && date >= today) {
      dayBtn.onclick = () => selectDate(date);
    }

    calendarDays.appendChild(dayBtn);
  }
}

// === Seleccionar fecha ===
function selectDate(date) {
  selectedDate = date;
  const isoDate = date.toLocaleDateString('en-CA');
  const formatted = date.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });

  selectedDateText.textContent = formatted;
  fechaSeleccionadaInput.value = isoDate;

  renderCalendar();
}

// === Navegación ===
prevMonthBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
};
nextMonthBtn.onclick = () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
};

// === Enviar formulario ===
document.getElementById('formReserva').onsubmit = function(e) {
  e.preventDefault();
  const horaSeleccionada = document.querySelector('input[name="hora"]:checked');
  if (!selectedDate || !horaSeleccionada) {
    alert('Seleccioná una fecha y una hora disponible.');
    return;
  }

  fetch('../conexion/controllerReserva.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      'action': 'crear_reserva',
      'idservicio': idservicio,
      'fecha': fechaSeleccionadaInput.value,
      'hora': horaSeleccionada.value
    })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      alert('✅ Reserva creada exitosamente');
      window.location.href = 'perfil-cliente.php';
    } else {
      alert('❌ Error: ' + (data.error || 'Error desconocido'));
    }
  })
  .catch(err => alert('Error de conexión con el servidor'));
};

// === Inicialización ===
document.addEventListener('DOMContentLoaded', () => {
  cargarReservasExistentes();
});
</script>

</body>
</html>