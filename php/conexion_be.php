<?php
$conexion = new mysqli("autorack.proxy.rlwy.net", "root", "tCowNBAOpxdSWVPMHEpdEIFJJMCGzftz", "railway", 22392);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
