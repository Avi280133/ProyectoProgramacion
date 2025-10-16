<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar Servicio | SkillMatch</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/soli.css">
</head>
<body>
  <!-- Header -->
  <header>
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

  <div class="main-content">
    <div class="request-container">
      <div class="left-panel">
        <div class="logo-section">
          <h1>📅 Reservá tu cita</h1>
          <p>Elegí el día que mejor te convenga</p>
        </div>

        <div class="calendar-container">
          <div class="calendar-header">
            <h3 id="monthYear">Octubre 2025</h3>
            <div class="calendar-nav">
              <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
              <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>

          <div class="calendar-weekdays">
            <span>D</span>
            <span>L</span>
            <span>M</span>
            <span>M</span>
            <span>J</span>
            <span>V</span>
            <span>S</span>
          </div>

          <div class="calendar-days" id="calendarDays"></div>

          <div class="selected-date-display" id="selectedDateDisplay">
            <i class="fas fa-calendar-check"></i>
            <p>Fecha seleccionada</p>
            <strong id="selectedDateText">Elegí una fecha</strong>
          </div>
        </div>
      </div>

      <div class="right-panel">
        <div class="form-header">
          <h2>Tus datos</h2>
          <p>Completá tu información para confirmar la reserva</p>
        </div>

        <form class="form-grid" action="#" method="POST">
          <input type="hidden" id="fechaSeleccionada" name="fecha" required>

          <div class="form-group">
            <label for="nombre">
              <i class="fas fa-user"></i>
              Nombre completo
            </label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Juan Pérez" required>
          </div>

          <div class="form-group">
            <label for="email">
              <i class="fas fa-envelope"></i>
              Correo electrónico
            </label>
            <input type="email" id="email" name="email" class="form-control" placeholder="juan@ejemplo.com" required>
          </div>

          <div class="form-group">
            <label for="detalles">
              <i class="fas fa-comment-dots"></i>
              Detalles adicionales
            </label>
            <textarea id="detalles" name="detalles" class="form-control" placeholder="Contanos más sobre el servicio que necesitás..."></textarea>
          </div>

          <button type="submit" class="submit-btn">
            <i class="fas fa-check-circle"></i>
            Confirmar Reserva
          </button>
        </form>
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
    const monthYear = document.getElementById('monthYear');
    const calendarDays = document.getElementById('calendarDays');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const selectedDateText = document.getElementById('selectedDateText');
    const fechaSeleccionadaInput = document.getElementById('fechaSeleccionada');

    let currentDate = new Date();
    let selectedDate = null;

    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();
      
      monthYear.textContent = `${monthNames[month]} ${year}`;
      
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const daysInPrevMonth = new Date(year, month, 0).getDate();
      
      calendarDays.innerHTML = '';
      
      for (let i = firstDay - 1; i >= 0; i--) {
        const dayBtn = document.createElement('button');
        dayBtn.className = 'calendar-day other-month';
        dayBtn.textContent = daysInPrevMonth - i;
        dayBtn.type = 'button';
        calendarDays.appendChild(dayBtn);
      }
      
      const today = new Date();
      for (let day = 1; day <= daysInMonth; day++) {
        const dayBtn = document.createElement('button');
        dayBtn.className = 'calendar-day';
        dayBtn.textContent = day;
        dayBtn.type = 'button';
        
        const currentDateCheck = new Date(year, month, day);
        if (currentDateCheck < today.setHours(0, 0, 0, 0)) {
          dayBtn.classList.add('disabled');
        } else {
          dayBtn.addEventListener('click', () => selectDate(year, month, day));
        }
        
        if (selectedDate && 
            selectedDate.getDate() === day && 
            selectedDate.getMonth() === month && 
            selectedDate.getFullYear() === year) {
          dayBtn.classList.add('selected');
        }
        
        calendarDays.appendChild(dayBtn);
      }
      
      const totalCells = calendarDays.children.length;
      const remainingCells = 35 - totalCells;
      for (let i = 1; i <= remainingCells; i++) {
        const dayBtn = document.createElement('button');
        dayBtn.className = 'calendar-day other-month';
        dayBtn.textContent = i;
        dayBtn.type = 'button';
        calendarDays.appendChild(dayBtn);
      }
    }

    function selectDate(year, month, day) {
      selectedDate = new Date(year, month, day);
      const formattedDate = `${day} de ${monthNames[month]} de ${year}`;
      selectedDateText.textContent = formattedDate;
      fechaSeleccionadaInput.value = selectedDate.toISOString().split('T')[0];
      renderCalendar();
    }

    prevMonthBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });

    document.querySelector('form').addEventListener('submit', (e) => {
      if (!selectedDate) {
        e.preventDefault();
        alert('Por favor, seleccioná una fecha en el calendario');
      }
    });

    renderCalendar();
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
</body>
</html>