<?php 

session_start();

include 'conexion_be.php';

$user = $_POST['user'];
$password = $_POST['password'];
$password = hash('sha512', $password);

// Modifica la consulta para obtener el ID del usuario
$validarLogin = mysqli_query($conexion, "SELECT id, nombre FROM admin_users WHERE nombre='$user' and password='$password'");

if(mysqli_num_rows($validarLogin) > 0){ 
    $usuario = mysqli_fetch_assoc($validarLogin); // Obtener los datos del usuario
    $_SESSION['username'] = $usuario['email']; // Almacena el email o nombre de usuario
    $_SESSION['id'] = $usuario['id']; // Almacena el ID del usuario
    
    echo '
        <script>
        window.location = "../index_login.php";
        </script>
    ';  
    exit();
} else {
    echo '
        <script>
        alert("Usuario no existe");
        window.location = "../form.php";
        </script>
    ';      
    exit();      
}
?>
