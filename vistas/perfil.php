<?php
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil de Usuario</title>
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <link rel="conexion" href="../conexion/controllerUsuario.php">
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #ffffff;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* ===== HEADER NUEVO ===== */
.header-nuevo {
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%) !important;
  padding: 1rem 2rem !important;
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  box-shadow: 0 8px 32px rgba(14, 178, 124, 0.2) !important;
  position: sticky !important;
  top: 0 !important;
  z-index: 1000 !important;
  width: 100% !important;
}

.header-logo {
  font-size: 1.8rem !important;
  font-weight: 800 !important;
  color: white !important;
  letter-spacing: 0.5px !important;
  display: flex !important;
  align-items: center !important;
  gap: 0.5rem !important;
}

.header-actions {
  display: flex !important;
  gap: 2rem !important;
  align-items: center !important;
}

.header-icon {
  color: white !important;
  font-size: 1.3rem !important;
  cursor: pointer !important;
  transition: all 0.3s ease !important;
  position: relative !important;
  text-decoration: none !important;
  display: inline-block !important;
}

.header-icon:hover {
  transform: scale(1.2) rotate(5deg) !important;
  filter: brightness(1.2) !important;
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

/* ===== CONTENIDO PERFIL ===== */
.contenedor {
  flex: 1;
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0;
}

.perfil {
  border: 3px solid #aec3bb;
  border-radius: 20px;
  padding: 50px;
  width: 700px;
  background-color: #fbfcfa;
  text-align: center;
  box-shadow: 0 6px 16px rgba(27, 81, 16, 0.548);
}

.redonda {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
  border: 3px solid #025939;
}

.nombre-usuario {
  font-size: 22px;
  margin: 10px 0 5px;
  color: #333;
}

.gmail {
  color: #000000;
  margin-bottom: 20px;
}

.botones {
  display: flex;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}

.btneditar, .btncerrar {
  padding: 10px 18px;
  border: none;
  border-radius: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btneditar {
  background-color: #11be7f;
  color: #fcfdfb;
}

.btneditar:hover {
  background-color: #025939;
}

.btncerrar {
  background-color: #c6c9b9;
  color: #333;
  text-decoration: none;
  display: inline-block;
}

.btncerrar:hover {
  background-color: #999;
  color: #c6c9b9;
}

/* ===== MODAL EDIT ===== */
.modal-overlay-edit {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  transition: all 0.3s ease;
}

.modal-overlay-edit.active {
  display: flex;
}

.modal-edit {
  background: #fff;
  border-radius: 20px;
  padding: 40px;
  width: 90%;
  max-width: 800px;
  position: relative;
  border: 3px solid #26e0a3;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  transform: translateY(-30px);
  transition: transform 0.3s ease;
  z-index: 2001;
}

.modal-overlay-edit.active .modal-edit {
  transform: translateY(0);
}

.modal-header-edit {
  text-align: center;
  margin-bottom: 30px;
}

.modal-title-edit {
  font-size: 32px;
  font-weight: bold;
  color: #26e0a3;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.close-btn-edit {
  position: absolute;
  top: 20px;
  right: 25px;
  background: none;
  border: none;
  font-size: 30px;
  color: #26e0a3;
  cursor: pointer;
  padding: 5px;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn-edit:hover {
  background: #26e0a3;
  color: #f9fffd;
  transform: rotate(90deg);
}

.modal-content-edit {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 40px;
  align-items: start;
  background: transparent;
  z-index: 2002;
}

.form-section-edit {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.form-group-edit {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-label-edit {
  font-size: 18px;
  font-weight: 600;
  color: #374151;
}

.form-input-edit, .form-select-edit, .form-textarea-edit {
  padding: 12px 16px;
  border: 2px solid #26e0a3;
  border-radius: 12px;
  font-size: 16px;
  transition: all 0.2s ease;
  background: #f9fffd;
}

.form-input-edit:focus, .form-select-edit:focus, .form-textarea-edit:focus {
  outline: none;
  border-color: #1fb087;
  box-shadow: 0 0 0 3px rgba(38, 224, 163, 0.1);
}

.form-input-edit:disabled {
  background: #f0f9ff;
  color: #6b7280;
  cursor: not-allowed;
}

.form-select-edit {
  cursor: pointer;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2326e0a3' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 20px;
  padding-right: 45px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

.form-textarea-edit {
  resize: vertical;
  min-height: 120px;
  font-family: inherit;
}

.profile-section-edit {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.profile-photo-container-edit {
  position: relative;
  width: 180px;
  height: 180px;
  border: 4px solid #26e0a3;
  border-radius: 50%;
  background: #f9fffd;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  overflow: hidden;
}

.profile-photo-container-edit:hover {
  border-color: #1fb087;
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(38, 224, 163, 0.3);
}

.profile-photo-container-edit input[type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 2;
}

.upload-overlay-edit {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(38, 224, 163, 0.8);
  border-radius: 50%;
  display: none;
  align-items: center;
  justify-content: center;
  transition: opacity 0.3s ease;
}

.profile-photo-container-edit:hover .upload-overlay-edit {
  display: flex;
  opacity: 1;
}

.upload-icon-edit {
  font-size: 30px;
  color: #f9fffd;
}

.profile-inputs-edit {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.save-btn-edit {
  background: linear-gradient(135deg, #26e0a3 0%, #1fb087 100%);
  color: #f9fffd;
  border: none;
  padding: 15px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  width: 100%;
  margin-bottom: 0px;
}

.save-btn-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(38, 224, 163, 0.4);
}

.save-btn-edit:active {
  transform: translateY(0);
}

.delete-btn-edit {
  background: linear-gradient(135deg, #e6344a 0%, #b8001c 100%);
  color: #f9fffd;
  border: none;
  padding: 15px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  width: 100%;
  margin-top: 1px;
}

.delete-btn-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(230, 52, 74, 0.4);
}

.delete-btn-edit:active {
  transform: translateY(0);
}

/* ===== FOOTER ===== */
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
/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .modal-edit {
    padding: 25px;
    width: 95%;
  }

  .modal-content-edit {
    grid-template-columns: 1fr;
    gap: 25px;
  }

  .modal-title-edit {
    font-size: 24px;
  }

  .profile-section-edit {
    order: -1;
  }

  .profile-photo-container-edit {
    width: 150px;
    height: 150px;
  }
}

@media (max-width: 600px) {
  .header-nuevo {
    padding: 1rem !important;}
  }
/* ===== TABS ===== */
.tabs-section {
  max-width: 1200px;
  margin: 40px auto;
  padding: 0 20px;
}

.tabs-header {
  display: flex;
  gap: 0;
  border-bottom: 3px solid #e0e0e0;
  margin-bottom: 30px;
}

.tab-button {
  flex: 1;
  padding: 18px 30px;
  background: transparent;
  border: none;
  font-size: 18px;
  font-weight: 600;
  color: #7f8c8d;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  border-bottom: 3px solid transparent;
  margin-bottom: -3px;
}

.tab-button.active {
  color: #0eb27c;
  border-bottom-color: #0eb27c;
  background: rgba(14, 178, 124, 0.08);
}

.tab-content {
  display: none;
  animation: fadeIn 0.4s ease;
}

.tab-content.active {
  display: block;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ===== STATISTICS ===== */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 35px;
  margin-bottom: 40px;
}

.stat-card {
  background: linear-gradient(135deg, #ffffff 0%, #f0fdf9 100%);
  border: 3px solid #aec3bb;
  border-radius: 25px;
  padding: 45px 35px;
  text-align: center;
  box-shadow: 0 6px 20px rgba(14, 178, 124, 0.15);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 12px 35px rgba(14, 178, 124, 0.25);
  border-color: #0eb27c;
}

.stat-icon {
  width: 90px;
  height: 90px;
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 25px;
  color: white;
  font-size: 40px;
  box-shadow: 0 8px 20px rgba(14, 178, 124, 0.3);
  transition: all 0.4s ease;
}

.stat-value {
  font-size: 48px;
  font-weight: 900;
  color: #025939;
  margin-bottom: 12px;
  letter-spacing: -1px;
}

.stat-label {
  font-size: 18px;
  color: #5a6c64;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* ===== SERVICES ===== */
.service-actions-top {
  display: flex;
  gap: 15px;
  margin-bottom: 30px;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 15px;
}

.btn-action-top {
  padding: 12px 30px;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.5;
  pointer-events: none;
}

.btn-action-top.active {
  opacity: 1;
  pointer-events: all;
}

.btn-modify {
  background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
  color: white;
}

.btn-modify.active:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
}

.btn-delete-top {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
  color: white;
}

.btn-delete-top.active:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* ← 3 columnas fijas */
  gap: 25px;
}

.service-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 15px;
  padding: 30px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
}

.service-card:hover {
  border-color: #0eb27c;
  box-shadow: 0 8px 25px rgba(14, 178, 124, 0.15);
  transform: translateY(-5px);
}

.service-card.selected {
  border-color: #0eb27c;
  border-width: 3px;
  background: linear-gradient(135deg, #f0fdf9 0%, #e6f7f1 100%);
  box-shadow: 0 10px 30px rgba(14, 178, 124, 0.25);
}

.service-card-title {
  font-size: 22px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
  line-height: 1.3;
}

.service-card-description {
  font-size: 15px;
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 20px;
}

.service-card-meta {
  display: flex;
  gap: 15px;
  font-size: 14px;
  color: #95a5a6;
  margin-bottom: 15px;
}

.service-card-meta span {
  display: flex;
  align-items: center;
  gap: 8px;
}

.service-card-meta i {
  color: #0eb27c;
  width: 20px;
}

.service-card-price {
  font-size: 24px;
  font-weight: 800;
  color: #0eb27c;
  margin-top: 15px;
}

/* ===== CALENDAR ===== */
.calendar-container {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 10px 40px rgba(14, 178, 124, 0.15);
  border: 3px solid #0eb27c;
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 2px solid #e0e0e0;
}

.calendar-month {
  font-size: 28px;
  font-weight: 700;
  color: #2c3e50;
}

.calendar-nav {
  display: flex;
  gap: 15px;
}

.calendar-nav-btn {
  width: 40px;
  height: 40px;
  border: 2px solid #0eb27c;
  background: white;
  border-radius: 10px;
  cursor: pointer;
  color: #0eb27c;
  font-size: 18px;
  transition: all 0.3s ease;
}

.calendar-nav-btn:hover {
  background: #0eb27c;
  color: white;
  transform: scale(1.1);
}

.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 10px;
  margin-bottom: 15px;
}

.calendar-weekday {
  text-align: center;
  font-weight: 700;
  color: #0eb27c;
  font-size: 14px;
  text-transform: uppercase;
  padding: 10px 0;
}

.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 10px;
}

.calendar-day {
  aspect-ratio: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  background: #f8f9fa;
  color: #2c3e50;
}

.calendar-day:hover:not(.disabled):not(.reserved) {
  background: #e6f7f1;
  border-color: #0eb27c;
  transform: scale(1.05);
}

.calendar-day.disabled {
  background: #ecf0f1;
  color: #bdc3c7;
  cursor: not-allowed;
  opacity: 0.5;
}

.calendar-day.reserved {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
  color: white;
  cursor: not-allowed;
  position: relative;
}

.calendar-day.reserved::after {
  content: '✕';
  position: absolute;
  font-size: 12px;
  top: 2px;
  right: 4px;
}

.calendar-day.available {
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
  color: white;
  box-shadow: 0 4px 15px rgba(14, 178, 124, 0.3);
}

.calendar-day.today {
  border: 2px solid #3498db;
  font-weight: 800;
}

.calendar-legend {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 2px solid #e0e0e0;
}

.calendar-legend-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
  color: #7f8c8d;
}

.calendar-legend-box {
  width: 25px;
  height: 25px;
  border-radius: 6px;
}

.legend-available {
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
}

.legend-reserved {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
}

.legend-disabled {
  background: #ecf0f1;
}

@media (max-width: 768px) {
  .services-grid {
    grid-template-columns: 1fr;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }
}
/* ===== MODAL EDIT SERVICE ===== */
.modal-overlay-edit-service {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 2500;
}

.modal-overlay-edit-service.active {
  display: flex;
}

.modal-edit-service {
  background: #fff;
  border-radius: 20px;
  padding: 40px;
  width: 90%;
  max-width: 900px;
  max-height: 90vh;
  overflow-y: auto;
  border: 3px solid #3498db;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  position: relative;
}

.modal-header-edit-service {
  text-align: center;
  margin-bottom: 30px;
}

.modal-title-edit-service {
  font-size: 32px;
  font-weight: bold;
  color: #3498db;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.close-btn-edit-service {
  position: absolute;
  top: 20px;
  right: 25px;
  background: none;
  border: none;
  font-size: 30px;
  color: #3498db;
  cursor: pointer;
  width: 40px;
  height: 40px;
}

.form-group-edit-service {
  margin-bottom: 20px;
}

.form-label-edit-service {
  display: block;
  font-size: 16px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
}

.form-input-edit-service,
.form-select-edit-service,
.form-textarea-edit-service {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #3498db;
  border-radius: 12px;
  font-size: 16px;
  background: #f8fbff;
}

.form-textarea-edit-service {
  min-height: 100px;
  resize: vertical;
  font-family: inherit;
}

.save-btn-edit-service {
  width: 100%;
  background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
  color: white;
  border: none;
  padding: 15px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-top: 20px;
}

/* ===== MODAL NOTIFICATION ===== */
.modal-overlay-notification {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 4000;
  animation: fadeIn 0.3s ease;
}

.modal-overlay-notification.active {
  display: flex;
}

.modal-notification {
  background: white;
  border-radius: 25px;
  padding: 40px;
  width: 90%;
  max-width: 450px;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: scaleIn 0.3s ease;
}

@keyframes scaleIn {
  from {
    transform: scale(0.8);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

.modal-notification-icon {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 25px;
  color: white;
  font-size: 45px;
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

.modal-notification-icon.success {
  background: linear-gradient(135deg, #0eb27c 0%, #047857 100%);
  box-shadow: 0 8px 20px rgba(14, 178, 124, 0.4);
}

.modal-notification-title {
  font-size: 28px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
}

.modal-notification-text {
  font-size: 16px;
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 30px;
}

.btn-notification-ok {
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

.btn-notification-ok:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(14, 178, 124, 0.4);
}
@media (max-width: 600px) {
  .header-nuevo {
    padding: 1rem !important;
  }
}

.modal-overlay-delete {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none; /* ← esto es clave */
  align-items: center;
  justify-content: center;
  z-index: 3000;
}

.modal-overlay-delete.active {
  display: flex;
}
/* ===== MODAL DELETE SERVICE ===== */
.modal-overlay-delete {
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

.modal-overlay-delete.active {
  display: flex;
}

.modal-delete {
  background: white;
  border-radius: 25px;
  padding: 45px;
  width: 90%;
  max-width: 500px;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: scaleIn 0.3s ease;
  position: relative;
}

.modal-delete-icon {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 25px;
  color: white;
  font-size: 50px;
  box-shadow: 0 8px 20px rgba(231, 76, 60, 0.4);
  animation: bounceIn 0.5s ease;
}

.modal-delete-title {
  font-size: 32px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
}

.modal-delete-text {
  font-size: 17px;
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 35px;
}

.modal-delete-text span {
  font-weight: 700;
  color: #e74c3c;
}

.modal-delete-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
}

.btn-cancel,
.btn-confirm {
  padding: 14px 40px;
  border-radius: 15px;
  border: none;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  min-width: 140px;
}

.btn-cancel {
  background: #ecf0f1;
  color: #7f8c8d;
}

.btn-cancel:hover {
  background: #bdc3c7;
  color: #2c3e50;
  transform: translateY(-2px);
}

.btn-confirm {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
  color: white;
}

.btn-confirm:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
}

/* ===== MODAL CANCEL RESERVATION ===== */
.modal-overlay-cancel-reservation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 3500;
  animation: fadeIn 0.3s ease;
}

.modal-overlay-cancel-reservation.active {
  display: flex;
}

.modal-cancel-reservation {
  background: white;
  border-radius: 25px;
  padding: 45px;
  width: 90%;
  max-width: 500px;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: scaleIn 0.3s ease;
}

.modal-cancel-icon {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 25px;
  color: white;
  font-size: 50px;
  box-shadow: 0 8px 20px rgba(243, 156, 18, 0.4);
  animation: bounceIn 0.5s ease;
}

.modal-cancel-title {
  font-size: 32px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
}

.modal-cancel-text {
  font-size: 17px;
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 10px;
}

.modal-cancel-date {
  font-size: 20px;
  font-weight: 700;
  color: #e67e22;
  margin-bottom: 35px;
}

.modal-cancel-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
}

.btn-cancel-no,
.btn-cancel-yes {
  padding: 14px 40px;
  border-radius: 15px;
  border: none;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  min-width: 140px;
}

.btn-cancel-no {
  background: #ecf0f1;
  color: #7f8c8d;
}

.btn-cancel-no:hover {
  background: #bdc3c7;
  color: #2c3e50;
  transform: translateY(-2px);
}

.btn-cancel-yes {
  background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
  color: white;
}

.btn-cancel-yes:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(243, 156, 18, 0.4);
}

/* Animaciones */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Estilos adicionales para el modal de editar servicio */
.modal-overlay-edit-service .close-btn-edit-service:hover {
  background: #3498db;
  color: white;
  transform: rotate(90deg);
}

.form-select-edit-service option {
  padding: 10px;
}

.save-btn-edit-service:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(52, 152, 219, 0.4);
}

.save-btn-edit-service:active {
  transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 600px) {
  .modal-delete,
  .modal-cancel-reservation,
  .modal-notification {
    padding: 30px 20px;
    width: 95%;
  }

  .modal-delete-icon,
  .modal-cancel-icon,
  .modal-notification-icon {
    width: 80px;
    height: 80px;
    font-size: 40px;
  }

  .modal-delete-title,
  .modal-cancel-title,
  .modal-notification-title {
    font-size: 24px;
  }

  .modal-delete-actions,
  .modal-cancel-actions {
    flex-direction: column;
  }

  .btn-cancel,
  .btn-confirm,
  .btn-cancel-no,
  .btn-cancel-yes {
    width: 100%;
  }
}

  </style>
  
</head>
<body>
  <!-- Header -->
  <header class="header-nuevo">
    <div class="header-logo">
      <img src="../img/logomini.png" alt="SkillMatch Logo" style="height: 50px; width: auto; margin-right: 0.5rem;">
      <a href="../vistas/vistas-prov.php" style="text-decoration: none; color: white;">
        SkillMatch
      </a>
    </div>
    <div class="header-actions">
      <div style="position: relative;">
        <div class="header-icon" id="notificationBell" style="position:relative; cursor:pointer;">
          <i class="fas fa-bell"></i>
          <span id="notifBadge" style="position: absolute; top: -6px; right: -10px; min-width: 20px; height: 20px; background: #ff6b6b; color: white; border-radius: 50%; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold; padding:0 6px;"></span>
        </div>

        <div class="notification-modal" id="notificationModal">
          <div class="notification-header">
            <h3>Notificaciones</h3>
            <i class="fas fa-times" id="closeNotifications" style="cursor:pointer;color:#7f8c8d;"></i>
          </div>
          <div class="notification-list"></div>
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

  <div class="contenedor">
    <div class="perfil">
      <!-- Foto de perfil -->
    
      <img src="../img/<?php echo htmlspecialchars($usuario['fotoperfil'] ?? '4ae62d57-16c3-4974-b494-e9c26f8036fe.jpg'); ?>" 
           alt="Foto de perfil" class="redonda" />

      <!-- Nombre y correo -->
      <h2 class="nombre-usuario"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h2>
      <p class="gmail"><?php echo htmlspecialchars($usuario['email']); ?></p>

      <!-- Username y Edad -->
      <p>Username: <?php echo htmlspecialchars($usuario['username']); ?></p>
      <p>Edad: <?php echo htmlspecialchars($usuario['edad']); ?></p>

      <div class="botones">
        <button class="btneditar">Editar perfil</button>
        <a href="registro.html" class="btncerrar">Cerrar Sesion</a>
      </div>
    </div>
  </div>


<div>





<?php
require_once '../conexion/controllerUsuario.php';


  $cx=(new ClaseConexion())->getConexion();
   

require_once '../conexion/modelUsuario.php';

$chats = Usuario::cargarChatsProv();

?>





 
<?php  
if (!empty($chats)) {
  echo '<form action="../chatphp/chat.php" method="POST">';
  echo "<ul>";
    foreach ($chats as $c) {
        // Agregar un campo oculto para el idemisor
        echo '<li>';
        //echo '<input type="submit" name="emite" value="' . htmlspecialchars($c['idemisor']) . '">';
        echo '<button type="submit" name="emite" value="' . htmlspecialchars($c['idemisor']) . '">' . htmlspecialchars($c['nombre']) . '</button>';
        echo '</li>';
    }
    echo "</ul>";
    echo '</form>'; // Asegúrate de cerrar el formulario aquí
} else {
    echo '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No hay usuarios.</p></div>';
}
?>










</div>



  <div class="modal-overlay-edit" id="editProfileModalOverlay">
    <div class="modal-edit">
      <div class="modal-header-edit">
        <h2 class="modal-title-edit">Editar Perfil</h2>
        <button class="close-btn-edit" id="closeModalBtn">×</button>
      </div>
 <form action="../conexion/controllerUsuario.php" method="POST" enctype="multipart/form-data">
      <div class="modal-content-edit">
        <div class="form-section-edit">
          <div class="form-group-edit">
            <label class="form-label-edit">Localidad</label>
            <select class="form-select-edit" id="locationSelect" name="localidad">
              <option>Ciudades</option>
              <option>Montevideo</option>
              <option>Salto</option>
              <option>Paysandú</option>
              <option>Las Piedras</option>
              <option>Rivera</option>
              <option>Maldonado</option>
              <option>Tacuarembó</option>
              <option>Melo</option>
              <option>Mercedes</option>
              <option>Artigas</option>
              <option>Minas</option>
              <option>San José de Mayo</option>
              <option>Durazno</option>
              <option>Florida</option>
              <option>Treinta y Tres</option>
              <option>Rocha</option>
              <option>Colonia del Sacramento</option>
              <option>Fray Bentos</option>
              <option>Canelones</option>
              <option>Young</option>
              <option>Carmelo</option>
              <option>Trinidad</option>
            </select>
          </div>

          <div class="form-group-edit">
            <label class="form-label-edit">Habilidades</label>
            <textarea class="form-textarea-edit" name="habilidad"  id="skillsTextarea" placeholder="Describe tus principales habilidades y competencias..."></textarea>
          </div>

          <div class="form-group-edit">
            <label class="form-label-edit">Experiencia</label>
            <textarea class="form-textarea-edit" name="experiencia"id="experienceTextarea" placeholder="Cuéntanos sobre tu experiencia profesional..."></textarea>
          </div>
        </div>
 
        <div class="profile-section-edit">
            <div class="profile-photo-container-edit" id="photoContainer">
            <div class="upload-overlay-edit">
              <i class="fa-solid fa-image upload-icon-edit"></i>
            </div>
           
           


            
          </div>
 <input type="file" id="photoInput" name="foto" accept="image/*">
          <div class="profile-inputs-edit">
            <input type="text" class="form-input-edit" id="nameInput" placeholder="Alexandra Gim" value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" disabled>
            <input type="text" class="form-input-edit" id="usernameInput" name="username" placeholder="username" value="<?php echo htmlspecialchars($usuario['username'] ?? ''); ?>">
            <!-- Enviar la ruta actual de la foto (si existe) para que el controlador la use cuando no se suba una nueva -->
            <input type="hidden" name="fotoperfil" value="<?php echo htmlspecialchars($usuario['fotoperfil'] ?? ''); ?>">
          </div>

          <button type="submit" name="action" value="modificar" class="save-btn-edit" id="saveBtn">Guardar</button>
          <button type="submit" name="action" value="eliminar"   class="delete-btn-edit" id="deleteBtn">Eliminar Usuario</button>
        </div>
      </div>
    </div>
  </div>

  </form>
    <!-- Tabs Section -->


<!-- Modal Delete Service -->
<div class="modal-overlay-delete" id="deleteServiceModal">
  <div class="modal-delete">
    <div class="modal-delete-icon"><i class="fas fa-exclamation-triangle"></i></div>
    <h2 class="modal-delete-title">¿Estás seguro?</h2>
    <p class="modal-delete-text">¿Deseas eliminar el servicio "<span id="serviceNameToDelete"></span>"?</p>
    <div class="modal-delete-actions">
      <button class="btn-cancel" onclick="closeDeleteModal()">Cancelar</button>
      <button class="btn-confirm" onclick="confirmDelete()">Eliminar</button>
    </div>
  </div>
</div>

<!-- Modal Notification -->
<div class="modal-overlay-notification" id="notificationSuccess">
  <div class="modal-notification">
    <div class="modal-notification-icon success"><i class="fas fa-check-circle"></i></div>
    <h2 class="modal-notification-title" id="notificationTitle">¡Éxito!</h2>
    <p class="modal-notification-text" id="notificationText">La operación se completó correctamente.</p>
    <button class="btn-notification-ok" onclick="closeNotification()">Aceptar</button>
  </div>
</div>

<!-- Modal Editar Servicio -->
<div class="modal-overlay-edit-service" id="editServiceModal">
  <div class="modal-edit_service">
    <div class="modal-header-edit-service">
      <h2 class="modal-title-edit-service">Editar Servicio</h2>
      <button class="close-btn-edit-service" id="closeEditServiceBtn">×</button>
    </div>

    <form action="#" method="POST">
      <div class="form-group-edit-service">
        <label class="form-label-edit-service">Título del Servicio</label>
        <input type="text" class="form-input-edit-service" name="titulo" placeholder="Ej: Desarrollo Web Full Stack">
      </div>

      <div class="form-group-edit-service">
        <label class="form-label-edit-service">Descripción</label>
        <textarea class="form-textarea-edit-service" name="descripcion" placeholder="Describe tu servicio..."></textarea>
      </div>

      <div class="form-group-edit-service">
        <label class="form-label-edit-service">Categoría</label>
        <select class="form-select-edit-service" name="categoria">
          <option value="">Seleccionar</option>
          <option value="Tecnología">Tecnología</option>
          <option value="Diseño">Diseño</option>
          <option value="Marketing">Marketing</option>
          <option value="Soporte Técnico">Soporte Técnico</option>
          <option value="Fotografía">Fotografía</option>
          <option value="Redacción">Redacción</option>
        </select>
      </div>

      <div class="form-group-edit-service">
        <label class="form-label-edit-service">Localidad</label>
        <select class="form-select-edit-service" name="localidad">
          <option value="">Seleccionar</option>
          <option value="Montevideo">Montevideo</option>
          <option value="Salto">Salto</option>
          <option value="Maldonado">Maldonado</option>
          <option value="Punta del Este">Punta del Este</option>
          <option value="Paysandú">Paysandú</option>
        </select>
      </div>

      <div class="form-group-edit-service">
        <label class="form-label-edit-service">Precio</label>
        <input type="number" class="form-input-edit-service" name="precio" placeholder="Ej: 1200">
      </div>

      <button type="submit" class="save-btn-edit-service">Guardar Cambios</button>
    </form>
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
    document.querySelector('.btneditar').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.add('active');
    };
    document.getElementById('closeModalBtn').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.remove('active');
    };
    document.getElementById('saveBtn').onclick = function() {
      document.getElementById('editProfileModalOverlay').classList.remove('active');
    };
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

  <script>
    (function(){
      // Lee el fragmento de la URL después de #
      const hash = window.location.hash.substring(1); // quita el "#"
      const params = new URLSearchParams(hash);
      const d = params.get('d');
      if (!d) return;

      try {
        // Decodificar lo que mandó PHP con urlencode
        const obj = JSON.parse(decodeURIComponent(d));

        // Actualizar el DOM
        const nombreEl = document.querySelector('.nombre-usuario');
        const correoEl = document.querySelector('.gmail');

        if (nombreEl) nombreEl.textContent = obj.nombre || '';
        if (correoEl) correoEl.textContent = obj.email || '';
      } catch (e) {
        console.error("Payload inválido", e);
      }
    })();
  </script>

 <script>
    // ===== VARIABLES GLOBALES =====
let selectedServiceId = null;
let currentMonth = 9; // Octubre (0-indexed)
let currentYear = 2025;
let dateToCancel = null;

// Fechas reservadas en formato YYYY-MM-DD (mutable para poder eliminar)
let reservedDates = <?php 
    if(isset($_SESSION['cedula'])) {
        $reservas = Usuario::obtenerReservas($_SESSION['cedula']);
        $fechas = array_map(function($r) {
            return $r['fecha'];
        }, $reservas);
        echo json_encode($fechas);
    } else {
        echo '[]';
    }
?>;

// Datos de servicios
const serviceData = {
  1: {
    title: 'Desarrollo Web Full Stack',
    location: 'Montevideo',
    category: 'Tecnología',
    price: '1200',
    description: 'Creación de aplicaciones web completas con React, Node.js y bases de datos. Diseño responsive y optimizado para SEO.'
  },
  2: {
    title: 'Identidad Visual Corporativa',
    location: 'Salto',
    category: 'Diseño',
    price: '650',
    description: 'Desarrollo completo de marca: logo, manual de identidad, papelería corporativa y elementos visuales para redes sociales.'
  },
  3: {
    title: 'Estrategia de Marketing Digital',
    location: 'Maldonado',
    category: 'Marketing',
    price: '890',
    description: 'Plan integral de marketing digital: análisis de mercado, gestión de redes sociales, campañas publicitarias y métricas de rendimiento.'
  },
  4: {
    title: 'Mantenimiento y Soporte IT',
    location: 'Montevideo',
    category: 'Soporte Técnico',
    price: '280',
    description: 'Servicio mensual de soporte técnico, mantenimiento preventivo, actualización de sistemas y resolución de incidencias en menos de 24 horas.'
  },
  5: {
    title: 'Sesión Fotográfica de Producto',
    location: 'Punta del Este',
    category: 'Fotografía',
    price: '420',
    description: 'Fotografía profesional para e-commerce con fondo blanco, edición incluida y hasta 50 productos. Entrega en 72 horas.'
  },
  6: {
    title: 'Redacción de Contenido SEO',
    location: 'Montevideo',
    category: 'Redacción',
    price: '350',
    description: 'Pack de 10 artículos optimizados para SEO de 1000 palabras cada uno, con investigación de keywords y meta descripciones incluidas.'
  }
};

// ===== FUNCIONES DE NOTIFICACIONES =====
function showNotificationModal(title, message) {
  document.getElementById('notificationTitle').textContent = title;
  document.getElementById('notificationText').textContent = message;
  document.getElementById('notificationSuccess').classList.add('active');
}

function closeNotification() {
  document.getElementById('notificationSuccess').classList.remove('active');
}

// ===== FUNCIONES DE TABS =====
function initTabs() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      const tabName = button.getAttribute('data-tab');
      
      tabButtons.forEach(btn => btn.classList.remove('active'));
      tabContents.forEach(content => content.classList.remove('active'));
      
      button.classList.add('active');
      document.getElementById(tabName).classList.add('active');
    });
  });
}

