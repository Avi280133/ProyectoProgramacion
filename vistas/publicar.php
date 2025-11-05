<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicá tu Servicio | SkillMatch</title>

  <!-- Estilos propios -->
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/soli.css">

  <!-- Icono -->
  <link rel="icon" type="image/png" href="../img/favicon_SkillMatch.png">

  <!-- FontAwesome (para iconos del header) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/publicar.css">
</head>
<body>
  <header class="main-header">
    <div class="menu-left">
      <a href="#" class="menu-icon">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
      </a>
    </div>

    <div class="logo-center">
      <a href="../index.html"><img src="../img/logo-SkillMatch-v3.png" alt="SkillMatch Logo"></a>
    </div>

    <div class="actions-right">
      <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
      <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
      <a href="perfil.php"><i class="fa-solid fa-user" style="color: #ffffff;"></i></a>
    </div>
  </header>

  <!-- Formulario de publicación -->
  <main class="seccion-formulario-solicitud">
    <div class="contenedor-formulario">
      <h2 class="titulo-formulario">Publicá tu Servicio</h2>

      <!-- IMPORTANTE: enctype para subir archivos y action oculto -->
      <form action="../conexion/controllerPublicacion.php" method="POST" class="formulario-servicio" enctype="multipart/form-data">
        <input type="hidden" name="action" value="publicar">

        <label for="titulo" class="etiqueta-campo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ej: Reparación de PC a domicilio" class="campo-formulario" required>

        <label for="ubicacion" class="etiqueta-campo">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" placeholder="Ej: Pocitos, Montevideo" class="campo-formulario" required>

        <label for="categoria" class="etiqueta-campo">Categoría (opcional):</label>
        <select id="categoria" name="categoria" class="campo-formulario">
          <option value="">--Seleccioná--</option>
          <option value="Soporte Técnico">Soporte Técnico</option>
          <option value="Mantenimiento">Mantenimiento</option>
          <option value="Consultoría">Consultoría</option>
          <option value="Limpieza">Limpieza</option>
          <option value="Construcción">Construcción</option>
          <option value="Otro">Otro</option>
        </select>

        <label class="etiqueta-campo">Imagen (opcional):</label>
        <div class="imagen-equipo">
          <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>

        <label for="descripcion" class="etiqueta-campo">Descripción del servicio:</label>
        <textarea id="descripcion" name="descripcion" rows="5" class="campo-formulario" placeholder="Contá brevemente qué ofrecés, experiencia, qué incluye, etc." required></textarea>

        <label for="precio" class="etiqueta-campo">Precio del servicio:</label>
        <div class="form-group price-input-container">
          <span class="price-symbol">$</span>
          <input
            type="number"
            id="precio"
            name="precio"
            class="price-input"
            placeholder="0.00"
            step="0.01"
            min="0"
            required
          >
        </div>

        <button type="submit" class="boton-enviar-formulario">📩 Publicar servicio</button>
      </form>
    </div>
  </main>

  <footer class="pie-de-pagina">
    <div class="contenedor-pie">
      <p>&copy; 2025 ServiciosPro. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>
