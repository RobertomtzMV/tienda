<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php";

// Usa la variable $conexion para las consultas
$query = "SELECT id, usuario, contraseña, nombre, correo FROM usuarios";
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
            background-color: #343a40; /* Color de fondo medio oscuro */
            color: #ffffff; /* Texto blanco para mejor contraste */
        }

        /* Botones posicionados a la izquierda y derecha */
        .btn-logout {
            position: absolute;
            top: 20px; /* Alineado con el botón de regreso */
            right: 20px; /* Alineado al lado derecho */
        }

        .btn-back {
            position: absolute;
            top: 20px; /* Alineado con el botón de cerrar sesión */
            left: 20px; /* Alineado al lado izquierdo */
        }

        table {
            width: 100%;
            margin-top: 200px; /* Ajuste el margen superior para dar espacio a los botones */
            background-color: #ffffff; /* Color de fondo de la tabla */
            border-radius: 10px; /* Esquinas redondeadas */
            overflow: hidden; /* Esquinas redondeadas */
        }
        th {
            background-color: #495057; /* Fondo oscuro para encabezados */
            color: #000000; /* Texto negro para encabezados */
        }
        tr:hover {
            background-color: #f1f1f1; /* Efecto de hover en filas */
        }
        img {
            height: 80px; /* Altura fija para las imágenes */
            object-fit: cover; /* Mantiene la proporción de la imagen */
            border-radius: 5px; /* Esquinas redondeadas para imágenes */
        }

        /* Estilo para el botón de regresar */
        .button {
            line-height: 1;
            text-decoration: none;
            display: inline-flex;
            border: none;
            cursor: pointer;
            align-items: center;
            gap: 0.75rem;
            background-color: #7808d0; /* Color de fondo morado */
            color: #fff;
            border-radius: 10rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            padding-left: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background-color 0.3s;
        }

        .button__icon-wrapper {
            flex-shrink: 0;
            width: 25px;
            height: 25px;
            position: relative;
            color: #7808d0;
            background-color: #fff;
            border-radius: 50%;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .button:hover {
            background-color: #7808d0; /* Mismo color morado en hover */
            color: #fff; /* Asegura que el texto se mantenga blanco */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra sutil al texto */
        }

        .button:hover .button__icon-wrapper {
            color: #000;
        }

        .button__icon-svg--copy {
            position: absolute;
            transform: translate(-150%, 150%);
        }

        .button:hover .button__icon-svg:first-child {
            transition: transform 0.3s ease-in-out;
            transform: translate(150%, -150%);
        }

        .button:hover .button__icon-svg--copy {
            transition: transform 0.3s ease-in-out 0.1s;
            transform: translate(0);
        }
    </style>
</head>
<body>
    <!-- Botón de regresar con el diseño personalizado -->
    <a href="admin.php" class="button btn-back" style="--clr: #7808d0">
        <span class="button__icon-wrapper">
            <svg
              viewBox="0 0 14 15"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="button__icon-svg"
              width="10"
            >
                <path
                  d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                  fill="currentColor"
                ></path>
            </svg>

            <svg
              viewBox="0 0 14 15"
              fill="none"
              width="10"
              xmlns="http://www.w3.org/2000/svg"
              class="button__icon-svg button__icon-svg--copy"
            >
                <path
                  d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                  fill="currentColor"
                ></path>
            </svg>
        </span>
        Regresar
    </a>

    <!-- Botón de cerrar sesión -->
    <a href="cerrar.php" class="btn btn-danger btn-logout">Cerrar sesión</a>

    <div class="container">
        <h1 class="text-center mt-5">Bienvenido Sneake -Administrador-</h1>
       
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['contraseña']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td>
                        <a href="formus.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Actualizar</a>
                        <a href="eliminar_us.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este Usuario?');">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>  
