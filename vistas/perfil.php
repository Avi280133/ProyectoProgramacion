<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil de Usuario</title>
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

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

.header-actions {
  display: flex !important;
  gap: 2rem !important;
  align-items: center !important;
}

.header-icon {
  color: white !important;
  font-size: 1.3rem !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  position: relative !important;
  text-decoration: none !important;
  display: inline-block !important;
}

.header-icon:hover {
  transform: scale(1.2) rotate(5deg) !important;
  filter: brightness(1.2) !important;
}

/* Notification Modal */
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
  opacity: 1;
  visibility: visible;
  transform: translateY(0) scale(1);
}

.notification-header {
  padding: 1.5rem;
  border-bottom: 2px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.notification-header h3 {
  color: #2c3e50;
  font-size: 1.2rem;
}

.notification-list {
  padding: 0;
}

.notification-item {
  padding: 1.2rem 1.5rem;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  gap: 1rem;
  transition: all 0.2s ease;
  cursor: pointer;
}

.notification-item:hover {
  background: #f8f9fa;
  padding-left: 2rem;
}

.notification-item.unread {
  background: linear-gradient(135deg, #e8f5f1 0%, #d1f0e5 100%);
}

.notification-icon {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  flex-shrink: 0;
  font-size: 1.2rem;
}

.notification-content {
  flex: 1;
}

.notification-title {
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 0.3rem;
  font-size: 0.95rem;
}

.notification-text {
  color: #7f8c8d;
  font-size: 0.85rem;
  line-height: 1.4;
}

.notification-time {
  color: #95a5a6;
  font-size: 0.75rem;
  margin-top: 0.5rem;
}

/* ===== CONTENIDO PERFIL ===== */
.contenedor {
  flex: 1;
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0;
}

.perfil {
  border: 3px solid #aec3bb;
  border-radius: 20px;
  padding: 50px;
  width: 700px;
  background-color: #fbfcfa;
  text-align: center;
  box-shadow: 0 6px 16px rgba(27, 81, 16, 0.548);
}

.redonda {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
  border: 3px solid #025939;
}

.nombre-usuario {
  font-size: 22px;
  margin: 10px 0 5px;
  color: #333;
}

.gmail {
  color: #000000;
  margin-bottom: 20px;
}

.botones {
  display: flex;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}

.btneditar, .btncerrar {
  padding: 10px 18px;
  border: none;
  border-radius: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btneditar {
  background-color: #11be7f;
  color: #fcfdfb;
}

.btneditar:hover {
  background-color: #025939;
}

.btncerrar {
  background-color: #c6c9b9;
  color: #333;
  text-decoration: none;
  display: inline-block;
}

.btncerrar:hover {
  background-color: #999;
  color: #c6c9b9;
}

/* ===== MODAL EDIT ===== */
.modal-overlay-edit {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  transition: all 0.3s ease;
}

.modal-overlay-edit.active {
  display: flex;
}

.modal-edit {
  background: #fff;
  border-radius: 20px;
  padding: 40px;
  width: 90%;
  max-width: 800px;
  position: relative;
  border: 3px solid #26e0a3;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  transform: translateY(-30px);
  transition: transform 0.3s ease;
  z-index: 2001;
}

.modal-overlay-edit.active .modal-edit {
  transform: translateY(0);
}

.modal-header-edit {
  text-align: center;
  margin-bottom: 30px;
}

.modal-title-edit {
  font-size: 32px;
  font-weight: bold;
  color: #26e0a3;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.close-btn-edit {
  position: absolute;
  top: 20px;
  right: 25px;
  background: none;
  border: none;
  font-size: 30px;
  color: #26e0a3;
  cursor: pointer;
  padding: 5px;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn-edit:hover {
  background: #26e0a3;
  color: #f9fffd;
  transform: rotate(90deg);
}

.modal-content-edit {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 40px;
  align-items: start;
  background: transparent;
  z-index: 2002;
}

.form-section-edit {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.form-group-edit {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-label-edit {
  font-size: 18px;
  font-weight: 600;
  color: #374151;
}

.form-input-edit, .form-select-edit, .form-textarea-edit {
  padding: 12px 16px;
  border: 2px solid #26e0a3;
  border-radius: 12px;
  font-size: 16px;
  transition: all 0.2s ease;
  background: #f9fffd;
}

.form-input-edit:focus, .form-select-edit:focus, .form-textarea-edit:focus {
  outline: none;
  border-color: #1fb087;
  box-shadow: 0 0 0 3px rgba(38, 224, 163, 0.1);
}

.form-input-edit:disabled {
  background: #f0f9ff;
  color: #6b7280;
  cursor: not-allowed;
}

.form-select-edit {
  cursor: pointer;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2326e0a3' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 20px;
  padding-right: 45px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

.form-textarea-edit {
  resize: vertical;
  min-height: 120px;
  font-family: inherit;
}

.profile-section-edit {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.profile-photo-container-edit {
  position: relative;
  width: 180px;
  height: 180px;
  border: 4px solid #26e0a3;
  border-radius: 50%;
  background: #f9fffd;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  overflow: hidden;
}

.profile-photo-container-edit:hover {
  border-color: #1fb087;
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(38, 224, 163, 0.3);
}

.profile-photo-container-edit input[type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 2;
}

.upload-overlay-edit {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(38, 224, 163, 0.8);
  border-radius: 50%;
  display: none;
  align-items: center;
  justify-content: center;
  transition: opacity 0.3s ease;
}

.profile-photo-container-edit:hover .upload-overlay-edit {
  display: flex;
  opacity: 1;
}

.upload-icon-edit {
  font-size: 30px;
  color: #f9fffd;
}

.profile-inputs-edit {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.save-btn-edit {
  background: linear-gradient(135deg, #26e0a3 0%, #1fb087 100%);
  color: #f9fffd;
  border: none;
  padding: 15px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  width: 100%;
  margin-bottom: 0px;
}

.save-btn-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(38, 224, 163, 0.4);
}

.save-btn-edit:active {
  transform: translateY(0);
}

.delete-btn-edit {
  background: linear-gradient(135deg, #e6344a 0%, #b8001c 100%);
  color: #f9fffd;
  border: none;
  padding: 15px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  width: 100%;
  margin-top: 1px;
}

.delete-btn-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(230, 52, 74, 0.4);
}

.delete-btn-edit:active {
  transform: translateY(0);
}

/* ===== FOOTER ===== */
.footer {
  background: linear-gradient(135deg, #059669 0%, #10b981 100%);
  padding: 3rem 2rem;
  color: white;
  margin-top: auto;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
}

.footer-section h3 {
  margin-bottom: 20px;
  font-size: 1.3rem;
}

.footer-section p {
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
}

.footer-section a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  display: block;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}

.footer-section a:hover {
  color: white;
  transform: translateX(5px);
}

.social-icons {
  display: flex;
  gap: 15px;
  margin-top: 15px;
}

.social-icon {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  color: white;
  text-decoration: none;
}

.social-icon:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-3px);
}

.footer-bottom {
  text-align: center;
  margin-top: 40px;
  padding-top: 30px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.7);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .modal-edit {
    padding: 25px;
    width: 95%;
  }

  .modal-content-edit {
    grid-template-columns: 1fr;
    gap: 25px;
  }

  .modal-title-edit {
    font-size: 24px;
  }

  .profile-section-edit {
    order: -1;
  }

  .profile-photo-container-edit {
    width: 150px;
    height: 150px;
  }
}

@media (max-width: 600px) {
  .header-nuevo {
    padding: 1rem !important;
  </style>
  
</head>
<body>
  <!-- Header -->
  <header class="header-nuevo">
    <div class="header-logo">
      <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
      SkillMatch
    </div>
    <div class="header-actions">
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
          <div class="notification-list">
            <div class="notification-item unread">
              <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Trabajo aceptado</div>
                <div class="notification-text">Tu solicitud de reparación del hogar fue aceptada por Juan M.</div>
                <div class="notification-time">Hace 2 horas</div>
              </div>
            </div>

            <div class="notification-item unread">
              <div class="notification-icon" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                <i class="fas fa-star"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Nueva reseña</div>
                <div class="notification-text">Carlos P. dejó una reseña de 5 estrellas para tu servicio</div>
                <div class="notification-time">Hace 5 horas</div>
              </div>
            </div>

            <div class="notification-item">
              <div class="notification-icon" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                <i class="fas fa-info-circle"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Recordatorio</div>
                <div class="notification-text">Tu servicio de desarrollo web está próximo a completarse</div>
                <div class="notification-time">Hace 1 día</div>
              </div>
            </div>

            <div class="notification-item">
              <div class="notification-icon" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);">
                <i class="fas fa-user-check"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Perfil verificado</div>
                <div class="notification-text">Tu identidad ha sido verificada exitosamente</div>
                <div class="notification-time">Hace 2 días</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a href="perfil.php" class="header-icon" style="text-decoration: none; color: white;">
        <i class="fas fa-user"></i>
      </a>
    </div>
  </header>

  <div class="contenedor">
    <div class="perfil">
      <!-- Foto de perfil -->
      <img src="../img/<?php echo htmlspecialchars($usuario['fotoperfil'] ?? 'mujercita.jpeg'); ?>" 
           alt="Foto de perfil" class="redonda" />

      <!-- Nombre y correo -->
      <h2 class="nombre-usuario"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h2>
      <p class="gmail"><?php echo htmlspecialchars($usuario['email']); ?></p>

      <!-- Username y Edad -->
      <p>Username: <?php echo htmlspecialchars($usuario['username']); ?></p>
      <p>Edad: <?php echo htmlspecialchars($usuario['edad']); ?></p>

      <div class="botones">
        <button class="btneditar">Editar perfil</button>
        <a href="registro.html" class="btncerrar">Cerrar Sesion</a>
      </div>
    </div>
  </div>

  <div class="modal-overlay-edit" id="editProfileModalOverlay">
    <div class="modal-edit">
      <div class="modal-header-edit">
        <h2 class="modal-title-edit">Editar Perfil</h2>
        <button class="close-btn-edit" id="closeModalBtn">×</button>
      </div>

      <div class="modal-content-edit">
        <div class="form-section-edit">
          <div class="form-group-edit">
            <label class="form-label-edit">Localidad</label>
            <select class="form-select-edit" id="locationSelect">
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
            <textarea class="form-textarea-edit" id="skillsTextarea" placeholder="Describe tus principales habilidades y competencias..."></textarea>
          </div>

          <div class="form-group-edit">
            <label class="form-label-edit">Experiencia</label>
            <textarea class="form-textarea-edit" id="experienceTextarea" placeholder="Cuéntanos sobre tu experiencia profesional..."></textarea>
          </div>
        </div>

        <div class="profile-section-edit">
          <div class="profile-photo-container-edit" id="photoContainer">
            <div class="upload-overlay-edit">
              <i class="fa-solid fa-image upload-icon-edit"></i>
            </div>
            <input type="file" id="photoInput" accept="image/*">
          </div>

          <div class="profile-inputs-edit">
            <input type="text" class="form-input-edit" id="nameInput" placeholder="Alexandra Gim" value="Alexandra Gim" disabled>
            <input type="text" class="form-input-edit" id="usernameInput" placeholder="username" value="username">
          </div>

          <button class="save-btn-edit" id="saveBtn">Guardar</button>
          <button class="delete-btn-edit" id="deleteBtn">Eliminar Usuario</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>SkillMatch</h3>
        <p>La plataforma líder que conecta profesionales con clientes. Publica tus servicios y encuentra oportunidades.</p>
        <div class="social-icons">
          <a href="#" class="social-icon">
            <i class="fa-brands fa-facebook-f"></i>
          </a>
          <a href="#" class="social-icon">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="#" class="social-icon">
            <i class="fa-brands fa-twitter"></i>
          </a>
          <a href="#" class="social-icon">
            <i class="fa-brands fa-linkedin-in"></i>
          </a>
        </div>
      </div>

      <div class="footer-section">
        <h3>Para Proveedores</h3>
        <a href="#">Publicar Servicio</a>
        <a href="#">Mis Servicios</a>
        <a href="#">Estadísticas</a>
        <a href="#">Mensajes</a>
        <a href="#">Mi Perfil</a>
      </div>

      <div class="footer-section">
        <h3>Para Clientes</h3>
        <a href="#">Buscar Servicios</a>
        <a href="#">Categorías</a>
        <a href="#">Mis Favoritos</a>
        <a href="#">Historial</a>
      </div>

      <div class="footer-section">
        <h3>Soporte</h3>
        <a href="#">Centro de Ayuda</a>
        <a href="#">Políticas de Seguridad</a>
        <a href="#">Términos y Condiciones</a>
        <a href="#">Contáctanos</a>
        <a href="#">Acerca de Nosotros</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 SkillMatch. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    document.querySelector('.btneditar').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.add('active');
    };
    document.getElementById('closeModalBtn').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.remove('active');
    };
  </script>

  <script>
    const notificationBell = document.getElementById('notificationBell');
    const notificationModal = document.getElementById('notificationModal');
    const closeNotifications = document.getElementById('closeNotifications');

    notificationBell.addEventListener('click', () => {
      notificationModal.classList.toggle('active');
    });

    closeNotifications.addEventListener('click', () => {
      notificationModal.classList.remove('active');
    });

    // Cerrar modal al hacer click afuera
    document.addEventListener('click', (e) => {
      if (!notificationBell.contains(e.target) && !notificationModal.contains(e.target)) {
        notificationModal.classList.remove('active');
      }
    });
  </script>

  <script>
    (function(){
      // Lee el fragmento de la URL después de #
      const hash = window.location.hash.substring(1); // quita el "#"
      const params = new URLSearchParams(hash);
      const d = params.get('d');
      if (!d) return;

      try {
        // Decodificar lo que mandó PHP con urlencode
        const obj = JSON.parse(decodeURIComponent(d));

        // Actualizar el DOM
        const nombreEl = document.querySelector('.nombre-usuario');
        const correoEl = document.querySelector('.gmail');

        if (nombreEl) nombreEl.textContent = obj.nombre || '';
        if (correoEl) correoEl.textContent = obj.email || '';
      } catch (e) {
        console.error("Payload inválido", e);
      }
    })();
  </script>
</body>
</html>