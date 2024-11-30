<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php";

// Usa la variable $conexion para las consultas
$query = "SELECT id, nombre, marca, precio, stock, imagen FROM producto";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Calzado</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }

        /* Hamburger Menu CSS */
        .label-check {
            display: none;
        }

        .hamburger-label {
            width: 70px;
            height: 58px;
            display: block;
            cursor: pointer;
            transition: 0.3s;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .hamburger-label div {
            width: 70px;
            height: 6px;
            background-color: #fff;
            position: absolute;
        }

        .line1 {
            transition: all 0.3s;
        }

        .line2 {
            margin: 18px 0 0 0;
            transition: 0.3s;
        }

        .line3 {
            margin: 36px 0 0 0;
            transition: 0.3s;
        }

        #label-check:checked + .hamburger-label .line1 {
            transform: rotate(35deg) scaleX(0.55) translate(39px, -4.5px);
            border-radius: 50px 50px 50px 0;
        }

        #label-check:checked + .hamburger-label .line3 {
            transform: rotate(-35deg) scaleX(0.55) translate(39px, 4.5px);
            border-radius: 0 50px 50px 50px;
        }

        #label-check:checked + .hamburger-label .line2 {
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            width: 45px;
        }

        #label-check:checked + .hamburger-label {
            transform: rotate(90deg);
        }

        .hamburger-menu {
            position: absolute;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #333;
            display: none;
            flex-direction: column;
            padding-top: 80px;
            transition: transform 0.3s ease;
            padding-bottom: 30px; /* Para dejar espacio en la parte inferior */
        }

        #label-check:checked + .hamburger-label + .hamburger-menu {
            display: flex;
        }

        .hamburger-menu a {
            color: #fff;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .hamburger-menu a:hover {
            background-color: #495057;
        }

        /* X (Tache) button to close the menu */
        .close-menu {
            color: #fff;
            font-size: 30px;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            z-index: 100;
            display: none;
        }

        #label-check:checked + .hamburger-label + .hamburger-menu .close-menu {
            display: block;
        }

        /* From Uiverse.io by Gaurav-WebDev */
        .button {
            height: 50px;
            width: 200px;
            position: relative;
            background-color: transparent;
            cursor: pointer;
            border: 2px solid #252525;
            overflow: hidden;
            border-radius: 30px;
            color: #333;
            transition: all 0.5s ease-in-out;
            display: block;
            margin: 10px auto;
        }

        .btn-txt {
            z-index: 1;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .type1::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            transition: all 0.5s ease-in-out;
            background-color: #333;
            border-radius: 30px;
            visibility: hidden;
            height: 10px;
            width: 10px;
            z-index: -1;
        }

        .button:hover {
            box-shadow: 1px 1px 200px #252525;
            color: #fff;
            border: none;
        }

        .type1:hover::after {
            visibility: visible;
            transform: scale(100) translateX(2px);
        }

        /* Estilo para el botón de Cerrar sesión */
        .btn-logout {
            padding: 15px 30px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            background-color: #dc3545; /* Rojo */
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            width: 100%;
            text-align: center;
            margin-top: auto; /* Empuja el botón hasta el final */
        }
        .btn-logout:hover {
            background-color: #c82333; /* Rojo más oscuro */
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            margin-top: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #495057;
            color: #000000;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .custom-btn {
            display: inline-block;
            padding: 15px 30px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-image: linear-gradient(135deg, #ff7e5f, #feb47b);
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: background-image 0.3s ease;
        }
        .custom-btn:hover {
            background-image: linear-gradient(135deg, #feb47b, #ff7e5f);
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Hamburger menu -->
    <input type="checkbox" id="label-check" class="label-check">
    <label for="label-check" class="hamburger-label">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </label>

    <!-- Hamburger Menu Content -->
    <div class="hamburger-menu">
        <span class="close-menu" onclick="document.getElementById('label-check').checked = false;">&times;</span> <!-- Icono X -->
        <a href="grafica.php" class="button type1 btn-txt">Gráfica</a>
        <a href="reporte.php" class="button type1 btn-txt">Ventas</a>
        <a href="agregar_producto.php" class="button type1 btn-txt">Productos</a>
        <a href="usuadmin.php" class="button type1 btn-txt">Usuarios</a>
        <a href="cerrar.php" class="btn-logout">Cerrar sesión</a> <!-- Botón de cerrar sesión -->
    </div>

    <div class="container">
        <h1 class="text-center mt-5">Bienvenido Sneake -Administrador-</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['marca']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Imagen"></td>
                    <td>
                        <a href="editar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
