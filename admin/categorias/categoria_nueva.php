<?php
session_start();
include("../../config.php");

// ============================
//   PROTECCIÓN ADMIN REAL
// ============================
if (!isset($_SESSION["admin"])) {
    echo "
    <div style='
        background:black;
        color:white;
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction:column;
        font-family:Arial;
        text-align:center;
    '>
        <h1 style='font-size:50px; color:#00d4ff;'>🚫 Acceso denegado</h1>
        <p style='font-size:20px; opacity:0.8;'>No tienes permisos para entrar aquí</p>
        <a href='../../admin_login.php' style='
            margin-top:20px;
            padding:12px 25px;
            background:#00d4ff;
            color:black;
            border-radius:10px;
            text-decoration:none;
            font-weight:bold;
        '>Ir al login</a>
    </div>";
    exit();
}

// ============================
//   PROCESAR FORMULARIO
// ============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];

    $sql = "INSERT INTO Categoria (nombre, descripcion)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
    $stmt->execute();

    header("Location: categorias.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Categoría</title>

<style>
body { background: #000; color: white; font-family: Arial; }
form { width: 400px; margin: 40px auto; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; }
input, textarea {
    width: 100%; padding: 10px; margin: 10px 0;
    background: rgba(255,255,255,0.1); border: none; color: white;
}
button {
    padding: 10px 20px; background: #00d4ff; border: none; color: black; font-weight: bold; cursor: pointer;
}
</style>

</head>
<body>

<h1 style="text-align:center;">➕ Nueva Categoría</h1>

<form method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>

    <button type="submit">Guardar</button>
</form>

</body>
</html>
