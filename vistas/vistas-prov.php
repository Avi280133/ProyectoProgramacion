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
        /* Features Showcase Section */
.features-showcase {
    padding: 5rem 2rem;
    background: linear-gradient(180deg, #f8fffe 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.features-showcase::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 300px;
    background: radial-gradient(circle at 50% 0%, rgba(14, 178, 124, 0.1) 0%, transparent 70%);
    pointer-events: none;
}

.features-container {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.features-header {
    text-align: center;
    margin-bottom: 4rem;
}

.features-grid {
    display: flex;
    flex-direction: column;
    gap: 4rem;
}

.feature-item {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
    align-items: center;
    padding: 2rem;
    border-radius: 20px;
    transition: all 0.4s ease;
}

.feature-item:hover {
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transform: translateY(-5px);
}

.feature-item-reverse {
    grid-template-columns: 1fr 300px;
}

.feature-item-reverse .feature-visual {
    order: 2;
}

.feature-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 250px;
}

.feature-circle {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, #0eb27c 0%, #064e3b 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
    box-shadow: 0 20px 60px rgba(14, 178, 124, 0.3);
    transition: all 0.4s ease;
}

.feature-item:hover .feature-circle {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 25px 80px rgba(14, 178, 124, 0.4);
}

.feature-circle i {
    font-size: 4rem;
    color: white;
}

.feature-glow {
    position: absolute;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(14, 178, 124, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
}

.feature-content h3 {
    font-size: 1.8rem;
    color: #025939;
    margin-bottom: 1rem;
    font-weight: 700;
}

.feature-content p {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.feature-list {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.feature-list li {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: #475569;
    font-size: 0.95rem;
}

.feature-list i {
    color: #0eb27c;
    font-size: 1.1rem;
}

/* Features CTA */
.features-cta {
    margin-top: 5rem;
    padding: 3rem;
    background: linear-gradient(135deg, #064e3b 0%, #0eb27c 100%);
    border-radius: 25px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 3rem;
    align-items: center;
    box-shadow: 0 20px 60px rgba(14, 178, 124, 0.3);
    position: relative;
    overflow: hidden;
}

.features-cta::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.cta-content {
    position: relative;
    z-index: 1;
}

.cta-content h3 {
    font-size: 2rem;
    color: white;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.cta-content p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.cta-button {
    background: white;
    color: #025939;
    padding: 1rem 2.5rem;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    background: #f0fdf9;
}

.cta-button i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.cta-button:hover i {
    transform: translateX(5px);
}

.cta-stats {
    display: flex;
    gap: 2rem;
    position: relative;
    z-index: 1;
}

.cta-stat {
    text-align: center;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-width: 120px;
}

.cta-stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.3rem;
}

.cta-stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 968px) {
    .feature-item,
    .feature-item-reverse {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .feature-item-reverse .feature-visual {
        order: 1;
    }

    .features-cta {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .cta-stats {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .features-showcase {
        padding: 3rem 1rem;
    }

    .features-grid {
        gap: 2.5rem;
    }

    .feature-circle {
        width: 120px;
        height: 120px;
    }

    .feature-circle i {
        font-size: 3rem;
    }

    .feature-content h3 {
        font-size: 1.5rem;
    }

    .cta-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .cta-stat {
        width: 100%;
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
                <a href="../vistas/perfil.php" style="color: inherit; text-decoration: none;">
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
        </div>
    </section>

    <!-- Features Showcase Section -->
<section class="features-showcase">
    <div class="features-container">
        <div class="features-header">
            <h2 class="section-title">Todo lo que necesitas para crecer</h2>
            <p class="section-subtitle">Herramientas profesionales diseñadas para impulsar tu negocio</p>
        </div>

        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-visual">
                    <div class="feature-circle">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="feature-glow"></div>
                </div>
                <div class="feature-content">
                    <h3>Publicar Servicios</h3>
                    <p>Crea publicaciones atractivas con fotos, descripciones detalladas y precios competitivos. Llega a miles de clientes potenciales en minutos.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Galería de hasta 10 fotos</li>
                        <li><i class="fas fa-check-circle"></i> Categorización automática</li>
                        <li><i class="fas fa-check-circle"></i> SEO optimizado</li>
                    </ul>
                </div>
            </div>

            <div class="feature-item feature-item-reverse">
                <div class="feature-visual">
                    <div class="feature-circle" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="feature-glow" style="background: radial-gradient(circle, rgba(52,152,219,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="feature-content">
                    <h3>Gestionar Servicios</h3>
                    <p>Controla todos tus servicios desde un solo lugar. Visualiza estadísticas en tiempo real y optimiza tu presencia en la plataforma.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Panel de métricas detalladas</li>
                        <li><i class="fas fa-check-circle"></i> Estado de publicaciones</li>
                        <li><i class="fas fa-check-circle"></i> Análisis de rendimiento</li>
                    </ul>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-visual">
                    <div class="feature-circle" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div class="feature-glow" style="background: radial-gradient(circle, rgba(243,156,18,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="feature-content">
                    <h3>Editar Fácilmente</h3>
                    <p>Actualiza tus servicios en cualquier momento. Modifica precios, descripciones, disponibilidad y mucho más con solo unos clics.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Edición en tiempo real</li>
                        <li><i class="fas fa-check-circle"></i> Vista previa instantánea</li>
                        <li><i class="fas fa-check-circle"></i> Historial de cambios</li>
                    </ul>
                </div>
            </div>

            <div class="feature-item feature-item-reverse">
                <div class="feature-visual">
                    <div class="feature-circle" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="feature-glow" style="background: radial-gradient(circle, rgba(231,76,60,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="feature-content">
                    <h3>Control Total</h3>
                    <p>Elimina o pausa servicios cuando lo necesites. Mantén tu portafolio actualizado y relevante para tus clientes.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Eliminación segura</li>
                        <li><i class="fas fa-check-circle"></i> Pausar temporalmente</li>
                        <li><i class="fas fa-check-circle"></i> Confirmación de seguridad</li>
                    </ul>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-visual">
                    <div class="feature-circle" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <div class="feature-glow" style="background: radial-gradient(circle, rgba(155,89,182,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="feature-content">
                    <h3>Perfil Profesional</h3>
                    <p>Construye tu marca personal. Personaliza tu perfil con portafolio, certificaciones y reseñas de clientes satisfechos.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Portafolio visual</li>
                        <li><i class="fas fa-check-circle"></i> Verificación de identidad</li>
                        <li><i class="fas fa-check-circle"></i> Sistema de reputación</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="features-cta">
            <div class="cta-content">
                <h3>¿Listo para destacar?</h3>
                <p>Únete a miles de profesionales que ya están creciendo con SkillMatch</p>
                <button class="cta-button" onclick="location.href='publicar.php'">
                    <span>Publicar Mi Primer Servicio</span>
                    <i class="fa-solid fa-rocket"></i>
                </button>
            </div>
            <div class="cta-stats">
                <div class="cta-stat">
                    <div class="cta-stat-number">10K+</div>
                    <div class="cta-stat-label">Proveedores</div>
                </div>
                <div class="cta-stat">
                    <div class="cta-stat-number">50K+</div>
                    <div class="cta-stat-label">Servicios</div>
                </div>
                <div class="cta-stat">
                    <div class="cta-stat-number">4.9</div>
                    <div class="cta-stat-label">Calificación</div>
                </div>
            </div>
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