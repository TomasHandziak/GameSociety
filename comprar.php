<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - Smoke Society</title>
    <link rel="stylesheet" href="styles/comprar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="container">
        <header>
            <img src="files/logo.png" alt="Logo Smoke Society" class="logo">
            <h1>Realiza tu Compra</h1>
        </header>

        <form action="php/procesar_pedido.php" method="post">
            <div class="form-group">
                <label for="tipo-envio">Tipo de Envío:</label>
                <select id="tipo-envio" name="envio" required>
                    <option value="domicilio">Envio a domicilio</option>
                    <option value="retirar">Retirar en el local</option>
                </select>
            </div>
            <div id="direccion-envio" class="form-group">
                <label for="address">Dirección:</label>
                <input type="text" id="address" name="address">
            </div>
            
            <div class="form-group">
                <label for="stock">Cantidad:</label>
                <input type="number" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="payment">Medio de Pago:</label>
                <select id="payment" name="payment" required>
                    <option value="credit_card">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Transferencia Bancaria</option>
                </select>
            </div>
            <div class="form-group">
                <label for="product">Producto:</label>
                <?php
                $productoId = $_POST['idProducto'];
                $titulo = $_POST['titulo'];
                $username = $_POST['usuario'];
                $precio = $_POST['precio'];
                $idUsuario = $_POST['idUsuario'];

                echo 'Hola <input type="text" name="username" value="' . htmlspecialchars($username) . '" readonly onmousedown="return false;" />';
                echo 'Estás comprando este producto <input type="text" value="' . htmlspecialchars($titulo) . '" readonly onmousedown="return false;" />';
                echo 'Precio <input type="text" name="precio" value="' . htmlspecialchars($precio) . '" readonly onmousedown="return false;" />';
                echo '<input type="hidden" name="idProducto" value="' . htmlspecialchars($productoId) . '" readonly onmousedown="return false;" />';
                echo '<input type="hidden" name="usuario" value="' . htmlspecialchars($idUsuario) . '" readonly onmousedown="return false;" />';
                ?>
            </div>
            <button type="submit" class="btn-submit">Enviar Pedido</button>
        </form>
    </div>

    <script src="js/comprar.js"></script>
</body>
</html>
