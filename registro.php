<?php
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $fecha = date("Y-m-d");

    // Comprobar si ya existe email
    $check = $conn->query("SELECT * FROM Cliente WHERE email='$email'");

    if ($check->num_rows > 0) {
        $error = "El email ya está registrado";
    } else {

        $sql = "INSERT INTO Cliente 
        (email, direccion, fecha_registro, telefono, nombre, apellidos, contrasena_hash)
        VALUES 
        ('$email','$direccion','$fecha','$telefono','$nombre','$apellidos','$password')";

        $conn->query($sql);

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro - Tienda Interstellar</title>

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

/* Caja de registro */
.form-container {
    width: 420px;
    margin: 120px auto;
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(4px);
    text-align: center;
}

.form-container h2 {
    margin-bottom: 20px;
    text-shadow: 0 0 10px #00d4ff;
}

/* Inputs */
input {
    width: 90%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
}

/* Botón */
button {
    padding: 12px;
    background: #00d4ff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
    transition: 0.3s;
}

button:hover {
    background: #00ffff;
    transform: scale(1.05);
}

/* Botón volver */
.volver {
    display: block;
    width: 200px;
    margin: 20px auto 0 auto;
    padding: 10px;
    text-align: center;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.volver:hover {
    background: rgba(255,255,255,0.2);
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

<div class="form-container">

<h2>🪐 Registro</h2>

<form method="POST">

    <input type="text" name="nombre" placeholder="Nombre" required>

    <input type="text" name="apellidos" placeholder="Apellidos" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Contraseña" required>

    <input type="text" name="direccion" placeholder="Dirección">

    <input type="text" name="telefono" placeholder="Teléfono">

    <button type="submit">Registrarse</button>

</form>

<p class="error"><?php echo $error; ?></p>

<a href="index.php" class="volver">⬅ Volver al inicio</a>

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
