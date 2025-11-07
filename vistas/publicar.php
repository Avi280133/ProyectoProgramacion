<?php require_once('../conexion/guards/auth_guard.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicá tu Servicio | SkillMatch</title>

  <!-- Estilos propios -->
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/soli.css">

  <!-- Icono -->
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">

  <!-- FontAwesome (para iconos del header) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/publicar.css">
  <style>
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

        .header-logo i {
            font-size: 2rem;
        }

        .header-actions {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .header-icon {
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-icon:hover {
            transform: scale(1.2) rotate(5deg);
            filter: brightness(1.2);
        }

        /* ===== MODAL NOTIFICATION (éxito / error) ===== */
.modal-overlay-notification {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.6);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 4000;
}
.modal-overlay-notification.active { display: flex; }

.modal-notification {
  background: #fff;
  border-radius: 25px;
  padding: 40px;
  width: 90%;
  max-width: 450px;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0,0,0,.3);
  animation: notifScaleIn .25s ease;
}

@keyframes notifScaleIn {
  from { transform: scale(.94); opacity:.6; }
  to   { transform: scale(1);   opacity:1; }
}

.modal-notification-icon {
  width: 90px; height: 90px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 25px; color: #fff; font-size: 45px;
}
.modal-notification-icon.success { background: linear-gradient(135deg,#0eb27c,#047857); }
.modal-notification-icon.error   { background: linear-gradient(135deg,#ef4444,#b91c1c); }

.modal-notification-title { font-size: 28px; font-weight: 700; color: #2c3e50; margin-bottom: 12px; }
.modal-notification-text  { font-size: 16px; color: #7f8c8d; line-height: 1.6; margin-bottom: 24px; }

.btn-notification-ok {
  padding: 12px 34px; border-radius: 12px; border: none; font-size: 16px; font-weight: 700;
  cursor: pointer; transition: transform .15s ease, box-shadow .15s ease;
  background: linear-gradient(135deg,#0eb27c,#047857); color: #fff;
}
.btn-notification-ok:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(14,178,124,.35); }

@media (max-width: 600px) {
  .modal-notification { padding: 28px 22px; width: 95%; }
  .modal-notification-icon { width: 80px; height: 80px; font-size: 40px; }
  .modal-notification-title { font-size: 24px; }
}


.header-logo {
    cursor: pointer;
    transition: all 0.3s ease;
}

.header-logo:hover {
    transform: translateY(-5px);
}

.header-logo img {
    transition: all 0.3s ease;
}

.header-logo:hover img {
    transform: scale(1.1) rotate(-5deg);
}

  </style>
</head>
<body>
  <header>
        
        <div class="header-logo">
          <a href="vistas-prov.php" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
            SkillMatch
          </a>
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
            <div class="header-icon">
                <a href="perfil.php" style="color: inherit; text-decoration: none;">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </header>

  <!-- Formulario de publicación -->
  <main class="seccion-formulario-solicitud">
    <div class="contenedor-formulario">
      <h2 class="titulo-formulario">Publicá tu Servicio</h2>


      <?php
require_once('../conexion/ClaseConexion.php');
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$categorias = [];
$cx = (new ClaseConexion())->getConexion(); // mysqli
$cx->set_charset('utf8mb4');
$sql = "SELECT nombre FROM categoria ORDER BY nombre";
if ($st = $cx->prepare($sql)) {
  $st->execute();
  if ($res = $st->get_result()) {
    while ($row = $res->fetch_assoc()) { $categorias[] = $row['nombre']; }
    $res->free();
  }
  $st->close();
}
$cx->close();

// si volvés de un POST o estás editando
$categoriaSeleccionada = $_POST['categoria'] ?? '';
?>


      <!-- IMPORTANTE: enctype para subir archivos y action oculto -->
      <form action="../conexion/controllerPublicacion.php" method="POST" class="formulario-servicio" enctype="multipart/form-data">
        <input type="hidden" name="action" value="publicar">

        <label for="titulo" class="etiqueta-campo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ej: Reparación de PC a domicilio" class="campo-formulario" required>

        <label for="ubicacion" class="etiqueta-campo">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" placeholder="Ej: Pocitos, Montevideo" class="campo-formulario" required>

      <label for="categoria" class="etiqueta-campo">Categoría (opcional):</label>
<select id="categoria" name="categoria" class="campo-formulario">
  <option value="">--Seleccioná--</option>
  <?php foreach ($categorias as $nombre): 
        $sel = ($categoriaSeleccionada === $nombre) ? 'selected' : ''; ?>
    <option value="<?php echo h($nombre); ?>" <?php echo $sel; ?>>
      <?php echo h($nombre); ?>
    </option>
  <?php endforeach; ?>
</select>

        <label class="etiqueta-campo">Imagen (opcional):</label>
        <div class="imagen-equipo">
          <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>

        <label for="descripcion" class="etiqueta-campo">Descripción del servicio:</label>
        <textarea id="descripcion" name="descripcion" rows="5" class="campo-formulario" placeholder="Contá brevemente qué ofrecés, experiencia, qué incluye, etc." required></textarea>

        <label for="precio" class="etiqueta-campo">Precio del servicio:</label>
        <div class="form-group price-input-container">
          <span class="price-symbol">$</span>
          <input
            type="number"
            id="precio"
            name="precio"
            class="price-input"
            placeholder="0.00"
            step="0.01"
            min="0"
            required
          >
        </div>

        <button type="submit" class="boton-enviar-formulario">📩 Publicar servicio</button>
      </form>
    </div>
  </main>

  <footer class="pie-de-pagina">
    <div class="contenedor-pie">
      <p>&copy; 2025 ServiciosPro. Todos los derechos reservados.</p>
    </div>
  </footer>
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

<!-- Modal de Notificación (éxito / error) -->
<div class="modal-overlay-notification" id="notificationOverlay">
  <div class="modal-notification" role="dialog" aria-modal="true" aria-labelledby="notifTitle" aria-describedby="notifText">
    <div class="modal-notification-icon success" id="notifIcon">
      <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="modal-notification-title" id="notifTitle">¡Éxito!</h2>
    <p class="modal-notification-text" id="notifText">La operación se completó correctamente.</p>
    <button class="btn-notification-ok" id="notifOkBtn">Aceptar</button>
  </div>
</div>

<script>
  // API simple para abrir/cerrar el modal
  function showNotificationModal(title, message, type = 'success') {
    const overlay = document.getElementById('notificationOverlay');
    const iconBox = document.getElementById('notifIcon');
    const titleEl = document.getElementById('notifTitle');
    const textEl  = document.getElementById('notifText');

    // Tipo: success | error
    iconBox.classList.remove('success','error');
    iconBox.classList.add(type === 'error' ? 'error' : 'success');
    iconBox.innerHTML = type === 'error'
      ? '<i class="fas fa-times-circle"></i>'
      : '<i class="fas fa-check-circle"></i>';

    titleEl.textContent = title || (type === 'error' ? 'Ocurrió un error' : '¡Éxito!');
    textEl.textContent  = message || (type === 'error'
      ? 'No se pudo completar la operación.'
      : 'La operación se completó correctamente.');

    overlay.classList.add('active');
  }

  function closeNotificationModal() {
    document.getElementById('notificationOverlay').classList.remove('active');
  }

  // Cierre por botón y por click fuera
  document.getElementById('notifOkBtn').addEventListener('click', closeNotificationModal);
  document.getElementById('notificationOverlay').addEventListener('click', (e) => {
    if (e.target.id === 'notificationOverlay') closeNotificationModal();
  });

  // Auto-abrir si venís del controlador con ?ok=1&msg=... o ?error=1&msg=...
  (function autoOpenFromQuery(){
    try {
      const q = new URLSearchParams(window.location.search);
      const msg = q.get('msg');
      if (q.has('ok')) {
        showNotificationModal('¡Publicación creada!', msg || 'Tu servicio fue publicado correctamente.', 'success');
      } else if (q.has('error')) {
        showNotificationModal('No se pudo publicar', msg || 'Intentalo nuevamente.', 'error');
      }
    } catch (_) {}
  })();
</script>

</body>
</html>
