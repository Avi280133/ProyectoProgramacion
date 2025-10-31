<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Proveedores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/vistas-prov.css">
    <style>
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

    <!-- Quick Stats -->
    <section class="stats-bar">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-briefcase"></i></div>
                <div class="stat-number">12</div>
                <div class="stat-label">Servicios Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-eye"></i></div>
                <div class="stat-number">1,234</div>
                <div class="stat-label">Visualizaciones</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Calificación</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-comments"></i></div>
                <div class="stat-number">45</div>
                <div class="stat-label">Mensajes Nuevos</div>
            </div>
        </div>
    </section>

    <!-- Dashboard Actions -->
    <section class="dashboard-section">
        <h2 class="section-title">Panel de Control</h2>
        <p class="section-subtitle">Gestiona tus servicios y explora nuevas oportunidades</p>
        
        <div class="dashboard-grid">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fa-solid fa-plus-circle"></i>
                </div>
                <h3 class="action-title">Publicar Servicio</h3>
                <p class="action-description">Crea una nueva publicación y llega a miles de clientes potenciales.</p>
                <button class="action-btn" onclick="location.href='publicar.php'; event.stopPropagation();">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Comenzar</span>
                </button>
            </div>

            <div class="action-card" onclick="location.href='html/mis-servicios.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h3 class="action-title">Mis Servicios</h3>
                <p class="action-description">Administra, edita y monitorea el rendimiento de tus publicaciones.</p>
                <button class="action-btn" onclick="location.href='perfil.php#services?from=dashboard'; event.stopPropagation();">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Ver Todos</span>
                </button>
            </div>

            <div class="action-card" onclick="location.href='index-cliente.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-search"></i>
                </div>
                <h3 class="action-title">Buscar Servicios</h3>
                <p class="action-description">Explora y contrata profesionales para tus propios proyectos.</p>
                <button class="action-btn">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Explorar</span>
                </button>
            </div>

            <div class="action-card" onclick="location.href='html/mensajes.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="action-title">Mensajes</h3>
                <p class="action-description">Comunícate con clientes y otros profesionales de forma segura.</p>
                <button class="action-btn">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Ver Mensajes</span>
                </button>
            </div>

            <div class="action-card" onclick="location.href='html/estadisticas.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="action-title">Estadísticas</h3>
                <p class="action-description">Analiza el rendimiento de tus servicios y optimiza tus resultados.</p>
                <button class="action-btn">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Ver Datos</span>
                </button>
            </div>

            <div class="action-card" onclick="location.href='html/perfil.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <h3 class="action-title">Mi Perfil</h3>
                <p class="action-description">Actualiza tu información y mejora tu presencia profesional.</p>
                <button class="action-btn" onclick="location.href='perfil.php'; event.stopPropagation();">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Editar Perfil</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Services Carousel -->
    <section class="carousel-section">
        <div class="carousel-container">
            <h2 class="section-title">Servicios Destacados</h2>
            <p class="section-subtitle">Descubre la amplia gama de servicios profesionales disponibles</p>
            
            <div class="carousel">
                <article>
                    <img src="../img/Albañil.png" alt="Albañilería">
                    <h2>Albañilería</h2>
                    <div class="text-container">
                        <p>Profesionales de la construcción listos para tu proyecto con garantía de calidad.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=albanileria">Ver más</a>
                </article>

                <article>
                    <img src="../img/Costura.png" alt="Costura">
                    <h2>Costureros</h2>
                    <div class="text-container">
                        <p>Servicios de costura profesional para arreglos y diseños personalizados.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=costura">Ver más</a>
                </article>

                <article>
                    <img src="../img/Mecanico.png" alt="Mecánicos">
                    <h2>Mecánicos</h2>
                    <div class="text-container">
                        <p>Expertos en reparación y mantenimiento vehicular con tecnología moderna.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=mecanica">Ver más</a>
                </article>

                <article>
                    <img src="../img/Programacion.png" alt="Programación">
                    <h2>Programación</h2>
                    <div class="text-container">
                        <p>Desarrollo de software y soluciones tecnológicas innovadoras.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=programacion">Ver más</a>
                </article>

                <article>
                    <img src="../img/Limpieza.png" alt="Limpieza">
                    <h2>Limpieza</h2>
                    <div class="text-container">
                        <p>Personal capacitado para mantener tus espacios impecables.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=limpieza">Ver más</a>
                </article>

                <article>
                    <img src="../img/Trabajo.png" alt="Trabajos Generales">
                    <h2>Trabajos Generales</h2>
                    <div class="text-container">
                        <p>Amplia gama de servicios profesionales para todas tus necesidades.</p>
                    </div>
                    <a href="vistas/categoria.php?cat=general">Ver más</a>
                </article>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
        // Animaciones al scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Aplicar animación a elementos
        document.querySelectorAll('.stat-item, .action-card, .service-card, .notification-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Funcionalidad de búsqueda
        const searchIcon = document.querySelector('.search-icon');
        const searchInput = document.querySelector('.search-input');

        searchIcon.addEventListener('click', (e) => {
            e.preventDefault();
            if (searchInput.style.opacity === '1') {
                // Si está visible, realizar búsqueda
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `html/buscar.php?q=${encodeURIComponent(query)}`;
                }
            }
        });

        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `html/buscar.php?q=${encodeURIComponent(query)}`;
                }
            }
        });

        // Confirmación de eliminación
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (confirm('¿Estás seguro de que deseas eliminar este servicio? Esta acción no se puede deshacer.')) {
                    // Aquí iría la lógica de eliminación
                    const card = btn.closest('.service-card');
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }
            });
        });

        // Contador animado para estadísticas
        function animateCounter(element) {
            const target = parseInt(element.textContent.replace(/,/g, ''));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Animar contadores cuando son visibles
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    const number = entry.target.querySelector('.stat-number');
                    if (number) {
                        animateCounter(number);
                        entry.target.classList.add('animated');
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-item').forEach(stat => {
            statsObserver.observe(stat);
        });

        // Notificaciones: marcar como leída al hacer click
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                this.style.opacity = '0.6';
                this.style.borderLeftColor = '#cbd5e0';
                // Aquí iría la lógica para marcar como leída en la BD
            });
        });

        // Efecto hover para cards de acción
        document.querySelectorAll('.action-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Prevenir click en botones cuando se hace click en la card
        document.querySelectorAll('.service-actions button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

        // Actualizar estadísticas en tiempo real (simulado)
        function updateStats() {
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                const current = parseInt(stat.textContent.replace(/,/g, ''));
                const change = Math.floor(Math.random() * 3) - 1; // -1, 0, o 1
                if (change !== 0) {
                    const newValue = Math.max(0, current + change);
                    stat.textContent = newValue.toLocaleString();
                    
                    // Efecto visual de actualización
                    stat.style.color = change > 0 ? '#10b981' : '#ef4444';
                    setTimeout(() => {
                        stat.style.color = '#025939';
                    }, 1000);
                }
            });
        }

        // Actualizar cada 30 segundos (en producción sería con WebSockets)
        setInterval(updateStats, 30000);

        // Mensajes de éxito/error desde URL
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.get('login') === 'success') {
            showNotification('¡Bienvenido de nuevo!', 'success');
        }
        
        if (urlParams.get('register') === 'success') {
            showNotification('¡Cuenta creada exitosamente!', 'success');
        }
        
        if (urlParams.get('service') === 'published') {
            showNotification('¡Servicio publicado correctamente!', 'success');
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white;
                padding: 20px 30px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: slideInRight 0.5s ease;
            `;
            notification.innerHTML = `
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span style="margin-left: 10px;">${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Animaciones CSS adicionales
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

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