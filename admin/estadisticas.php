<?php
session_start();
include("../config.php");

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
        <h1 style=\"font-size:50px; color:#00d4ff;\">🚫 Acceso denegado</h1>
        <p style=\"font-size:20px; opacity:0.8;\">No tienes permisos para entrar aquí</p>
        <a href=\"../admin_login.php\" style=\"
            margin-top:20px;
            padding:12px 25px;
            background:#00d4ff;
            color:black;
            border-radius:10px;
            text-decoration:none;
            font-weight:bold;
        \">Ir al login</a>
    </div>";
    exit();
}

// ============================
//   CONSULTAS A LAS VISTAS
// ============================

$producto_top = $conn->query("SELECT * FROM vista_producto_mas_vendido")->fetch_assoc();
$ranking_productos = $conn->query("SELECT * FROM vista_ranking_productos");

$cliente_top = $conn->query("SELECT * FROM vista_cliente_top_gasto")->fetch_assoc();
$ranking_clientes = $conn->query("SELECT * FROM vista_ranking_clientes");

$pedidos_por_cliente = $conn->query("SELECT * FROM vista_pedidos_por_cliente");
$ingresos_por_producto = $conn->query("SELECT * FROM vista_ingresos_por_producto");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Estadísticas</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #0b0f1a;
    color: white;
}

.main {
    padding: 40px;
    margin-left: 260px;
}

h1 {
    color: #00d4ff;
    font-size: 36px;
    margin-bottom: 10px;
}

.section-title {
    margin-top: 40px;
    font-size: 28px;
    color: #00d4ff;
}

/* Tarjetas */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.card {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 20px rgba(0,212,255,0.1);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 0 25px rgba(0,212,255,0.3);
}

.card h3 {
    margin: 0;
    font-size: 22px;
    color: #00d4ff;
}

.card p {
    font-size: 26px;
    margin-top: 10px;
}

/* Tablas */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background: rgba(255,255,255,0.05);
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

th {
    background: rgba(0,212,255,0.2);
}
</style>

</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

    <h1>📊 Estadísticas generales</h1>

    <!-- TARJETAS PRINCIPALES -->
    <div class="stats">

        <div class="card">
            <h3>Producto más vendido</h3>
            <p><?php echo $producto_top["nombre"]; ?> (<?php echo $producto_top["total_vendido"]; ?> uds)</p>
        </div>

        <div class="card">
            <h3>Cliente que más compra</h3>
            <p><?php echo $cliente_top["nombre"] . " " . $cliente_top["apellidos"]; ?></p>
        </div>

        <div class="card">
            <h3>Total gastado por ese cliente</h3>
            <p><?php echo number_format($cliente_top["total_gastado"], 2); ?> €</p>
        </div>

    </div>

    <!-- RANKING PRODUCTOS -->
    <h2 class="section-title">🥇 Ranking de productos más vendidos</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Unidades vendidas</th>
        </tr>
        <?php while ($p = $ranking_productos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $p["nombre"]; ?></td>
            <td><?php echo $p["total_vendido"]; ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- RANKING CLIENTES -->
    <h2 class="section-title">🧑‍🤝‍🧑 Ranking de clientes por gasto total</h2>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Total gastado (€)</th>
        </tr>
        <?php while ($c = $ranking_clientes->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $c["nombre"] . " " . $c["apellidos"]; ?></td>
            <td><?php echo number_format($c["total_gastado"], 2); ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- PEDIDOS POR CLIENTE -->
    <h2 class="section-title">📦 Pedidos por cliente</h2>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Total pedidos</th>
        </tr>
        <?php while ($pc = $pedidos_por_cliente->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $pc["nombre"] . " " . $pc["apellidos"]; ?></td>
            <td><?php echo $pc["total_pedidos"]; ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- INGRESOS POR PRODUCTO -->
    <h2 class="section-title">💰 Ingresos por producto</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Ingresos (€)</th>
        </tr>
        <?php while ($ip = $ingresos_por_producto->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $ip["nombre"]; ?></td>
            <td><?php echo number_format($ip["ingresos"], 2); ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>
