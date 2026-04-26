<?php
session_start();
include("config.php");

if (!isset($_SESSION["cliente"])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION["cliente"];
$usar_puntos = $_POST["usar_puntos"] ?? 0;

// 1️⃣ Calcular total del carrito
$total = 0;

foreach ($_SESSION["carrito"] as $id => $cantidad) {

    // Obtener precio actual
    $sql = "SELECT p.*, h.precio_normal, h.precio_oferta, p.existencias
            FROM Producto p
            LEFT JOIN Historico_Precio h
              ON p.id_producto = h.id_producto
            WHERE p.id_producto = $id
              AND h.fecha_fin IS NULL";

    $res = $conn->query($sql);
    $prod = $res->fetch_assoc();

    // ❗ Comprobación de stock real
    if ($cantidad > $prod["existencias"]) {
        die("Error: No hay existencias suficientes del producto: " . $prod["nombre"]);
    }

    $precio = $prod["precio_oferta"] ?? $prod["precio_normal"];
    $total += $precio * $cantidad;
}

// 2️⃣ Aplicar puntos usados
if ($usar_puntos > $total) {
    $usar_puntos = $total;
}

$total_final = $total - $usar_puntos;

// 3️⃣ Fecha estimada
$fecha_estimada = date("Y-m-d H:i:s", strtotime("+3 days"));

// 4️⃣ Insertar pedido
$sqlPedido = "INSERT INTO Pedido 
(fecha, estado, total, puntos_usados, fecha_estimada_entrega, id_cliente)
VALUES 
(NOW(), 'pendiente', $total_final, $usar_puntos, '$fecha_estimada', $id_cliente)";

$conn->query($sqlPedido);

$id_pedido = $conn->insert_id;

// 5️⃣ Insertar detalle + RESTAR STOCK REAL
$id_detalle = 1;

foreach ($_SESSION["carrito"] as $id => $cantidad) {

    $sql = "SELECT p.*, h.precio_normal, h.precio_oferta
            FROM Producto p
            LEFT JOIN Historico_Precio h
              ON p.id_producto = h.id_producto
            WHERE p.id_producto = $id
              AND h.fecha_fin IS NULL";

    $res = $conn->query($sql);
    $prod = $res->fetch_assoc();

    $precio = $prod["precio_oferta"] ?? $prod["precio_normal"];

    // Insertar detalle
    $sqlDet = "INSERT INTO Detalle_pedido 
    (id_pedido, id_detalle, cantidad, precio_unitario, id_producto)
    VALUES 
    ($id_pedido, $id_detalle, $cantidad, $precio, $id)";

    $conn->query($sqlDet);

    // ❗ RESTAR STOCK REAL
    $sqlStock = "UPDATE Producto 
                 SET existencias = existencias - $cantidad
                 WHERE id_producto = $id";

    $conn->query($sqlStock);

    $id_detalle++;
}

// 6️⃣ Vaciar carrito
$_SESSION["carrito"] = [];

// 7️⃣ Redirigir al detalle del pedido
header("Location: detalle_pedido.php?id=$id_pedido");
exit();
?>
