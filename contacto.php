<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contacto</title>

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

form {
    margin-top: 30px;
    text-align: left;
}

input, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 10px;
    border: none;
}

button {
    margin-top: 20px;
    padding: 12px 25px;
    background: #00d4ff;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #00ffea;
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
    <h1>📬 Contacto</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>
        <a href="sobre_nosotros.php">Sobre nosotros</a>
        <a href="contacto.php">Contacto</a>
        <a href="politica_seguridad.php">Política de seguridad</a>

        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        <?php } ?>
    </nav>
</header>

<div class="contenido">
    <h2>¿Necesitas ayuda?</h2>
    <p>Estamos aquí para ayudarte. Puedes escribirnos a través del siguiente formulario.</p>

    <form>
        <label>Nombre:</label>
        <input type="text" placeholder="Tu nombre">

        <label>Email:</label>
        <input type="email" placeholder="Tu correo electrónico">

        <label>Mensaje:</label>
        <textarea rows="5" placeholder="Escribe tu mensaje aquí..."></textarea>

        <button>Enviar mensaje</button>
    </form>
</div>

<footer>
    <p>© 2026 Tienda Interstellar 🌌</p>
</footer>

</body>
</html>
