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
//   VALIDAR ID
// ============================
if (!isset($_GET["id"])) {
    echo "<h1 style='color:white; background:black; padding:40px;'>Categoría no especificada</h1>";
    exit;
}

$id = intval($_GET["id"]);

// ============================
//   ELIMINAR CATEGORÍA (SEGURO)
// ============================
$stmt = $conn->prepare("DELETE FROM Categoria WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Volver a la lista
header("Location: categorias.php");
exit;
