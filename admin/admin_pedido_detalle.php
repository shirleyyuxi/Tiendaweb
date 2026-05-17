<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// ============================
//   VALIDAR ID DEL PEDIDO
// ============================
if (!isset($_GET["id"])) {
    echo "<h1 style='color:white; background:black; padding:40px;'>Pedido no especificado</h1>";
    exit;
}

$id_pedido = intval($_GET["id"]);

// ============================
//   OBTENER DATOS DEL PEDIDO
// ============================
$sql_pedido = "SELECT p.id_pedido, p.fecha, p.total, p.estado,
                      c.nombre, c.apellidos, c.email
               FROM Pedido p
               INNER JOIN Cliente c ON p.id_cliente = c.id_cliente
               WHERE p.id_pedido = ?";

$stmt = $conn->prepare($sql_pedido);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();

// Si no existe el pedido
if (!$pedido) {
    echo "<h1 style='color:white; background:black; padding:40px;'>Pedido no encontrado</h1>";
    exit;
}

// ============================
//   OBTENER PRODUCTOS DEL PEDIDO
// ============================
$sql_detalle = "SELECT d.cantidad, d.precio_unitario,
                       pr.nombre AS producto
                FROM Detalle_pedido d
                INNER JOIN Producto pr ON d.id_producto = pr.id_producto
                WHERE d.id_pedido = ?";

$stmt2 = $conn->prepare($sql_detalle);
$stmt2->bind_param("i", $id_pedido);
$stmt2->execute();
$detalle = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle del pedido</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: radial-gradient(circle, #0b0f1a, #000);
    color: white;
}

header {
    background: rgba(0,0,0,0.8);
    padding: 20px;
    text-align: center;
}

nav a {
    margin: 10px;
    color: #00d4ff;
    text-decoration: none;
    font-weight: bold;
}

.contenedor {
    width: 80%;
    margin: 30px auto;
}

h2 {
    text-align: center;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    text-align: left;
}

th {
    background: rgba(0,212,255,0.2);
}

tr:hover {
    background: rgba(255,255,255,0.08);
}
</style>

</head>
<body>

<header>
    <h1>📦 Detalle del pedido #<?php echo $pedido["id_pedido"]; ?></h1>
    <nav>
        <a href="admin_pedidos.php">⬅ Volver a pedidos</a>
        <a href="index.php">Panel admin</a>
        <a href="../admin_logout.php">Cerrar sesión</a>
    </nav>
</header>

<div class="contenedor">

    <h2>Información del pedido</h2>
    <p><strong>Cliente:</strong> <?php echo $pedido["nombre"] . " " . $pedido["apellidos"]; ?></p>
    <p><strong>Email:</strong> <?php echo $pedido["email"]; ?></p>
    <p><strong>Fecha:</strong> <?php echo $pedido["fecha"]; ?></p>
    <p><strong>Estado:</strong> <?php echo $pedido["estado"]; ?></p>
    <p><strong>Total:</strong> <?php echo number_format($pedido["total"], 2); ?> €</p>

    <h2>Productos del pedido</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio (€)</th>
            <th>Total (€)</th>
        </tr>

        <?php while ($fila = $detalle->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $fila["producto"]; ?></td>
            <td><?php echo $fila["cantidad"]; ?></td>
            <td><?php echo number_format($fila["precio_unitario"], 2); ?></td>
            <td><?php echo number_format($fila["cantidad"] * $fila["precio_unitario"], 2); ?></td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>
