<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="styles/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script>
        function handlePurchase(event) {
            
            event.preventDefault();

            
            <?php if (!isset($_SESSION['username'])): ?>
                alert('Debes iniciar sesión para comprar.');
            <?php else: ?>
                
                event.target.submit();
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="files/logo.png" alt="Logo" class="logo"></a></li>
                <li class="profile"><a href="form.php"><i class="fa-solid fa-user"></i></a></li>                
            </ul>
        </nav>
    </header>    

    <main class="mainContainer">
        <h1>Productos</h1>
        <div class="search-and-filter">
            <input type="text" id="searchBar" placeholder="Buscar productos..." onkeyup="searchProducts()">
            <div class="view-toggle">
                <button class="btnView" id="toggleView"><i id="btnIcon" class="fa-solid fa-list"></i></button>
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
                 
                 $conn = new mysqli("autorack.proxy.rlwy.net", "root", "tCowNBAOpxdSWVPMHEpdEIFJJMCGzftz", "railway", 22392);

                 
                 $sql = "SELECT id, nombre, descripcion, precio, imagen, categoria FROM productos WHERE activo = 1";
                 $result = $conn->query($sql);
                 
                 
                 if ($result->num_rows > 0) {
                    
                     while($row = $result->fetch_assoc()) {
                         
                         $imagen = base64_encode($row['imagen']);
                         echo '<div class="product-card card" id="producto' . $row['id'] . '" data-category="' . $row['categoria'] . '">';
                         echo '<img src="data:image/jpeg;base64,' . $imagen . '" alt="' . $row['nombre'] . '">'; 
                         echo '<div class="textCard">';
                         echo '<h2 class="titleProduct">' . $row['nombre'] . '</h2>';
                         echo '<p>' . $row['descripcion'] . '</p>';
                         echo '</div>';
                         echo '<p class="price">$' . $row['precio'] . '</p>';
                         echo '<form id="purchaseForm" onsubmit="handlePurchase(event)">'; 
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

    <script src="js/products.js"></script>
</body>
</html>
