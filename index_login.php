<?php 

    session_start();

    if (!isset($_SESSION['username'])) {
        echo '
        <script> 
            alert("Debes iniciar sesion");
            window.location = "form.php";
        </script>
        ';
        session_destroy(); 
        die();
    }

    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="styles/productsLogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="files/logo.png" alt="Logo" class="logo"></a></li>
                <li class="profile"><div class="dropdown">
                                        <button class="dropbtn"><i class="fa-solid fa-user"></i></button>
                                        <div class="dropdown-content">
                                            <div class="profile-image-container">
                                                <img src="files/profile.png" alt="Imagen de Perfil" class="profile-image">
                                                <h2 class="profile-name"><?php echo $_SESSION['username'] ?></h2>
                                            </div>  
                                            <a href="/mi-perfil">Mi Perfil</a>
                                            <a href="/mis-pedidos">Mis Pedidos</a>
                                            <a href="" class="cartBtn-drop">Carrito</a>
                                            <a class="logout" href="php/logout.php">Cerrar Sesión</a>
                                        </div>
                                    </div>
                                </li>
            </ul>
            
        </nav>
    </header>    

    <main class="mainContainer">
        <h1>Productos</h1>
        <div class="search-and-filter">
            <div class="view-toggle">
                <input type="text" id="searchBar" placeholder="Buscar productos..." onkeyup="searchProducts()">
                <button id="toggleView"><i id="btnIcon" class="fa-solid fa-list"></i></button>
            </div>
            <select id="filterCategory" onchange="filterProducts()">
                <option value="all">Todas las categorías</option>
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
        </div>


        <div id="productContainer" class="table-view">
            <?php
                    // Crear la conexión
                    $conn = new mysqli("autorack.proxy.rlwy.net", "root", "tCowNBAOpxdSWVPMHEpdEIFJJMCGzftz", "railway", 22392);

                    // Consultar los productos cuyo valor de 'activo' sea 1
                    $sql = "SELECT id, nombre, descripcion, precio, imagen, categoria FROM productos WHERE activo = 1";
                    $result = $conn->query($sql);
                    
                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Generar el HTML para cada producto
                        while($row = $result->fetch_assoc()) {
                            // Obtener la imagen BLOB y convertirla a base64
                            $imagen = base64_encode($row['imagen']);
                            echo '<div class="product-card card" id="producto' . $row['id'] . '" data-category="' . $row['categoria'] . '">';
                            echo '<img src="data:image/jpeg;base64,' . $imagen . '" alt="' . $row['nombre'] . '">'; // Mostrar la imagen en formato base64
                            echo '<div class="textCard">';
                            echo '<h2 class="titleProduct">' . $row['nombre'] . '</h2>';
                            echo '<p>' . $row['descripcion'] . '</p>';
                            echo '</div>';
                            echo '<p class="price">$' . $row['precio'] . '</p>';
                            echo '<form id="purchaseForm" action="comprar.php" method="POST">';
                            echo '<input type="hidden" id="idProducto" name="idProducto" value="' . $row['id'] . '">';
                            echo '<input type="hidden" id="titulo" name="titulo" value="' . $row['nombre'] . '">';
                            echo '<input type="hidden" id="idUsuario" name="idUsuario" value="' . $_SESSION['id'] . '">';
                            echo '<input type="hidden" id="usuario" name="usuario" value="' . $_SESSION['username'] . '">';
                            echo '<input type="hidden" id="precio" name="precio" value="' . $row['precio'] . '">';
                            echo '<button type="submit" class="btn-add-cart">Comprar</button>';
                            echo '</form>';                           
                            echo '</div>';
                        }
                    } else {
                        echo "No hay productos disponibles.";
                    }
                ?>
        </div>
       
    </main>

    <footer>
        <a href=""><i class="fa-brands fa-facebook"></i></a>
       <a href=""><i class="fa-brands fa-instagram"></i></a>
    </footer>

    <script src="js/index-login.js"></script>
</body>
</html>
