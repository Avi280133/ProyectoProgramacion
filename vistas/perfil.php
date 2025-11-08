<?php
require_once('../conexion/guards/auth_guard.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conexion/modelUsuario.php');

// Verificamos que haya alguien logueado
if (!isset($_SESSION['cedula'])) {
    header("Location: ../vistas/login.php");
    exit();
}

// Cargamos datos del usuario
$usuario = Usuario::buscarPorCedula($_SESSION['cedula']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil de Usuario</title>
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="conexion" href="../conexion/controllerUsuario.php">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #ffffff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ===== HEADER NUEVO ===== */
    .header-nuevo {
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%) !important;
      padding: 1rem 2rem !important;
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      box-shadow: 0 8px 32px rgba(14, 178, 124, 0.2) !important;
      position: sticky !important;
      top: 0 !important;
      z-index: 1000 !important;
      width: 100% !important;
    }
    .header-logo {
      font-size: 1.8rem !important;
      font-weight: 800 !important;
      color: white !important;
      letter-spacing: 0.5px !important;
      display: flex !important;
      align-items: center !important;
      gap: 0.5rem !important;
    }
    .header-actions { display: flex !important; gap: 2rem !important; align-items: center !important; }
    .header-icon {
      color: white !important; font-size: 1.3rem !important; cursor: pointer !important;
      transition: all 0.3s ease !important; position: relative !important; text-decoration: none !important;
      display: inline-block !important;
    }
    .header-icon:hover { transform: scale(1.2) rotate(5deg) !important; filter: brightness(1.2) !important; }

    /* ===== Notification Modal ===== */
    .notification-modal {
      position: absolute;
      top: 100%;
      right: -1rem;
      background: white;
      border-radius: 20px;
      width: 350px;
      max-height: 500px;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
      margin-top: 1rem;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-20px) scale(0.9);
      transition: all 0.3s ease;
      z-index: 2000;
    }
    .notification-modal.active {
      opacity: 1; visibility: visible; transform: translateY(0) scale(1);
    }
    .notification-header {
      padding: 1.5rem; border-bottom: 2px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;
    }
    .notification-header h3 { color: #2c3e50; font-size: 1.2rem; }
    .notification-list { padding: 0; }
    .notification-item {
      padding: 1.2rem 1.5rem; border-bottom: 1px solid #f0f0f0; display: flex; gap: 1rem; transition: all 0.2s ease; cursor: pointer;
    }
    .notification-item:hover { background: #f8f9fa; padding-left: 2rem; }
    .notification-item.unread { background: linear-gradient(135deg, #e8f5f1 0%, #d1f0e5 100%); }
    .notification-icon {
      width: 45px; height: 45px; border-radius: 50%;
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; font-size: 1.2rem;
    }
    .notification-content { flex: 1; }
    .notification-title { font-weight: 600; color: #2c3e50; margin-bottom: 0.3rem; font-size: 0.95rem; }
    .notification-time { color: #95a5a6; font-size: 0.75rem; margin-top: 0.5rem; }

    /* ===== CONTENIDO PERFIL ===== */
    .contenedor {
      flex: 1; background-color: white; display: flex; justify-content: center; align-items: center; padding: 40px 0;
    }
    .perfil {
      border: 3px solid #aec3bb; border-radius: 20px; padding: 50px; width: 700px; background-color: #fbfcfa;
      text-align: center; box-shadow: 0 6px 16px rgba(27, 81, 16, 0.548);
    }
    .redonda {
      width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #025939;
    }
    .nombre-usuario { font-size: 22px; margin: 10px 0 5px; color: #333; }
    .gmail { color: #000000; margin-bottom: 20px; }
    .botones { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
    .btneditar, .btncerrar {
      padding: 10px 18px; border: none; border-radius: 15px; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease;
    }
    .btneditar { background-color: #11be7f; color: #fcfdfb; margin: 10px; text-decoration: none; display: inline-block; }
    .btneditar:hover { background-color: #025939; }
    .btncerrar { background-color: #c6c9b9; color: #333; text-decoration: none; display: inline-block; }
    .btncerrar:hover { background-color: #999; color: #c6c9b9; }

    /* ===== MODAL EDIT PERFIL ===== */
    .modal-overlay-edit {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5); display: none; align-items: center; justify-content: center; z-index: 2000; transition: all 0.3s ease;
    }
    .modal-overlay-edit.active { display: flex; }
    .modal-edit {
      background: #fff; border-radius: 20px; padding: 40px; width: 90%; max-width: 800px; position: relative;
      border: 3px solid #26e0a3; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      transform: translateY(-30px); transition: transform 0.3s ease; z-index: 2001;
    }
    .modal-overlay-edit.active .modal-edit { transform: translateY(0); }
    .modal-header-edit { text-align: center; margin-bottom: 30px; }
    .modal-title-edit {
      font-size: 32px; font-weight: bold; color: #26e0a3; letter-spacing: 2px; text-transform: uppercase;
    }
    .close-btn-edit {
      position: absolute; top: 20px; right: 25px; background: none; border: none; font-size: 30px; color: #26e0a3;
      cursor: pointer; padding: 5px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;
      transition: all 0.2s ease;
    }
    .close-btn-edit:hover { background: #26e0a3; color: #f9fffd; transform: rotate(90deg); }
    .modal-content-edit { display: grid; grid-template-columns: 1fr 300px; gap: 40px; align-items: start; }
    .form-section-edit { display: flex; flex-direction: column; gap: 25px; }
    .form-group-edit { display: flex; flex-direction: column; gap: 8px; }
    .form-label-edit { font-size: 18px; font-weight: 600; color: #374151; }
    .form-input-edit, .form-select-edit, .form-textarea-edit {
      padding: 12px 16px; border: 2px solid #26e0a3; border-radius: 12px; font-size: 16px; transition: all 0.2s ease; background: #f9fffd;
    }
    .form-input-edit:focus, .form-select-edit:focus, .form-textarea-edit:focus {
      outline: none; border-color: #1fb087; box-shadow: 0 0 0 3px rgba(38, 224, 163, 0.1);
    }
    .form-textarea-edit { resize: vertical; min-height: 120px; font-family: inherit; }
    .profile-section-edit { display: flex; flex-direction: column; align-items: center; gap: 20px; }
    .profile-photo-container-edit {
      position: relative; width: 180px; height: 180px; border: 4px solid #26e0a3; border-radius: 50%;
      background: #f9fffd; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; overflow: hidden;
    }
    .profile-photo-container-edit:hover { border-color: #1fb087; transform: scale(1.05); box-shadow: 0 8px 25px rgba(38, 224, 163, 0.3); }
    .profile-photo-container-edit input[type="file"] {
      position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;
    }
    .upload-overlay-edit {
      position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(38, 224, 163, 0.8);
      border-radius: 50%; display: none; align-items: center; justify-content: center; transition: opacity 0.3s ease;
    }
    .profile-photo-container-edit:hover .upload-overlay-edit { display: flex; opacity: 1; }
    .upload-icon-edit { font-size: 30px; color: #f9fffd; }
    .profile-inputs-edit { width: 100%; display: flex; flex-direction: column; gap: 15px; }
    .save-btn-edit {
      background: linear-gradient(135deg, #26e0a3 0%, #1fb087 100%); color: #f9fffd; border: none; padding: 15px 40px; font-size: 18px;
      font-weight: bold; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px; width: 100%;
    }
    .save-btn-edit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(38, 224, 163, 0.4); }
    .delete-btn-edit {
      background: linear-gradient(135deg, #e6344a 0%, #b8001c 100%); color: #f9fffd; border: none; padding: 15px 40px; font-size: 18px;
      font-weight: bold; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px; width: 100%;
      margin-top: 10px;
    }
    .delete-btn-edit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(230, 52, 74, 0.4); }

    /* ===== FOOTER ===== */
    footer {
      background: linear-gradient(135deg, #064e3b 0%, #025939 50%, #0eb27c 100%);
      color: white; padding: 3rem 2rem 2rem; margin-top: 3rem;
    }
    .footer-content {
      max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem; margin-bottom: 2rem;
    }
    .footer-section h4 { font-size: 1.1rem; margin-bottom: 1rem; font-weight: 700; }
    .footer-links { display: flex; flex-direction: column; gap: 0.8rem; }
    .footer-links a { color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s ease; font-size: 0.9rem; }
    .footer-links a:hover { color: white; padding-left: 0.5rem; }
    .footer-bottom {
      text-align: center; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 2rem; display: flex;
      justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
    }
    .social-links { display: flex; gap: 1rem; justify-content: center; }
    .social-icon {
      width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;
      color: white; text-decoration: none; transition: all 0.3s ease;
    }
    .social-icon:hover { background: white; color: #0eb27c; transform: translateY(-3px); }

    @media (max-width: 600px) { .header-nuevo { padding: 1rem !important; } .modal-edit { padding: 25px; width: 95%; } .modal-content-edit { grid-template-columns: 1fr; gap: 25px; } .modal-title-edit { font-size: 24px; } .profile-photo-container-edit { width: 150px; height: 150px; } }

    /* Forzar visibilidad del modal con .active */
    .header-actions { position: relative; }
    .notification-modal { opacity:0; visibility:hidden; transform:translateY(-20px) scale(.96); }
    .notification-modal.active { opacity:1; visibility:visible; transform:translateY(0) scale(1); }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header-nuevo">
    <div class="header-logo">
      <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
      <a href="../vistas/vistas-prov.php" style="text-decoration: none; color: white;">SkillMatch</a>
    </div>
    <div class="header-actions">
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

      <!-- Botón Cerrar sesión -->
      <form action="../logout.php" method="POST" style="display:inline; margin:0;">
        <button type="submit" class="header-icon" title="Cerrar sesión" style="background:none; border:none; color:white; cursor:pointer;">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </header>

  <div class="contenedor">
    <div class="perfil">
      <img src="../img/<?php echo htmlspecialchars($usuario['fotoperfil'] ?? '4ae62d57-16c3-4974-b494-e9c26f8036fe.jpg'); ?>" alt="Foto de perfil" class="redonda" />
      <h2 class="nombre-usuario"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h2>
      <p class="gmail"><?php echo htmlspecialchars($usuario['email']); ?></p>
      <p>Username: <?php echo htmlspecialchars($usuario['username']); ?></p>
      <p>Edad: <?php echo htmlspecialchars($usuario['edad']); ?></p>

      <div class="botones">
        <button class="btneditar">Editar perfil</button>
      </div>
    </div>
  </div>

  <div>
    <?php
      require_once '../conexion/controllerUsuario.php';
      $cx=(new ClaseConexion())->getConexion();
      require_once '../conexion/modelUsuario.php';
      $chats = Usuario::cargarChatsProv();
      if (!empty($chats)) {
        echo '<form action="../chatphp/chat.php" method="POST">';
        echo "<ul>";
        foreach ($chats as $c) {
          echo '<li>';
          echo '<button type="submit" name="emite" value="' . htmlspecialchars($c['idemisor']) . '">' . htmlspecialchars($c['nombre']) . '</button>';
          echo '</li>';
        }
        echo "</ul>";
        echo '</form>';
      } else {
        echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
      }
    ?>
  </div>

  <!-- MODAL EDIT PERFIL -->
  <div class="modal-overlay-edit" id="editProfileModalOverlay">
    <div class="modal-edit">
      <div class="modal-header-edit">
        <h2 class="modal-title-edit">Editar Perfil</h2>
        <button class="close-btn-edit" id="closeModalBtn">×</button>
      </div>

      <form action="../conexion/controllerUsuario.php" method="POST" enctype="multipart/form-data">
        <div class="modal-content-edit">
          <div class="form-section-edit">
            <div class="form-group-edit">
              <label class="form-label-edit">Localidad</label>
              <select class="form-select-edit" id="locationSelect" name="localidad">
                <option>Ciudades</option>
                <option>Montevideo</option>
                <option>Salto</option>
                <option>Paysandú</option>
                <option>Las Piedras</option>
                <option>Rivera</option>
                <option>Maldonado</option>
                <option>Tacuarembó</option>
                <option>Melo</option>
                <option>Mercedes</option>
                <option>Artigas</option>
                <option>Minas</option>
                <option>San José de Mayo</option>
                <option>Durazno</option>
                <option>Florida</option>
                <option>Treinta y Tres</option>
                <option>Rocha</option>
                <option>Colonia del Sacramento</option>
                <option>Fray Bentos</option>
                <option>Canelones</option>
                <option>Young</option>
                <option>Carmelo</option>
                <option>Trinidad</option>
              </select>
            </div>

            <div class="form-group-edit">
              <label class="form-label-edit">Habilidades</label>
              <textarea class="form-textarea-edit" name="habilidad" id="skillsTextarea" placeholder="Describe tus principales habilidades y competencias..."></textarea>
            </div>

            <div class="form-group-edit">
              <label class="form-label-edit">Experiencia</label>
              <textarea class="form-textarea-edit" name="experiencia" id="experienceTextarea" placeholder="Cuéntanos sobre tu experiencia profesional..."></textarea>
            </div>
          </div>

          <div class="profile-section-edit">
            <div class="profile-photo-container-edit" id="photoContainer">
              <div class="upload-overlay-edit">
                <i class="fa-solid fa-image upload-icon-edit"></i>
              </div>
            </div>
            <input type="file" id="photoInput" name="foto" accept="image/*">
            <div class="profile-inputs-edit">
              <input type="text" class="form-input-edit" id="nameInput" placeholder="Nombre Apellido" value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" disabled>
              <input type="text" class="form-input-edit" id="usernameInput" name="username" placeholder="username" value="<?php echo htmlspecialchars($usuario['username'] ?? ''); ?>">
              <input type="hidden" name="fotoperfil" value="<?php echo htmlspecialchars($usuario['fotoperfil'] ?? ''); ?>">
            </div>

            <button type="submit" name="action" value="modificar" class="save-btn-edit" id="saveBtn">Guardar</button>
          </div>
        </div>
      </form>
      <form id="deleteForm" action="../conexion/controllerUsuario.php" method="POST" style="margin-top:10px;">
        <input type="hidden" name="action" value="eliminar">
        <button type="button" class="delete-btn-edit" id="deleteBtn">Eliminar Usuario</button>
      </form>
      <script>
        // Confirmación + submit del form simple
        document.getElementById('deleteBtn').addEventListener('click', function () {
          if (confirm('¿Seguro que querés eliminar tu cuenta? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
          }
        });
      </script>
    </div>
  </div>

  <!-- Modal Notification (genérico, opcional) -->
  <div class="modal-overlay-notification" id="notificationSuccess" style="display:none; align-items:center; justify-content:center;">
    <div class="modal-notification" style="background:white;border-radius:25px;padding:40px;width:90%;max-width:450px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
      <div class="modal-notification-icon success" style="width:90px;height:90px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 25px;color:white;font-size:45px;background:linear-gradient(135deg,#0eb27c,#047857);box-shadow:0 8px 20px rgba(14,178,124,.4);"><i class="fas fa-check-circle"></i></div>
      <h2 class="modal-notification-title" id="notificationTitle" style="font-size:28px;font-weight:700;color:#2c3e50;margin-bottom:15px;">¡Éxito!</h2>
      <p class="modal-notification-text" id="notificationText" style="font-size:16px;color:#7f8c8d;line-height:1.6;margin-bottom:30px;">La operación se completó correctamente.</p>
      <button class="btn-notification-ok" onclick="document.getElementById('notificationSuccess').style.display='none';" style="padding:14px 50px;border-radius:15px;border:none;font-size:16px;font-weight:600;cursor:pointer;transition:all .3s;text-transform:uppercase;letter-spacing:.5px;background:linear-gradient(135deg,#0eb27c,#047857);color:white;">Aceptar</button>
    </div>
  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h4>Empresa</h4>
        <div class="footer-links">
          <a href="#acerca">Acerca de SkillMatch</a>
          <a href="#blog">Blog</a>
          <a href="#prensa">Prensa</a>
          <a href="#carreras">Carreras</a>
        </div>
      </div>
      <div class="footer-section">
        <h4>Servicio</h4>
        <div class="footer-links">
          <a href="#como-funciona">Cómo Funciona</a>
          <a href="#tarifas">Tarifas</a>
          <a href="#categorias">Categorías</a>
          <a href="#garantia">Garantía de Calidad</a>
        </div>
      </div>
      <div class="footer-section">
        <h4>Soporte</h4>
        <div class="footer-links">
          <a href="html/ayuda.php">Centro de Ayuda</a>
          <a href="#contacto">Contacto</a>
          <a href="#seguridad">Seguridad</a>
          <a href="#privacidad">Privacidad</a>
        </div>
      </div>
      <div class="footer-section">
        <h4>Conecta</h4>
        <div class="footer-links">
          <a href="#descarga">Descargar App</a>
          <a href="#newsletter">Newsletter</a>
          <a href="#comunidad">Comunidad</a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2024 SkillMatch. Todos los derechos reservados.</p>
      <div class="social-links">
        <a href="#facebook" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/skillmatch.sm/" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#twitter" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#linkedin" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </footer>

  <!-- JS: Modal Edit Perfil -->
  <script>
    document.querySelector('.btneditar').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.add('active');
    };
    document.getElementById('closeModalBtn').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.remove('active');
    };
    document.getElementById('saveBtn').onclick = function() {
      // Si querés feedback visual:
      // document.getElementById('notificationTitle').textContent = 'Perfil actualizado';
      // document.getElementById('notificationText').textContent = 'Tus datos fueron guardados correctamente.';
      // document.getElementById('notificationSuccess').style.display = 'flex';
      document.getElementById('editProfileModalOverlay').classList.remove('active');
    };
  </script>

  <!-- JS: Notificaciones (único y robusto) -->
  <script>
  (function(){
    const bell  = document.getElementById('notificationBell');
    const modal = document.getElementById('notificationModal');
    const closeBtn = document.getElementById('closeNotifications');
    const badge = document.getElementById('notifBadge');
    const listEl = modal ? modal.querySelector('.notification-list') : null;

    if (!bell || !modal || !closeBtn || !listEl) {
      console.warn('Notif UI incompleta: faltan nodos');
      return;
    }

    function escapeHtml(s){ return String(s||'').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
    function emptyState(title, desc){
      return `
        <div class="notification-empty" style="padding:18px;text-align:center;color:#6b7280;display:flex;flex-direction:column;align-items:center;gap:10px;">
          <div class="icon" style="width:56px;height:56px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:22px;color:#64748b;box-shadow:0 6px 18px rgba(15,23,42,0.04);">
            <i class="fas fa-inbox"></i>
          </div>
          <div class="title" style="font-weight:700;color:#374151;">${escapeHtml(title)}</div>
          <div class="desc" style="font-size:0.92rem;max-width:260px;line-height:1.3;color:#6b7280;">${escapeHtml(desc || 'No hay notificaciones por ahora.')}</div>
          <button class="btn-refresh" id="notifRefresh" style="margin-top:8px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:600;">Actualizar</button>
        </div>
      `;
    }
    function iconFor(type){
      if (type === 'reporte')      return { icon: 'fa-flag',           bg: 'linear-gradient(135deg,#ef4444,#b91c1c)' };
      if (type === 'solicitud')    return { icon: 'fa-file-signature', bg: 'linear-gradient(135deg,#0ea5e9,#0369a1)' };
      if (type === 'calificacion') return { icon: 'fa-star',           bg: 'linear-gradient(135deg,#f59e0b,#b45309)' };
      return { icon: 'fa-bell', bg: 'linear-gradient(135deg,#0eb27c,#047857)' };
    }

    async function markAsRead(id){
      try{
        const r = await fetch('../conexion/getNotifications.php?action=mark', {
          method:'POST',
          credentials:'same-origin',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:'id='+encodeURIComponent(id)
        });
        const j = await r.json();
        return !!j.success;
      }catch(e){ console.error('markAsRead', e); return false; }
    }

    async function loadNotifications(){
      try{
        const r = await fetch('../conexion/getNotifications.php?action=list', { credentials:'same-origin' });
        const j = await r.json();

        if (!j.success) {
          listEl.innerHTML = emptyState('Error al cargar', 'Reintentá en unos segundos.');
          document.getElementById('notifRefresh')?.addEventListener('click', loadNotifications);
          badge.style.display = 'none';
          badge.textContent = '';
          return;
        }

        const list = j.notifications || [];
        const unread = j.unread || 0;

        // Badge
        if (unread > 0) { badge.textContent = unread; badge.style.display = 'flex'; }
        else { badge.textContent = ''; badge.style.display = 'none'; }

        if (list.length === 0) {
          listEl.innerHTML = emptyState('Buzón vacío', 'No hay notificaciones nuevas.');
          document.getElementById('notifRefresh')?.addEventListener('click', loadNotifications);
          return;
        }

        listEl.innerHTML = '';
        list.forEach(n => {
          if (!['reporte','solicitud','calificacion','sistema'].includes(n.tipo)) return;

          const {icon, bg} = iconFor(n.tipo);
          const item = document.createElement('div');
          item.className = 'notification-item' + (Number(n.leida) === 0 ? ' unread' : '');
          item.innerHTML = `
            <div class="notification-icon" style="background:${bg}"><i class="fas ${icon}"></i></div>
            <div class="notification-content">
              <div class="notification-title">${escapeHtml(n.mensaje)}</div>
              <div class="notification-time">${new Date(n.fecha).toLocaleString()}</div>
            </div>`;

          item.addEventListener('click', async (e) => {
            e.stopPropagation();
            if (item.classList.contains('unread')) {
              const ok = await markAsRead(n.idnotificacion);
              if (ok) item.classList.remove('unread');
            }
            // Deep-links opcionales:
            // if (n.tipo === 'reporte')      location.href = '../vistas/admin/reports.php';
            // if (n.tipo === 'solicitud')    location.href = '../vistas/reservas.php';
            // if (n.tipo === 'calificacion') location.href = '../vistas/mis-calificaciones.php';
          });

          listEl.appendChild(item);
        });

      }catch(e){
        console.error('loadNotifications', e);
        listEl.innerHTML = emptyState('Error al cargar', 'No se pudieron cargar las notificaciones.');
        document.getElementById('notifRefresh')?.addEventListener('click', loadNotifications);
        badge.style.display = 'none';
        badge.textContent = '';
      }
    }

    // Toggle + stopPropagation
    bell.addEventListener('click', async (e) => {
      e.stopPropagation();
      modal.classList.toggle('active');
      if (modal.classList.contains('active')) await loadNotifications();
    });
    modal.addEventListener('click', (e) => e.stopPropagation());
    closeBtn.addEventListener('click', (e) => { e.stopPropagation(); modal.classList.remove('active'); });
    document.addEventListener('click', () => modal.classList.remove('active'));

    // Cargar badge inicial
    (async function initBadge(){
      try{
        const r = await fetch('../conexion/getNotifications.php?action=list', { credentials:'same-origin' });
        const j = await r.json();
        if (j.success && (j.unread||0) > 0) { badge.textContent = j.unread; badge.style.display = 'flex'; }
        else { badge.textContent = ''; badge.style.display = 'none'; }
      }catch{
        badge.textContent = ''; badge.style.display = 'none';
      }
    })();

    // Poll badge + refresh si abierto
    setInterval(async () => {
      try{
        const r = await fetch('../conexion/getNotifications.php?action=list', { credentials:'same-origin' });
        const j = await r.json();
        if (!j.success) return;
        const u = j.unread || 0;
        if (u > 0) { badge.textContent = u; badge.style.display = 'flex'; }
        else { badge.textContent = ''; badge.style.display = 'none'; }
        if (modal.classList.contains('active')) loadNotifications();
      }catch{}
    }, 45000);
  })();
  </script>

  <!-- JS: Payload hash (nombre/email) opcional -->
  <script>
    (function(){
      const hash = window.location.hash.substring(1);
      if (!hash) return;
      const params = new URLSearchParams(hash);
      const d = params.get('d');
      if (!d) return;
      try {
        const obj = JSON.parse(decodeURIComponent(d));
        const nombreEl = document.querySelector('.nombre-usuario');
        const correoEl = document.querySelector('.gmail');
        if (nombreEl && obj.nombre) nombreEl.textContent = obj.nombre;
        if (correoEl && obj.email)  correoEl.textContent = obj.email;
      } catch (e) { console.error("Payload inválido", e); }
    })();
  </script>
  <script>
// Confirmación para eliminar desde el modal de perfil (proveedor)
(function(){
  const form = document.querySelector('#editProfileModalOverlay form');
  const deleteBtn = document.getElementById('deleteBtn');
  if (!form || !deleteBtn) return;

  deleteBtn.addEventListener('click', function(e){
    const ok = confirm('¿Seguro que querés eliminar tu cuenta? Esta acción no se puede deshacer.');
    if (!ok) {
      e.preventDefault();
      return;
    }
    // Evitar doble submit por si se clickea muchas veces
    deleteBtn.disabled = true;
    deleteBtn.textContent = 'Eliminando...';
  });
})();
</script>

</body>
</html>
