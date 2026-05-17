<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

// ============================
//   CONSULTA DE CATEGORÍAS
// ============================
$sql = "SELECT id_categoria, nombre, descripcion FROM Categoria ORDER BY id_categoria ASC";
$res = $conn->query($sql);

// ============================
//   REGISTRO DE AUDITORÍA
// ============================
include("../log_funcion.php");
registrar_log($_SESSION["admin_email"], "EXPORTAR_CATEGORIAS", "Exportó todas las categorías.");

// ============================
//   DESCARGA DEL CSV
// ============================
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=categorias.csv");

$out = fopen("php://output", "w");
fputcsv($out, ["id_categoria","nombre","descripcion"], ";");

while ($f = $res->fetch_assoc()) {
    fputcsv($out, $f, ";");
}

fclose($out);
exit;