// ===== FUNCIONES DE SERVICIOS =====
function selectService(serviceId) {
  const cards = document.querySelectorAll('.service-card');
  const clickedCard = document.querySelector(`[data-service-id="${serviceId}"]`);
  
  if (selectedServiceId === serviceId) {
    // Deseleccionar
    selectedServiceId = null;
    clickedCard.classList.remove('selected');
    updateActionButtons(false);
  } else {
    // Seleccionar
    cards.forEach(card => card.classList.remove('selected'));
    selectedServiceId = serviceId;
    clickedCard.classList.add('selected');
    updateActionButtons(true);
  }

  if (selectedServiceId) {
    initCalendar(); // Recargar calendario con las reservas del servicio seleccionado
  }
}

function updateActionButtons(active) {
  const btnModify = document.getElementById('btnModify');
  const btnDelete = document.getElementById('btnDelete');
  
  if (active) {
    btnModify.classList.add('active');
    btnDelete.classList.add('active');
  } else {
    btnModify.classList.remove('active');
    btnDelete.classList.remove('active');
  }
}

function modifySelected() {
  if (!selectedServiceId) return;
  
  const service = serviceData[selectedServiceId];
  if (!service) return;

  // Llenar el formulario con los datos actuales
  document.querySelector('#editServiceModal input[name="titulo"]').value = service.title;
  document.querySelector('#editServiceModal select[name="localidad"]').value = service.location;
  document.querySelector('#editServiceModal select[name="categoria"]').value = service.category;
  document.querySelector('#editServiceModal input[name="precio"]').value = service.price;
  document.querySelector('#editServiceModal textarea[name="descripcion"]').value = service.description;

  document.getElementById('editServiceModal').classList.add('active');
}

