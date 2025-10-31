<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados || SkillMatch</title>
    <link rel="stylesheet" href="../css/busqueda-styles.css">
    <script src="https://kit.fontawesome.com/6d671fbf0c.js" crossorigin="anonymous"></script>
       <link rel="conexion" href="../conexion/controllerPublicacion.php">
</head>



<body>
    <header class="main-header">
        <div class="menu-left">
            <a href="#" class="menu-icon">
                <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
            </a>
        </div>

        <div class="logo-center">
            <img src="../img/logo-SkillMatch-v3.png" alt="SkillMatch Logo">
        </div>

        <div class="actions-right">
            <a href="../vistas/publicar.php"><i class="fa-solid fa-plus" style="color: #ffffff;"></i>
            <a href="../vistas/perfil.php"><i class="fa-solid fa-user" style="color: #ffffff;"></i></a>
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

    <footer class="footer">
        <div class="glow-effect"></div>
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#politicas">Políticas de Seguridad</a>
                    <a href="#acerca">Acerca de Nosotros</a>
                    <a href="#trabajo">Sé Parte de Nuestra Empresa</a>
                </div>
                <div class="social-icons">
                    <a href="#facebook" class="social-icon" title="Facebook">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#instagram" class="social-icon" title="Instagram">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#twitter" class="social-icon" title="Twitter">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#linkedin" class="social-icon" title="LinkedIn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="mailto:contacto@empresa.com" class="social-icon" title="Gmail">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                        </svg>
                    </a>
            </div>
        </div>
    </footer>
</body>
</html>