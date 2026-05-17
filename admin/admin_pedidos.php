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
//   CONSULTA DE PEDIDOS
// ============================
$sql = "SELECT p.id_pedido, p.fecha, p.total, p.estado,
               c.nombre, c.apellidos, c.email
        FROM Pedido p
        INNER JOIN Cliente c ON p.id_cliente = c.id_cliente
        ORDER BY p.id_pedido DESC";

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pedidos - Panel Admin</title>

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

table {
    width: 90%;
    margin: 30px auto;
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

.btn-detalle {
    padding: 6px 12px;
    background: #00d4ff;
    color: black;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
</style>

</head>
<body>

<header>
    <h1>🧾 Pedidos realizados</h1>
    <nav>
        <a href="index.php">⬅ Volver al panel</a>
        <a href="../admin_logout.php">Cerrar sesión</a>
    </nav>
</header>

<table>
    <tr>
        <th>ID Pedido</th>
        <th>Cliente</th>
        <th>Email</th>
        <th>Fecha</th>
        <th>Total (€)</th>
        <th>Estado</th>
        <th>Detalle</th>
    </tr>

    <?php while ($fila = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $fila["id_pedido"]; ?></td>
        <td><?php echo $fila["nombre"] . " " . $fila["apellidos"]; ?></td>
        <td><?php echo $fila["email"]; ?></td>
        <td><?php echo $fila["fecha"]; ?></td>
        <td><?php echo number_format($fila["total"], 2); ?></td>
        <td><?php echo $fila["estado"]; ?></td>
        <td>
            <a class="btn-detalle" href="admin_pedido_detalle.php?id=<?php echo $fila['id_pedido']; ?>">
                Ver detalle
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
