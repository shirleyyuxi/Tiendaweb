<?php
session_start();
include("../../config.php");

if (!isset($_SESSION["admin"])) exit("ACCESO DENEGADO");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $archivo = $_FILES["csv"]["tmp_name"];

    if (($handle = fopen($archivo, "r")) !== false) {

        fgetcsv($handle, 1000, ";"); // Cabeceras

        while (($data = fgetcsv($handle, 1000, ";")) !== false) {

            $id = intval($data[0]);
            $nombre = $data[1];
            $descripcion = $data[2];

            // ¿Existe la categoría?
            $check = $conn->prepare("SELECT id_categoria FROM Categoria WHERE id_categoria=?");
            $check->bind_param("i", $id);
            $check->execute();
            $res = $check->get_result();

            if ($res->num_rows > 0) {
                // Actualizar
                $update = $conn->prepare("UPDATE Categoria SET nombre=?, descripcion=? WHERE id_categoria=?");
                $update->bind_param("ssi", $nombre, $descripcion, $id);
                $update->execute();
            } else {
                // Insertar
                $insert = $conn->prepare("INSERT INTO Categoria (id_categoria, nombre, descripcion) VALUES (?, ?, ?)");
                $insert->bind_param("iss", $id, $nombre, $descripcion);
                $insert->execute();
            }
        }

        fclose($handle);
    }

    // ============================
    //   REGISTRO DE AUDITORÍA
    // ============================
    include("../log_funcion.php");
    registrar_log($_SESSION["admin_email"], "IMPORTAR_CATEGORIAS", "Importó categorías mediante CSV.");

    echo "Categorías importadas correctamente";
    exit;
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="csv" required>
    <button>Importar categorías</button>
</form>
