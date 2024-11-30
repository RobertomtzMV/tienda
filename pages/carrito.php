<?php
session_start(); // Iniciar la sesión

// Si el carrito no existe, inicializarlo
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Verificar que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = (int)$_POST['cantidad'];

    // Consultar el producto en la base de datos para obtener sus datos
    include "./../includes/config.php";
    $query = "SELECT nombre, precio FROM producto WHERE id = $id_producto";
    $result = mysqli_query($conexion, $query);
    $producto = mysqli_fetch_assoc($result);

    // Si el producto existe y la cantidad es válida
    if ($producto && $cantidad > 0) {
        // Si el producto ya está en el carrito, sumamos la cantidad
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
        } else {
            // Si no está en el carrito, lo agregamos
            $_SESSION['carrito'][$id_producto] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad
            ];
        }
    }

    // Redirigir de nuevo a la página de productos o mostrar el carrito
    header('Location: carrito.php');
    exit();
}

// Mostrar el contenido del carrito
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .container {
            margin-top: 50px;
            background-color: #495057;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table {
            background-color: #ffffff;
            color: #000;
            border-radius: 5px;
            overflow: hidden;
        }
        .btn-eliminar {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-eliminar:hover {
            background-color: #c82333;
        }
        .btn-regresar {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-regresar:hover {
            background-color: #0056b3;
        }
        .btn-comprar {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-comprar:hover {
            background-color: #218838;
        }
    </style>
    <script>
        // Función para mostrar la alerta de confirmación
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar este producto del carrito?');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $id_producto => $producto) : ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo '$' . number_format($producto['precio'], 2); ?></td>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td><?php echo '$' . number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
                    <td>
                        <!-- Formulario para eliminar una cantidad específica del producto con confirmación -->
                        <form method="POST" action="eliminar_carrito.php" onsubmit="return confirmarEliminacion();">
                            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                            <input type="number" name="cantidad" value="1" min="1" max="<?php echo $producto['cantidad']; ?>" required>
                            <button type="submit" name="accion" value="eliminar" class="btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php $total += $producto['precio'] * $producto['cantidad']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Total: <?php echo '$' . number_format($total, 2); ?></h2>

        <!-- Botón para regresar a la página de inicio -->
        <form method="get" action="inicio.php">
            <button type="submit" class="btn-regresar">Regresar a Inicio</button>
        </form>

        <!-- Botón de Comprar -->
        <form method="get" action="comprar.php">
            <button type="submit" class="btn-comprar">Comprar</button>
        </form>
    </div>
</body>
</html>
