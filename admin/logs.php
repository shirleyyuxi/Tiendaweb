<?php
session_start();
if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

// Ruta del archivo de logs (asumiendo logs.php está en /admin/)
$archivo = __DIR__ . "/logs/log_admin.txt";

// Leer líneas del archivo
$lineas = file_exists($archivo)
    ? file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    : [];

// Mostrar las más recientes primero
$lineas = array_reverse($lineas);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registro de actividad</title>
<style>
body {
    background:#0b0f1a;
    color:white;
    font-family:Arial;
}
table {
    width:90%;
    margin:30px auto;
    border-collapse:collapse;
    background:rgba(255,255,255,0.05);
}
th, td {
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}
th {
    background:rgba(0,212,255,0.2);
    color:#00d4ff;
}
tr:hover {
    background:rgba(255,255,255,0.08);
}
.boton-volver {
    display:block;
    width:200px;
    margin:20px auto;
    padding:12px;
    text-align:center;
    background:#00d4ff;
    color:black;
    font-weight:bold;
    border-radius:10px;
    text-decoration:none;
}
.boton-volver:hover {
    background:white;
}
</style>
</head>
<body>

<h1 style="text-align:center; color:#00d4ff;">📜 Registro de actividad</h1>

<a href="index.php" class="boton-volver">⬅ Volver al panel</a>

<table>
<tr>
    <th>Fecha</th>
    <th>Administrador</th>
    <th>Acción</th>
    <th>Detalles</th>
</tr>

<?php
foreach ($lineas as $l) {

    // Ejemplo de línea:
    // [2026-05-12 12:37:03] admin: admin@tienda.com | ACCIÓN: EXPORTAR_PRODUCTOS | Detalles: Exportó todos los productos.

    // Buscar fecha entre corchetes
    $posIni = strpos($l, '[');
    $posFin = strpos($l, ']');

    if ($posIni === false || $posFin === false) continue;

    $fecha = substr($l, $posIni + 1, $posFin - $posIni - 1);

    // Resto de la línea después de "] "
    $resto = trim(substr($l, $posFin + 1)); // "admin: ... | ACCIÓN: ... | Detalles: ..."

    // Partes separadas por " | "
    $partes = explode(' | ', $resto);
    if (count($partes) < 3) continue;

    // admin: email
    $admin = trim(str_replace('admin: ', '', $partes[0]));

    // ACCIÓN: algo
    $accion = trim(str_replace('ACCIÓN: ', '', $partes[1]));

    // Detalles: texto
    $detalles = trim(str_replace('Detalles: ', '', $partes[2]));

    echo "<tr>
            <td>" . htmlspecialchars($fecha) . "</td>
            <td>" . htmlspecialchars($admin) . "</td>
            <td>" . htmlspecialchars($accion) . "</td>
            <td>" . htmlspecialchars($detalles) . "</td>
          </tr>";
}
?>

</table>

</body>
</html>
