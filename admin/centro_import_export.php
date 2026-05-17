<?php
session_start();
include("../config.php");

// PROTECCIÓN ADMIN
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
        <a href='../admin_login.php' style='
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Centro de Importación / Exportación</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: radial-gradient(circle, #0b0f1a, #000);
    color: white;
}

header {
    background: rgba(0,0,0,0.85);
    padding: 20px;
    text-align: center;
    border-bottom: 2px solid #00d4ff;
}

.container {
    width: 90%;
    margin: 40px auto;
}

.section {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    border: 1px solid rgba(255,255,255,0.1);
}

.section h2 {
    color: #00d4ff;
    margin-bottom: 15px;
}

.btn {
    display: inline-block;
    padding: 10px 18px;
    background: #00d4ff;
    color: black;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    margin: 5px;
}

input[type=file] {
    margin: 10px 0;
}
</style>

</head>
<body>

<header>
    <h1>📦 Centro de Importación / Exportación</h1>
    <a href="index.php" style="color:#00d4ff;">Volver al panel</a>
</header>

<div class="container">

    <!-- PRODUCTOS -->
    <div class="section">
        <h2>🛒 Productos</h2>

        <a class="btn" href="productos/exportar.php">📤 Exportar productos (CSV)</a>

        <form action="productos/importar.php" method="POST" enctype="multipart/form-data">
            <p>📥 Importar productos completos (crear + actualizar)</p>
            <input type="file" name="csv" accept=".csv" required>
            <button class="btn">Importar productos</button>
        </form>

        <form action="productos/importar_stock.php" method="POST" enctype="multipart/form-data">
            <p>📥 Importar solo existencias (stock)</p>
            <input type="file" name="csv" accept=".csv" required>
            <button class="btn">Actualizar stock</button>
        </form>
    </div>

    <!-- CATEGORÍAS -->
    <div class="section">
        <h2>📂 Categorías</h2>

        <a class="btn" href="categorias/exportar.php">📤 Exportar categorías</a>

        <form action="categorias/importar.php" method="POST" enctype="multipart/form-data">
            <p>📥 Importar categorías</p>
            <input type="file" name="csv" accept=".csv" required>
            <button class="btn">Importar categorías</button>
        </form>
    </div>

    <!-- CLIENTES -->
    <div class="section">
        <h2>👤 Clientes</h2>

        <a class="btn" href="clientes/exportar.php">📤 Exportar clientes</a>
    </div>

    <!-- PEDIDOS -->
    <div class="section">
        <h2>📦 Pedidos</h2>

        <a class="btn" href="pedidos/exportar.php">📤 Exportar pedidos</a>
    </div>

</div>

</body>
</html>
