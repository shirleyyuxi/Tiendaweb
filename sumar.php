<?php
session_start();
include("config.php");

$id = intval($_GET["id"]);

// Obtener existencias reales del producto
$sql = "SELECT existencias FROM Producto WHERE id_producto = $id";
$res = $conn->query($sql);
$row = $res->fetch_assoc();

// Si existe el producto y no supera el stock, sumar 1
if ($row && isset($_SESSION["carrito"][$id]) && $_SESSION["carrito"][$id] < $row["existencias"]) {
    $_SESSION["carrito"][$id]++;
}

header("Location: carrito.php");
exit();
?>