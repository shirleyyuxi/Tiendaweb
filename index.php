<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tienda Interstellar</title>

<style>
/* Fondo general */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: black;
    color: white;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

/* Canvas para estrellas */
#stars {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -2;
    background: black;
}

/* Capa de degradado suave encima del fondo */
#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at top, rgba(11,15,26,0.6), rgba(0,0,0,0.9));
    z-index: -1;
}

/* Header */
header {
    background: rgba(0,0,0,0.7);
    padding: 20px;
    text-align: center;
    backdrop-filter: blur(5px);
    position: sticky;
    top: 0;
    z-index: 10;
}

nav a {
    margin: 0 15px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

nav a:hover {
    color: #00ffea;
}

/* HERO */
.hero {
    flex: 1;
    text-align: center;
    padding: 120px 20px;
    position: relative;
}

.hero h2 {
    font-size: 3rem;
    margin-bottom: 10px;
    animation: fadeInDown 1s ease-out;
}

.hero p {
    font-size: 1.3rem;
    opacity: 0.9;
    animation: fadeInUp 1.2s ease-out;
}

/* Botón CTA */
.hero .cta {
    display: inline-block;
    margin-top: 25px;
    padding: 12px 25px;
    background: #00d4ff;
    color: black;
    border-radius: 10px;
    font-weight: bold;
    text-decoration: none;
    transition: transform 0.3s, box-shadow 0.3s;
}

.hero .cta:hover {
    transform: scale(1.1);
    box-shadow: 0 0 15px #00d4ff;
}

/* Animaciones */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Footer fijo */
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

<!-- Fondo animado -->
<canvas id="stars"></canvas>
<div id="overlay"></div>

<header>
    <h1>🚀 Tienda Interstellar</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="carrito.php">Carrito</a>

        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        <?php } ?>
    </nav>
</header>

<section class="hero">
    <h2>Explora el universo 🚀</h2>
    <p>Compra productos tecnológicos, científicos y espaciales</p>

    <a href="productos.php" class="cta">Ver productos</a>
</section>

<footer>
    <p>© 2026 Tienda Interstellar 🌌 — Tecnología más allá de las estrellas</p>
</footer>

<!-- SCRIPT DEL FONDO DE ESTRELLAS MEJORADO -->
<script>
const canvas = document.getElementById("stars");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let stars = [];

function initStars() {
    stars = [];
    for (let i = 0; i < 400; i++) {  // MÁS ESTRELLAS
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2.5 + 0.5, // MÁS GRANDES
            speed: Math.random() * 1.2 + 0.4, // MÁS RÁPIDAS
            alpha: Math.random(), // BRILLO
            alphaChange: Math.random() * 0.02 + 0.005 // PARPADEO
        });
    }
}

function animateStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let star of stars) {
        // Parpadeo suave
        star.alpha += star.alphaChange;
        if (star.alpha <= 0 || star.alpha >= 1) {
            star.alphaChange *= -1;
        }

        ctx.fillStyle = `rgba(255,255,255,${star.alpha})`;
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
        ctx.fill();

        // Movimiento hacia abajo
        star.y += star.speed;

        // Reaparecer arriba
        if (star.y > canvas.height) {
            star.y = 0;
            star.x = Math.random() * canvas.width;
        }
    }

    requestAnimationFrame(animateStars);
}

initStars();
animateStars();

window.onresize = () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    initStars();
};
</script>

</body>
</html>
