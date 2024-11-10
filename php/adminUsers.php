<?php
include 'conexion_be.php'; // Asegúrate de incluir la conexión a la base de datos

// Lógica para agregar un nuevo administrador
if (isset($_POST['add_admin'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $hashed_password = hash('sha512', $password); // Encriptar la contraseña

    // Verificar si el correo o nombre de usuario ya existen, pero solo para cuentas de administradores
    $check_query = "SELECT * FROM usuarios WHERE (email = '$email' OR username = '$username') AND admin = 1";
    $result = mysqli_query($conexion, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "El correo o nombre de usuario ya están en uso por otro administrador. Por favor, elige otro.";
        echo '
                <script>
                window.location = "../gestionar_admin.php";
                </script>
            ';  
    } else {
        // Insertar el nuevo administrador
        $insert_query = "INSERT INTO usuarios (nombre, email, username, contrasena, admin) VALUES ('$nombre', '$email', '$username', '$hashed_password', 1)";
        
        if (mysqli_query($conexion, $insert_query)) {
            echo "Administrador creado exitosamente.";
            echo '
                <script>
                window.location = "../gestionar_admin.php";
                </script>
            ';  
        } else {
            echo "Error al crear el administrador: " . mysqli_error($conexion);
        }
    }
}
?>
        
