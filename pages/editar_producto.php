<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php";

// Obtener el ID del producto a actualizar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales del producto de la base de datos
    $query = "SELECT * FROM producto WHERE id = ?";
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
    } else {
        echo "Error al obtener los datos del producto: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="./../assets/css/bulma.min.css">
</head>
<body>
    <div class="login-box">
        <h1>Actualizar Producto</h1>
        <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

            <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                    <input class="input" type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Marca</label>
                <div class="control">
                    <input class="input" type="text" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Precio</label>
                <div class="control">
                    <input class="input" type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Stock</label>
                <div class="control">
                    <input class="input" type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
                </div>
            </div>

            <!-- Campo para imagen normal -->
            <div class="field">
                <label class="label">Imagen</label>
                <div class="control">
                    <input class="input" type="file" name="imagen" accept="image/*">
                </div>
            </div>

            <!-- Campo para imagen 3D GLB -->
            <div class="field">
                <label class="label">Modelo 3D (GLB)</label>
                <div class="control">
                    <input class="input" type="file" name="img360" accept=".glb">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button" type="submit">Actualizar Producto</button>
                    <a href="admin.php" class="button button-cancel">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Procesar la actualización del producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Inicializar valores binarios como null
    $imagen = null;
    $modelo3d = null;

    // Procesar la imagen normal
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
    }

    // Procesar el modelo 3D GLB
    if (isset($_FILES['img360']) && $_FILES['img360']['error'] == UPLOAD_ERR_OK) {
        $modelo3d = file_get_contents($_FILES['img360']['tmp_name']);
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE producto SET nombre=?, marca=?, precio=?, stock=?, imagen=?, img360=? WHERE id=?";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los valores de texto y numéricos
        $stmt->bind_param("ssdisbi", $nombre, $marca, $precio, $stock, $imagen, $modelo3d, $id);

        // Enviar los datos binarios (imagen y modelo 3D)
        if ($imagen !== null) {
            $stmt->send_long_data(4, $imagen);
        }
        if ($modelo3d !== null) {
            $stmt->send_long_data(5, $modelo3d);
        }

        // Ejecutar la declaración
        if ($stmt->execute()) {
            header("Location: admin.php"); // Redirigir al panel de administración
            exit();
        } else {
            echo "Error al actualizar el producto: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>
