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
//   VALIDAR ID DEL PRODUCTO
// ============================
if (!isset($_GET["id"])) {
    echo "<h1 style='color:white; background:black; padding:40px;'>Producto no especificado</h1>";
    exit;
}

$id = intval($_GET["id"]);

// ============================
//   OBTENER PRODUCTO
// ============================
$stmt = $conn->prepare("SELECT * FROM Producto WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();

if (!$producto) {
    echo "<h1 style='color:white; background:black; padding:40px;'>Producto no encontrado</h1>";
    exit;
}

// ============================
//   OBTENER CATEGORÍAS
// ============================
$categorias = $conn->query("SELECT * FROM Categoria");

// ============================
//   PROCESAR FORMULARIO
// ============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $existencias = intval($_POST["existencias"]);
    $descripcion = $_POST["descripcion"];
    $categoria = intval($_POST["categoria"]);

    $sql = "UPDATE Producto 
            SET nombre = ?, existencias = ?, descripcion = ?, 
                id_categoria = ?, fecha_modificacion = CURDATE()
            WHERE id_producto = ?";

    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("sisii", $nombre, $existencias, $descripcion, $categoria, $id);
    $stmt2->execute();

    header("Location: productos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>

<style>
body { background: #000; color: white; font-family: Arial; }
form { width: 400px; margin: 40px auto; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; }
input, textarea, select {
    width: 100%; padding: 10px; margin: 10px 0;
    background: rgba(255,255,255,0.1); border: none; color: white;
}
button {
    padding: 10px 20px; background: #00d4ff; border: none; color: black; font-weight: bold; cursor: pointer;
}
</style>

</head>
<body>

<h1 style="text-align:center;">✏️ Editar Producto</h1>

<form method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

    <label>Existencias:</label>
    <input type="number" name="existencias" value="<?php echo $producto['existencias']; ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion"><?php echo $producto['descripcion']; ?></textarea>

    <label>Categoría:</label>
    <select name="categoria" required>
        <?php while ($c = $categorias->fetch_assoc()) { ?>
            <option value="<?php echo $c['id_categoria']; ?>"
                <?php if ($c['id_categoria'] == $producto['id_categoria']) echo "selected"; ?>>
                <?php echo $c['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Guardar cambios</button>
</form>

</body>
</html>
