<?php
function registrar_log($email_admin, $accion, $descripcion) {

    $ruta = __DIR__ . "/logs/log_admin.txt";

    $fecha = date("Y-m-d H:i:s");

    $linea = "[$fecha] admin: $email_admin | ACCIÓN: $accion | Detalles: $descripcion" . PHP_EOL;

    file_put_contents($ruta, $linea, FILE_APPEND);
}
?>
