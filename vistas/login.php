<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome back to SkillMatch</title>
     <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/login-styles.css">
     <link rel="conexion" href="../conexion/controllerUsuario.php">
</head>
<body>
    
    <div class="login-container">
        <img src="../img/logo-SkillMatch-v3.png" alt="logoSM" class="Logo">
        <h1 class="Subtitle">Welcome Back!</h1>
        <div class="form-container">
            <form action="../conexion/controllerUsuario.php" method="POST">
            <!--  <form id="loginForm">-->
                <input type="email" id="email" name="email" placeholder="Email">
            <!-- </form>
            <form id="loginForm">-->
              <input type="password" id="contrasna" name="contrasena" placeholder="Contraseña" required>
            <!--  </form>-->
            <button type="submit" name="action" value="login"></button>
        <a href="../index.html"><button type="submit" name="action" value="login">Confirmar</button></a>
        </form>
    </div>
</body>
</html>