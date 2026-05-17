<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tienda Interstellar</title>

<style>
/* ======== ESTILOS GENERALES ======== */
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: radial-gradient(circle at top, #0b0f1a, #000);
    color: white;
}

/* ======== CABECERA ======== */
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
    letter-spacing: 1px;
}

nav a {
    margin-left: 20px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

nav a:hover {
    color: white;
}

/* ======== HERO / BANNER ======== */
.hero {
    text-align: center;
    padding: 120px 20px;
    background: url('https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat;
    background-attachment: fixed;
    color: white;
    text-shadow: 0 0 10px black;
}

.hero h1 {
    font-size: 60px;
    margin-bottom: 20px;
}

.hero p {
    font-size: 22px;
    margin-bottom: 40px;
}

.hero a {
    padding: 14px 28px;
    background: #00d4ff;
    color: black;
    border-radius: 10px;
    text-decoration: none;
    font-size: 20px;
    font-weight: bold;
    transition: 0.3s;
}

.hero a:hover {
    background: white;
}

/* ======== SECCIÓN DESTACADOS ======== */
.section {
    padding: 60px 40px;
    text-align: center;
}

.section h2 {
    font-size: 36px;
    margin-bottom: 30px;
}

.cards {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.card {
    background: rgba(255,255,255,0.05);
    padding: 20px;
    width: 260px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.1);
}

.card h3 {
    margin-bottom: 10px;
    color: #00d4ff;
}

/* ======== FOOTER ======== */
footer {
    text-align: center;
    padding: 30px;
    background: rgba(0,0,0,0.8);
    margin-top: 40px;
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

        <?php if (isset($_SESSION["cliente"])): ?>
            <a href="mis_pedidos.php">Mis pedidos</a>
            <a href="logout.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>

<!-- HERO -->
<div class="hero">
    <h1>Bienvenido a Interstellar Shop</h1>
    <p>La tienda donde la tecnología y el universo se encuentran</p>
    <a href="productos.php">Explorar productos</a>
</div>

<!-- SECCIÓN DESTACADOS -->
<div class="section">
    <h2>Productos destacados</h2>

    <div class="cards">
        <div class="card">
            <h3>🔭 Astronomía</h3>
            <p>Telescopios, lentes y accesorios para explorar el cosmos.</p>
        </div>

        <div class="card">
            <h3>🧪 Ciencia</h3>
            <p>Material de laboratorio para estudiantes y profesionales.</p>
        </div>

        <div class="card">
            <h3>🔌 Tecnología</h3>
            <p>Cables, adaptadores y dispositivos esenciales.</p>
        </div>
    </div>
</div>

<footer>
    © 2026 Interstellar Shop — Todos los derechos reservados  
    <br><br>

    <!-- SECCIONES INFORMATIVAS ABAJO -->
    <a href="sobre_nosotros.php">Quiénes somos</a>
    <a href="contacto.php">Contacto</a>
    <a href="politica_seguridad.php">Política de seguridad</a>

    <br><br>

    <!-- LOGIN ADMIN SEPARADO -->
    <a href="admin_login.php">Acceso administradores</a>
</footer>

</body>
</html>