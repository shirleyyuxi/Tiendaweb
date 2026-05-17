<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) {
    exit("ACCESO DENEGADO");
}

// ============================
//   REGISTRO DE AUDITORÍA
// ============================
include("../log_funcion.php");
registrar_log($_SESSION["admin_email"], "EXPORTAR_PRODUCTOS", "Exportó todos los productos.");

// ============================
//   CONSULTA DE PRODUCTOS
// ============================
$sql = "SELECT id_producto, nombre, existencias, fecha_modificacion, descripcion, id_categoria
        FROM Producto ORDER BY id_producto ASC";

$resultado = $conn->query($sql);

// ============================
//   DESCARGA DEL CSV
// ============================
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=productos.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["id_producto","nombre","existencias","fecha_modificacion","descripcion","id_categoria"], ";");

while ($fila = $resultado->fetch_assoc()) {
    fputcsv($output, $fila, ";");
}

fclose($output);
exit;