function deleteSelected() {
  if (!selectedServiceId) return;
  
  const card = document.querySelector(`[data-service-id="${selectedServiceId}"]`);
  const serviceName = card.querySelector('.service-card-title').textContent;
  
  document.getElementById('serviceNameToDelete').textContent = serviceName;
  document.getElementById('deleteServiceModal').classList.add('active');
}

function closeDeleteModal() {
  document.getElementById('deleteServiceModal').classList.remove('active');
}

function confirmDelete() {
  if (!selectedServiceId) return;
  
  // Cerrar modal de confirmación
  closeDeleteModal();
  
  // Deseleccionar
  selectedServiceId = null;
  updateActionButtons(false);
  
  const cards = document.querySelectorAll('.service-card');
  cards.forEach(card => card.classList.remove('selected'));
  
  // Mostrar notificación de éxito
  showNotificationModal('¡Eliminado con Éxito!', 'El servicio ha sido eliminado correctamente.');
}

function closeEditServiceModal() {
  document.getElementById('editServiceModal').classList.remove('active');
}

function handleEditServiceSubmit(e) {
  e.preventDefault();
  
  // Cerrar modal
  closeEditServiceModal();
  
  // Mostrar notificación de éxito
  showNotificationModal('¡Modificado con Éxito!', 'El servicio ha sido modificado correctamente.');
}

