<?php
session_start();
include("config.php");

$mensaje = "";
$animacion = ""; // Para mostrar mensajes animados

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $pass = $_POST["password"];

    // Consulta segura
    $sql = "SELECT * FROM Administrador WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $admin = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($pass, $admin["contrasena_hash"])) {

            // Sesión correcta
            $_SESSION["admin"] = $admin["id_admin"];
            $_SESSION["admin_email"] = $admin["email"];

            header("Location: admin/index.php");
            exit();

        } else {
            $mensaje = "❌ Contraseña incorrecta";
            $animacion = "shake";
        }

    } else {
        $mensaje = "🚫 Administrador no encontrado";
        $animacion = "shake";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login Administrador</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: black;
    color: white;
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Fondo animado */
#stars {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -2;
}

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

header a {
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
}

/* Formulario */
.contenedor {
    margin: auto;
    width: 350px;
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.2);
    text-align: center;
    animation: <?php echo $animacion; ?> 0.3s;
}

input {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border-radius: 8px;
    border: none;
}

button {
    width: 100%;
    padding: 12px;
    background: #00d4ff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: white;
    color: black;
}

/* Animación de error */
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    50% { transform: translateX(8px); }
    75% { transform: translateX(-8px); }
    100% { transform: translateX(0); }
}

/* Footer */
footer {
    background: rgba(0,0,0,0.8);
    text-align: center;
    padding: 25px;
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
    <a href="index.php">⬅ Volver al inicio</a>
</header>

<div class="contenedor">
    <h2>Acceso Administrador</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>

        <?php if ($mensaje != "") { ?>
            <p style="color:#ff4444; margin-top:10px; font-weight:bold;">
                <?php echo $mensaje; ?>
            </p>
        <?php } ?>
    </form>
</div>

<footer>
    © 2026 Interstellar Shop 🌌  
    <br><br>

    <a href="sobre_nosotros.php">Quiénes somos</a>
    <a href="contacto.php">Contacto</a>
    <a href="politica_seguridad.php">Política de seguridad</a>
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
