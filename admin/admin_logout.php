<?php
session_start();

// Cerrar sesión del administrador
session_destroy();

// Redirigir al login de administración
header("Location: admin_login.php");
exit();
?>
