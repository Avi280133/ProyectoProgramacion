<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Diseño Gráfico Profesional | SkillMatch</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/publi.css">
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">
    <link rel="conexion" href="../conexion/controllerPublicacion.php">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
* {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #fafafa;
      margin: 0;
      min-height: 100vh;
      color: #1a1a1a;
    }

    /* Header Styles */
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

    /* Main Content */
    .pagina-servicio {
      max-width: 1100px;
      margin: 0 auto;
      padding: 60px 20px;
    }

    .contenedor-servicio {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 40px;
      align-items: start;
    }

    /* Sección Principal */
    .seccion-principal {
      background: white;
      border-radius: 16px;
      padding: 0;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .imagen-destacada {
      width: 100%;
      height: 400px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .imagen-destacada::before {
      content: '🎨';
      font-size: 120px;
      opacity: 0.3;
      position: absolute;
    }

    .contenido-servicio {
      padding: 40px;
    }

    .categoria {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #00b894;
      font-weight: 600;
      margin-bottom: 12px;
    }

    .titulo-principal {
      font-size: 2rem;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 16px;
      line-height: 1.3;
    }

    .descripcion {
      font-size: 1rem;
      line-height: 1.8;
      color: #666;
      margin-bottom: 32px;
    }

    .caracteristicas {
      border-top: 1px solid #f0f0f0;
      padding-top: 32px;
    }

    .caracteristicas h3 {
      font-size: 0.875rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #1a1a1a;
      margin-bottom: 20px;
    }

    .lista-caracteristicas {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      list-style: none;
      padding: 0;
    }

    .lista-caracteristicas li {
      font-size: 0.9rem;
      color: #666;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .lista-caracteristicas li::before {
      content: '•';
      color: #00b894;
      font-size: 1.5rem;
      line-height: 1;
    }

    .detalles-adicionales {
      border-top: 1px solid #f0f0f0;
      padding-top: 32px;
      margin-top: 32px;
    }

    .detalles-adicionales h3 {
      font-size: 0.875rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #1a1a1a;
      margin-bottom: 16px;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-label {
      font-size: 0.875rem;
      color: #999;
      font-weight: 500;
    }

    .info-value {
      font-size: 0.875rem;
      color: #1a1a1a;
      font-weight: 600;
    }

    /* Sidebar Proveedor */
    .sidebar-proveedor {
      position: sticky;
      top: 100px;
    }

    .card-proveedor {
      background: white;
      border-radius: 16px;
      padding: 32px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      text-align: center;
    }

    .foto-proveedor {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
      margin: 0 auto 20px;
      border: 3px solid #f5f5f5;
    }

    .nombre-proveedor {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 8px;
      text-decoration: none;
      display: block;
      transition: color 0.3s ease;
    }

    .nombre-proveedor:hover {
      color: #00b894;
    }

    .rating {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 4px;
      font-size: 18px;
      color: #ffc107;
      margin-bottom: 16px;
    }

    .ubicacion {
      font-size: 0.875rem;
      color: #999;
      margin-bottom: 24px;
    }

    .separador {
      height: 1px;
      background: #f0f0f0;
      margin: 24px 0;
    }

    .precio-container {
      margin-bottom: 24px;
    }

    .precio-label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #999;
      margin-bottom: 8px;
    }

    .precio {
      font-size: 2rem;
      font-weight: 700;
      color: #1a1a1a;
    }

    .precio-periodo {
      font-size: 1rem;
      font-weight: 400;
      color: #999;
    }

    .botones-accion {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .botones-accion a {
      text-decoration: none;
    }

    .btn {
      width: 100%;
      padding: 14px 24px;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      text-align: center;
    }

    .btn-solicitar {
      background: #00b894;
      color: white;
    }

    .btn-solicitar:hover {
      background: #019875;
      transform: translateY(-1px);
    }

    .btn-mensaje {
      background: white;
      color: #00b894;
      border: 2px solid #00b894;
    }

    .btn-mensaje:hover {
      background: #f0f9f4;
    }

    .btn-reportar {
      background: white !important;
      color: #dc3545 !important;
      border: 2px solid #dc3545 !important;
    }

    .btn-reportar:hover {
      background: #dc3545 !important;
      color: white !important;
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }


    /* Footer Styles */
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

    /* Responsive */
    @media (max-width: 768px) {
      .contenedor-servicio {
        grid-template-columns: 1fr;
      }

      .sidebar-proveedor {
        position: static;
      }

      .imagen-destacada {
        height: 300px;
      }

      .titulo-principal {
        font-size: 1.5rem;
      }

      .lista-caracteristicas {
        grid-template-columns: 1fr;
      }
    }

    /* Modal de calificar - Estilo mejorado */
    .modal-prof {
        display: none;
        position: fixed;
        z-index: 3000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content-prof {
        background: white;
        margin: auto;
        border-radius: 20px;
        max-width: 550px;
        width: 100%;
        padding: 35px 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: slideUp 0.3s ease;
        border: 1px solid rgba(14, 178, 124, 0.1);
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(30px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    .close-prof {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 28px;
        cursor: pointer;
        color: #95a5a6;
        transition: all 0.3s ease;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: transparent;
    }

    .close-prof:hover {
        color: #e74c3c;
        background: #fee;
        transform: rotate(90deg);
    }

    .modal-header-prof {
        margin-bottom: 25px;
        text-align: center;
    }

    .modal-header-prof .modal-title-prof {
        font-size: 1.6rem;
        margin-bottom: 10px;
        color: #025939;
        font-weight: 700;
    }

    .modal-header-prof .modal-subtitle-prof {
        color: #7f8c8d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    .star-rating-prof {
        display: flex;
        gap: 12px;
        margin: 25px 0;
        font-size: 42px;
        cursor: pointer;
        justify-content: center;
    }

    .star-prof {
        color: #e0e0e0;
        transition: all 0.2s ease;
        user-select: none;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .star-prof:hover {
        transform: scale(1.15);
    }

    .star-prof.active-prof {
        color: #ffc107;
        transform: scale(1.1);
        text-shadow: 0 4px 8px rgba(255, 193, 7, 0.4);
    }

    .comment-section-prof {
        margin-top: 25px;
    }

    .comment-label-prof {
        display: block;
        margin-bottom: 10px;
        color: #2c3e50;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .comment-textarea-prof {
        width: 100%;
        min-height: 110px;
        border-radius: 12px;
        border: 2px solid #e1e5e9;
        padding: 14px 16px;
        font-size: 0.95rem;
        resize: vertical;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .comment-textarea-prof:focus {
        outline: none;
        border-color: #0eb27c;
        background: white;
        box-shadow: 0 0 0 4px rgba(14, 178, 124, 0.1);
    }

    .comment-textarea-prof:hover {
        border-color: #0eb27c;
        background: white;
    }

    .modal-actions-prof {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
    }

    .modal-btn-prof {
        padding: 13px 28px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .modal-btn-secondary-prof {
        background: #f0f0f0;
        color: #495057;
        border: 2px solid #e0e0e0;
    }

    .modal-btn-secondary-prof:hover {
        background: #e8e8e8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-btn-primary-prof {
        background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
    }

    .modal-btn-primary-prof:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 178, 124, 0.4);
    }

    .modal-btn-primary-prof:active {
        transform: translateY(0);
    }

    @media (max-width: 580px) {
        .modal-content-prof { 
            padding: 25px 20px; 
            border-radius: 16px;
        }
        
        .star-rating-prof { 
            font-size: 36px;
            gap: 8px;
        }
        
        .modal-header-prof .modal-title-prof {
            font-size: 1.3rem;
        }
        
        .modal-actions-prof {
            flex-direction: column;
        }
        
        .modal-btn-prof {
            width: 100%;
            padding: 12px 20px;
        }
    }

    @media (max-width: 480px) {
        .modal-content-prof { 
            padding: 16px; 
        }
        .star-rating-prof { 
            font-size: 22px; 
        }
    }
  </style>
</head>
<body>
  <header>
        
        <div class="header-logo">
          <a href="vistas-cliente.php" style="color: inherit; text-decoration: none; display: flex; align-items: center;">
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
                    </div>
                </div>
            </div>

            <div class="header-icon">
                <a href="perfil-cliente.php" style="color: inherit; text-decoration: none;">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </header>
  
  <main class="pagina-servicio">
    <div class="contenedor-servicio">
      <!-- Sección Principal -->
      <div class="seccion-principal">
        <div class="imagen-destacada"></div>
        
        <div class="contenido-servicio">
          <div class="categoria">Diseño y Creatividad</div>
          <h1 class="titulo-principal"><?php echo htmlspecialchars($servicio['titulo']); ?></h1>
          
          <p class="descripcion">
           <?php echo htmlspecialchars($servicio['descripcion']); ?>
          </p>
        </div>
      </div>

      <!-- Sidebar Proveedor -->
      <aside class="sidebar-proveedor">
        <div class="card-proveedor">

          <img src="../img/usuario-juan.jpg" alt="Foto de <?php echo htmlspecialchars($usuario['fotoperfil'] ?? 'Proveedor'); ?>" class="foto-proveedor" />
          <a href="../vistas/perfil-externo.php" class="nombre-proveedor"><?php echo htmlspecialchars($usuario['nombre'] ?? 'Proveedor', ENT_QUOTES); ?></a>

          <div class="rating">
            <span>★</span>
            <span>★</span>
            <span>★</span>
            <span>★</span>
            <span>☆</span>
          </div>
          <p class="ubicacion">Pocitos, Montevideo</p>
          
          <div class="separador"></div>
          
          <div class="precio-container">
            <div class="precio-label">Desde</div>
            <div class="precio">$120<span class="precio-periodo">/proyecto</span></div>
          </div>
          <!-- class="btn btn-mensaje" -->
          <div class="botones-accion">
            <a href="solicitud.php"><button class="btn btn-solicitar">Solicitar Servicio</button></a>

          
            <form action="../chatphp/chat.php" method="post">
  <input type="hidden" name="emite" value="<?php echo htmlspecialchars($usuario['cedula']); ?>">
  <button type="submit" class="btn btn-mensaje">Enviar Mensaje</button>
</form>

            <button class="btn btn-reportar">Reportar Usuario</button>


          </div>
        </div>
      </aside>
    </div>
  </main>

  <div id="chatModalContainer"></div>

  <!-- Modal de calificar (copiado de perfil-externo) -->
  <div id="ratingModal-prof" class="modal-prof" aria-hidden="true">
    <div class="modal-content-prof" role="dialog" aria-modal="true" aria-labelledby="ratingTitle-prof">
        <span class="close-prof" aria-label="Cerrar">&times;</span>
        <div class="modal-header-prof">
            <h2 id="ratingTitle-prof" class="modal-title-prof">Calificar a Juan Martínez</h2>
            <p class="modal-subtitle-prof">Tu opinión nos ayuda a mejorar la comunidad</p>
        </div>

        <div class="star-rating-prof" aria-label="Seleccionar calificación">
            <span class="star-prof" data-rating="1">★</span>
            <span class="star-prof" data-rating="2">★</span>
            <span class="star-prof" data-rating="3">★</span>
            <span class="star-prof" data-rating="4">★</span>
            <span class="star-prof" data-rating="5">★</span>
        </div>

        <div class="comment-section-prof">
            <label for="comment-prof" class="comment-label-prof">Comentario (opcional)</label>
            <textarea id="comment-prof" class="comment-textarea-prof" placeholder="Comparte tu experiencia..."></textarea>
        </div>

        <div class="modal-actions-prof">
            <button class="modal-btn-prof modal-btn-secondary-prof" id="cancelBtn-prof">Cancelar</button>
            <button class="modal-btn-prof modal-btn-primary-prof" id="submitRating-prof">Enviar Calificación</button>
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
  let chatModalLoaded = false;



  document.addEventListener('DOMContentLoaded', function() {
    // Captura botones y enlaces que abren el modal y previene navegación
    document.querySelectorAll('a, button').forEach(el => {
      // Si el elemento o su hijo tiene la clase .btn-mensaje lo enlazamos
      if (el.matches('.btn-mensaje') || el.querySelector?.('.btn-mensaje')) {
        el.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          loadChatModal();
        });
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
<script>
(function() {
    const modalProf = document.getElementById('ratingModal-prof');
    if (!modalProf) return;

    const openModalBtnProf = document.querySelector('.btn-calificar') || document.querySelector('.btn-solicitar') || document.getElementById('openModal-prof');
    const closeModalBtnProf = modalProf.querySelector('.close-prof');
    const cancelBtnProf = document.getElementById('cancelBtn-prof');
    const submitBtnProf = document.getElementById('submitRating-prof');
    const starsProf = modalProf.querySelectorAll('.star-prof');
    const commentProfEl = document.getElementById('comment-prof');
    let selectedRatingProf = 0;

    // abrir modal si se dispara el botón (si existe un botón específico)
    // Aquí en publicacion.php no había un "Calificar" público, así que si querés abrir desde un elemento concreto agrega id="openModal-prof" a ese botón.
    if (openModalBtnProf) {
        openModalBtnProf.addEventListener('click', (e) => {
            e.preventDefault();
            showModalProf();
        });
    }

    function showModalProf() {
        modalProf.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeModalProf() {
        modalProf.style.display = 'none';
        document.body.style.overflow = 'auto';
        resetModalProf();
    }

    closeModalBtnProf.addEventListener('click', closeModalProf);
    cancelBtnProf.addEventListener('click', closeModalProf);

    window.addEventListener('click', (event) => {
        if (event.target === modalProf) closeModalProf();
    });

    starsProf.forEach((starProf, indexProf) => {
        starProf.addEventListener('mouseenter', () => highlightStarsProf(indexProf + 1));
        starProf.addEventListener('mouseleave', () => highlightStarsProf(selectedRatingProf));
        starProf.addEventListener('click', () => {
            selectedRatingProf = indexProf + 1;
            highlightStarsProf(selectedRatingProf);
        });
    });

    function highlightStarsProf(ratingProf) {
        starsProf.forEach((starProf, indexProf) => {
            starProf.classList.toggle('active-prof', indexProf < ratingProf);
        });
    }

    function resetModalProf() {
        selectedRatingProf = 0;
        highlightStarsProf(0);
        if (commentProfEl) commentProfEl.value = '';
    }

    submitBtnProf.addEventListener('click', () => {
        if (selectedRatingProf === 0) {
            alert('Por favor, selecciona una calificación');
            return;
        }
        const commentProf = commentProfEl ? commentProfEl.value.trim() : '';
        // Aquí envía por fetch/XHR al servidor si necesitas persistir la calificación
        // Ejemplo (ajusta URL y payload según tu backend):
        /*
        fetch('/conexion/ratings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ providerId: 'juan-id', rating: selectedRatingProf, comment: commentProf })
        }).then(res => res.json()).then(resp => {
            // manejar respuesta
        }).catch(err => console.error(err));
        */
        alert(`¡Gracias! Calificación enviada: ${selectedRatingProf} estrella${selectedRatingProf>1?'s':''}`);
        closeModalProf();
    });
})();
</script>
</body>
</html>