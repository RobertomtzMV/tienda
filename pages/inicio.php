<?php
include "./../includes/config.php"; // Incluye la conexión a la base de datos
$query = "SELECT id, nombre, marca, precio, stock, imagen FROM producto";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body {
            background-color: #343a40;
            color: #000000; /* Color de las letras cambiado a negro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative; /* Para posicionar la imagen del carrito */
        }

        .btn-logout {
            position: absolute; /* Posición absoluta para moverlo */
            top: 20px; /* Distancia desde el borde superior */
            right: 20px; /* Distancia desde el borde derecho */
            background-color: #dc3545; /* Color de fondo del botón */
            color: #fff; /* Color del texto */
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #c82333; /* Color de fondo al pasar el mouse */
        }

        .container {
            text-align: center;
            background-color: #495057;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }

        .card {
            background-color: #ffffff;
            border: none;
            margin: 15px;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            color: #000000; /* Color del texto en las tarjetas */
            display: flex;
            flex-direction: column;
            align-items: center; /* Alineación de los contenidos al centro */
            justify-content: center;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); /* Sombra brillante por defecto */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 30px rgba(255, 255, 255, 0.7); /* Sombra más brillante al hacer hover */
        }

        .card img {
            height: 120px; /* Ajusta el tamaño de la imagen según sea necesario */
            width: auto;
            max-width: 100%;
            margin-top: 15px; /* Espacio adicional arriba de la imagen */
            margin-bottom: 10px; /* Espacio debajo de la imagen */
            display: block;
            margin-left: auto;
            margin-right: auto; /* Para centrar la imagen horizontalmente */
        }

        .btn-comprar {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .btn-comprar:hover {
            background-color: #218838;
            transform: scale(1.05); /* Efecto de agrandamiento en hover */
        }

        .btn-cantidad {
            background-color: #495057;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.2s ease, background-color 0.2s ease; /* Transición para el hover */
        }

        .btn-cantidad:hover {
            background-color: #6c757d;
            transform: scale(1.05); /* Efecto de agrandamiento en hover */
        }

        .cantidad-input {
            width: 60px;
            text-align: center;
        }

        .cantidad-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .img-carrito {
            width: 50px; /* Ajusta el tamaño de la imagen según sea necesario */
            height: auto;
            position: absolute; /* Posiciona la imagen de forma absoluta */
            top: 20px; /* Ajusta la distancia desde el borde superior */
            left: 20px; /* Ajusta la distancia desde el borde izquierdo */
            cursor: pointer; /* Cambia el cursor al pasar sobre la imagen */
        }

        .btn-360 {
            background-color: #17a2b8; /* Color de fondo del botón */
            color: #fff; /* Color del texto */
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease; /* Transición suave */
            display: inline-block;
            margin-top: 10px;
        }

        .btn-360:hover {
            background-color: #138496; /* Color al pasar el mouse */
            color: #ffffff;
            transform: scale(1.1); /* Efecto de agrandamiento */
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.5); /* Sombra atractiva */
        }

    </style>
</head>
<body>
    <!-- Botón de cerrar sesión en la esquina superior derecha -->
    <a href="cerrar.php" class="btn btn-danger btn-logout">Cerrar sesión</a>

    <!-- Botón como imagen para ir al carrito -->
    <a href="carrito.php">
        <img src="./../assets/img/compra.png" alt="Ir al carrito" class="img-carrito">
    </a>

    <div class="container">
        <h1 class="text-center mt-5">Bienvenido a Sneaker</h1>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="mostrarimagen.php?id=<?php echo $row['id']; ?>" class="card-img-top" alt="Imagen del producto">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                        <p class="card-text">Marca: <?php echo $row['marca']; ?></p>
                        <p class="card-text">Precio: <?php echo '$' . number_format($row['precio'], 2); ?></p>
                        <p class="card-text">Stock: <?php echo $row['stock']; ?></p>
                        <form method="POST" action="carrito.php">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                            <div class="cantidad-container">
                                <!-- Botón de menos -->
                                <button type="button" class="btn-cantidad" onclick="this.nextElementSibling.stepDown();">-</button>
                                <!-- Campo de cantidad -->
                                <input type="number" name="cantidad" value="1" min="1" max="<?php echo $row['stock']; ?>" class="cantidad-input">
                                <!-- Botón de más -->
                                <button type="button" class="btn-cantidad" onclick="this.previousElementSibling.stepUp();">+</button>
                            </div>
                            <button type="submit" name="accion" value="agregar" class="btn-comprar">Agregar al Carrito</button>

                            <a href="img360.php" class="btn-360">Vista 360°</a>
                            
                            </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
