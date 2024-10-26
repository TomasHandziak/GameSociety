<?php 
$conexion = mysqli_connect("junction.proxy.rlwy.net", "root", "WqyHgwxnQkrHoyLvRAMYzRmWyXfaNoKi", "railway", 59235);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa con MySQLi";
}
?>
