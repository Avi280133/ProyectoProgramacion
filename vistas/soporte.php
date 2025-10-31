<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Soporte - SkillMatch</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e8561 0%, #2d9f6f 50%, #8ab353 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            padding-top: 20px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.95;
        }

        .back-button {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }

        .content-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 35px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section h2 {
            color: #1e8561;
            font-size: 1.8em;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section h3 {
            color: #2d9f6f;
            font-size: 1.3em;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .section p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .icon {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e8561, #2d9f6f);
            border-radius: 50%;
            color: white;
            font-size: 20px;
        }

        .faq-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #1e8561;
        }

        .faq-question {
            font-weight: bold;
            color: #1e8561;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .contact-card {
            background: linear-gradient(135deg, #1e8561, #2d9f6f);
            padding: 25px;
            border-radius: 15px;
            color: white;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .contact-card h4 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .contact-card p {
            color: white;
            opacity: 0.95;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 12px 0;
            padding-left: 30px;
            position: relative;
            color: #555;
        }

        .feature-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #1e8561;
            font-weight: bold;
            font-size: 1.2em;
        }

        .alert-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .alert-box p {
            color: #2e7d32;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="back-button">← Volver al inicio</a>
        
        <div class="header">
            <h1>Centro de Soporte</h1>
            <p>Estamos aquí para ayudarte en cada paso</p>
        </div>

        <div class="content-card">
            <div class="section">
                <h2><span class="icon">📋</span> ¿Qué es SkillMatch?</h2>
                <p>SkillMatch es una plataforma innovadora que conecta profesionales con oportunidades laborales ideales. Utilizamos tecnología avanzada para emparejar tus habilidades, experiencia y preferencias con las necesidades de empresas verificadas.</p>
                <p>Nuestro objetivo es simplificar tu búsqueda de empleo y ayudarte a encontrar el trabajo perfecto para ti.</p>
            </div>

            <div class="section">
                <h2><span class="icon">🚀</span> Cómo Empezar</h2>
                <ul class="feature-list">
                    <li><strong>Crea tu cuenta:</strong> Regístrate gratis con tu correo electrónico o redes sociales</li>
                    <li><strong>Completa tu perfil:</strong> Añade tu experiencia, habilidades y preferencias laborales</li>
                    <li><strong>Explora oportunidades:</strong> Navega por miles de ofertas de empresas verificadas</li>
                    <li><strong>Aplica con un clic:</strong> Envía tu candidatura fácilmente a las posiciones que te interesen</li>
                    <li><strong>Recibe notificaciones:</strong> Te avisamos cuando haya nuevas oportunidades que coincidan contigo</li>
                </ul>
            </div>

            <div class="section">
                <h2><span class="icon">❓</span> Preguntas Frecuentes</h2>
                
                <div class="faq-item">
                    <div class="faq-question">¿Es gratis usar SkillMatch?</div>
                    <p>Sí, crear una cuenta y buscar empleos es completamente gratis. Ofrecemos funciones premium opcionales para mejorar tu experiencia.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">¿Cómo puedo editar mi perfil?</div>
                    <p>Una vez iniciada la sesión, dirígete a "Mi Perfil" en el menú principal. Desde ahí podrás actualizar tu información, añadir nuevas habilidades o cambiar tus preferencias.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">¿Las empresas están verificadas?</div>
                    <p>Absolutamente. Todas las empresas en nuestra plataforma pasan por un proceso de verificación riguroso para garantizar la autenticidad de las ofertas.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">¿Cómo funcionan las notificaciones?</div>
                    <p>Puedes configurar alertas personalizadas según tus intereses. Te notificaremos por email o notificaciones push cuando haya nuevas oportunidades relevantes.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">¿Puedo aplicar a varias ofertas simultáneamente?</div>
                    <p>Sí, puedes aplicar a tantas ofertas como desees. Recomendamos personalizar tu carta de presentación para cada aplicación.</p>
                </div>
            </div>

            <div class="section">
                <h2><span class="icon">🔒</span> Seguridad y Privacidad</h2>
                <p>Tu información está protegida con encriptación de nivel bancario. Nunca compartimos tus datos personales con terceros sin tu consentimiento explícito.</p>
                <ul class="feature-list">
                    <li>Transacciones 100% seguras</li>
                    <li>Protección de datos conforme RGPD</li>
                    <li>Control total sobre tu información visible</li>
                    <li>Autenticación de dos factores disponible</li>
                </ul>
            </div>

            <div class="section">
                <h2><span class="icon">💬</span> Contacta con Soporte</h2>
                <p>¿Necesitas ayuda adicional? Nuestro equipo está disponible para asistirte.</p>
                
                <div class="contact-grid">
                    <div class="contact-card">
                        <h4>📧 Email</h4>
                        <p>soporte@skillmatch.com</p>
                        <p><small>Respuesta en 24h</small></p>
                    </div>
                    <div class="contact-card">
                        <h4>💬 Chat en Vivo</h4>
                        <p>Lun - Vie: 9:00 - 18:00</p>
                        <p><small>Respuesta inmediata</small></p>
                    </div>
                    <div class="contact-card">
                        <h4>📞 Teléfono</h4>
                        <p>+1 (800) 123-4567</p>
                        <p><small>Lun - Vie: 9:00 - 18:00</small></p>
                    </div>
                </div>

                <div class="alert-box">
                    <p><strong>💡 Consejo:</strong> Antes de contactarnos, revisa nuestras preguntas frecuentes. La mayoría de las dudas se resuelven allí.</p>
                </div>
            </div>

            <div class="section">
                <h2><span class="icon">📚</span> Recursos Adicionales</h2>
                <p>Aprovecha nuestros recursos gratuitos para mejorar tu búsqueda de empleo:</p>
                <ul class="feature-list">
                    <li>Guías para optimizar tu currículum</li>
                    <li>Consejos para entrevistas exitosas</li>
                    <li>Blog con tendencias del mercado laboral</li>
                    <li>Webinars gratuitos sobre desarrollo profesional</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>