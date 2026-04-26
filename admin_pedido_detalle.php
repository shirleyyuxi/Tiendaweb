<?php
include("config.php");

$id_pedido = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sqlPedido = "SELECT p.*, c.nombre, c.apellidos, c.email
              FROM Pedido p
              JOIN Cliente c ON p.id_cliente = c.id_cliente
              WHERE p.id_pedido = $id_pedido";
$resPedido = $conn->query($sqlPedido);
$pedido = $resPedido->fetch_assoc();

if (!$pedido) {
    die("Pedido no encontrado");
}

$sqlDet = "SELECT d.*, pr.nombre
           FROM Detalle_pedido d
           JOIN Producto pr ON d.id_producto = pr.id_producto
           WHERE d.id_pedido = $id_pedido";
$resDet = $conn->query($sqlDet);

// Cambiar estado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_estado = $_POST["estado"];

    if ($nuevo_estado == "entregado") {
        $conn->query("UPDATE Pedido 
                      SET estado='entregado', fecha_real_entrega = NOW()
                      WHERE id_pedido=$id_pedido");
    } else {
        $conn->query("UPDATE Pedido 
                      SET estado='$nuevo_estado'
                      WHERE id_pedido=$id_pedido");
    }

    header("Location: admin_pedido_detalle.php?id=".$id_pedido);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle pedido <?php echo $id_pedido; ?></title>
<link rel="stylesheet" href="css/estilos.css">
<style>
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    color: white;
}
th, td {
    border-bottom: 1px solid rgba(255,255,255,0.2);
    padding: 10px;
}
.form-estado {
    width: 90%;
    margin: 20px auto;
}
</style>
</head>
<body>

<header>
    <h1>🛠️ Detalle pedido #<?php echo $id_pedido; ?></h1>
    <nav>
        <a href="admin_pedidos.php">Volver a pedidos</a>
    </nav>
</header>

<div class="form-estado">
    <h3>Cliente</h3>
    <p><?php echo $pedido['nombre']." ".$pedido['apellidos']; ?> (<?php echo $pedido['email']; ?>)</p>
    <p>Fecha del pedido: <?php echo $pedido['fecha']; ?></p>
    <p>Total: <?php echo $pedido['total']; ?> €</p>

    <p>Entrega estimada: <strong><?php echo $pedido['fecha_estimada_entrega']; ?></strong></p>
    <p>Entrega real: <strong><?php echo $pedido['fecha_real_entrega'] ?? "—"; ?></strong></p>

    <?php
    if ($pedido["estado"] == "entregado") {
        if ($pedido["fecha_real_entrega"] > $pedido["fecha_estimada_entrega"]) {
            echo "<p style='color:red;'>⛔ Pedido entregado con retraso</p>";
        } else {
            echo "<p style='color:#00ff88;'>✔ Pedido entregado a tiempo</p>";
        }
    } elseif ($pedido["estado"] == "enviado") {
        echo "<p style='color:#ffcc00;'>🚚 Pedido en camino</p>";
    } else {
        echo "<p style='color:#888;'>⏳ Pedido pendiente</p>";
    }
    ?>

    <form method="POST">
        <label>Estado: </label>
        <select name="estado">
            <option value="pendiente" <?php if($pedido['estado']=='pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="preparando" <?php if($pedido['estado']=='preparando') echo 'selected'; ?>>Preparando</option>
            <option value="enviado" <?php if($pedido['estado']=='enviado') echo 'selected'; ?>>Enviado</option>
            <option value="entregado" <?php if($pedido['estado']=='entregado') echo 'selected'; ?>>Entregado</option>
        </select>
        <button type="submit">Actualizar</button>
    </form>
</div>

<table>
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Subtotal</th>
    </tr>
    <?php while($row = $resDet->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['cantidad']; ?></td>
        <td><?php echo $row['precio_unitario']; ?> €</td>
        <td><?php echo $row['cantidad'] * $row['precio_unitario']; ?> €</td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
