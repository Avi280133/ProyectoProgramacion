<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $id_destino = $_POST['id_destino']; //Hay que saber cual es el destino y se carga en session
    
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['id_destino'] = $id_destino;
            //header("Location: chat.php"); 
            header("Location: general.php"); 
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="name" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <br>
         <label>ID DEL USUARIO DESTINO:</label>
        <input type="text" name="id_destino" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>