<?php
    session_start();
    include 'php/conexion_be.php'; // Conexión a la base de datos
    
    // Verificar si hay una sesión activa
    if (!isset($_SESSION['id'])) {
        echo '
            <script>
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
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['admin'] != 1) {
            echo '
                <script>
                window.location = "index_login.php";
                </script>
            ';  // Redirige si no es admin
            exit();
        }
    } else {
        echo '
        <script> 
            alert("Debes iniciar sesion");
            window.location = "form.php";
        </script>
        ';
        exit();
    }

    // Cambiar el estado de un pedido a completado (activo = false)
    if (isset($_GET['completar_id'])) {
        $id_pedido = mysqli_real_escape_string($conexion, $_GET['completar_id']);
        $update_query = "UPDATE pedidos SET activo = FALSE WHERE id = '$id_pedido'";
        
        if (mysqli_query($conexion, $update_query)) {
            echo "Pedido marcado como completado.";
        } else {
            echo "Error al completar el pedido: " . mysqli_error($conexion);
        }
        echo '
            <script>
            window.location = "indexAdmin.php";
            </script>
        '; 
        exit();
    }

    // Consultar los pedidos en la base de datos
    $query = "SELECT id, usuario_id, fecha_pedido, total, tipo_envio, direccion_envio, activo FROM pedidos";
    $result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Pedidos</title>
    <link rel="stylesheet" href="styles/indexAdmin.css"> <!-- Aquí va el enlace a tu archivo de estilos -->
</head>
<body>

    <!-- Barra de navegación del admin -->
    <nav>
        <ul>
            <li><a href="gestionar_admin.php">Gestionar Usuarios Admin</a></li>
            <li><a href="gestionar_productos.php">Gestionar Productos</a></li>
            <li><a href="php/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <h2>Panel de Administración - Pedidos</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Tabla que muestra los pedidos -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario ID</th>
                    <th>Fecha del Pedido</th>
                    <th>Total</th>
                    <th>Tipo de Envío</th>
                    <th>Dirección de Envío</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo $pedido['usuario_id']; ?></td>
                        <td><?php echo $pedido['fecha_pedido']; ?></td>
                        <td><?php echo $pedido['total']; ?></td>
                        <td><?php echo $pedido['tipo_envio']; ?></td>
                        <td><?php echo $pedido['direccion_envio']; ?></td>
                        <td><?php echo $pedido['activo'] ? "Activo" : "Completado"; ?></td>
                        <td>
                            <a href="ver_detalle.php?id=<?php echo $pedido['id']; ?>">Ver Detalle</a>
                            <?php if ($pedido['activo']): ?>
                                | <a href="indexAdmin.php?completar_id=<?php echo $pedido['id']; ?>" onclick="return confirm('¿Estás seguro de marcar este pedido como completado?')">Completar</a>
                            <?php else: ?>
                                | Completado
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay pedidos registrados en la base de datos.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
