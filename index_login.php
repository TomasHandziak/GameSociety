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
            <div class="container-icon">

                <div class="container-cart-icon">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="icon-cart"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
					/>
				</svg>
				<div class="count-products">
					<span id="contador-productos">0</span>
				</div>
            </div>
				<div class="container-cart-products hidden-cart">
                    <div class="row-product">
                        <div class="cart-product">
                            <div class="info-cart-product">
                                <span class="cantidad-producto-carrito">1</span>
                                <p class="titulo-producto-carrito">Comienza a comprar</p>
                                <span class="precio-producto-carrito">$free</span>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="icon-close"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="cart-total">
                        <h3>Total:</h3>
                        <span class="total-pagar">$200</span>
                        <button id="finalizar-compra" class="btn-finalizar-compra">Finalizar Compra</button>
                    </div>
				</div>
			</div>
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
                // Conexión a la base de datos
                $servername = "localhost"; // Cambiar por tu servidor
                $username = "root";        // Cambiar por tu usuario
                $password = "";            // Cambiar por tu contraseña
                $dbname = "gamesociety";      // Cambiar por el nombre de tu base de datos

                // Crear la conexión
                $conn = new mysqli($servername, $username, $password, $dbname);

                $sql = "SELECT id, nombre, descripcion, precio, imagen, categoria FROM productos";
                $result = $conn->query($sql);
                
                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Generar el HTML para cada producto
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-card card" id="producto' . $row['id'] . '" data-category="' . $row['categoria'] . '">';
                        echo '<img src="files/productos/' . $row['imagen'] . '" alt="' . $row['nombre'] . '">';
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
