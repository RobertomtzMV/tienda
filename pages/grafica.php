<?php
include "./../includes/config.php";

// Conexión a la base de datos usando mysqli
$conn =  new mysqli($servidor,$usuariodb,$contrasenadb,$nombredb);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Definir la consulta SQL
$query = "SELECT nombre, stock FROM producto";

// Ejecutar la consulta y obtener el resultado
$result = $conn->query($query);

// Verificar si la consulta tuvo resultados
if ($result->num_rows > 0) {
    // Almacenar datos en arreglos para JavaScript
    $nombres = [];
    $stocks = [];
    
    while ($row = $result->fetch_assoc()) {
        $nombres[] = $row['nombre'];
        $stocks[] = $row['stock'];
    }
} else {
    echo "No se encontraron productos.";
    exit;
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Stock de Productos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Importar la fuente Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
        /* Aplicar la fuente Poppins */
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center; /* Centrar el contenido */
        }

        /* Centramos el título */
        h1 {
            font-weight: 600;
        }

        /* Estilos para el botón de Uiverse.io */
        .button {
            line-height: 1;
            text-decoration: none;
            display: inline-flex;
            border: none;
            cursor: pointer;
            align-items: center;
            gap: 0.75rem;
            background-color: #7808d0; /* Color base */
            color: #fff;
            border-radius: 10rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            padding-left: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background-color 0.3s;
            margin-top: 20px; /* Agregar espacio superior */
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
            background-color: #5c07a1;
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

        /* Centrar el canvas */
        #colorfulBarChart {
            display: block;
            margin: 0 auto;
            width: 80%; /* Ajusta el ancho como desees */
            height: 400px; /* Ajusta la altura como desees */
        }
    </style>
</head>
<body>
    <h1>Stock de Productos</h1>
    
    <!-- Gráfica -->
    <canvas id="colorfulBarChart" width="800" height="400"></canvas>

    <!-- Botón con el diseño proporcionado -->
    <a href="admin.php" class="button" style="--clr: #7808d0">
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
    
    <script>
        // Datos de PHP a JavaScript
        const labels = <?php echo json_encode($nombres); ?>;
        const data = <?php echo json_encode($stocks); ?>;

        // Generar colores aleatorios para cada barra
        const backgroundColors = labels.map(() => {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, 0.6)`;
        });

        const borderColors = backgroundColors.map(color => color.replace("0.6", "1"));

        const ctx = document.getElementById('colorfulBarChart').getContext('2d');
        const colorfulBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Nombres de los productos
                datasets: [{
                    label: 'Stock de Productos',
                    data: data, // Stock de cada producto
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Stock'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Productos'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
