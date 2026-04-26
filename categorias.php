<?php
session_start();
include("config.php");

$sql = "SELECT * FROM Categoria ORDER BY id_categoria";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Categorías</title>

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

/* Capa de degradado suave */
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

/* Título */
.titulo {
    text-align: center;
    margin: 40px 0 20px;
    font-size: 2rem;
}

/* Grid de categorías */
.categorias-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    padding: 20px;
}

.categoria-card {
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid rgba(255,255,255,0.1);
}

.categoria-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 15px rgba(0,212,255,0.4);
}

.categoria-card h3 {
    margin-bottom: 10px;
    color: #00d4ff;
}

/* Footer */
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
    <h1>🌌 Categorías</h1>
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

<h2 class="titulo">Explora por categorías</h2>

<div class="categorias-grid">
<?php while($cat = $resultado->fetch_assoc()) { ?>
    <a href="categoria.php?id=<?php echo $cat['id_categoria']; ?>" style="text-decoration:none; color:white;">
        <div class="categoria-card">
            <h3><?php echo $cat['nombre']; ?></h3>
            <p><?php echo $cat['descripcion']; ?></p>
        </div>
    </a>
<?php } ?>
</div>

<footer>
    <p>© 2026 Tienda Interstellar 🌌</p>
</footer>

<!-- SCRIPT DEL FONDO DE ESTRELLAS -->
<script>
const canvas = document.getElementById("stars");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let stars = [];

function initStars() {
    stars = [];
    for (let i = 0; i < 400; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2.5 + 0.5,
            speed: Math.random() * 1.2 + 0.4,
            alpha: Math.random(),
            alphaChange: Math.random() * 0.02 + 0.005
        });
    }
}

function animateStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let star of stars) {
        star.alpha += star.alphaChange;
        if (star.alpha <= 0 || star.alpha >= 1) {
            star.alphaChange *= -1;
        }

        ctx.fillStyle = `rgba(255,255,255,${star.alpha})`;
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
        ctx.fill();

        star.y += star.speed;

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
