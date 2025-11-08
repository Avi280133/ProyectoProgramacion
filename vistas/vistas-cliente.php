<?php require_once('../conexion/guards/auth_guard.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Encuentra tu Servicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/cliente.css">
     <link rel="conexion" href="../conexion/controllerUsuario.php">
      <link rel="conexion" href="../conexion/controllerPublicacion.php">
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
                
            <div class="header-icon">
                <a href="../vistas/perfil-cliente.php" style="color: inherit; text-decoration: none;">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Encuentra el Profesional Perfecto</h1>
            <p>Conecta con expertos calificados para cualquier servicio que necesites</p>
             <form action="../conexion/controllerPublicacion.php" method="POST">
            <div class="search-container">
                <input type="text" name="titulo" placeholder="Busca plomero, electricista, programador...">
                <!--<button><i class="fas fa-search"></i></button>-->
                <button type="submit" name="action" value="buscar"><i class="fas fa-search"></i></button>
            </div>
            </form>
        </div>
    </section>


    <!-- Categories Section -->
    <section style="padding: 5rem 2rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 class="section-title">Categorías de Servicios</h2>
            <p class="section-subtitle">Explora todas las áreas disponibles</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                <!-- Category Card -->
                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #0eb27c; margin-bottom: 1rem;">
                        <i class="fas fa-hammer"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Construcción</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">250+ profesionales</p>
                </div>

                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #3498db; margin-bottom: 1rem;">
                        <i class="fas fa-car"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Automotriz</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">180+ profesionales</p>
                </div>

                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #9b59b6; margin-bottom: 1rem;">
                        <i class="fas fa-code"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Tecnología</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">320+ profesionales</p>
                </div>

                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #f39c12; margin-bottom: 1rem;">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Electricidad</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">140+ profesionales</p>
                </div>

                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #e74c3c; margin-bottom: 1rem;">
                        <i class="fas fa-paint-roller"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Pintura</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">95+ profesionales</p>
                </div>

                <div style="background: white; padding: 2rem; border-radius: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.08);" class="category-card-hover">
                    <div style="font-size: 3rem; color: #1abc9c; margin-bottom: 1rem;">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Soporte Técnico</h4>
                    <p style="color: #7f8c8d; font-size: 0.85rem;">210+ profesionales</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section style="padding: 5rem 2rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 class="section-title">¿Cómo Funciona?</h2>
            <p class="section-subtitle">3 simples pasos para conectar con el profesional ideal</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0eb27c 0%, #047857 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(14, 178, 124, 0.3);">1</div>
                    <h3 style="color: #2c3e50; font-size: 1.3rem; font-weight: 700; margin-bottom: 0.8rem;">Busca</h3>
                    <p style="color: #7f8c8d; line-height: 1.6;">Explora nuestra amplia red de profesionales calificados en diferentes categorías.</p>
                </div>

                <div style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0eb27c 0%, #047857 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(14, 178, 124, 0.3);">2</div>
                    <h3 style="color: #2c3e50; font-size: 1.3rem; font-weight: 700; margin-bottom: 0.8rem;">Compara</h3>
                    <p style="color: #7f8c8d; line-height: 1.6;">Revisa perfiles, reseñas, calificaciones y precios para elegir la mejor opción.</p>
                </div>

                <div style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0eb27c 0%, #047857 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(14, 178, 124, 0.3);">3</div>
                    <h3 style="color: #2c3e50; font-size: 1.3rem; font-weight: 700; margin-bottom: 0.8rem;">Contrata</h3>
                    <p style="color: #7f8c8d; line-height: 1.6;">Contacta directamente, acuerda detalles y agenda tu servicio de forma segura.</p>
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
                <a href="#instagram" class="social-icon" title="Instagram">
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
        const getServicios = () => {
            const papanotificaciones = document.getElementById('papanotificaciones');
            if (!papanotificaciones) return;
            
            // Limpiar las notificaciones existentes
            papanotificaciones.innerHTML = '';
            
            // Array con todas las tablas que queremos consultar
            const tablas = ['notificacion', 'contrata', 'comenta', 'supervisa', 'ofrece'];
            
            // Realizar todas las consultas en paralelo
            Promise.all(tablas.map(tabla => 
                fetch(`../conexion/notificaciones.php?tabla=${tabla}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => ({tabla, data}))
            ))
            .then(resultados => {
                let notificacionesHTML = ''; // acumulamos todas las notificaciones
                
                resultados.forEach(({tabla, data}) => {
                    if (data.error) {
                        console.error(`Error en tabla ${tabla}:`, data.error);
                        return;
                    }
                    console.log(`Datos de ${tabla}:`, data);
                    
                    // Procesar cada registro según el tipo de tabla
                    data.forEach(item => {
                        let titulo = '';
                        let texto = '';
                        let icono = '';
                        let color = '';

                        switch(tabla) {
                            case 'notificacion':
                                titulo = 'Notificación';
                                texto = item.mensaje || item.descripcion || 'Nueva notificación';
                                icono = 'fa-bell';
                                color = '#3498db, #2980b9';
                                break;
                            case 'contrata':
                                titulo = 'Nuevo Contrato';
                                texto = 'Se ha generado un nuevo contrato';
                                icono = 'fa-file-contract';
                                color = '#27ae60, #219a52';
                                break;
                            case 'comenta':
                                titulo = 'Nuevo Comentario';
                                texto = item.comentario || 'Han comentado en tu publicación';
                                icono = 'fa-comment';
                                color = '#e67e22, #d35400';
                                break;
                            case 'supervisa':
                                titulo = 'Supervisión';
                                texto = 'Nueva actividad de supervisión';
                                icono = 'fa-eye';
                                color = '#9b59b6, #8e44ad';
                                break;
                            case 'ofrece':
                                titulo = 'Nueva Oferta';
                                texto = 'Has recibido una nueva oferta';
                                icono = 'fa-gift';
                                color = '#e74c3c, #c0392b';
                                break;
                        }

                        notificacionesHTML += `
                            <div class="notification-item">
                                <div class="notification-icon" style="background: linear-gradient(135deg, ${color});">
                                    <i class="fas ${icono}"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">${titulo}</div>
                                    <div class="notification-text">${texto}</div>
                                    <div class="notification-time">Nuevo</div>
                                </div>
                            </div>
                        `;
                        });

            // insertamos todo el HTML una sola vez
            papanotificaciones.innerHTML = notificacionesHTML;

            })
            .catch(error => console.error('Error:', error));
        }
setInterval(() => {
    getServicios()
    console.log('Actualizando servicios...');
}, 20000); // Cada 
getServicios()
    </script>
</body>
</html>