// ===== FUNCIONES DEL CALENDARIO =====
function initCalendar() {
  // Cargar reservas al iniciar
  fetch('../conexion/controllerReserva.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'action=obtener_reservas&idservicio=' + selectedServiceId
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        reservedDates = data.reservas.map(r => r.fecha);
        renderCalendar(currentMonth, currentYear);
    }
});
}

function renderCalendar(month, year) {
  const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  
  document.querySelector('.calendar-month').textContent = `${monthNames[month]} ${year}`;
  
  const calendarDaysDiv = document.getElementById('calendarDays');
  calendarDaysDiv.innerHTML = '';
  
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  // Agregar días vacíos al inicio
  for (let i = 0; i < firstDay; i++) {
    const emptyDay = document.createElement('div');
    emptyDay.className = 'calendar-day disabled';
    calendarDaysDiv.appendChild(emptyDay);
  }
  
  // Agregar días del mes
  for (let day = 1; day <= daysInMonth; day++) {
    const dayDiv = document.createElement('div');
    dayDiv.className = 'calendar-day';
    dayDiv.textContent = day;
    
    const currentDate = new Date(year, month, day);
    currentDate.setHours(0, 0, 0, 0);
    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    
    if (currentDate.getTime() === today.getTime()) {
      dayDiv.classList.add('today');
    }
    
    if (currentDate < today) {
      dayDiv.classList.add('disabled');
    } else if (reservedDates.includes(dateString)) {
      dayDiv.classList.add('reserved');
      dayDiv.title = 'Reservado';
      dayDiv.addEventListener('click', (e) => {
        e.stopPropagation();
        openCancelReservationModal(dateString);
      });
    } else {
      dayDiv.classList.add('available');
    }
    
    calendarDaysDiv.appendChild(dayDiv);
  }
}

