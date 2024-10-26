<?php 

    session_start();

    if (isset($_SESSION['username'])) {
        header("location: index_login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/formStyle.css">
    <title>login</title>
</head>
<body>
    <div class="login-form">
        <h2>Iniciar Sesión</h2>
        <form action="php/login.php" method="POST" class="form-container">
            <a href="index.php"><img src="files/logo.png" alt=""></a>
            <label for="mail">Correo electronico:</label>
            <input type="text" id="mail" name="mail" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
            <p>¿No tienes una cuenta?<a href="registerForm.php">Registrate</a></p>
        </form>
    </div>
</body>
</html>