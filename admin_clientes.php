<?php
include("config.php");

$sql = "SELECT c.id_cliente, c.nombre, c.apellidos, c.email, c.telefono, c.fecha_registro,
               COUNT(p.id_pedido) AS num_pedidos,
               IFNULL(SUM(p.total),0) AS total_gastado
        FROM Cliente c
        LEFT JOIN Pedido p ON c.id_cliente = p.id_cliente
        GROUP BY c.id_cliente
        ORDER BY c.fecha_registro DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin - Clientes</title>
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
    text-align: left;
}
th {
    background: rgba(255,255,255,0.1);
}
</style>
</head>
<body>

<header>
    <h1>🛠️ Admin - Clientes</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="admin_pedidos.php">Pedidos</a>
        <a href="admin.php">Admin básico</a>
    </nav>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Fecha registro</th>
        <th>Nº pedidos</th>
        <th>Total gastado</th>
    </tr>
    <?php while($row = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id_cliente']; ?></td>
        <td><?php echo $row['nombre']." ".$row['apellidos']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['telefono']; ?></td>
        <td><?php echo $row['fecha_registro']; ?></td>
        <td><?php echo $row['num_pedidos']; ?></td>
        <td><?php echo $row['total_gastado']; ?> €</td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
