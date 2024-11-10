<?php
session_start();
include 'conexion_be.php'; // Asegúrate de incluir el archivo de conexión a la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $user = mysqli_real_escape_string($conexion, $_POST['user']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar si el usuario existe y es administrador
    $query = "SELECT * FROM usuarios WHERE username = '$user' AND admin = TRUE";
    $result = mysqli_query($conexion, $query);

    // Verificar si el usuario existe
    if (mysqli_num_rows($result) == 1) {
        // El usuario existe, ahora verificamos la contraseña
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['contrasena']; // Contraseña almacenada (encriptada con SHA-512)
        
        // Verificar la contraseña utilizando SHA-512
        if (hash('sha512', $password) == $hashed_password) {
            // La contraseña es correcta, iniciar sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nombre'] = $row['nombre']; // Guardamos el nombre del administrador
            header('Location: ../indexAdmin.php'); // Redirigir a la página de administración
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado o no es administrador.";
        header('Location: ../admin.php');
    }
}
?>

