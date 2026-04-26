<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Política de Seguridad</title>

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
}

h2 {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 20px;
}

p {
    font-size: 1.1rem;
    line-height: 1.7;
    opacity: 0.9;
    margin-bottom: 20px;
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
    <h1>🔐 Política de Seguridad</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>
        <a href="sobre_nosotros.php">Sobre nosotros</a>
        <a href="contacto.php">Contacto</a>
        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        <?php } ?>
    </nav>
</header>

<div class="contenido">
    <h2>Protección de datos y seguridad</h2>

    <p>
        En <strong>Tienda Interstellar</strong> nos tomamos muy en serio la seguridad de tus datos.
        Toda la información proporcionada por nuestros clientes se almacena de forma segura y se utiliza
        exclusivamente para la gestión de pedidos y la mejora del servicio.
    </p>

    <p>
        Los datos personales no se comparten con terceros, salvo en los casos estrictamente necesarios
        para completar un pedido (por ejemplo, servicios de envío).
    </p>

    <p>
        Las contraseñas se almacenan mediante cifrado seguro (<strong>hash</strong>), lo que garantiza que
        nadie pueda acceder a ellas, ni siquiera nuestro equipo.
    </p>

    <p>
        Implementamos medidas de seguridad como:
        <ul>
            <li>Cifrado de contraseñas</li>
            <li>Control de acceso por roles</li>
            <li>Protección contra inyecciones SQL</li>
            <li>Validación de datos en formularios</li>
        </ul>
    </p>

    <p>
        Si tienes dudas sobre cómo protegemos tu información, puedes escribirnos desde la página de contacto.
    </p>
</div>

<footer>
    <p>© 2026 Tienda Interstellar 🌌</p>
</footer>

</body>
</html>
