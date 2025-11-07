<?php require_once('../conexion/guards/auth_guard.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar Servicio | SkillMatch</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background: #f5f5f5;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Header */
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
  text-decoration: none;
  display: inline-block;
}

.header-icon:hover {
  transform: scale(1.2) rotate(5deg);
  filter: brightness(1.2);
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


/* Main Content */
.main-content {
  flex: 1;
  padding: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.request-container {
  background: white;
  border-radius: 24px;
  box-shadow: 0 4px 40px rgba(0, 0, 0, 0.12), 0 10px 80px rgba(0, 0, 0, 0.08);
  max-width: 900px;
  width: 100%;
  overflow: hidden;
  display: grid;
  grid-template-columns: 380px 1fr;
}

.left-panel {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  padding: 2.5rem;
  color: white;
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.logo-section h1 {
  font-size: 1.6rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.logo-section p {
  opacity: 0.9;
  font-size: 0.95rem;
}

.calendar-container {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid rgba(255,255,255,0.2);
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.2rem;
}

.calendar-header h3 {
  font-size: 1.1rem;
  font-weight: 600;
}

.calendar-nav {
  display: flex;
  gap: 0.5rem;
}

.calendar-nav button {
  background: rgba(255,255,255,0.2);
  border: none;
  color: white;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.calendar-nav button:hover {
  background: rgba(255,255,255,0.3);
}

.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 0.4rem;
  margin-bottom: 0.5rem;
}

.calendar-weekdays span {
  text-align: center;
  font-size: 0.75rem;
  opacity: 0.8;
  font-weight: 600;
}

.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 0.4rem;
}

.calendar-day {
  aspect-ratio: 1;
  border: none;
  background: rgba(255,255,255,0.1);
  color: white;
  border-radius: 10px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.calendar-day:hover:not(.disabled):not(.other-month) {
  background: rgba(255,255,255,0.25);
  transform: scale(1.05);
}

.calendar-day.selected {
  background: white;
  color: #10b981;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.calendar-day.disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.calendar-day.other-month {
  opacity: 0.4;
}

.selected-date-display {
  background: rgba(255,255,255,0.2);
  padding: 1rem;
  border-radius: 12px;
  text-align: center;
  margin-top: 1rem;
  border: 1px solid rgba(255,255,255,0.3);
}

.selected-date-display i {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.selected-date-display p {
  font-size: 0.9rem;
  opacity: 0.9;
}

.selected-date-display strong {
  font-size: 1.1rem;
  display: block;
  margin-top: 0.3rem;
}

.right-panel {
  padding: 2.5rem;
  background: white;
  display: flex;
  flex-direction: column;
}

.form-header {
  margin-bottom: 2rem;
}

.form-header h2 {
  font-size: 1.6rem;
  color: #0a3d62;
  margin-bottom: 0.5rem;
}

.form-header p {
  color: #6c757d;
  font-size: 0.9rem;
}

.form-grid {
  display: flex;
  flex-direction: column;
  gap: 1.3rem;
  flex: 1;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 600;
  color: #333;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.form-group label i {
  color: #10b981;
  font-size: 0.95rem;
}

.form-control {
  width: 100%;
  padding: 0.85rem 1rem;
  border: 2px solid #e1e4e8;
  border-radius: 12px;
  font-size: 0.95rem;
  font-family: inherit;
  transition: all 0.3s ease;
  background: #fafbfc;
}

.form-control:focus {
  outline: none;
  border-color: #10b981;
  background: white;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

textarea.form-control {
  resize: vertical;
  min-height: 90px;
}

.submit-btn {
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  border: none;
  padding: 1rem 2rem;
  font-size: 1.05rem;
  font-weight: 600;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
  margin-top: auto;
}

.submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
}

.submit-btn:active {
  transform: translateY(0);
}

.submit-btn i {
  font-size: 1.1rem;
}

/* Footer */
footer {
  background: linear-gradient(135deg, #064e3b 0%, #025939 50%, #0eb27c 100%);
  color: white;
  padding: 3rem 2rem 2rem;
  margin-top: 3rem;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-section h4 {
  font-size: 1.1rem;
  margin-bottom: 1rem;
  font-weight: 700;
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}

.footer-links a {
  color: rgba(255,255,255,0.8);
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.footer-links a:hover {
  color: white;
  padding-left: 0.5rem;
}

.footer-bottom {
  text-align: center;
  border-top: 1px solid rgba(255,255,255,0.2);
  padding-top: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.social-links {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.social-icon {
  width: 45px;
  height: 45px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-icon:hover {
  background: white;
  color: #0eb27c;
  transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 900px) {
  .request-container {
    grid-template-columns: 1fr;
    max-width: 500px;
  }

  .left-panel {
    padding: 2rem;
  }
}

@media (max-width: 600px) {
  .main-content {
    padding: 1rem;
  }

  .right-panel,
  .left-panel {
    padding: 1.5rem;
  }

  .footer-content {
    grid-template-columns: 1fr;
    gap: 30px;
  }

  header {
    padding: 1rem;
  }

  .header-logo {
    font-size: 1.4rem;
  }

  .header-actions {
    gap: 1rem;
  }

  .notification-modal {
    width: 300px;
    right: 0;
  }
}
  </style>
</head>
<body>
  <header>
    <div class="header-logo">
      <a href="../vistas/vistas-cliente.php" style="text-decoration: none; color: white; display: flex; align-items: center;">
        <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
        SkillMatch
      </a>
    </div>
    <div class="header-actions">
      <div style="position: relative;">
      <a href="perfil-cliente.php" class="header-icon" style="text-decoration: none; color: white;">
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
              <button type="button" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
              <button type="button" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
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

        <form class="form-grid" id="formReserva">
  <input type="hidden" id="fechaSeleccionada" name="fecha" required>

  <div class="form-group">
    <label for="nombre"><i class="fas fa-user"></i> Nombre completo</label>
    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Juan Pérez" required>
  </div>

  <div class="form-group">
    <label for="email"><i class="fas fa-envelope"></i> Correo electrónico</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="juan@ejemplo.com" required>
  </div>

  <div class="form-group">
    <label><i class="fas fa-clock"></i> Seleccioná horario disponible</label>
    <div style="display:flex; flex-wrap:wrap; gap:10px;">
      <label><input type="radio" name="hora" value="10:00:00" required> 10:00</label>
      <label><input type="radio" name="hora" value="12:00:00"> 12:00</label>
      <label><input type="radio" name="hora" value="15:00:00"> 15:00</label>
      <label><input type="radio" name="hora" value="18:00:00"> 18:00</label>
    </div>
  </div>

  <button type="submit" class="submit-btn">
    <i class="fas fa-check-circle"></i> Confirmar Reserva
  </button>
</form>

      </div>
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
                    <a href="#ayuda">Centro de Ayuda</a>
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
                <a href="#facebook" class="social-icon" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/skillmatch.sm/" class="social-icon" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#twitter" class="social-icon" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#linkedin" class="social-icon" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
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
      
      monthYear.textContent = monthNames[month] + ' ' + year;
      
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
      today.setHours(0, 0, 0, 0);
      
      for (let day = 1; day <= daysInMonth; day++) {
        const dayBtn = document.createElement('button');
        dayBtn.className = 'calendar-day';
        dayBtn.textContent = day;
        dayBtn.type = 'button';
        
        const currentDateCheck = new Date(year, month, day);
        currentDateCheck.setHours(0, 0, 0, 0);
        
        if (currentDateCheck < today) {
          dayBtn.classList.add('disabled');
        } else {
          dayBtn.onclick = function() {
            selectDate(year, month, day);
          };
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

    let idservicio = <?php echo $_GET['idservicio'] ?? 'null'; ?>;
    let reservasExistentes = [];

    // Cargar reservas existentes al iniciar
    function cargarReservasExistentes() {
        if (!idservicio) return;
        
        fetch('../conexion/controllerReserva.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=obtener_reservas&idservicio=${idservicio}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                reservasExistentes = data.reservas;
                renderCalendar(); // Volver a renderizar el calendario
            }
        });
    }

    // Modificar la función selectDate
    function selectDate(year, month, day) {
        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        
        // Verificar si la fecha está reservada
        const reservada = reservasExistentes.some(r => r.fecha === dateString);
        if (reservada) {
            alert('Esta fecha ya está reservada');
            return;
        }
        
        selectedDate = new Date(year, month, day);
        const formattedDate = day + ' de ' + monthNames[month] + ' de ' + year;
        selectedDateText.textContent = formattedDate;
        
        const dateForPHP = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
        fechaSeleccionadaInput.value = dateForPHP;
        
        renderCalendar();
    }

    prevMonthBtn.onclick = function() {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    };

    nextMonthBtn.onclick = function() {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    };

    document.getElementById('formReserva').onsubmit = function(e) {
      e.preventDefault();

      const horaSeleccionada = document.querySelector('input[name="hora"]:checked');
      if (!selectedDate || !horaSeleccionada || !idservicio) {
        alert('Seleccioná una fecha, una hora y asegurate de que el servicio sea válido.');
        return;
      }

      fetch('../conexion/controllerReserva.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
          'action': 'crear_reserva',
          'idservicio': idservicio,
          'fecha': fechaSeleccionadaInput.value,
          'hora': horaSeleccionada.value
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('✅ Reserva creada exitosamente');
          window.location.href = 'perfil-cliente.php';
        } else {
          alert('❌ Error al crear la reserva: ' + (data.error || 'Error desconocido'));
        }
      })
      .catch(err => alert('Error de conexión con el servidor'));
    };


    // Cargar reservas al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        cargarReservasExistentes();
    });

    renderCalendar();
  </script>

  <script>
    const notificationBell = document.getElementById('notificationBell');
    const notificationModal = document.getElementById('notificationModal');
    const closeNotifications = document.getElementById('closeNotifications');

    notificationBell.onclick = function() {
      notificationModal.classList.toggle('active');
    };

    closeNotifications.onclick = function() {
      notificationModal.classList.remove('active');
    };

    document.onclick = function(e) {
      if (!notificationBell.contains(e.target) && !notificationModal.contains(e.target)) {
        notificationModal.classList.remove('active');
      }
    };
  </script>
</body>
</html>