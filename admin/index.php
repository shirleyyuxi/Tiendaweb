<?php
session_start();
include("../config.php");

// ============================
//   PROTECCIÓN DE ADMIN
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

/* ============================
   CONSULTAS A LAS VISTAS
============================ */

// Total pedidos
$pedidos_total = $conn->query("SELECT COUNT(*) AS total FROM Pedido")->fetch_assoc()["total"];

// Total clientes
$clientes_total = $conn->query("SELECT COUNT(*) AS total FROM Cliente")->fetch_assoc()["total"];

// Total productos
$productos_total = $conn->query("SELECT COUNT(*) AS total FROM Producto")->fetch_assoc()["total"];

// Total categorías
$categorias_total = $conn->query("SELECT COUNT(*) AS total FROM Categoria")->fetch_assoc()["total"];

// Producto más vendido
$producto_top = $conn->query("SELECT * FROM vista_producto_mas_vendido")->fetch_assoc();

// Cliente que más compra
$cliente_top = $conn->query("SELECT * FROM vista_cliente_top_gasto")->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración</title>

<style>
/* ======== GENERAL ======== */
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #0b0f1a;
    color: white;
    display: flex;
}

/* ======== SIDEBAR ======== */
.sidebar {
    width: 260px;
    background: #0d111f;
    height: 100vh;
    padding: 30px 20px;
    border-right: 2px solid #00d4ff;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar h2 {
    color: #00d4ff;
    text-align: center;
    margin-bottom: 40px;
    font-size: 26px;
}

.sidebar a {
    display: block;
    padding: 12px 15px;
    margin: 10px 0;
    color: #ccefff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
    font-size: 18px;
}

.sidebar a:hover {
    background: #00d4ff;
    color: black;
}

/* ======== CONTENIDO PRINCIPAL ======== */
.main {
    margin-left: 260px;
    padding: 40px;
    width: calc(100% - 260px);
}

/* ======== HEADER ======== */
.main h1 {
    font-size: 40px;
    margin-bottom: 10px;
    color: #00d4ff;
}

.subtitle {
    opacity: 0.7;
    margin-bottom: 40px;
}

/* ======== TARJETAS DE ESTADÍSTICAS ======== */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.stat-card {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 20px rgba(0,212,255,0.1);
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 0 25px rgba(0,212,255,0.3);
}

.stat-card h3 {
    margin: 0;
    font-size: 22px;
    color: #00d4ff;
}

.stat-card p {
    font-size: 32px;
    margin-top: 10px;
}

/* ======== SECCIÓN DE ACCESOS ======== */
.section-title {
    margin-top: 50px;
    font-size: 28px;
    color: #00d4ff;
}

.grid-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.link-card {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.1);
    text-align: center;
    transition: 0.3s;
}

.link-card:hover {
    transform: translateY(-6px);
    background: rgba(255,255,255,0.12);
}

.link-card a {
    color: #00d4ff;
    text-decoration: none;
    font-size: 22px;
    font-weight: bold;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🚀 Admin Panel</h2>

    <a href="index.php">🏠 Dashboard</a>
    <a href="admin_pedidos.php">📦 Pedidos</a>
    <a href="admin_clientes.php">👤 Clientes</a>
    <a href="productos/productos.php">🛒 Productos</a>
    <a href="categorias/categorias.php">📂 Categorías</a>
    <a href="estadisticas.php">📊 Estadísticas</a>

    <!-- ⭐ NUEVO BOTÓN AÑADIDO ⭐ -->
    <a href="centro_import_export.php">📦 Importar / Exportar</a>

    <!-- ⭐ BOTÓN DE LOGS AÑADIDO ⭐ -->
    <a href="logs.php">📜 Registro de actividad</a>

    <a href="../index.php">⬅ Volver a la tienda</a>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="main">

    <h1>Bienvenido</h1>
    <p class="subtitle">Panel de control general del sistema</p>

    <!-- TARJETAS DE ESTADÍSTICAS -->
    <div class="stats">

        <div class="stat-card">
            <h3>Pedidos totales</h3>
            <p><?php echo $pedidos_total; ?></p>
        </div>

        <div class="stat-card">
            <h3>Clientes registrados</h3>
            <p><?php echo $clientes_total; ?></p>
        </div>

        <div class="stat-card">
            <h3>Productos activos</h3>
            <p><?php echo $productos_total; ?></p>
        </div>

        <div class="stat-card">
            <h3>Categorías</h3>
            <p><?php echo $categorias_total; ?></p>
        </div>

    </div>

    <!-- TARJETAS EXTRA -->
    <h2 class="section-title">Estadísticas destacadas</h2>

    <div class="stats">

        <div class="stat-card">
            <h3>Producto más vendido</h3>
            <p><?php echo $producto_top["nombre"]; ?></p>
        </div>

        <div class="stat-card">
            <h3>Cliente que más compra</h3>
            <p><?php echo $cliente_top["nombre"] . " " . $cliente_top["apellidos"]; ?></p>
        </div>

    </div>

    <!-- ACCESOS RÁPIDOS -->
    <h2 class="section-title">Accesos rápidos</h2>

    <div class="grid-links">
        <div class="link-card">
            <a href="admin_pedidos.php">📦 Gestionar pedidos</a>
        </div>

        <div class="link-card">
            <a href="productos/productos.php">🛒 Gestionar productos</a>
        </div>

        <div class="link-card">
            <a href="categorias/categorias.php">📂 Gestionar categorías</a>
        </div>

        <div class="link-card">
            <a href="admin_clientes.php">👤 Gestionar clientes</a>
        </div>

        <div class="link-card">
            <a href="centro_import_export.php">📦 Importar / Exportar</a>
        </div>

        <div class="link-card">
            <a href="logs.php">📜 Registro de actividad</a>
        </div>

    </div>

</div>

</body>
</html>