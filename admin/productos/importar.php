<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) {
    exit("ACCESO DENEGADO");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $archivo = $_FILES["csv"]["tmp_name"];

    if (($handle = fopen($archivo, "r")) !== false) {

        $headers = fgetcsv($handle, 1000, ";");

        $creados = 0;
        $actualizados = 0;

        while (($data = fgetcsv($handle, 1000, ";")) !== false) {

            $id = intval($data[0]);
            $nombre = $data[1];
            $existencias = intval($data[2]);
            $fecha_mod = $data[3];
            $descripcion = $data[4];
            $categoria = intval($data[5]);

            // ¿Existe el producto?
            $check = $conn->prepare("SELECT id_producto FROM Producto WHERE id_producto=?");
            $check->bind_param("i", $id);
            $check->execute();
            $res = $check->get_result();

            if ($res->num_rows > 0) {
                // ACTUALIZAR
                $update = $conn->prepare("
                    UPDATE Producto SET nombre=?, existencias=?, fecha_modificacion=?, descripcion=?, id_categoria=?
                    WHERE id_producto=?
                ");
                $update->bind_param("sissii", $nombre, $existencias, $fecha_mod, $descripcion, $categoria, $id);
                $update->execute();
                $actualizados++;
            } else {
                // CREAR
                $insert = $conn->prepare("
                    INSERT INTO Producto (nombre, existencias, fecha_modificacion, descripcion, id_categoria)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $insert->bind_param("sissi", $nombre, $existencias, $fecha_mod, $descripcion, $categoria);
                $insert->execute();
                $creados++;
            }
        }

        fclose($handle);

        // ============================
        //   REGISTRO DE AUDITORÍA
        // ============================
        include("../log_funcion.php");
        registrar_log($_SESSION["admin_email"], "IMPORTAR_PRODUCTOS", "Creados: $creados | Actualizados: $actualizados");

        $mensaje = "Importación completada. Creados: $creados | Actualizados: $actualizados";
    }
}
?>
<!DOCTYPE html>
<html>
<body style="background:black;color:white;font-family:Arial;">
<h1>📥 Importar productos</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="csv" accept=".csv" required>
    <button type="submit">Importar</button>
</form>

<p><?= $mensaje ?></p>
</body>
</html>
