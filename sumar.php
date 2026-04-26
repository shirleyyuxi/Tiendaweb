<?php
session_start();
include("config.php");

$id = intval($_GET["id"]);

$sql = "SELECT existencias FROM Producto WHERE id_producto = $id";
$res = $conn->query($sql);
$row = $res->fetch_assoc();

if ($row && $_SESSION["carrito"][$id] < $row["existencias"]) {
    $_SESSION["carrito"][$id]++;
}

header("Location: carrito.php");
exit();
?>
