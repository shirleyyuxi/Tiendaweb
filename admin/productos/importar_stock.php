<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

// Detectar delimitador automáticamente
function detectarDelimitador($file) {
    $delimitadores = [",", ";", "\t"];
    $linea = fgets(fopen($file, "r"));
    $conteos = [];

    foreach ($delimitadores as $d) {
        $conteos[$d] = substr_count($linea, $d);
    }

    // Devuelve el delimitador más usado
    return array_search(max($conteos), $conteos);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $archivo = $_FILES["csv"]["tmp_name"];
    $delimitador = detectarDelimitador($archivo);

    if (($handle = fopen($archivo, "r")) !== false) {

        // Leer cabeceras
        fgetcsv($handle, 1000, $delimitador);

        while (($data = fgetcsv($handle, 1000, $delimitador)) !== false) {

            // Evitar errores si la fila viene incompleta
            if (count($data) < 2) continue;

            $id = intval($data[0]);
            $stock = intval($data[1]);

            // Actualizar stock
            $update = $conn->prepare("
                UPDATE Producto 
                SET existencias=?, fecha_modificacion=CURDATE() 
                WHERE id_producto=?
            ");
            $update->bind_param("ii", $stock, $id);
            $update->execute();
        }

        fclose($handle);
    }

    // ============================
    //   REGISTRO DE AUDITORÍA
    // ============================
    include("../log_funcion.php");
    registrar_log($_SESSION["admin_email"], "IMPORTAR_STOCK", "Actualizó existencias mediante CSV.");

    echo "Stock actualizado correctamente";
    exit;
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="csv" required>
    <button>Actualizar stock</button>
</form>
