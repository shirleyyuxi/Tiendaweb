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

/* Header */
header {
    background: rgba(0,0,0,0.85);
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #00d4ff;
}

.logo {
    font-size: 26px;
    font-weight: bold;
    color: #00d4ff;
}

nav a {
    margin-left: 20px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
}

nav a:hover {
    color: white;
}

/* Contenido */
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

/* Footer */
footer {
    background: rgba(0,0,0,0.8);
    text-align: center;
    padding: 25px;
    margin-top: auto;
    border-top: 2px solid #00d4ff;
}

footer a {
    color: #00d4ff;
    text-decoration: none;
    margin: 0 12px;
}

footer a:hover {
    color: white;
}
</style>

</head>
<body>

<header>
    <div class="logo">🌌 Interstellar Shop</div>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>

        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="mis_pedidos.php">Mis pedidos</a>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php">Registrarse</a>
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
    © 2026 Interstellar Shop 🌌  
    <br><br>

    <a href="sobre_nosotros.php">Quiénes somos</a>
    <a href="contacto.php">Contacto</a>
    <a href="politica_seguridad.php">Política de seguridad</a>

    <br><br>

    <a href="admin_login.php">Acceso administradores</a>
</footer>

</body>
</html>