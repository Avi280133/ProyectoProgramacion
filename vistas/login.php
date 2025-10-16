<!-- <!DOCTYPE html>
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
             <form id="loginForm">-->
                <!-- <input type="email" id="email" name="email" placeholder="Email">
             </form>
            <form id="loginForm">-->
               <!-- <input type="password" id="contrasna" name="contrasena" placeholder="Contraseña" required>
             </form>
            <button type="submit" name="action" value="login"></button>
        <a href="../index.html"><button type="submit" name="action" value="login">Confirmar</button></a>
        </form>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome back to SkillMatch</title>
    <link rel="conexion" href="../conexion/controllerUsuario.php">
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #2d5016 0%, #4CAF50 50%, #81C784 100%);
    background-size: cover;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url(../img/2819346192asc.jpg);
    background-size: cover;
    background-position: center;
    opacity: 0.15;
    z-index: 0;
}

.login-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 45px 40px;
    border-radius: 24px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 
                0 0 100px rgba(76, 175, 80, 0.1);
    width: 100%;
    max-width: 440px;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 15px;
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.6s ease-out;
    border: 1px solid rgba(129, 199, 132, 0.3);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.Logo {
    max-width: 280px;
    height: auto;
    filter: contrast(1.1) brightness(1.05) saturate(1.1);
    margin: 0 auto 10px;
    transition: transform 0.3s ease;
}

.Logo:hover {
    transform: scale(1.02);
}

.Subtitle {
    color: #2d5016;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
}

.form-container {
    margin: 15px 0;
}

.input-group {
    position: relative;
    margin-bottom: 24px;
}

#email,
#contrasna {
    width: 100%;
    padding: 16px 20px;
    padding-left: 48px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 15px;
    box-sizing: border-box;
    transition: all 0.3s ease;
    background: #fafafa;
    font-family: inherit;
}

#email:focus,
#contrasna:focus {
    outline: none;
    border-color: #4CAF50;
    background: white;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
    transform: translateY(-2px);
}

#email::placeholder,
#contrasna::placeholder {
    color: #999;
}

.input-group::before {
    content: '';
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    background-size: contain;
    opacity: 0.5;
    z-index: 1;
}

.input-group:first-child::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234CAF50' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z'%3E%3C/path%3E%3Cpolyline points='22,6 12,13 2,6'%3E%3C/polyline%3E%3C/svg%3E");
}

.input-group:last-of-type::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234CAF50' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='11' width='18' height='11' rx='2' ry='2'%3E%3C/rect%3E%3Cpath d='M7 11V7a5 5 0 0 1 10 0v4'%3E%3C/path%3E%3C/svg%3E");
}

button {
    background: linear-gradient(135deg, #4CAF50 0%, #268c2b 100%);
    color: white;
    padding: 16px 30px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
    letter-spacing: 0.3px;
    text-transform: uppercase;
    font-size: 14px;
    margin-top: 8px;
}

button:hover {
    background: linear-gradient(135deg, #45a049 0%, #1B5E20 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(76, 175, 80, 0.5);
}

button:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.35);
}

a {
    text-decoration: none;
}

.form-footer {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.form-footer a {
    color: #4CAF50;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease;
    font-weight: 500;
}

.form-footer a:hover {
    color: #2d5016;
    text-decoration: underline;
}

@media (max-width: 480px) {
    .login-container {
        padding: 35px 25px;
    }
    
    .Subtitle {
        font-size: 28px;
    }
    
    .Logo {
        max-width: 240px;
    }
}
    </style>
</head>
<body>
    <!-- Avii si ves esto y salta error es que me dio toc, arriba esta el otro coso por si no lo podes solucionar,
     queria agregar el "olvidaste tu contraseña" y de repente el .css me dio error y no se actualizaba entonces lo puse
     en la etiqueta style en el mismo archivo pero eso no afecta al php :( -->
    <div class="login-container">
        <img src="../img/logo-SkillMatch-v3.png" alt="logoSM" class="Logo">
        <h1 class="Subtitle">Welcome Back!</h1>
        <div class="form-container">
            <form action="../conexion/controllerUsuario.php" method="POST">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" id="contrasna" name="contrasena" placeholder="Contraseña" required>
                </div>
                <button type="submit" name="action" value="login">Iniciar Sesión</button>
            </form>
            <div class="form-footer">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
        </div>
    </div>
</body>
</html>