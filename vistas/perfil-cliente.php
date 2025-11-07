<?php
require_once('../conexion/guards/auth_guard.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../conexion/modelUsuario.php');

// Verificamos que haya alguien logueado
if (!isset($_SESSION['cedula'])) {
    header("Location: ../vistas/login.php");
    exit();
}

// Cargamos datos del usuario
$usuario = Usuario::buscarPorCedula($_SESSION['cedula']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Perfil - Cliente</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e6f7f1 0%, #d1f0e5 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ===== HEADER ===== */
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

    /* ===== PROFILE SECTION ===== */
    .profile-container {
      flex: 1;
      max-width: 1400px;
      margin: 3rem auto;
      padding: 0 2rem;
      width: 100%;
    }

    .profile-card {
      background: white;
      border-radius: 30px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(14, 178, 124, 0.2);
      display: grid;
      grid-template-columns: 350px 1fr;
      min-height: 600px;
    }

    /* SIDEBAR */
    .profile-sidebar {
      background: linear-gradient(180deg, #0eb27c 0%, #047857 100%);
      padding: 3rem 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: white;
      position: relative;
    }

    .profile-photo-wrapper {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      border: 6px solid rgba(255, 255, 255, 0.3);
      overflow: hidden;
      margin-bottom: 1.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-photo {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-name {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-align: center;
    }

    .profile-username {
      font-size: 1rem;
      opacity: 0.9;
      margin-bottom: 0.3rem;
    }

    .profile-age {
      font-size: 0.95rem;
      opacity: 0.8;
      margin-bottom: 2rem;
    }

    .profile-stats {
      width: 100%;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.8rem 0;
      font-size: 0.95rem;
    }

    .stat-label {
      opacity: 0.9;
    }

    .stat-value {
      font-weight: 700;
      font-size: 1.1rem;
    }

    .edit-profile-btn {
      width: 100%;
      padding: 0.9rem;
      background: white;
      color: #0eb27c;
      border: none;
      border-radius: 15px;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: auto;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .edit-profile-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
    }

    /* MAIN CONTENT */
    .profile-main {
      padding: 3rem;
      background: #fafafa;
    }

    .profile-section {
      margin-bottom: 2.5rem;
    }

    .section-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .section-title i {
      color: #0eb27c;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    .info-item {
      background: white;
      padding: 1.5rem;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .info-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 20px rgba(14, 178, 124, 0.2);
      border-color: #0eb27c;
    }

    .info-label {
      font-size: 0.85rem;
      color: #7f8c8d;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .info-value {
      font-size: 1.1rem;
      color: #2c3e50;
      font-weight: 600;
    }

    .description-box {
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      line-height: 1.8;
      color: #555;
      border: 2px solid #e0e0e0;
      transition: all 0.3s ease;
    }

    .description-box:hover {
      border-color: #0eb27c;
      box-shadow: 0 5px 20px rgba(14, 178, 124, 0.15);
    }

    .badges-container {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .badge {
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      color: white;
      padding: 0.6rem 1.2rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
      transition: all 0.3s ease;
    }

    .badge:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(14, 178, 124, 0.4);
    }

    /* ===== MODAL EDITAR PERFIL ===== */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 2000;
      animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
      display: flex;
    }

    .modal {
      background: white;
      border-radius: 25px;
      padding: 2.5rem;
      width: 90%;
      max-width: 600px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      animation: scaleIn 0.3s ease;
      position: relative;
      border: 3px solid #0eb27c;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes scaleIn {
      from {
        transform: scale(0.9);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .modal-header {
      text-align: center;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 2px solid #e6f7f1;
    }

    .modal-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #0eb27c;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .close-btn {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      background: none;
      border: none;
      font-size: 1.8rem;
      color: #0eb27c;
      cursor: pointer;
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .close-btn:hover {
      background: #0eb27c;
      color: white;
      transform: rotate(90deg);
    }

    .photo-upload-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 2rem;
      border-bottom: 2px solid #e6f7f1;
    }

    .photo-preview {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      border: 4px solid #0eb27c;
      overflow: hidden;
      margin-bottom: 1rem;
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .photo-preview:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 25px rgba(14, 178, 124, 0.4);
    }

    .photo-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .photo-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(14, 178, 124, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .photo-preview:hover .photo-overlay {
      opacity: 1;
    }

    .photo-overlay i {
      font-size: 2rem;
      color: white;
    }

    .photo-input {
      display: none;
    }

    .upload-btn {
      padding: 0.7rem 1.5rem;
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .upload-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(14, 178, 124, 0.4);
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-size: 0.95rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
      width: 100%;
      padding: 0.9rem 1.2rem;
      border: 2px solid #0eb27c;
      border-radius: 12px;
      font-size: 1rem;
      transition: all 0.3s ease;
      font-family: inherit;
      background: #f9fffd;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: #047857;
      box-shadow: 0 0 0 3px rgba(14, 178, 124, 0.1);
    }

    .form-input:disabled {
      background: #f0f9ff;
      color: #6b7280;
      cursor: not-allowed;
    }

    .form-textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%230eb27c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 20px;
      padding-right: 45px;
    }

    .save-btn {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      color: white;
      border: none;
      border-radius: 15px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .save-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(14, 178, 124, 0.4);
    }

    /* ===== MODAL SUCCESS NOTIFICATION ===== */
    .modal-success-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 3000;
      animation: fadeIn 0.3s ease;
    }

    .modal-success-overlay.active {
      display: flex;
    }

    .modal-success {
      background: white;
      border-radius: 25px;
      padding: 40px;
      width: 90%;
      max-width: 450px;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      animation: scaleIn 0.3s ease;
    }

    .modal-success-icon {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      color: white;
      font-size: 45px;
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      box-shadow: 0 8px 20px rgba(14, 178, 124, 0.4);
      animation: bounceIn 0.5s ease;
    }

    @keyframes bounceIn {
      0% {
        transform: scale(0);
      }
      50% {
        transform: scale(1.1);
      }
      100% {
        transform: scale(1);
      }
    }

    .modal-success-title {
      font-size: 28px;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 15px;
    }

    .modal-success-text {
      font-size: 16px;
      color: #7f8c8d;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .btn-success-ok {
      padding: 14px 50px;
      border-radius: 15px;
      border: none;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
      color: white;
    }

    .btn-success-ok:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(14, 178, 124, 0.4);
    }

    /* ===== FOOTER ===== */
    .footer {
      background: linear-gradient(135deg, #059669 0%, #10b981 100%);
      padding: 2rem;
      color: white;
      text-align: center;
      margin-top: auto;
    }

    .footer p {
      opacity: 0.8;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 968px) {
      .profile-card {
        grid-template-columns: 1fr;
      }

      .profile-sidebar {
        padding: 2rem;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 600px) {
      .header {
        padding: 1rem 1.5rem;
      }

      .profile-container {
        padding: 0 1rem;
        margin: 2rem auto;
      }

      .profile-main {
        padding: 2rem 1.5rem;
      }

      .modal {
        padding: 2rem 1.5rem;
      }
    }

    /* Modificar el estilo existente o agregar después del edit-profile-btn */
.sign-out-btn {
    width: 100%;
    padding: 0.9rem;
    background: linear-gradient(135deg, #ff4d4d 0%, #cc0000 100%);
    color: white;
    border: none;
    border-radius: 15px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.sign-out-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 77, 77, 0.3);
}
  </style>
</head>
<body>
  <!-- HEADER -->
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

            <!-- Botón Cerrar sesión -->
            <form action="../logout.php" method="POST" style="display:inline; margin:0;">
              <button type="submit" class="header-icon" title="Cerrar sesión" style="background:none; border:none; color:white; cursor:pointer;">
                <i class="fas fa-sign-out-alt"></i>
              </button>
            </form>
        </div>
    </header>
  <!-- PROFILE CONTAINER -->
  <div class="profile-container">
    <div class="profile-card">
      <!-- SIDEBAR -->
      <div class="profile-sidebar">
        <div class="profile-photo-wrapper">
          <img src="../img/4ae62d57-16c3-4974-b494-e9c26f8036fe.jpg" alt="Foto de perfil" class="profile-photo">
        </div>
        <h2 class="profile-name">María González</h2>
        <p class="profile-username">@maria.gonzalez</p>
        <p class="profile-age">28 años</p>

        <div class="profile-stats">
          <div class="stat-item">
            <span class="stat-label">Ubicación</span>
            <span class="stat-value">Uruguay</span>
          </div>
        </div>

        <button class="edit-profile-btn" onclick="openEditModal()">
          <i class="fas fa-edit"></i> Editar Perfil
        </button>
        <button class="sign-out-btn" style="margin-top: 1rem; background: #ff4d4d; color: white; border: none; padding: 0.9rem; border-radius: 15px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease;">
          <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </button>
      </div>

      <!-- MAIN CONTENT -->
      <div class="profile-main">
        <div class="profile-section">
          <h3 class="section-title">
            <i class="fas fa-info-circle"></i>
            Información Personal
          </h3>
          <div class="info-grid">
            <div class="info-item">
              <div class="info-label">Nombre Completo</div>
              <div class="info-value">María González</div>
            </div>
            <div class="info-item">
              <div class="info-label">Username</div>
              <div class="info-value">@maria.gonzalez</div>
            </div>
            <div class="info-item">
              <div class="info-label">Localidad</div>
              <div class="info-value"><i class="fas fa-map-marker-alt" style="color: #0eb27c;"></i> Montevideo</div>
            </div>
            <div class="info-item">
              <div class="info-label">Edad</div>
              <div class="info-value">28 años</div>
            </div>
          </div>
        </div>

        <!-- descripcion section -->
        <div class="profile-section">
          <h3 class="section-title">
            <i class="fas fa-user"></i>
            Sobre Mí
          </h3>
          <div class="description-box">
            Soy una profesional apasionada por la tecnología y el diseño. Me encanta descubrir nuevos servicios y trabajar con profesionales talentosos. Busco siempre calidad y compromiso en cada proyecto. Disfruto conectar con personas creativas y aprender de sus experiencias.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL EDITAR PERFIL -->
  <div class="modal-overlay" id="editModal">
    <div class="modal">
      <div class="modal-header">
        <h2 class="modal-title">Editar Mi Perfil</h2>
        <button class="close-btn" onclick="closeEditModal()">×</button>
      </div>

      <form>
        <!-- UPLOAD PHOTO -->
        <div class="photo-upload-section">
          <label for="photoInput" class="photo-preview">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop" alt="Preview" id="photoPreview">
            <div class="photo-overlay">
              <i class="fas fa-camera"></i>
            </div>
          </label>
          <input type="file" id="photoInput" class="photo-input" accept="image/*" onchange="previewPhoto(event)">
          <label for="photoInput" class="upload-btn">
            <i class="fas fa-upload"></i> Cambiar Foto
          </label>
        </div>

        <!-- FORM FIELDS -->
        <div class="form-group">
          <label class="form-label">Nombre Completo</label>
          <input type="text" class="form-input" value="María González" disabled>
        </div>

        <div class="form-group">
          <label class="form-label">Username</label>
          <input type="text" class="form-input" value="@maria.gonzalez" placeholder="@tu_username">
        </div>

        <div class="form-group">
          <label class="form-label">Localidad</label>
          <select class="form-select">
            <option>Montevideo</option>
            <option>Salto</option>
            <option>Paysandú</option>
            <option>Maldonado</option>
            <option>Canelones</option>
            <option>Colonia</option>
            <option>Rivera</option>
            <option>Rocha</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Descripción Personal</label>
          <textarea class="form-textarea" placeholder="Cuéntanos sobre ti...">Soy una profesional apasionada por la tecnología y el diseño. Me encanta descubrir nuevos servicios y trabajar con profesionales talentosos. Busco siempre calidad y compromiso en cada proyecto. Disfruto conectar con personas creativas y aprender de sus experiencias.</textarea>
        </div>

        <button type="submit" class="save-btn" onclick="saveProfile(event)">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </form>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 SkillMatch. Todos los derechos reservados.</p>
  </footer>

  <!-- MODAL SUCCESS NOTIFICATION -->
  <div class="modal-success-overlay" id="successModal">
    <div class="modal-success">
      <div class="modal-success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2 class="modal-success-title">¡Perfil Modificado!</h2>
      <p class="modal-success-text">Tus cambios han sido guardados correctamente.</p>
      <button class="btn-success-ok" onclick="closeSuccessModal()">Aceptar</button>
    </div>
  </div>

  <script>
    // Abrir modal
    function openEditModal() {
      document.getElementById('editModal').classList.add('active');
    }

    // Cerrar modal
    function closeEditModal() {
      document.getElementById('editModal').classList.remove('active');
    }

    // Cerrar al hacer clic fuera
    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditModal();
      }
    });

    // Preview de foto
    function previewPhoto(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('photoPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }

    // Guardar perfil
    function saveProfile(event) {
      event.preventDefault();
      closeEditModal();
      // Mostrar modal de éxito
      document.getElementById('successModal').classList.add('active');
    }

    // Cerrar modal de éxito
    function closeSuccessModal() {
      document.getElementById('successModal').classList.remove('active');
    }

    // Cerrar modal de éxito al hacer clic fuera
    document.getElementById('successModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeSuccessModal();
      }
    });

    // Notificaciones
    const notificationBell = document.getElementById('notificationBell');
    const notificationModal = document.getElementById('notificationModal');
    const closeNotifications = document.getElementById('closeNotifications');

    notificationBell.addEventListener('click', () => {
      notificationModal.classList.toggle('active');
    });

    closeNotifications.addEventListener('click', () => {
      notificationModal.classList.remove('active');
    });

    // Cerrar notificaciones al hacer click afuera
    document.addEventListener('click', (e) => {
      if (!notificationBell.contains(e.target) && !notificationModal.contains(e.target)) {
        notificationModal.classList.remove('active');
      }
    });
  </script>
</body>
</html>