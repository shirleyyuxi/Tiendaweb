<?php
session_start();
include("config.php");

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Obtener puntos del cliente si está logueado
$puntos_cliente = 0;

if (isset($_SESSION["cliente"])) {
    $id_cliente = $_SESSION["cliente"];
    $sqlP = "SELECT puntos_acumulados FROM Cliente WHERE id_cliente = $id_cliente";
    $resP = $conn->query($sqlP);
    $rowP = $resP->fetch_assoc();
    $puntos_cliente = $rowP["puntos_acumulados"];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito</title>

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

/* Carrito */
.carrito {
    width: 80%;
    margin: auto;
    margin-top: 40px;
}

.card {
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}

.card img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
}

.total {
    text-align: center;
    margin-top: 30px;
    font-size: 1.4em;
}

button, a.btn {
    padding: 8px 12px;
    background: #00d4ff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    color: black;
    text-decoration: none;
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
    <h1>🛒 Tu carrito</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="categorias.php">Categorías</a>
        <a href="carrito.php">Carrito</a>

        <?php if(isset($_SESSION["cliente"])) { ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        <?php } ?>
    </nav>
</header>

<div class="carrito">

<?php
$total = 0;

if (count($_SESSION['carrito']) > 0) {

    foreach ($_SESSION['carrito'] as $id => $cantidad) {

        $sql = "SELECT p.*, h.precio_normal, h.precio_oferta
                FROM Producto p
                LEFT JOIN Historico_Precio h
                  ON p.id_producto = h.id_producto
                WHERE p.id_producto = $id
                  AND h.fecha_fin IS NULL";

        $resultado = $conn->query($sql);
        $producto = $resultado->fetch_assoc();

        if ($producto) {

            $precio = $producto['precio_oferta'] ?? $producto['precio_normal'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;
?>
    <div class="card">
        <img src="img/<?php echo $producto['id_producto']; ?>.jpg">

        <div style="flex:1;">
            <h3><?php echo $producto['nombre']; ?></h3>
            <p>Precio: <?php echo number_format($precio, 2); ?> €</p>

            <p>
                <a class="btn" href="sumar.php?id=<?php echo $id; ?>">➕</a>
                <strong><?php echo $cantidad; ?></strong>
                <a class="btn" href="restar.php?id=<?php echo $id; ?>">➖</a>
            </p>

            <p>Subtotal: <?php echo number_format($subtotal, 2); ?> €</p>
        </div>
    </div>
<?php
        }
    }

} else {
    echo "<p style='text-align:center; font-size:1.3rem;'>Tu carrito está vacío 🚀</p>";
}
?>

</div>

<div class="total">
    <p><strong>Total:</strong> <?php echo number_format($total, 2); ?> €</p>

    <?php if(isset($_SESSION["cliente"])) { ?>
        <p style="font-size:1.2rem;">
            ⭐ Puntos disponibles: <strong><?php echo $puntos_cliente; ?></strong>
        </p>
    <?php } ?>

    <?php if ($total > 0 && isset($_SESSION["cliente"])) { ?>
        <form method="POST" action="finalizar.php" style="margin-top:20px;">
            <label>¿Cuántos puntos quieres usar?</label><br>
            <input type="number" name="usar_puntos" min="0" max="<?php echo $puntos_cliente; ?>" value="0"
                   style="padding:8px; border-radius:8px; margin-top:10px;">
            <br><br>
            <button type="submit">Finalizar compra</button>
        </form>
    <?php } elseif ($total > 0) { ?>
        <a href="login.php"><button>Iniciar sesión para finalizar compra</button></a>
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

