<?php 
$conexion = mysqli_connect("mysql.railway.internal", "root", "tCowNBAOpxdSWVPMHEpdEIFJJMCGzftz", "railway", 3306);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa con MySQLi";
}
?>
