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
        <a href="perfil.php" style="color: inherit; text-decoration: none;">
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

  <!-- Sección: Calendario (moved from perfil.php) -->
  <section id="calendario-section" style="padding:2rem 1rem;">
    <style>
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
    </style>

    <div class="calendar-wrap">
      <div class="left">
        <div>
          <h3>Disponibilidad</h3>
          <p style="opacity:0.9; margin-top:8px;">Seleccioná la fecha disponible para revisar horarios.</p>
        </div>

        <div class="calendar-container" id="miniCalendar">
          <div class="calendar-header">
            <div style="color:#fff; font-weight:700;" id="monthLabel">Mes Año</div>
            <div class="calendar-nav">
              <button id="prevMonth" title="Mes anterior">&lt;</button>
              <button id="nextMonth" title="Mes siguiente">&gt;</button>
            </div>
          </div>

          <div class="calendar-weekdays">
            <div class="weekday">Lun</div><div class="weekday">Mar</div><div class="weekday">Mié</div>
            <div class="weekday">Jue</div><div class="weekday">Vie</div><div class="weekday">Sáb</div><div class="weekday">Dom</div>
          </div>

          <div class="calendar-days" id="calendarDays"></div>
        </div>
      </div>

      <div class="right">
        <div class="selected-info">
          <div class="dot"><i class="fas fa-calendar-day"></i></div>
          <div>
            <div class="selected-text" id="selectedDateText">Seleccioná una fecha</div>
            <div style="color:#6b7280; font-size:0.9rem;" id="selectedDateSub">No hay fecha seleccionada</div>
          </div>
        </div>

        <div id="detailArea">
          <p style="color:#374151;">Aquí podés mostrar disponibilidad, reservas o la información relacionada con la publicación seleccionada.</p>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        try {
          const daysContainer = document.getElementById('calendarDays');
          const monthLabel = document.getElementById('monthLabel');
          const prevBtn = document.getElementById('prevMonth');
          const nextBtn = document.getElementById('nextMonth');
          const selectedText = document.getElementById('selectedDateText');
          const selectedSub = document.getElementById('selectedDateSub');

          if (!daysContainer || !monthLabel) return console.error('Elementos del calendario no encontrados');

          let viewDate = new Date();
          viewDate.setDate(1);
          let selectedDate = null;

          function render() {
            daysContainer.innerHTML = '';
            const year = viewDate.getFullYear();
            const month = viewDate.getMonth();
            monthLabel.textContent = viewDate.toLocaleString('es-ES', { month: 'long', year: 'numeric' });

            const firstWeekday = (new Date(year, month, 1).getDay() + 6) % 7; // lunes=0
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevDays = firstWeekday;
            const totalCells = Math.ceil((prevDays + daysInMonth) / 7) * 7;

            const prevMonthLastDay = new Date(year, month, 0).getDate();

            for (let i = 0; i < totalCells; i++) {
              const cell = document.createElement('div');
              cell.className = 'day';
              let dayNumber, cellDate;
              if (i < prevDays) {
                dayNumber = prevMonthLastDay - prevDays + 1 + i;
                cell.classList.add('other-month');
                cellDate = new Date(year, month - 1, dayNumber);
              } else if (i < prevDays + daysInMonth) {
                dayNumber = i - prevDays + 1;
                cellDate = new Date(year, month, dayNumber);
              } else {
                dayNumber = i - (prevDays + daysInMonth) + 1;
                cell.classList.add('other-month');
                cellDate = new Date(year, month + 1, dayNumber);
              }

              cell.textContent = dayNumber;
              cell.dataset.date = cellDate.toISOString();

              const today = new Date();
              today.setHours(0,0,0,0);
              if (cellDate < today) {
                cell.classList.add('disabled');
              } else {
                cell.addEventListener('click', () => {
                  const prev = daysContainer.querySelector('.day.selected');
                  if (prev) prev.classList.remove('selected');
                  cell.classList.add('selected');
                  selectedDate = cellDate;
                  selectedText.textContent = selectedDate.toLocaleDateString('es-ES', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
                  selectedSub.textContent = 'Fecha seleccionada: ' + selectedDate.toLocaleDateString('es-ES');
                  // Aquí podés disparar fetch para obtener horarios/ reservas de la publicación
                });
              }

              daysContainer.appendChild(cell);
            }
          }

          if (prevBtn) prevBtn.addEventListener('click', () => { viewDate.setMonth(viewDate.getMonth() - 1); render(); });
          if (nextBtn) nextBtn.addEventListener('click', () => { viewDate.setMonth(viewDate.getMonth() + 1); render(); });

          render();
        } catch (err) {
          console.error('Error inicializando calendario:', err);
        }
      });
    </script>
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
  // --- Reemplazar el manejador del menú de perfil por este más robusto ---
  (function(){
    const profileMenu = document.getElementById('profileMenu');
    const wrapper     = document.getElementById('userMenuWrapper');

    if (!wrapper || !profileMenu) return;

    // Toggle por click (mejor que hover para evitar cierres por propagación)
    wrapper.addEventListener('click', function (e) {
      // evitar que el click burbujee al document (que cierra el menú)
      e.stopPropagation();
      profileMenu.classList.toggle('active');
    });

    // Evitar que clicks dentro del menú cierren por accidente
    profileMenu.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    // Cerrar al hacer click fuera
    document.addEventListener('click', function () {
      profileMenu.classList.remove('active');
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') profileMenu.classList.remove('active');
    });
  })();

  // Notificaciones (mantener loader real)
  const bell = document.getElementById('notificationBell');
  const modalNotif = document.getElementById('notificationModal');
  const closeBtnNotif = document.getElementById('closeNotifications');
  const notifListEl = modalNotif.querySelector('.notification-list');
  const badgeEl = document.getElementById('notifBadge');

  function escapeHtml(s){ return String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

  async function loadNotifications() {
    try {
      const res = await fetch('../conexion/getNotifications.php?action=list', { credentials: 'same-origin' });
      const json = await res.json();
      if (!json.success) return console.error(json.error || 'No success');
      notifListEl.innerHTML = '';
      const list = json.notifications || [];
      const unread = json.unread || 0;
      badgeEl.textContent = unread > 0 ? unread : '';

      if (list.length === 0) {
        notifListEl.innerHTML = '<div style="padding:12px;color:#6b7280;">No hay notificaciones</div>';
        return;
      }

      list.forEach(n => {
        // sólo tipos permitidos (defensa extra)
        if (!['reporte','solicitud','calificacion'].includes(n.tipo)) return;
        const item = document.createElement('div');
        item.className = 'notification-item' + (n.leida == 0 ? ' unread' : '');
        item.style.display = 'flex';
        item.style.padding = '10px';
        item.style.borderBottom = '1px solid #eef2f7';
        item.style.gap = '10px';
        item.innerHTML = `
          <div class="notification-icon" style="font-size:18px;color:#045a4a;"><i class="fas fa-bell"></i></div>
          <div class="notification-content" style="flex:1;">
            <div class="notification-title" style="font-weight:600">${escapeHtml(n.mensaje)}</div>
            <div class="notification-time" style="font-size:12px;color:#6b7280">${new Date(n.fecha).toLocaleString()}</div>
          </div>
        `;
        item.dataset.id = n.idnotificacion;
        item.dataset.tipo = n.tipo;
        item.dataset.ref = n.referencia;
        item.addEventListener('click', async () => {
          await markAsRead(n.idnotificacion);
          item.classList.remove('unread');
          // redirección según tipo (ajusta rutas si hace falta)
          if (n.tipo === 'reporte') {
            // si sos admin podrías llevar a panel de reports; por ahora abrir listado
            window.location.href = 'admin/reports.php';
          } else if (n.tipo === 'solicitud') {
            window.location.href = 'reservas.php';
          } else if (n.tipo === 'calificacion') {
            window.location.href = 'mis-calificaciones.php';
          }
        });
        notifListEl.appendChild(item);
      });
    } catch (err) {
      console.error('loadNotifications', err);
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
      if (j.success) loadNotifications(); // actualizar badge
      return j.success;
    } catch (e) {
      console.error('markAsRead', e);
      return false;
    }
  }

  bell?.addEventListener('click', async (e) => {
    modalNotif.classList.toggle('active');
    if (modalNotif.classList.contains('active')) await loadNotifications();
  });
  closeBtnNotif?.addEventListener('click', () => modalNotif.classList.remove('active'));

  // carga inicial y poll cada 45s
  loadNotifications();
  setInterval(loadNotifications, 45000);
</script>

<script>
  (function(){
    const bell = document.getElementById('notificationBell');
    const modal = document.getElementById('notificationModal');
    const closeBtn = document.getElementById('closeNotifications');
    const listEl = modal ? modal.querySelector('.notification-list') : null;
    const badge = document.getElementById('notifBadge');

    function escapeHtml(s){ return String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

    async function loadNotifications() {
      if (!listEl) return;
      try {
        const res = await fetch('../conexion/getNotifications.php?action=list', { credentials: 'same-origin' });
        const json = await res.json();
        if (!json.success) { listEl.innerHTML = emptyState('Error al cargar'); return; }
        const list = json.notifications || [];
        const unread = json.unread || 0;
        badge.textContent = unread > 0 ? unread : '';

        if (list.length === 0) {
          listEl.innerHTML = emptyState('Buzón vacío', 'No hay notificaciones por ahora. Volvé más tarde o tocá actualizar.');
          const btn = document.getElementById('notifRefresh');
          if (btn) btn.addEventListener('click', loadNotifications);
          return;
        }

        listEl.innerHTML = '';
        list.forEach(n => {
          // defensa extra: solo permitir tipos válidos
          if (!['reporte','solicitud','calificacion'].includes(n.tipo)) return;
          const item = document.createElement('div');
          item.className = 'notification-item' + (n.leida == 0 ? ' unread' : '');
          item.style.display = 'flex';
          item.style.padding = '10px';
          item.style.borderBottom = '1px solid #eef2f7';
          item.style.gap = '10px';
          item.innerHTML = `
            <div class="notification-icon" style="font-size:18px;color:#045a4a;"><i class="fas fa-bell"></i></div>
            <div class="notification-content" style="flex:1;">
              <div class="notification-title" style="font-weight:600">${escapeHtml(n.mensaje)}</div>
              <div class="notification-time" style="font-size:12px;color:#6b7280">${new Date(n.fecha).toLocaleString()}</div>
            </div>
          `;
          item.dataset.id = n.idnotificacion;
          item.dataset.tipo = n.tipo;
          item.dataset.ref = n.referencia;
          item.addEventListener('click', async () => {
            await markAsRead(n.idnotificacion);
            item.classList.remove('unread');
            // redirecciones ejemplo (ajustar rutas según tu app)
            if (n.tipo === 'reporte') window.location.href = '/ProyectoProgramacion/vistas/admin/reports.php';
            else if (n.tipo === 'solicitud') window.location.href = '/ProyectoProgramacion/vistas/reservas.php';
            else if (n.tipo === 'calificacion') window.location.href = '/ProyectoProgramacion/vistas/mis-calificaciones.php';
          });
          listEl.appendChild(item);
        });
      } catch (err) {
        console.error('loadNotifications', err);
        if (listEl) listEl.innerHTML = emptyState('Error al cargar', 'No se pudieron cargar las notificaciones. Reintentá.');
      }
    }

    function emptyState(title, desc){
      desc = desc || 'No hay notificaciones por ahora.';
      return `
        <div class="notification-empty" style="padding:18px;text-align:center;color:#6b7280;display:flex;flex-direction:column;align-items:center;gap:10px;">
          <div class="icon" style="width:56px;height:56px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:22px;color:#64748b;box-shadow:0 6px 18px rgba(15,23,42,0.04);">
            <i class="fas fa-inbox"></i>
          </div>
          <div class="title" style="font-weight:700;color:#374151;">${escapeHtml(title)}</div>
          <div class="desc" style="font-size:0.92rem;max-width:260px;line-height:1.3;color:#6b7280;">${escapeHtml(desc)}</div>
          <button class="btn-refresh" id="notifRefresh" style="margin-top:8px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:600;">Actualizar</button>
        </div>
      `;
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
        if (j.success) loadNotifications();
        return j.success;
      } catch (e) {
        console.error('markAsRead', e);
        return false;
      }
    }

    // Toggle modal & listeners
    if (bell && modal) {
      bell.addEventListener('click', async (e) => {
        modal.classList.toggle('active');
        if (modal.classList.contains('active')) await loadNotifications();
      });
    }
    if (closeBtn && modal) closeBtn.addEventListener('click', () => modal.classList.remove('active'));

    // Close when click outside
    document.addEventListener('click', (e) => {
      if (!modal || !bell) return;
      if (!bell.contains(e.target) && !modal.contains(e.target)) modal.classList.remove('active');
    });

    // load initial badge and poll
    loadNotifications();
    setInterval(loadNotifications, 45000);
  })();
</script>

</body>
</html>
