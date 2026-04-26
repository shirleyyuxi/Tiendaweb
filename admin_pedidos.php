<?php
include("config.php");

$sql = "SELECT p.*, 
               c.nombre, c.apellidos, c.email
        FROM Pedido p
        JOIN Cliente c ON p.id_cliente = c.id_cliente
        ORDER BY p.fecha DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin - Pedidos</title>
<link rel="stylesheet" href="css/estilos.css">
<style>
table {
    width: 95%;
    margin: 20px auto;
    border-collapse: collapse;
    color: white;
}
th, td {
    border-bottom: 1px solid rgba(255,255,255,0.2);
    padding: 10px;
}
th {
    background: rgba(255,255,255,0.1);
}
a.btn {
    padding: 5px 10px;
    background: #00d4ff;
    border-radius: 8px;
    text-decoration: none;
    color: black;
}
</style>
</head>
<body>

<header>
    <h1>🛠️ Admin - Pedidos</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="admin.php">Admin básico</a>
        <a href="admin_clientes.php">Clientes</a>
    </nav>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Email</th>
        <th>Estado</th>
        <th>Total</th>
        <th>Entrega estimada</th>
        <th>Entrega real</th>
        <th>Retraso</th>
        <th>Acciones</th>
    </tr>

    <?php while($row = $resultado->fetch_assoc()) { 

        // Calcular retraso
        if ($row["estado"] == "entregado") {
            if ($row["fecha_real_entrega"] > $row["fecha_estimada_entrega"]) {
                $retraso = "<span style='color:red;'>⛔ Retrasado</span>";
            } else {
                $retraso = "<span style='color:#00ff88;'>✔ A tiempo</span>";
            }
        } elseif ($row["estado"] == "enviado") {
            $retraso = "<span style='color:#ffcc00;'>🚚 En camino</span>";
        } else {
            $retraso = "<span style='color:#888;'>⏳ Pendiente</span>";
        }
    ?>
    <tr>
        <td><?php echo $row['id_pedido']; ?></td>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['nombre'] . " " . $row['apellidos']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['estado']; ?></td>
        <td><?php echo $row['total']; ?> €</td>
        <td><?php echo $row['fecha_estimada_entrega']; ?></td>
        <td><?php echo $row['fecha_real_entrega'] ?? "—"; ?></td>
        <td><?php echo $retraso; ?></td>
        <td>
            <a class="btn" href="admin_pedido_detalle.php?id=<?php echo $row['id_pedido']; ?>">Ver</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

