<?php 

    session_start();

    if (isset($_SESSION['username'])) {
        echo '
        <script>
        window.location = "indexAdmin.php";
        </script>
    ';  
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/adminform.css">
    <title>login</title>
</head>
<body>
    <div class="login-form">
    <form action="php/adminform.php" method="POST" class="form-container">
        <a href="index.php"><img src="files/logo.png" alt=""></a>
        <h2>Panel ADMIN</h2>
        <label for="user">Usuario:</label>
        <input type="text" id="user" name="user" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    </div>
</body>
</html>