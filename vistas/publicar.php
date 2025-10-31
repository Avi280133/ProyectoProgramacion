<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Solicitud | ServiciosPro</title>
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <link rel="conexion" href="../conexion/controllerPublicacion.php">
   <style>
    * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: #c6c9b9;
            font-family: "Abel", sans-serif;
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

        /* Sección principal del formulario */
.seccion-formulario-solicitud {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 60px 20px;
    min-height: calc(100vh - 200px);
}

/* Contenedor del formulario */
.contenedor-formulario {
    max-width: 700px;
    margin: 0 auto;
    background: white;
    border-radius: 25px;
    padding: 50px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.contenedor-formulario:hover {
    box-shadow: 0 15px 50px rgba(14, 178, 124, 0.15);
}

/* Título del formulario */
.titulo-formulario {
    font-size: 2.5rem;
    color: #025939;
    text-align: center;
    margin-bottom: 40px;
    font-weight: 700;
    position: relative;
    padding-bottom: 20px;
}

.titulo-formulario::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
    border-radius: 2px;
}

/* Formulario */
.formulario-servicio {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Etiquetas */
.etiqueta-campo {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    display: block;
}

/* Campos del formulario */
.campo-formulario {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e1e5e9;
    border-radius: 12px;
    font-size: 1rem;
    font-family: "Abel", sans-serif;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.campo-formulario:focus {
    outline: none;
    border-color: #0eb27c;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(14, 178, 124, 0.1);
}

.campo-formulario:hover {
    border-color: #0eb27c;
    background-color: white;
}

/* Select específico */
select.campo-formulario {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230eb27c' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 45px;
}

/* Textarea */
textarea.campo-formulario {
    resize: vertical;
    min-height: 120px;
    font-family: "Abel", sans-serif;
}

/* Contenedor de imagen */
.imagen-equipo {
    padding: 25px;
    border: 2px dashed #0eb27c;
    border-radius: 12px;
    background: linear-gradient(135deg, #e8f5f1 0%, #d1f0e5 100%);
    text-align: center;
    transition: all 0.3s ease;
}

.imagen-equipo:hover {
    border-color: #025939;
    background: linear-gradient(135deg, #d1f0e5 0%, #c1ead9 100%);
    transform: translateY(-2px);
}

.imagen-equipo input[type="file"] {
    font-family: "Abel", sans-serif;
    cursor: pointer;
    padding: 8px;
}

.imagen-equipo input[type="file"]::file-selector-button {
    background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: "Abel", sans-serif;
}

.imagen-equipo input[type="file"]::file-selector-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
}

/* Contenedor de precio */
.form-group {
    margin-bottom: 0;
}

.price-input-container {
    position: relative;
}

.price-symbol {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #0eb27c;
    font-weight: 700;
    font-size: 1.2rem;
    pointer-events: none;
    z-index: 1;
}

.price-input {
    width: 100%;
    padding: 15px 20px;
    padding-left: 45px !important;
    border: 2px solid #e1e5e9;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
    font-family: "Abel", sans-serif;
}

.price-input:focus {
    outline: none;
    border-color: #0eb27c;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(14, 178, 124, 0.1);
}

.price-input:hover {
    border-color: #0eb27c;
    background-color: white;
}

/* Botón de envío */
.boton-enviar-formulario {
    background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
    color: white;
    border: none;
    padding: 18px 40px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 20px;
    box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
    font-family: "Abel", sans-serif;
}

.boton-enviar-formulario:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(14, 178, 124, 0.4);
}

.boton-enviar-formulario:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .contenedor-formulario {
        padding: 30px 20px;
        border-radius: 15px;
    }

    .titulo-formulario {
        font-size: 2rem;
    }

    .formulario-servicio {
        gap: 20px;
    }

    .boton-enviar-formulario {
        padding: 15px 30px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .seccion-formulario-solicitud {
        padding: 30px 10px;
    }

    .contenedor-formulario {
        padding: 25px 15px;
    }

    .titulo-formulario {
        font-size: 1.6rem;
    }
}

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

        .category-card-hover {
            border: 2px solid transparent;
        }

        .category-card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(14, 178, 124, 0.2) !important;
            border-color: #0eb27c;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
            }
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

            <div class="header-icon">
                <a href="perfil.php" style="color: inherit; text-decoration: none;">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </header>
  <!-- Sección del formulario de solicitud -->
  <main class="seccion-formulario-solicitud">
    <div class="contenedor-formulario">
      <h2 class="titulo-formulario">Publicá tu Servicio</h2>
      
      <form action="../conexion/controllerPublicacion.php" method="POST" class="formulario-servicio">

        <label for="titulo" class="etiqueta-campo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Titulo"  class="campo-formulario" required>

        <label for="ubicacion" class="etiqueta-campo">Ubicacion:</label>
        <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicacion"  class="campo-formulario" required>

        <label for="servicio" class="etiqueta-campo">Categoria del servicio:</label>
        <select id="servicio" name="servicio" class="campo-formulario" >
          <option value="">--Seleccioná--</option>
          <option value="Soporte Técnico">Soporte Técnico</option>
          <option value="Mantenimiento">Mantenimiento</option>
          <option value="Consultoría">Consultoría</option>
          <option value="Consultoría">Limpieza</option>
          <option value="Consultoría">Contruccion</option>
          <option value="Consultoría">Otro</option>
        </select>
        <label for="servicio" class="etiqueta-campo">Inserte imagenes</label>
        <div class="imagen-equipo">
          <input type="file" id="imagen" name="imagen" value="imagen" accept="image/*">
        </div>

        <label for="descripcion" class="etiqueta-campo">Descripción del servicio:</label>
        <textarea id="descripcion" name="descripcion" rows="5" class="campo-formulario" required></textarea>

          <label for="precio" class="etiqueta-campo">Precio del servicio:</label>
          <div class="form-group price-input-container">
            <span class="price-symbol">$</span>
            <input type="text" id="precio" name="precio" class="price-input" placeholder="0.00" pattern="[0-9]+(\.[0-9]{1,2})?" title="Ingresa un precio válido">
        <!--    <style>
              .form-group {
                margin-bottom: 24px;
              }

              label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #333;
                font-size: 14px;
              }

              .price-input-container {
                position: relative;
              }

              .price-symbol {
                  position: absolute;
                  left: 16px;
                  top: 50%;
                  transform: translateY(-50%);
                  color: #6c757d;
                  font-weight: 500;
                  font-size: 16px;
                  pointer-events: none;
                  z-index: 1;
              }

              .price-input {
                  width: 100%;
                  padding: 12px 16px;
                  padding-left: 35px !important;
                  border: 2px solid #e1e5e9;
                  border-radius: 8px;
                  font-size: 16px;
                  font-weight: 500;
                  background-color: #fff;
                  transition: border-color 0.2s ease, box-shadow 0.2s ease;
                  font-family: inherit;
              }

              .price-input:focus {
                  outline: none;
                  border-color: #28a745;
                  box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
              }
            </style>-->
          </div>
        <a href="../vistas/vistas-prov.php" style="text-decoration: none;">
            <button type="submit" name="action" value="publicar"class="boton-enviar-formulario">📩 Publicar servicio</button>
        </a>
      </form>
    </div>
  </main>

  
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
      (function initNotificationBox() {
    const bell = document.getElementById('notificationBell');
    const modal = document.getElementById('notificationModal');
    const closeBtn = document.getElementById('closeNotifications');
    const list = modal ? modal.querySelector('.notification-list') : null;
    const badge = bell ? bell.querySelector('span') : null;

    if (!bell || !modal || !list) return;

    function updateBadge() {
        const unread = list.querySelectorAll('.notification-item.unread').length;
        if (!badge) return;
        badge.textContent = unread > 0 ? unread : '';
        badge.style.display = unread > 0 ? 'flex' : 'none';
    }

    function markAsRead(item) {
        if (!item.classList.contains('unread')) return;
        item.classList.remove('unread');
        // opcional: enviar al servidor que la notificación fue leída
        // const id = item.dataset.notificationId;
        // fetch('/conexion/notifications.php', { method: 'POST', body: new URLSearchParams({ action: 'mark_read', id }) });
        updateBadge();
    }

    // Toggle modal
    bell.addEventListener('click', (e) => {
        e.stopPropagation();
        modal.classList.toggle('active');
    });

    // Close icon
    if (closeBtn) closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        modal.classList.remove('active');
    });

    // Click fuera para cerrar
    document.addEventListener('click', (e) => {
        if (!bell.contains(e.target) && !modal.contains(e.target)) {
            modal.classList.remove('active');
        }
    });

    // Manejo de click en cada notificación
    list.addEventListener('click', (e) => {
        const item = e.target.closest('.notification-item');
        if (!item) return;
        // prevenir que el click cierre el modal
        e.stopPropagation();
        markAsRead(item);

        // acción asociada (si tiene link o detalle)
        const actionUrl = item.dataset.href;
        if (actionUrl) {
            // abrir en misma pestaña; usar target _blank si querés nueva pestaña
            window.location.href = actionUrl;
        }
    });

    // Inicializar estado del badge al cargar
    document.addEventListener('DOMContentLoaded', updateBadge);
    updateBadge();

    // Exponer funciones para uso manual (opcional)
    window.notifications = {
        updateBadge,
        markAsReadAll: () => {
            list.querySelectorAll('.notification-item.unread').forEach(item => markAsRead(item));
            // opcional: notificar servidor
        }
    };
})();
    </script>
</body>
</html>