<?php 
session_start();
include("config.php");

// Consulta con precio normal, oferta y categoría
$sql = "SELECT p.*, c.nombre AS categoria, h.precio_normal, h.precio_oferta 
        FROM Producto p
        LEFT JOIN Categoria c ON p.id_categoria = c.id_categoria
        LEFT JOIN Historico_Precio h 
          ON p.id_producto = h.id_producto
        WHERE h.fecha_fin IS NULL
        ORDER BY p.id_producto";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos</title>

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
    transition: color 0.3s;
}

nav a:hover {
    color: white;
}

/* Título */
.titulo {
    text-align: center;
    margin: 40px 0 20px;
    font-size: 2rem;
}

/* Grid de productos */
.productos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    padding: 20px;
}

.card {
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s;
    border: 1px solid rgba(255,255,255,0.1);
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0,212,255,0.4);
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.categoria {
    font-size: 0.9em;
    color: #00d4ff;
    margin-bottom: 5px;
}

.precio {
    margin: 10px 0;
}

.precio .normal {
    text-decoration: line-through;
    color: #888;
    margin-right: 8px;
}

.precio .oferta {
    color: #00ff88;
    font-size: 1.2em;
    font-weight: bold;
}

/* Estado de disponibilidad */
.estado {
    font-weight: bold;
    margin: 8px 0;
}

.disponible {
    color: #00ff88;
}

.ultimas {
    color: #ffcc00;
}

.agotado {
    color: #ff4444;
}

/* Botón */
button {
    background: #00d4ff;
    border: none;
    padding: 10px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
}

button:disabled {
    background: #555;
    cursor: not-allowed;
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

<!-- Fondo animado -->
<canvas id="stars"></canvas>
<div id="overlay"></div>

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

<h2 class="titulo">✨ Explora nuestros productos</h2>

<div class="productos">

<?php while($row = $resultado->fetch_assoc()) { ?>

    <div class="card">

        <img src="img/<?php echo $row['id_producto']; ?>.jpg">

        <p class="categoria">📂 <?php echo $row['categoria']; ?></p>

        <h3><?php echo $row['nombre']; ?></h3>

        <p class="precio">
            <?php if ($row['precio_oferta']) { ?>
                <span class="normal"><?php echo $row['precio_normal']; ?> €</span>
                <span class="oferta"><?php echo $row['precio_oferta']; ?> €</span>
            <?php } else { ?>
                <span class="oferta"><?php echo $row['precio_normal']; ?> €</span>
            <?php } ?>
        </p>

        <!-- ESTADO DE DISPONIBILIDAD -->
        <?php if ($row['existencias'] > 5) { ?>
            <p class="estado disponible">🟢 Disponible</p>
        <?php } elseif ($row['existencias'] > 0) { ?>
            <p class="estado ultimas">⚠️ Últimas unidades</p>
        <?php } else { ?>
            <p class="estado agotado">🔴 Agotado</p>
        <?php } ?>

        <!-- BOTÓN -->
        <?php if ($row['existencias'] > 0) { ?>
            <a href="pedido.php?id=<?php echo $row['id_producto']; ?>">
                <button>Agregar al carrito</button>
            </a>
        <?php } else { ?>
            <button disabled>Agotado</button>
        <?php } ?>

    </div>

<?php } ?>

</div>

<footer>
    © 2026 Tienda Interstellar 🌌  
    <br><br>

    <!-- SECCIONES INFORMATIVAS ABAJO -->
    <a href="sobre_nosotros.php">Quiénes somos</a>
    <a href="contacto.php">Contacto</a>
    <a href="politica_seguridad.php">Política de seguridad</a>

    <br><br>

    <!-- LOGIN ADMIN SEPARADO -->
    <a href="admin_login.php">Acceso administradores</a>
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