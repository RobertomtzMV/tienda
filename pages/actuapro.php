<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php"; 
// Inicializar variables para los datos del producto
$id = null;
$nombre = '';
$marca = '';
$precio = 0.00;
$stock = 0;
$imagen = null;

// Verificar si se pasó un ID para cargar los datos del producto
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Obtener los datos del producto
    $sql = "SELECT nombre, marca, precio, stock, imagen FROM producto WHERE id=?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nombre, $marca, $precio, $stock, $imagen);
        $stmt->fetch();
        $stmt->close();
    }
}

// Verificar si el ID es válido
if ($id === null) {
    echo "ID no válido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="./../assets/css/bulma.min.css">
    <style>
        /* From Uiverse.io by glisovic01 */
        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            padding: 40px;
            margin: 20px auto;
            transform: translate(-50%, -55%);
            background: rgba(0,0,0,.9);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0,0,0,.6);
            border-radius: 10px;
        }

        .login-box h1 {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-box .field {
            margin-bottom: 20px;
        }

        .login-box .label {
            color: #fff;
        }

        .login-box .input {
            background: transparent;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            color: #fff;
            padding: 10px 0;
            font-size: 16px;
        }

        .login-box .input:focus {
            border-bottom: 1px solid #fff;
        }

        .login-box .button {
            background: #00d1b2;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            transition: background 0.3s;
        }

        .login-box .button:hover {
            background: #00b89c;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Actualizar Producto</h1>
        <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                    <input class="input" type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Marca</label>
                <div class="control">
                    <input class="input" type="text" name="marca" value="<?php echo htmlspecialchars($marca); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Precio</label>
                <div class="control">
                    <input class="input" type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Stock</label>
                <div class="control">
                    <input class="input" type="number" name="stock" value="<?php echo htmlspecialchars($stock); ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Imagen</label>
                <div class="control">
                    <input class="input" type="file" name="imagen" accept="image/*">
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
// Cerrar la conexión
$conexion->close();
?>
