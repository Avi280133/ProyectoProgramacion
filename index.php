<?php
session_start();

function isUserAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireAuth() {
    if (!isUserAuthenticated()) {
        // No redirigir, solo mostrar el modal
        return false;
    }
    return true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Modal Overlay */
        .auth-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(2, 89, 57, 0.95);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.5s ease;
            overflow: hidden;
            padding: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Decoraciones de fondo */
        .bg-decorations {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(14, 178, 124, 0.3), rgba(153, 177, 101, 0.3));
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            top: 20%;
            right: -100px;
            animation-delay: 3s;
        }

        .shape-3 {
            width: 250px;
            height: 250px;
            bottom: -125px;
            left: 30%;
            animation-delay: 6s;
        }

        .shape-4 {
            width: 180px;
            height: 180px;
            bottom: 10%;
            right: 10%;
            animation-delay: 9s;
        }

        .geometric-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(30px, -30px) rotate(90deg);
            }
            50% {
                transform: translate(-20px, 20px) rotate(180deg);
            }
            75% {
                transform: translate(40px, 10px) rotate(270deg);
            }
        }

        /* Partículas flotantes */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particle-float 15s infinite;
        }

        @keyframes particle-float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(50px);
                opacity: 0;
            }
        }

        /* Modal Container */
        .auth-modal-container {
            background: white;
            border-radius: 30px;
            box-shadow: 
                0 30px 90px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            max-width: 900px;
            width: 85%;
            position: relative;
            z-index: 10000;
            animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Header decorativo */
        .modal-header {
            background: linear-gradient(135deg, #025939 0%, #0eb27c 50%, #99b165 100%);
            padding: 60px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.1), transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0.05), transparent 50%);
        }

        .modal-icon {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
            position: relative;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
            }
        }

        .modal-icon i {
            font-size: 40px;
            color: white;
        }

        .modal-title {
            font-size: 2.2rem;
            color: white;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            line-height: 1.6;
            position: relative;
            max-width: 90%;
        }

        /* Modal Body */
        .modal-body {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .benefits-list {
            list-style: none;
            margin-bottom: 35px;
        }

        .benefits-list li {
            display: flex;
            align-items: center;
            padding: 12px 0;
            color: #4a5568;
            font-size: 0.95rem;
            animation: slideInLeft 0.5s ease forwards;
            opacity: 0;
        }

        .benefits-list li:nth-child(1) { animation-delay: 0.2s; }
        .benefits-list li:nth-child(2) { animation-delay: 0.3s; }
        .benefits-list li:nth-child(3) { animation-delay: 0.4s; }
        .benefits-list li:nth-child(4) { animation-delay: 0.5s; }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .benefits-list li i {
            color: #0eb27c;
            margin-right: 12px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Botones */
        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .auth-btn {
            padding: 16px 32px;
            border: none;
            border-radius: 15px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auth-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .auth-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .auth-btn span {
            position: relative;
            z-index: 2;
        }

        .btn-login {
            background: linear-gradient(135deg, #0eb27c 0%, #025939 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(14, 178, 124, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(14, 178, 124, 0.4);
        }

        .btn-register {
            background: white;
            color: #025939;
            border: 2px solid #0eb27c;
            box-shadow: 0 4px 15px rgba(14, 178, 124, 0.15);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 178, 124, 0.25);
            background: rgba(14, 178, 124, 0.05);
        }

        /* Footer del modal */
        .modal-footer {
            padding: 25px 50px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            border-top: 1px solid rgba(14, 178, 124, 0.1);
            grid-column: 1 / -1;
        }

        .modal-footer p {
            color: #6c757d;
            font-size: 0.85rem;
            margin: 0;
        }

        .modal-footer a {
            color: #0eb27c;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .modal-footer a:hover {
            color: #025939;
        }

        /* Logo flotante */
        .floating-logo {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            opacity: 0.1;
            animation: float-logo 6s infinite ease-in-out;
        }

        @keyframes float-logo {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-10px);
            }
        }
        @media (max-width: 768px) {
            .auth-modal-container {
                max-width: 95%;
                width: 95%;
                grid-template-columns: 1fr;
                margin: 20px;
            }

            .modal-header {
                padding: 40px 30px 30px;
            }

            .modal-body {
                padding: 30px 25px;
            }

            .modal-title {
                font-size: 1.6rem;
            }

            .modal-subtitle {
                font-size: 0.95rem;
                max-width: 100%;
            }

            .floating-shape {
                display: none;
            }

            .benefits-list li {
                font-size: 0.9rem;
            }

            .modal-footer {
                padding: 20px 25px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .auth-modal-container {
                max-width: 750px;
                width: 90%;
            }

            .modal-header {
                padding: 50px 40px;
            }

            .modal-body {
                padding: 50px 40px;
            }
        }


        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .auth-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .auth-btn:disabled .loading-spinner {
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php if (!requireAuth()): ?>
    <div class="auth-modal-overlay" id="authModal">
        <div class="bg-decorations">
            <div class="geometric-pattern"></div>
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
            
            <?php for ($i = 0; $i < 20; $i++): ?>
                <div class="particle" style="left: <?php echo rand(0, 100); ?>%; animation-delay: <?php echo rand(0, 15); ?>s;"></div>
            <?php endfor; ?>
        </div>

 
        <div class="auth-modal-container">

            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h2 class="modal-title">¡Bienvenido a SkillMatch!</h2>
                <p class="modal-subtitle">Accede a miles de profesionales listos para ayudarte</p>
            </div>

            <div class="modal-body">
                <ul class="benefits-list">
                    <li>
                        <i class="fa-solid fa-check-circle"></i>
                        <span>Acceso ilimitado a todos los servicios</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-star"></i>
                        <span>Conecta con profesionales verificados</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Transacciones 100% seguras</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-heart"></i>
                        <span>Guarda tus favoritos y más</span>
                    </li>
                </ul>

                <div class="auth-buttons">
                    <a href="vistas/login.php" class="auth-btn btn-login">
                        <i class="fa-solid fa-sign-in-alt"></i>
                        <span>Iniciar Sesión</span>
                        <div class="loading-spinner"></div>
                    </a>
                    <a href="vistas/registro.php" class="auth-btn btn-register">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Crear Cuenta Gratis</span>
                        <div class="loading-spinner"></div>
                    </a>

                    </div>
                
                <!-- Checkbox de Términos y Condiciones -->
                <div class="terms-checkbox">
                    <label for="terminos">
                        <input type="checkbox" id="terminos">
                        <span>Acepto los términos y condiciones</a></span>
                    </label>
                </div>

                
            </div>
                </div>
            </div>

            <div class="modal-footer">
                <p>¿Necesitas ayuda? <a href="vistas/soporte.php">Centro de Soporte</a></p>
            
            </div>
        </div>
    </div>

    <script>
        // Prevenir cierre del modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                return false;
            }
        });

        // Prevenir cierre con click fuera del modal
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) {
                e.preventDefault();
                // Pequeña animación de "sacudida" para indicar que no se puede cerrar
                const container = document.querySelector('.auth-modal-container');
                container.style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    container.style.animation = 'slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                }, 500);
            }
        });

        // Animación de sacudida
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);

        // Simular carga en botones (opcional)
        document.querySelectorAll('.auth-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Si quieres agregar un estado de carga antes de navegar:
                // e.preventDefault();
                // this.disabled = true;
                // setTimeout(() => window.location.href = this.href, 1000);
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>