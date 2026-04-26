<?php
session_start();
session_destroy();
header("Location: carrito.php");
exit();
?>