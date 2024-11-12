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

// Función para manejar el cambio de estado de un producto (desactivar o activar)
if (isset($_GET['cambiar_estado_id'])) {
    $producto_id = $_GET['cambiar_estado_id'];
    $nuevo_estado = $_GET['estado']; // 'TRUE' o 'FALSE'

    // Actualizar el estado del producto
    $query = "UPDATE productos SET activo = $nuevo_estado WHERE id = '$producto_id'";

    if (mysqli_query($conexion, $query)) {
        echo "Producto actualizado exitosamente.";
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conexion);
    }
}

// Modificar el stock de un producto
if (isset($_POST['modificar_stock_id'])) {
    $producto_id = $_POST['modificar_stock_id'];
    $nuevo_stock = $_POST['nuevo_stock'];

    // Actualizar el stock del producto
    $query_stock = "UPDATE productos SET stock = '$nuevo_stock' WHERE id = '$producto_id'";

    if (mysqli_query($conexion, $query_stock)) {
        echo "Stock actualizado exitosamente.";
    } else {
        echo "Error al actualizar el stock: " . mysqli_error($conexion);
    }
}

// Agregar un nuevo producto
if (isset($_POST['agregar_producto'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    
    // Subir la imagen del producto
    $imagen = NULL;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    }

    // Insertar el nuevo producto en la base de datos
    $query_insert = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria, imagen, activo) 
                     VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$categoria', '$imagen', TRUE)";

    if (mysqli_query($conexion, $query_insert)) {
        echo "Producto agregado exitosamente.";
    } else {
        echo "Error al agregar el producto: " . mysqli_error($conexion);
    }
}

// Consultar todos los productos (activos e inactivos)
$query = "SELECT * FROM productos";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="styles/gestionar_productos.css"> <!-- Aquí va el enlace a tu archivo de estilos -->
</head>
<body>

    <nav>
        <ul>
            <li><a href="indexAdmin.php">Volver al Panel de Admin</a></li>
            <li><a href="gestionar_admin.php">Gestionar Usuarios Admin</a></li>
            <li><a href="php/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <h2>Gestión de Productos</h2>

    <h3>Agregar Nuevo Producto</h3>
    <form action="gestionar_productos.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" step="0.01" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" min="0" required><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" required>
            <option value="Teclados">Teclados</option>
            <option value="Mouses">Mouses</option>
            <option value="Monitores">Monitores</option>
            <option value="Almacenamiento">Almacenamiento</option>
            <option value="Procesadores">Procesadores</option>
            <option value="Memorias RAM">Memorias RAM</option>
            <option value="Placas de Video">Placas de Video</option>
            <option value="Fuentes de Poder">Fuentes de Poder</option>
            <option value="Gabinetes">Gabinetes</option>
            <option value="Auriculares">Auriculares</option>
            <option value="gabinetes">Gabinetes</option>
            <option value="procesadores">Procesadores</option>
        </select>

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" name="imagen" accept="image/*" required><br>

        <button type="submit" name="agregar_producto">Agregar Producto</button>
    </form>

    <h3>Todos los Productos</h3>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td>
                            <!-- Mostrar el stock actual -->
                            <?php echo $producto['stock']; ?>
                            <!-- Formulario para modificar el stock -->
                            <form action="gestionar_productos.php" method="POST" style="display:inline;">
                                <input type="hidden" name="modificar_stock_id" value="<?php echo $producto['id']; ?>">
                                <input type="number" name="nuevo_stock" value="<?php echo $producto['stock']; ?>" min="0" required>
                                <button type="submit">Actualizar Stock</button>
                            </form>
                        </td>
                        <td><?php echo $producto['categoria']; ?></td>
                        <td><?php echo $producto['activo'] ? 'Activo' : 'Inactivo'; ?></td>
                        <td>
                            <?php if ($producto['activo']): ?>
                                <!-- Si está activo, se muestra la opción de desactivarlo -->
                                <a href="gestionar_productos.php?cambiar_estado_id=<?php echo $producto['id']; ?>&estado=FALSE">Desactivar</a>
                            <?php else: ?>
                                <!-- Si está inactivo, se muestra la opción de activarlo -->
                                <a href="gestionar_productos.php?cambiar_estado_id=<?php echo $producto['id']; ?>&estado=TRUE">Activar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos registrados en la base de datos.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
