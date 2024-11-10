<?php
// Incluir el archivo de conexión
include 'conexion_be.php';

// Obtener los valores del formulario
$usuarioId = $_POST['usuario'];
$fechaPedido = date('Y-m-d H:i:s');
$total = $_POST['precio'];
$tipoEnvio = $_POST['envio'];
$productoId = $_POST['idProducto'];
$cantidad = $_POST['stock'];
$direccionEnvio = isset($_POST['address']) ? $_POST['address'] : null;

// Verificar que el usuario exista en la tabla `usuarios`
$checkUserSql = "SELECT id FROM usuarios WHERE id = ?";
$stmtCheck = $conexion->prepare($checkUserSql);
$stmtCheck->bind_param("i", $usuarioId);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

// Si el usuario existe, proceder con la verificación de stock
if ($result->num_rows > 0) {
    // Verificar si hay suficiente stock para el producto
    $checkStockSql = "SELECT stock FROM productos WHERE id = ?";
    $stmtStock = $conexion->prepare($checkStockSql);
    $stmtStock->bind_param("i", $productoId);
    $stmtStock->execute();
    $resultStock = $stmtStock->get_result();

    if ($resultStock->num_rows > 0) {
        $row = $resultStock->fetch_assoc();
        $stockDisponible = $row['stock'];

        // Verificar si el stock disponible es suficiente
        if ($stockDisponible >= $cantidad) {
            // Preparar la consulta SQL para insertar en la tabla `pedidos`
            $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha_pedido, total, tipo_envio, direccion_envio) 
                          VALUES (?, ?, ?, ?, ?)";
            $stmtPedido = $conexion->prepare($sqlPedido);

            if ($stmtPedido) {
                $stmtPedido->bind_param("isdss", $usuarioId, $fechaPedido, $total, $tipoEnvio, $direccionEnvio);

                // Ejecutar la consulta de pedido
                if ($stmtPedido->execute()) {
                    $pedidoId = $stmtPedido->insert_id;

                    // Preparar la consulta SQL para insertar en la tabla `detalles_pedido`
                    $sqlDetalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio) 
                                   VALUES (?, ?, ?, ?)";
                    $stmtDetalle = $conexion->prepare($sqlDetalle);

                    if ($stmtDetalle) {
                        $stmtDetalle->bind_param("iiid", $pedidoId, $productoId, $cantidad, $total);

                        // Ejecutar la consulta de detalles del pedido
                        if ($stmtDetalle->execute()) {
                            echo '
                                <script>
                                window.location = "../confirmacion.php";
                                </script>
                            ';  
                        } else {
                            echo "Error al registrar los detalles del pedido: " . $stmtDetalle->error;
                        }
                        $stmtDetalle->close();
                    } else {
                        echo "Error en la preparación de la consulta de detalles: " . $conexion->error;
                    }
                } else {
                    echo "Error al registrar el pedido: " . $stmtPedido->error;
                }
                $stmtPedido->close();
            } else {
                echo "Error en la preparación de la consulta del pedido: " . $conexion->error;
            }
        } else {
            echo '<script>alert("Stock insuficiente")</script>';
            echo '
                                <script>
                                window.location = "../index_login.php";
                                </script>
                            ';  
        }
    } else {
        echo "Producto no encontrado en la base de datos.";
    }

    $stmtStock->close();
} else {
    echo "El ID de usuario no existe. Por favor, verifica el ID del usuario.";
}

$stmtCheck->close();
$conexion->close();
?>