function previousMonth() {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar(currentMonth, currentYear);
}

function nextMonth() {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentMonth, currentYear);
}

function openCancelReservationModal(dateString) {
  dateToCancel = dateString;
  
  // Formatear la fecha para mostrarla más bonita
  const [year, month, day] = dateString.split('-');
  const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  const formattedDate = `${day} de ${monthNames[parseInt(month) - 1]} de ${year}`;
  
  document.getElementById('reservationDateToCancel').textContent = formattedDate;
  document.getElementById('cancelReservationModal').classList.add('active');
}

function closeCancelReservationModal() {
  document.getElementById('cancelReservationModal').classList.remove('active');
  dateToCancel = null;
}

function confirmCancelReservation() {
    if (!dateToCancel) return;
    
    // Send cancellation request to server
    fetch('../conexion/controllerUsuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=cancelReservation&fecha=${dateToCancel}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from local array
            const index = reservedDates.indexOf(dateToCancel);
            if (index > -1) {
                reservedDates.splice(index, 1);
            }
            
            // Update calendar
            renderCalendar(currentMonth, currentYear);
            
            // Show success message
            showNotificationModal('¡Cancelado con Éxito!', 
                'La reserva ha sido cancelada correctamente.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotificationModal('Error', 
            'No se pudo cancelar la reserva. Por favor intente nuevamente.');
    });
    
    closeCancelReservationModal();
}

