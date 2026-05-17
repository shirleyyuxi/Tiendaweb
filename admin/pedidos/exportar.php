<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

// ============================
//   REGISTRO DE AUDITORÍA
// ============================
include("../log_funcion.php");
registrar_log($_SESSION["admin_email"], "EXPORTAR_PEDIDOS", "Exportó todos los pedidos.");

// ============================
//   CONSULTA DE PEDIDOS
// ============================
$sql = "SELECT id_pedido, fecha, estado, total, fecha_real_entrega, fecha_estimada_entrega, puntos_usados, id_cliente
        FROM Pedido ORDER BY id_pedido ASC";

$res = $conn->query($sql);

// ============================
//   DESCARGA DEL CSV
// ============================
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=pedidos.csv");

$out = fopen("php://output", "w");
fputcsv($out, ["id_pedido","fecha","estado","total","fecha_real_entrega","fecha_estimada_entrega","puntos_usados","id_cliente"], ";");

while ($f = $res->fetch_assoc()) {
    fputcsv($out, $f, ";");
}

fclose($out);
exit;
