<?php
session_start();

$id = intval($_GET["id"]);

if ($_SESSION["carrito"][$id] > 1) {
    $_SESSION["carrito"][$id]--;
} else {
    unset($_SESSION["carrito"][$id]);
}

header("Location: carrito.php");
exit();
?>
