<?php
session_start();

$id = intval($_GET["id"]);

// Si el producto existe en el carrito
if (isset($_SESSION["carrito"][$id])) {

    // Si hay más de 1, restar
    if ($_SESSION["carrito"][$id] > 1) {
        $_SESSION["carrito"][$id]--;
    } else {
        // Si solo queda 1, eliminarlo
        unset($_SESSION["carrito"][$id]);
    }
}

header("Location: carrito.php");
exit();
?>