// ===== EVENT LISTENERS =====
function initEventListeners() {
  // Botones de acciones de servicios
  const btnModify = document.getElementById('btnModify');
  const btnDelete = document.getElementById('btnDelete');
  
  if (btnModify) {
    btnModify.addEventListener('click', modifySelected);
  }
  
  if (btnDelete) {
    btnDelete.addEventListener('click', deleteSelected);
  }
  
  // Cerrar modal de editar servicio
  const closeEditServiceBtn = document.getElementById('closeEditServiceBtn');
  if (closeEditServiceBtn) {
    closeEditServiceBtn.addEventListener('click', closeEditServiceModal);
  }
  
  // Cerrar modales al hacer clic fuera
  const editServiceModal = document.getElementById('editServiceModal');
  if (editServiceModal) {
    editServiceModal.addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditServiceModal();
      }
    });
  }
  
  const deleteServiceModal = document.getElementById('deleteServiceModal');
  if (deleteServiceModal) {
    deleteServiceModal.addEventListener('click', function(e) {
      if (e.target === this) {
        closeDeleteModal();
      }
    });
  }
  
  const notificationSuccess = document.getElementById('notificationSuccess');
  if (notificationSuccess) {
    notificationSuccess.addEventListener('click', function(e) {
      if (e.target === this) {
        closeNotification();
      }
    });
  }
  
  const cancelReservationModal = document.getElementById('cancelReservationModal');
  if (cancelReservationModal) {
    cancelReservationModal.addEventListener('click', function(e) {
      if (e.target === this) {
        closeCancelReservationModal();
      }
    });
  }
  
  // Formulario de editar servicio
  const editServiceForm = document.querySelector('#editServiceModal form');
  if (editServiceForm) {
    editServiceForm.addEventListener('submit', handleEditServiceSubmit);
  }
}

