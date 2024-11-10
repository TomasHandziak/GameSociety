<?php
session_start();
include 'php/conexion_be.php'; // Asegúrate de incluir el archivo de conexión a la base de datos

// Verificar si hay una sesión activa
if (!isset($_SESSION['id'])) {
    // Si no hay sesión, redirigir al login
    header('Location: form.php');
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
    header('Location: form.php');
    exit();
}


// Consulta para obtener los usuarios administradores
$query = "SELECT id, nombre, email, username FROM usuarios WHERE admin = 1";
$result = mysqli_query($conexion, $query);

// Lógica para eliminar un administrador
if (isset($_GET['id'])) {
    $id_admin = mysqli_real_escape_string($conexion, $_GET['id']);

    // Evitar la eliminación del administrador actual
    if ($id_admin == $_SESSION['id']) {
        echo "No puedes eliminar tu propio usuario.";
        exit();
    }

    // Eliminar el usuario administrador
    $delete_query = "DELETE FROM usuarios WHERE id = '$id_admin' AND admin = 1";
    
    if (mysqli_query($conexion, $delete_query)) {
        echo "Administrador eliminado exitosamente.";
    } else {
        echo "Error al eliminar el administrador: " . mysqli_error($conexion);
    }

    // Redirigir a la misma página después de la eliminación
    header("Location: gestionar_admin.php");
    exit();
}

// Verificar si se envió el formulario para crear un nuevo administrador


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios Administradores</title>
    <link rel="stylesheet" href="styles/gestionar_admin.css"> <!-- Incluye tu archivo CSS -->
</head>
<body>

    <nav>
        <ul>
            <li><a href="indexAdmin.php">Volver al Panel de Admin</a></li>
            <li><a href="php/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="admin-container">
        <h2>Administradores Existentes</h2>

        <!-- Mostrar lista de administradores -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Nombre de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los administradores existentes
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>";
                        // Asegurarse de no permitir la eliminación del administrador actual
                        if ($row['id'] != $_SESSION['id']) {
                            echo "<a href='gestionar_admin.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este administrador?\")'>Eliminar</a>";
                        } else {
                            echo "No se puede eliminar a sí mismo";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay usuarios administradores.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <h2>Crear Nuevo Administrador</h2>
        <!-- Formulario para crear un nuevo administrador -->
        <form action="php/adminUsers.php" method="POST" class="form-container">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" name="add_admin">Agregar Administrador</button>
        </form>

    </div>
</body>
</html>
