<?php
// Incluir el archivo de conexión
include 'conexion_be.php';

// Obtener los valores del formulario
$usuarioId = $_POST['usuario']; // ID del usuario           
$fechaPedido = date('Y-m-d H:i:s'); // Fecha y hora actual
$total = $_POST['precio']; // Total del pedido
$tipoEnvio = $_POST['envio']; // Tipo de envío  
$productoId = $_POST['idProducto']; // ID del producto
$cantidad = $_POST['stock']; // Cantidad del producto
$direccionEnvio = isset($_POST['address']) ? $_POST['address'] : null; // Dirección de envío (si aplica)

// Verificar que el usuario exista en la tabla `usuarios`
$checkUserSql = "SELECT id FROM usuarios WHERE id = ?";
$stmtCheck = $conexion->prepare($checkUserSql);
$stmtCheck->bind_param("i", $usuarioId);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

// Si el usuario existe, proceder con la inserción
if ($result->num_rows > 0) {
    // Preparar la consulta SQL para insertar en la tabla `pedidos`
    $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha_pedido, total, tipo_envio, direccion_envio) 
                  VALUES (?, ?, ?, ?, ?)";
    $stmtPedido = $conexion->prepare($sqlPedido);

    // Comprobar si la preparación fue exitosa
    if ($stmtPedido) {
        // Asignar los valores a la consulta
        $stmtPedido->bind_param("isdss", $usuarioId, $fechaPedido, $total, $tipoEnvio, $direccionEnvio);

        // Ejecutar la consulta
        if ($stmtPedido->execute()) {
            // Obtener el ID del pedido recién insertado
            $pedidoId = $stmtPedido->insert_id;

            // Preparar la consulta SQL para insertar en la tabla `detalles_pedido`
            $sqlDetalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio) 
                           VALUES (?, ?, ?, ?)";
            $stmtDetalle = $conexion->prepare($sqlDetalle);

            if ($stmtDetalle) {
                // Asignar los valores a la consulta
                $stmtDetalle->bind_param("iiid", $pedidoId, $productoId, $cantidad, $total);

                // Ejecutar la consulta
                if ($stmtDetalle->execute()) {
                    header("location: ../confirmacion.php");
                } else {
                    echo "Error al registrar los detalles del pedido: " . $stmtDetalle->error;
                }

                // Cerrar la declaración de detalles
                $stmtDetalle->close();
            } else {
                echo "Error en la preparación de la consulta de detalles: " . $conexion->error;
            }
        } else {
            echo "Error al registrar el pedido: " . $stmtPedido->error;
        }

        // Cerrar la declaración de pedido
        $stmtPedido->close();
    } else {
        echo "Error en la preparación de la consulta del pedido: " . $conexion->error;
    }
} else {
    echo "El ID de usuario no existe. Por favor, verifica el ID del usuario.";
}

// Cerrar las declaraciones y la conexión
$stmtCheck->close();
$conexion->close();
?>

