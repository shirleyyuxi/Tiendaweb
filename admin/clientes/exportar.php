<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

// ============================
//   REGISTRO DE AUDITORÍA
// ============================
include("../log_funcion.php");
registrar_log($_SESSION["admin_email"], "EXPORTAR_CLIENTES", "Exportó todos los clientes.");

// ============================
//   CONSULTA DE CLIENTES
// ============================
$sql = "SELECT id_cliente, email, direccion, fecha_registro, telefono, nombre, apellidos, puntos_acumulados
        FROM Cliente ORDER BY id_cliente ASC";

$res = $conn->query($sql);

// ============================
//   DESCARGA DEL CSV
// ============================
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=clientes.csv");

$out = fopen("php://output", "w");
fputcsv($out, ["id_cliente","email","direccion","fecha_registro","telefono","nombre","apellidos","puntos_acumulados"], ";");

while ($f = $res->fetch_assoc()) {
    fputcsv($out, $f, ";");
}

fclose($out);
exit;
