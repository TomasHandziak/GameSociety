<?php
 session_start();
 include 'php/conexion_be.php'; // Asegúrate de incluir el archivo de conexión a la base de datos
 
 // Verificar si hay una sesión activa
 if (!isset($_SESSION['id'])) {
     // Si no hay sesión, redirigir al login
     echo '
        <script> 
            alert("Debes iniciar sesion");
            window.location = "form.php";
        </script>
        ';
     exit();
 }
 
 // Obtener el id del usuario desde la sesión
 $usuario_id = $_SESSION['id'];
 
 // Consulta para verificar si el usuario es administrador
 $query = "SELECT admin FROM usuarios WHERE id = '$usuario_id'";
 $result = mysqli_query($conexion, $query);
 
 // Verificar si el usuario existe en la base de datos
 if (mysqli_num_rows($result) == 1) {
     $row = mysqli_fetch_assoc($result);
     
     // Si el usuario no es administrador, redirigir
     if ($row['admin'] != 1) {
         // No es administrador, redirigir a una página de acceso denegado o al inicio
         header('Location: index_login.php'); // O cualquier otra página que elijas
         exit();
     }
 } else {
     // Si no se encuentra el usuario en la base de datos
     echo '
        <script> 
            alert("Debes iniciar sesion");
            window.location = "form.php";
        </script>
        ';
     exit();
 }

// Obtener el ID del pedido desde la URL
$pedido_id = $_GET['id'];

// Consultar el pedido en la base de datos
$query_pedido = "SELECT * FROM pedidos WHERE id = '$pedido_id'";
$result_pedido = mysqli_query($conexion, $query_pedido);

// Verificar si el pedido existe
if (mysqli_num_rows($result_pedido) > 0) {
    $pedido = mysqli_fetch_assoc($result_pedido);
} else {
    echo "Pedido no encontrado.";
    exit();
}

// Consultar los detalles del pedido
$query_detalles = "SELECT dp.id, dp.producto_id, dp.cantidad, dp.precio, p.nombre 
                   FROM detalles_pedido dp
                   JOIN productos p ON dp.producto_id = p.id
                   WHERE dp.pedido_id = '$pedido_id'";
$result_detalles = mysqli_query($conexion, $query_detalles);

// Consultar los detalles del usuario que realizó el pedido
$query_usuario = "SELECT id, nombre, email, username FROM usuarios WHERE id = '".$pedido['usuario_id']."'";
$result_usuario = mysqli_query($conexion, $query_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link rel="stylesheet" href="styles/ver_detalles.css"> <!-- Aquí va el enlace a tu archivo de estilos -->
</head>
<body>

    <nav>
        <ul>
            <li><a href="indexAdmin.php">Volver al Panel de Admin</a></li>
            <li><a href="php/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <h2>Detalles del Pedido ID: <?php echo $pedido['id']; ?></h2>

    <!-- Mostrar detalles del usuario -->
    <h3>Detalles del Usuario</h3>
    <table border="1">
        <tr>
            <th>ID Usuario</th>
            <td><?php echo $usuario['id']; ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?php echo $usuario['nombre']; ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo $usuario['username']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $usuario['email']; ?></td>
        </tr>
    </table>

    <h3>Detalles del Pedido</h3>
    <table border="1">
        <tr>
            <th>Usuario ID</th>
            <td><?php echo $pedido['usuario_id']; ?></td>
        </tr>
        <tr>
            <th>Fecha del Pedido</th>
            <td><?php echo $pedido['fecha_pedido']; ?></td>
        </tr>
        <tr>
            <th>Total</th>
            <td><?php echo $pedido['total']; ?></td>
        </tr>
        <tr>
            <th>Tipo de Envío</th>
            <td><?php echo $pedido['tipo_envio']; ?></td>
        </tr>
        <tr>
            <th>Dirección de Envío</th>
            <td><?php echo $pedido['direccion_envio']; ?></td>
        </tr>
    </table>

    <h3>Detalles de los Productos</h3>
    <?php if (mysqli_num_rows($result_detalles) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detalle = mysqli_fetch_assoc($result_detalles)): ?>
                    <tr>
                        <td><?php echo $detalle['nombre']; ?></td>
                        <td><?php echo $detalle['cantidad']; ?></td>
                        <td><?php echo $detalle['precio']; ?></td>
                        <td><?php echo $detalle['cantidad'] * $detalle['precio']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay detalles de productos para este pedido.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
