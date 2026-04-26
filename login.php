<?php
session_start();
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Cliente WHERE email='$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["contrasena_hash"])) {

            $_SESSION["cliente"] = $usuario["id_cliente"];

            header("Location: index.php");
            exit();

        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - Tienda Interstellar</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: black;
    color: white;
    overflow: hidden;
}

/* Fondo de estrellas */
#stars {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: -3;
}

/* Nebulosa */
.nebulosa {
    position: fixed;
    width: 140%;
    height: 140%;
    top: -20%;
    left: -20%;
    background: radial-gradient(circle, rgba(0,150,255,0.15), transparent 70%);
    animation: moverNebulosa 25s infinite alternate ease-in-out;
    z-index: -2;
}

@keyframes moverNebulosa {
    0% { transform: translate(0,0) scale(1); }
    100% { transform: translate(60px, -40px) scale(1.15); }
}

/* Caja de login */
.login-box {
    width: 350px;
    margin: 150px auto;
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(4px);
}

.login-box h2 {
    margin-bottom: 20px;
    text-shadow: 0 0 10px #00d4ff;
}

input {
    width: 90%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
}

.btn {
    display: inline-block;
    padding: 12px 25px;
    background: #00d4ff;
    color: black;
    border-radius: 10px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
    cursor: pointer;
    border: none;
}

.btn:hover {
    background: #00ffff;
    transform: scale(1.05);
}

.error {
    color: #ff4444;
    margin-top: 10px;
}
</style>
</head>

<body>

<canvas id="stars"></canvas>
<div class="nebulosa"></div>

<div class="login-box">
    <h2>🚀 Iniciar sesión</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit" class="btn">Entrar</button>
    </form>

    <p class="error"><?php echo $error; ?></p>

    <br>
    <a href="index.php" class="btn">⬅ Volver al inicio</a>
</div>

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
            size: Math.random() * 1.5 + 0.3,
            speed: Math.random() * 0.15 + 0.05
        });
    }
}

function animateStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let s of stars) {
        ctx.fillStyle = "rgba(255,255,255,0.9)";
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
        ctx.fill();

        s.y += s.speed;

        if (s.y > canvas.height) {
            s.y = 0;
            s.x = Math.random() * canvas.width;
        }
    }

    requestAnimationFrame(animateStars);
}

initStars();
animateStars();
</script>

</body>
</html>
