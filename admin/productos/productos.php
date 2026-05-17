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
//   CONSULTA DE PRODUCTOS
// ============================
$sql = "SELECT p.id_producto, p.nombre, p.existencias, c.nombre AS categoria
        FROM Producto p
        INNER JOIN Categoria c ON p.id_categoria = c.id_categoria
        ORDER BY p.id_producto DESC";

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos</title>

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

table {
    width: 90%;
    margin: 30px auto;
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

a.btn {
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
    <h1>🛒 Gestión de Productos</h1>
    <a href="../index.php" style="color:#00d4ff;">Volver al panel</a>
</header>

<div style="text-align:center; margin:20px;">
    <a class="btn" href="producto_nuevo.php">➕ Añadir producto</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Existencias</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>

    <?php while ($fila = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $fila["id_producto"]; ?></td>
        <td><?php echo $fila["nombre"]; ?></td>
        <td><?php echo $fila["existencias"]; ?></td>
        <td><?php echo $fila["categoria"]; ?></td>
        <td>
            <a class="btn" href="producto_editar.php?id=<?php echo $fila['id_producto']; ?>">✏️ Editar</a>
            <a class="btn" href="producto_eliminar.php?id=<?php echo $fila['id_producto']; ?>" 
               onclick="return confirm('¿Seguro que deseas eliminar este producto?');">❌ Eliminar</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
