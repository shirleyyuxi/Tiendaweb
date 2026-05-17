<?php
session_start();
include("config.php");

if (!isset($_SESSION["cliente"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    die("Pedido no especificado.");
}

$id_pedido = intval($_GET["id"]);
$id_cliente = $_SESSION["cliente"];

// Obtener datos del pedido
$sql = "SELECT * FROM Pedido 
        WHERE id_pedido = $id_pedido 
        AND id_cliente = $id_cliente";

$res = $conn->query($sql);

if ($res->num_rows == 0) {
    die("No tienes acceso a este pedido.");
}

$pedido = $res->fetch_assoc();

// Obtener detalles del pedido
$sqlDet = "SELECT d.*, p.nombre, p.id_producto 
           FROM Detalle_pedido d
           JOIN Producto p ON d.id_producto = p.id_producto
           WHERE d.id_pedido = $id_pedido";

$detalles = $conn->query($sqlDet);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pedido #<?php echo $id_pedido; ?></title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: black;
    color: white;
    overflow-x: hidden;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

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

h2 {
    color: #00d4ff;
}

/* Tabla */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

th {
    color: #00d4ff;
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
        <a href="mis_pedidos.php">Mis pedidos</a>
        <a href="productos.php">Productos</a>
        <a href="carrito.php">Carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</header>

<div class="contenedor">

    <h2>📦 Detalle del pedido #<?php echo $id_pedido; ?></h2>

    <p><strong>Estado:</strong> <?php echo $pedido["estado"]; ?></p>
    <p><strong>Total:</strong> <?php echo number_format($pedido["total"], 2); ?> €</p>
    <p><strong>Puntos usados:</strong> <?php echo $pedido["puntos_usados"]; ?></p>
    <p><strong>Fecha estimada de entrega:</strong> <?php echo $pedido["fecha_estimada_entrega"]; ?></p>

    <h2>Artículos incluidos</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Subtotal</th>
        </tr>

        <?php while($row = $detalles->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["nombre"]; ?></td>
            <td><?php echo $row["cantidad"]; ?></td>
            <td><?php echo number_format($row["precio_unitario"], 2); ?> €</td>
            <td><?php echo number_format($row["cantidad"] * $row["precio_unitario"], 2); ?> €</td>
        </tr>
        <?php } ?>
    </table>

</div>

<footer>
    © 2026 Tienda Interstellar 🌌  
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