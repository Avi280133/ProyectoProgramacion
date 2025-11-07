<?php require_once('../conexion/guards/auth_guard.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados || SkillMatch</title>
    <link rel="stylesheet" href="../css/busqueda-styles.css">
    <script src="https://kit.fontawesome.com/6d671fbf0c.js" crossorigin="anonymous"></script>
       <link rel="conexion" href="../conexion/controllerPublicacion.php">
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
          <a href="../vistas/vistas-cliente.php" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
            <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
            SkillMatch
          </a>
        </div>
        <div class="header-actions">
            <div style="position: relative;">
        </div>
    </header>

    <section class="search-section">
        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Buscar servicios profesionales..." value="programadores">
            <button class="search-btn">
                <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
            </button>
        </div>
    </section>

    
    <main class="results-container">
        <div class="results-header">
            <div class="results-count">
                <strong>24</strong> servicios encontrados para <em>"programadores"</em>
            </div>
            <div class="sort-filter">
                <button class="filter-btn active">Relevancia</button>
                <button class="filter-btn">Precio</button>
                <button class="filter-btn">Valoración</button>
                <button class="filter-btn">Distancia</button>
            </div>
        </div>

<?php  

foreach ($servicio as $servicio) {
    echo ' <form action="../conexion/controllerPublicacion.php" method="POST">';
    echo '<div class="services-grid">';
    echo '<div class="service-card fade-in" style="animation-delay: 0.1s">';
    echo '<div class="service-icon">💻</div>';
    echo '<h3 class="service-title"> '
    . htmlspecialchars($servicio['titulo']) ;
    echo '</h3>';
    echo '<p class="service-description">'
    . htmlspecialchars($servicio['descripcion']) ;
    echo '</p>';
    echo '<div class="service-meta">';
    echo '<div class="rating">⭐ 4.9 (127 reviews)</div>';
    echo '<div class="price">'
    . htmlspecialchars($servicio['precio']) ;
    echo '</div>';
    echo '</div>';
    echo '<input type="hidden" name="action" value="cargarServicio">';
    echo '<input type="hidden" name="idservicio" value="' . htmlspecialchars($servicio['idservicio']) . '">';
    echo '<button type="submit">Contactar Ahora</button>';
    echo '</div>';
    echo '</form>';
        }
?>
            <!-- <div class="service-card fade-in" style="animation-delay: 0.2s">
                <div class="service-icon">⚙️</div>
                <h3 class="service-title">Desarrollo Backend</h3>
                <p class="service-description">
                    Experto en Node.js, Python y bases de datos. APIs robustas, arquitectura escalable y soluciones en la nube.
                </p>
                <div class="service-meta">
                    <div class="rating">
                        ⭐ 4.8 (89 reviews)
                    </div>
                    <div class="price">Desde $30/hora</div>
                </div>
                <button class="contact-btn">Contactar Ahora</button>
            </div>

            <div class="service-card fade-in" style="animation-delay: 0.3s">
                <div class="service-icon">📱</div>
                <h3 class="service-title">Desarrollo Mobile</h3>
                <p class="service-description">
                    Apps nativas para iOS y Android. React Native, Flutter y Swift. Desde MVPs hasta aplicaciones empresariales.
                </p>
                <div class="service-meta">
                    <div class="rating">
                        ⭐ 4.7 (156 reviews)
                    </div>
                    <div class="price">Desde $35/hora</div>
                </div>
                <button class="contact-btn">Contactar Ahora</button>
            </div>

            <div class="service-card fade-in" style="animation-delay: 0.4s">
                <div class="service-icon">🎨</div>
                <h3 class="service-title">UI/UX Design</h3>
                <p class="service-description">
                    Diseño centrado en el usuario. Prototipos interactivos, sistemas de diseño y optimización de conversiones.
                </p>
                <div class="service-meta">
                    <div class="rating">
                        ⭐ 4.9 (203 reviews)
                    </div>
                    <div class="price">Desde $28/hora</div>
                </div>
                <button class="contact-btn">Contactar Ahora</button>
            </div>

            <div class="service-card fade-in" style="animation-delay: 0.5s">
                <div class="service-icon">🛡️</div>
                <h3 class="service-title">Seguridad Informática</h3>
                <p class="service-description">
                    Auditorías de seguridad, pentesting y consultoría. Protección de datos y cumplimiento normativo.
                </p>
                <div class="service-meta">
                    <div class="rating">
                        ⭐ 4.8 (74 reviews)
                    </div>
                    <div class="price">Desde $45/hora</div>
                </div>
                <button class="contact-btn">Contactar Ahora</button>
            </div>

            <div class="service-card fade-in" style="animation-delay: 0.6s">
                <div class="service-icon">📊</div>
                <h3 class="service-title">Data Science & Analytics</h3>
                <p class="service-description">
                    Análisis de datos, machine learning y visualizaciones. Python, R y herramientas de BI para insights accionables.
                </p>
                <div class="service-meta">
                    <div class="rating">
                        ⭐ 4.9 (91 reviews)
                    </div>
                    <div class="price">Desde $40/hora</div>
                </div>
                <button class="contact-btn">Contactar Ahora</button>
            </div>
        </div>

        <div class="pagination">
            <button class="page-btn">‹</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">›</button>
        </div>
    </main> -->
</main>
    <script>
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        const resultsCount = document.querySelector('.results-count');
        
        function performSearch() {
            const query = searchInput.value;
            resultsCount.innerHTML = `<strong>24</strong> servicios encontrados para <em>"${query}"</em>`;
            const cards = document.querySelectorAll('.service-card');
            cards.forEach((card, index) => {
                card.style.animation = 'none';
                setTimeout(() => {
                    card.style.animation = `fadeInUp 0.6s ease forwards`;
                    card.style.animationDelay = `${index * 0.1}s`;
                }, 10);
            });
        }

        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') performSearch();
        });

       //   abrirServicio.addEventListener('click', performSearch);
      //  searchInput.addEventListener('keypress', (e) => {
      //      if (e.key === 'Enter') performSearch();
      //  });

        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>

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