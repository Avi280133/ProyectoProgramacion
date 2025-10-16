<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Proveedores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/vistas-prov.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="menu-left">
            <a href="#" class="menu-icon">
                <i class="fa-solid fa-bars"></i>
            </a>
        </div>

        <div class="logo-center">
            <img src="img/logo-SkillMatch-v3.png" alt="SkillMatch Logo">
        </div>

        <div class="actions-right">
            <div class="search-container">
                <button class="search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" class="search-input" placeholder="Buscar...">
            </div>
            <div style="position: relative;">
                <i class="fa-solid fa-bell" onclick="NotificationsModal.toggle()" style="cursor: pointer;" title="Notificaciones"></i>
                
            </div>
            <i class="fa-solid fa-plus" title="Publicar Servicio"></i>
            <i class="fa-solid fa-user" title="Mi Perfil"></i>
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
            <div class="action-card" onclick="location.href='html/publicar.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-plus-circle"></i>
                </div>
                <h3 class="action-title">Publicar Servicio</h3>
                <p class="action-description">Crea una nueva publicación y llega a miles de clientes potenciales.</p>
                <button class="action-btn">
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
                <button class="action-btn">
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
                <button class="action-btn">
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

    <!-- My Services Section -->
    <section class="my-services-section">
        <h2 class="section-title">Mis Servicios Publicados</h2>
        <p class="section-subtitle">Gestiona y monitorea tus publicaciones activas</p>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-header">
                    <span class="service-status status-active">Activo</span>
                </div>
                <h3 class="service-title">Reparación de Aires Acondicionados</h3>
                <div class="service-stats">
                    <span><i class="fa-solid fa-eye"></i> 234 vistas</span>
                    <span><i class="fa-solid fa-star"></i> 4.9</span>
                    <span><i class="fa-solid fa-comments"></i> 12 msgs</span>
                </div>
                <div class="service-actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen"></i> Editar</button>
                    <button class="btn-stats"><i class="fa-solid fa-chart-bar"></i> Stats</button>
                    <button class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <span class="service-status status-active">Activo</span>
                </div>
                <h3 class="service-title">Desarrollo Web Frontend</h3>
                <div class="service-stats">
                    <span><i class="fa-solid fa-eye"></i> 456 vistas</span>
                    <span><i class="fa-solid fa-star"></i> 5.0</span>
                    <span><i class="fa-solid fa-comments"></i> 8 msgs</span>
                </div>
                <div class="service-actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen"></i> Editar</button>
                    <button class="btn-stats"><i class="fa-solid fa-chart-bar"></i> Stats</button>
                    <button class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <span class="service-status status-pending">Pendiente</span>
                </div>
                <h3 class="service-title">Instalación Eléctrica Residencial</h3>
                <div class="service-stats">
                    <span><i class="fa-solid fa-eye"></i> 89 vistas</span>
                    <span><i class="fa-solid fa-star"></i> 4.7</span>
                    <span><i class="fa-solid fa-comments"></i> 3 msgs</span>
                </div>
                <div class="service-actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen"></i> Editar</button>
                    <button class="btn-stats"><i class="fa-solid fa-chart-bar"></i> Stats</button>
                    <button class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Notifications Section -->
    <section class="notifications-section">
        <h2 class="section-title">Notificaciones Recientes</h2>
        <p class="section-subtitle">Mantente al día con tus actividades</p>
        
        <div class="notifications-container">
            <div class="notification-item">
                <div class="notification-header">
                    <span class="notification-title"><i class="fa-solid fa-message"></i> Nuevo mensaje de Juan Pérez</span>
                    <span class="notification-time">Hace 5 minutos</span>
                </div>
                <p class="notification-message">Te ha enviado una consulta sobre tu servicio de "Reparación de Aires Acondicionados"</p>
            </div>

            <div class="notification-item">
                <div class="notification-header">
                    <span class="notification-title"><i class="fa-solid fa-star"></i> Nueva calificación recibida</span>
                    <span class="notification-time">Hace 2 horas</span>
                </div>
                <p class="notification-message">María González te ha calificado con 5 estrellas por tu servicio de desarrollo web.</p>
            </div>

            <div class="notification-item">
                <div class="notification-header">
                    <span class="notification-title"><i class="fa-solid fa-chart-line"></i> Tu servicio está destacado</span>
                    <span class="notification-time">Hace 1 día</span>
                </div>
                <p class="notification-message">"Reparación de Aires Acondicionados" ha alcanzado 200 visualizaciones esta semana.</p>
            </div>

            <div class="notification-item">
                <div class="notification-header">
                    <span class="notification-title"><i class="fa-solid fa-bell"></i> Recordatorio de pago</span>
                    <span class="notification-time">Hace 2 días</span>
                </div>
                <p class="notification-message">Tienes un pago pendiente de $150 por el proyecto "Instalación Eléctrica" completado.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>SkillMatch</h3>
                <p style="color: rgba(255, 255, 255, 0.8); line-height: 1.6;">
                    La plataforma líder que conecta profesionales con clientes. Publica tus servicios y encuentra oportunidades.
                </p>
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
                <a href="html/publicar.php">Publicar Servicio</a>
                <a href="html/mis-servicios.php">Mis Servicios</a>
                <a href="html/estadisticas.php">Estadísticas</a>
                <a href="html/mensajes.php">Mensajes</a>
                <a href="html/perfil.php">Mi Perfil</a>
            </div>

            <div class="footer-section">
                <h3>Para Clientes</h3>
                <a href="index-cliente.php">Buscar Servicios</a>
                <a href="html/categorias.php">Categorías</a>
                <a href="html/favoritos.php">Mis Favoritos</a>
                <a href="html/historial.php">Historial</a>
            </div>

            <div class="footer-section">
                <h3>Soporte</h3>
                <a href="html/ayuda.php">Centro de Ayuda</a>
                <a href="html/politicas.php">Políticas de Seguridad</a>
                <a href="html/terminos.php">Términos y Condiciones</a>
                <a href="html/contacto.php">Contáctanos</a>
                <a href="html/acerca.php">Acerca de Nosotros</a>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); color: rgba(255, 255, 255, 0.7);">
            <p>&copy; 2025 SkillMatch. Todos los derechos reservados.</p>
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
    </script>
    <script src="vistas/styles-notis.js"></script>
</body>
</html>