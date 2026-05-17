<?php
session_start();
include("config.php");

if (!isset($_SESSION["cliente"])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION["cliente"];

$sql = "SELECT * FROM Pedido 
        WHERE id_cliente = $id_cliente
        ORDER BY fecha DESC";

$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis pedidos</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: black;
    color: white;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Fondo estrellas */
#stars, #overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: -2;
}

#overlay {
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
}

nav a:hover {
    color: white;
}

/* Contenedor */
.contenedor {
    width: 80%;
    margin: 40px auto;
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.2);
}

/* Tabla */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

th {
    color: #00d4ff;
}

a.btn {
    color: #00d4ff;
    font-weight: bold;
    text-decoration: none;
}

a.btn:hover {
    color: white;
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

<canvas id="stars"></canvas>
<div id="overlay"></div>

<header>
    <div class="logo">🌌 Interstellar Shop</div>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>
        <a href="mis_pedidos.php">Mis pedidos</a>
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</header>

<div class="contenedor">

<h2 style="color:#00d4ff;">📜 Historial de pedidos</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Ver</th>
    </tr>

    <?php while($row = $res->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["id_pedido"]; ?></td>
        <td><?php echo $row["fecha"]; ?></td>
        <td><?php echo number_format($row["total"], 2); ?> €</td>
        <td><?php echo $row["estado"]; ?></td>
        <td><a class="btn" href="detalle_pedido.php?id=<?php echo $row["id_pedido"]; ?>">Ver detalle</a></td>
    </tr>
    <?php } ?>

</table>

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

<script>
// Fondo animado
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
            size: Math.random() * 2 + 0.5,
            speed: Math.random() * 1 + 0.2
        });
    }
}

function animateStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (let s of stars) {
        ctx.fillStyle = "white";
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
        ctx.fill();
        s.y += s.speed;
        if (s.y > canvas.height) s.y = 0;
    }
    requestAnimationFrame(animateStars);
}

initStars();
animateStars();
</script>

</body>
</html>