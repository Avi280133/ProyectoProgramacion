|| ★ SkillMatch ★ ||

SkillMatch es una plataforma web que tiene como propósito conectar a personas que ofrecen y solicitan servicios, brindando un entorno moderno, confiable y fácil de usar. Con un diseño intuitivo y una estructura orientada a la experiencia del usuario, la página promueve interacciones seguras y eficientes dentro de una comunidad digital en constante crecimiento.
========================================
★ Funciones
SkillMatch incorpora un conjunto de herramientas diseñadas para facilitar la interacción entre usuarios y proveedores, garantizando una experiencia completa y eficiente. Entre sus principales funciones se destacan:

     • Registro e inicio de sesión personalizados, que permiten a cada usuario crear y gestionar su perfil de manera segura.
• Publicación, edición y eliminación de servicios, con información detallada y categorizada para una mejor visibilidad.
      • Sistema de mensajería interna, que posibilita la comunicación directa entre clientes y proveedores.
      • Búsqueda avanzada de servicios, filtrada por palabra clave, categoría, ubicación o valoración.
      • Gestión de reseñas y calificaciones, para mantener la transparencia y la calidad de los servicios ofrecidos.
      • Panel de administración, encargado de supervisar la actividad dentro de la plataforma y asegurar el cumplimiento de las normas.
      • Notificaciones automáticas, que mantienen informados a los usuarios sobre interacciones, mensajes y actualizaciones relevantes.

========================================

★ Interfaz de Usuario
La interfaz de SkillMatch está diseñada para adaptarse al rol de cada usuario y ofrecer una experiencia personalizada, funcional y estética. Cada vista prioriza la usabilidad, la claridad de la información y la eficiencia en las acciones.

★ Administrador
Cuenta con un panel de control centralizado donde se muestran estadísticas globales sobre la plataforma: número de clientes, proveedores, categorías y servicios activos.
Desde allí puede visualizar, modificar, crear o eliminar registros, manteniendo la organización y el correcto funcionamiento del sistema.

★ Proveedor
Dispone de un panel con estadísticas detalladas de su actividad: servicios activos, visualizaciones, promedio de calificaciones y mensajes nuevos.
Incluye accesos rápidos para publicar servicios, gestionar su perfil, administrar publicaciones y enviar mensajes.
En la parte inferior, se encuentra un carrusel de servicios recomendados para contratar, seguido por una lista de sus servicios más recientes con opciones de editar, ver o eliminar.
En su perfil, puede modificar datos como nombre, nombre de usuario, localidad, habilidades, experiencia y edad. Debajo, un calendario de reservas muestra los servicios agendados, junto a un panel de sus publicaciones activas.

★ Cliente
Su interfaz prioriza la exploración y la contratación. Cuenta con un buscador principal, una sección de servicios destacados y un panel de categorías activas, donde se indica la cantidad de profesionales disponibles por rubro.
Al final, un tutorial interactivo orienta al usuario en sus primeros pasos dentro de la plataforma.
En su perfil, el cliente puede editar su descripción, nombre, nombre de usuario, edad y localidad.

★ Mensajería
La sección de mensajería ofrece una vista clara y dinámica de los chats recientes y las conversaciones activas. Cada chat permite comunicarse directamente con otros usuarios, manteniendo la continuidad de las interacciones dentro de la plataforma.

★ Publicar Servicio
Formulario intuitivo donde el proveedor puede ingresar los datos esenciales de su servicio, como título, descripción, categoría, precio y disponibilidad.

★ Publicación de Servicio
Muestra toda la información detallada del servicio ofrecido, junto con el perfil del proveedor que lo publica.
Incluye cuatro acciones principales: calificar, reportar, enviar mensaje y solicitar servicio.

★ Solicitud de Servicio
Formulario que permite al cliente completar los datos necesarios para contratar un servicio, con un calendario integrado para agendar fecha y hora.

★ Búsqueda y Resultados
Muestra los servicios disponibles según la búsqueda realizada, acompañada de una interfaz de filtrado que permite refinar los resultados por palabra clave, categoría, ubicación o valoración.

========================================

★ Contenedores Docker

★ Instalación en Linux
sudo dnf -y update
sudo dnf config-manager -add-repo=https://download.docker.com/linux/centos/docker-ce.repo
sudo dnf -y install docker-ce docker-ce-cli containerd.io docker-compose-plugin
sudo systemctl enable --now docker

★ Verificar su instalación del Docker
docker --version
sudo systemctl status docker

★ Levantar contenedor
sudo docker run -d --name SkillMatch -p 8080:80 -v /home/alphora4tech/Alphora4Tech/src/ProyectoProgramacion:/usr/local/apache2/htdocs:Z --restart unless-stopped httpd:2.4

★ Verificación del contenedor
docker ps
curl -I http://localhost:8080

========================================

★ Agradecimientos

El desarrollo de SkillMatch fue posible gracias al esfuerzo conjunto de un equipo comprometido con la innovación y la calidad.
Este proyecto refleja la colaboración, la creatividad y la pasión por construir herramientas que conecten personas y oportunidades.
Agradecemos especialmente a cada integrante que participó en su desarrollo, diseño y análisis, aportando sus conocimientos para hacer de SkillMatch una plataforma funcional, segura y accesible para todos.

Desarrollado por el equipo de Alphora⁴ Tech.
Conectando habilidades, creando oportunidades.
