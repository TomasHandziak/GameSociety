<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/regFormStyle.css">
    <title>login</title>
</head>
<body>
    <div class="registerForm">
        <h2>Registrate</h2>
        <form action="php/register_user_db.php" method="POST" class="form-container">
            <a href="index.php"><img src="files/logo.png" alt=""></a>
            <label for="name">Nombre completo:</label>
            <input type="text" id="name" name="name" required>

            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="mail">Correo Electronico:</label>
            <input type="text" id="mail" name="mail" required>
            
            <label for="password">Contrasena:</label>
            <input type="password" id="password" name="password" required>

            <label for="password">Repetir contraseña</label>
            <input type="password" id="repeatPassword" name="rePassword"  required>  
            
            
            <button type="submit">Registrarse</button>
            <p>¿Ya tienes una cuenta?<a href="form.php">Entra</a></p>
        </form>
    </div>
</body>
</html>