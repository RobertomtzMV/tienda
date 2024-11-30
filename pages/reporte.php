<?php
include "./../includes/config.php"; // Incluye la conexión a la base de datos

// Función para obtener el nombre del mes
function obtenerNombreMes($mes) {
    $meses = [
        1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
        5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
        9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
    ];
    return $meses[$mes];
}

// Verificar si se ha enviado el formulario de selección de rango
if (isset($_POST['mes_inicial'], $_POST['mes_final'], $_POST['anio'])) {
    $mes_inicial = $_POST['mes_inicial'];
    $mes_final = $_POST['mes_final'];
    $anio = $_POST['anio'];
} else {
    $mes_inicial = date('m');
    $mes_final = date('m');
    $anio = date('Y');
}

// Consulta SQL para obtener las compras en el rango especificado
$query = "SELECT * FROM compras WHERE YEAR(fecha) = '$anio' AND MONTH(fecha) BETWEEN '$mes_inicial' AND '$mes_final'";
$result = mysqli_query($conexion, $query);

// Verificar si la consulta ha devuelto resultados
$compras = mysqli_num_rows($result) > 0 ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];

// Calcular el total de todas las compras en el rango
$total_general = 0;
foreach ($compras as $compra) {
    $total_general += $compra['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compras</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        .container {
            background-color: #495057;
            padding: 30px;
            margin-top: 100px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #ffffff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #6c757d;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #ffffff;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #5a6268;
        }
        .no-records {
            text-align: center;
            font-size: 18px;
            color: #f8f9fa;
        }
        .button {
            line-height: 1;
            text-decoration: none;
            display: inline-flex;
            border: none;
            cursor: pointer;
            align-items: center;
            gap: 0.75rem;
            background-color: #7808d0;
            color: #fff;
            border-radius: 10rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #6a07b1;
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
        .total-row {
            font-weight: bold;
            background-color: #343a40;
            color: #ffc107;
        }
    </style>
</head>
<body>

    <!-- Botón de Regresar -->
    <a href="admin.php">
        <button class="button">
            <span class="button__icon-wrapper">
                <svg viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="button__icon-svg" width="10">
                    <path d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z" fill="currentColor"></path>
                </svg>
                <svg viewBox="0 0 14 15" fill="none" width="10" xmlns="http://www.w3.org/2000/svg" class="button__icon-svg button__icon-svg--copy">
                    <path d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z" fill="currentColor"></path>
                </svg>
            </span>
            Regresar
        </button>
    </a>

    <div class="container">
        <h1 class="text-center">Reporte de Compras</h1>

        <!-- Formulario para seleccionar rango de meses en un solo año -->
        <form method="post" class="text-center mb-4">
            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" value="<?php echo $anio; ?>" min="2000" max="<?php echo date('Y'); ?>" required>

            <label for="mes_inicial">Mes inicial:</label>
            <select id="mes_inicial" name="mes_inicial" required>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $nombre_mes = obtenerNombreMes($i);
                    $selected = $mes_inicial == $i ? 'selected' : '';
                    echo "<option value='$i' $selected>$nombre_mes</option>";
                }
                ?>
            </select>

            <label for="mes_final">Mes final:</label>
            <select id="mes_final" name="mes_final" required>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $nombre_mes = obtenerNombreMes($i);
                    $selected = $mes_final == $i ? 'selected' : '';
                    echo "<option value='$i' $selected>$nombre_mes</option>";
                }
                ?>
            </select>

            <button type="submit" class="button">Generar Reporte</button>
        </form>

        <?php if (empty($compras)): ?>
            <p class="no-records">No se han realizado compras en este rango de fechas.</p>
        <?php else: ?>
            <h2 class="text-center">Compras de <?php echo obtenerNombreMes($mes_inicial) . " a " . obtenerNombreMes($mes_final) . " de " . $anio; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Compra</th>
                        <th>Fecha y Hora de Compra</th>
                        <th>Total</th>
                        <th>Comprador P/C</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo $compra['id']; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($compra['fecha'])); ?></td>
                            <td><?php echo '$' . number_format($compra['total'], 2); ?></td>
                            <td><?php echo $compra['correo']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- Fila de total general -->
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;">Total General:</td>
                        <td colspan="2"><?php echo '$' . number_format($total_general, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>


