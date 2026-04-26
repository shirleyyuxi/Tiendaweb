<?php
session_start();
include("config.php");

$id = intval($_GET["id"]);

// Obtener producto y stock
$sql = "SELECT * FROM Producto WHERE id_producto = $id";
$res = $conn->query($sql);
$producto = $res->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado");
}

$stock = $producto["existencias"];

// Inicializar carrito si no existe
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

// Si ya existe en el carrito, sumar 1
if (isset($_SESSION["carrito"][$id])) {

    // Control de stock
    if ($_SESSION["carrito"][$id] < $stock) {
        $_SESSION["carrito"][$id]++;
    }

} else {
    // Primera vez que se añade
    $_SESSION["carrito"][$id] = 1;
}

header("Location: carrito.php");
exit();
?>
