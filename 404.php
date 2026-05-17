<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Error 404 - Página no encontrada</title>

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

h1 {
    font-size: 3rem;
    margin-bottom: 10px;
    text-shadow: 0 0 10px #00d4ff;
}

p {
    font-size: 1.3rem;
    opacity: 0.9;
    margin-bottom: 30px;
}

.volver {
    display: inline-block;
    padding: 12px 25px;
    background: #00d4ff;
    color: black;
    border-radius: 10px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

.volver:hover {
    background: #00ffff;
    transform: scale(1.05);
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
    <h1>🚫 Error 404</h1>
    <p>La página que buscas se ha perdido en el espacio profundo.</p>
    <a href="index.php" class="volver">⬅ Volver al inicio</a>
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
