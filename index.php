<?php 

    session_start();

    if (isset($_SESSION['username'])) {
        header("location: index_login.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header>
        <nav>
            <img src="files/logo.png" alt="Logo" class="logo">
            <ul class="list">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="products.php">Productos</a></li>
                <li class="profile"><a href="form.php"><i class="fa-solid fa-user"></i></a></li>                
            </ul>
            <div class="dropdown-container">
                <div class="dropdown">
                    <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
                    <div class="dropdown-content"> 
                        <a href="form.php"><i class="fa-solid fa-user"></i>Ingresar</a>
                        <a href="index.php"><i class="fa-solid fa-circle-user"></i>Nosotros</a>
                        <a href="products.php"><i class="fa-solid fa-shop"></i>Productos</a>
                </div>
            </div>
        </nav>
    </header>       
    <main class="mainContainer">
        
        <h1>JUGÁ</h1><h2 class="subTitle">LO QUE QUIERAS</h2><br>
        <p>En GameSociety, somos tu socio de confianza para todas tus necesidades informáticas. Ofrecemos una amplia gama de insumos y accesorios de alta calidad para mantener tu equipo funcionando al máximo rendimiento. </p><br>
        <a href="#" class="startButton">Comprá</a>

        

    </main>
    <footer>
        <a href=""><i class="fa-brands fa-facebook"></i></a>
        <a href=""><i class="fa-brands fa-instagram"></i></a>
    </footer>
    


    
    <script src="js/main.js"></script>
</body>
</html>