<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sobre nosotros</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: radial-gradient(circle, #0b0f1a, #000);
    color: white;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

header {
    background: rgba(0,0,0,0.8);
    padding: 20px;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 10;
}

nav a {
    margin: 0 15px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
}

nav a:hover {
    color: #00ffea;
}

.contenido {
    max-width: 900px;
    margin: auto;
    padding: 40px 20px;
    text-align: center;
}

h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

p {
    font-size: 1.2rem;
    line-height: 1.7;
    opacity: 0.9;
}

footer {
    background: rgba(0,0,0,0.8);
    text-align: center;
    padding: 15px;
    margin-top: auto;
    border-top: 1px solid rgba(255,255,255,0.1);
}
</style>

</head>
<body>

<header>
    <h1>🌌 Sobre nosotros</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>

        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        <?php } ?>
    </nav>
</header>

<div class="contenido">
    <h2>Quiénes somos</h2>
    <p>
        En <strong>Tienda Interstellar</strong> creemos que la tecnología y la ciencia 
        deben estar al alcance de todos. Nuestro objetivo es ofrecer productos 
        innovadores, curiosos y únicos, inspirados en el universo y en el futuro.
    </p>

    <p>
        Desde dispositivos tecnológicos hasta artículos espaciales, trabajamos para 
        que cada cliente viva una experiencia diferente, moderna y llena de imaginación.
    </p>

    <p>
        Somos un equipo apasionado por el espacio, la ingeniería y la creatividad.  
        Queremos que cada visita a nuestra tienda sea un pequeño viaje entre estrellas.
    </p>

    <p>🚀 Gracias por formar parte de esta aventura.</p>
</div>

<footer>
    <p>© 2026 Tienda Interstellar 🌌</p>
</footer>

</body>
</html>