// ===== INICIALIZACIÓN =====
document.addEventListener('DOMContentLoaded', function() {
  initTabs();
  initCalendar();
  initEventListeners();
  
  console.log(' Sistema inicializado correctamente');
  console.log(` Fechas reservadas: ${reservedDates.length}`);
});

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si venimos del dashboard y hay un hash #services
    const hash = window.location.hash;
    const searchParams = new URLSearchParams(hash.split('?')[1]);
    
    if(hash.includes('#services') && searchParams.get('from') === 'dashboard') {
        // Encontrar el div de servicios
        const servicesDiv = document.getElementById('services');
        if(servicesDiv) {
            // Activar la pestaña de servicios
            document.querySelector('[data-tab="services"]').click();
            
            // Scroll suave hacia la sección
            setTimeout(() => {
                servicesDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
});
</script>
<script>
  (function(){
    const bell = document.getElementById('notificationBell');
    const modal = document.getElementById('notificationModal');
    const closeBtn = document.getElementById('closeNotifications');
    const listEl = modal ? modal.querySelector('.notification-list') : null;
    const badge = document.getElementById('notifBadge');

    function escapeHtml(s){ return String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

    async function loadNotifications() {
      if (!listEl) return;
      try {
        const res = await fetch('../conexion/getNotifications.php?action=list', { credentials: 'same-origin' });
        const json = await res.json();
        if (!json.success) { listEl.innerHTML = emptyState('Error al cargar'); return; }
        const list = json.notifications || [];
        const unread = json.unread || 0;
        badge.textContent = unread > 0 ? unread : '';

        if (list.length === 0) {
          listEl.innerHTML = emptyState('Buzón vacío', 'No hay notificaciones por ahora. Volvé más tarde o tocá actualizar.');
          const btn = document.getElementById('notifRefresh');
          if (btn) btn.addEventListener('click', loadNotifications);
          return;
        }

        listEl.innerHTML = '';
        list.forEach(n => {
          // defensa extra: solo permitir tipos válidos
          if (!['reporte','solicitud','calificacion'].includes(n.tipo)) return;
          const item = document.createElement('div');
          item.className = 'notification-item' + (n.leida == 0 ? ' unread' : '');
          item.style.display = 'flex';
          item.style.padding = '10px';
          item.style.borderBottom = '1px solid #eef2f7';
          item.style.gap = '10px';
          item.innerHTML = `
            <div class="notification-icon" style="font-size:18px;color:#045a4a;"><i class="fas fa-bell"></i></div>
            <div class="notification-content" style="flex:1;">
              <div class="notification-title" style="font-weight:600">${escapeHtml(n.mensaje)}</div>
              <div class="notification-time" style="font-size:12px;color:#6b7280">${new Date(n.fecha).toLocaleString()}</div>
            </div>
          `;
          item.dataset.id = n.idnotificacion;
          item.dataset.tipo = n.tipo;
          item.dataset.ref = n.referencia;
          item.addEventListener('click', async () => {
            await markAsRead(n.idnotificacion);
            item.classList.remove('unread');
            // redirecciones ejemplo (ajustar rutas según tu app)
            if (n.tipo === 'reporte') window.location.href = '/ProyectoProgramacion/vistas/admin/reports.php';
            else if (n.tipo === 'solicitud') window.location.href = '/ProyectoProgramacion/vistas/reservas.php';
            else if (n.tipo === 'calificacion') window.location.href = '/ProyectoProgramacion/vistas/mis-calificaciones.php';
          });
          listEl.appendChild(item);
        });
      } catch (err) {
        console.error('loadNotifications', err);
        if (listEl) listEl.innerHTML = emptyState('Error al cargar', 'No se pudieron cargar las notificaciones. Reintentá.');
      }
    }

    function emptyState(title, desc){
      desc = desc || 'No hay notificaciones por ahora.';
      return `
        <div class="notification-empty" style="padding:18px;text-align:center;color:#6b7280;display:flex;flex-direction:column;align-items:center;gap:10px;">
          <div class="icon" style="width:56px;height:56px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:22px;color:#64748b;box-shadow:0 6px 18px rgba(15,23,42,0.04);">
            <i class="fas fa-inbox"></i>
          </div>
          <div class="title" style="font-weight:700;color:#374151;">${escapeHtml(title)}</div>
          <div class="desc" style="font-size:0.92rem;max-width:260px;line-height:1.3;color:#6b7280;">${escapeHtml(desc)}</div>
          <button class="btn-refresh" id="notifRefresh" style="margin-top:8px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:600;">Actualizar</button>
        </div>
      `;
    }

    async function markAsRead(id) {
      try {
        const res = await fetch('../conexion/getNotifications.php?action=mark', {
          method: 'POST',
          credentials: 'same-origin',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        });
        const j = await res.json();
        if (j.success) loadNotifications();
        return j.success;
      } catch (e) {
        console.error('markAsRead', e);
        return false;
      }
    }

    // Toggle modal & listeners
    if (bell && modal) {
      bell.addEventListener('click', async (e) => {
        modal.classList.toggle('active');
        if (modal.classList.contains('active')) await loadNotifications();
      });
    }
    if (closeBtn && modal) closeBtn.addEventListener('click', () => modal.classList.remove('active'));

    // Close when click outside
    document.addEventListener('click', (e) => {
      if (!modal || !bell) return;
      if (!bell.contains(e.target) && !modal.contains(e.target)) modal.classList.remove('active');
    });

    // load initial badge and poll
    loadNotifications();
    setInterval(loadNotifications, 45000);
  })();
</script>
</body>
</html>
