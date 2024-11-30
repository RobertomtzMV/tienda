<?php
session_start();

// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar que el carrito no esté vacío
if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

// Colocar las declaraciones `use` fuera de cualquier bloque de código
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correoDestino = $_POST['email']; // Obtener el correo de destino desde el formulario

    // Validar correo
    if (filter_var($correoDestino, FILTER_VALIDATE_EMAIL)) {
        // Conexión a la base de datos
        include './../includes/config.php';
        
        // Cargar Dompdf
        require './../vendor/autoload.php';
        
        $pdf = new Dompdf(); // Crear una nueva instancia de Dompdf
        $html = '
        <div style="font-family: Arial, sans-serif; color: #333;">
            <h1 style="text-align: center; color: #4CAF50;">SNIKERS</h1>
            <h2 style="text-align: center; color: #555;">¡Gracias por su compra!</h2>
            <table border="1" width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="text-align: left;">Nombre del Producto</th>
                        <th style="text-align: left;">Precio</th>
                        <th style="text-align: left;">Cantidad</th>
                        <th style="text-align: left;">Total</th>
                        <th style="text-align: left;">Imagen</th>
                    </tr>
                </thead>
                <tbody>';
        
        $total = 0;
        
        // Obtener información de los productos desde la base de datos
        foreach ($_SESSION['carrito'] as $id_producto => $producto) {
            $query_product = "SELECT nombre, precio, imagen FROM producto WHERE id = $id_producto";
            $result = mysqli_query($conexion, $query_product);
            if ($result && mysqli_num_rows($result) > 0) {
                $producto_bd = mysqli_fetch_assoc($result);
                
                // Información del producto
                $nombre = $producto_bd['nombre'];
                $precio = $producto_bd['precio'];
                $cantidad = $producto['cantidad'];
                $subtotal = $precio * $cantidad;
                $total += $subtotal;
                
                // Convertir la imagen a base64
                $imagenData = base64_encode($producto_bd['imagen']);
                $imgSrc = 'data:image/jpeg;base64,' . $imagenData; // Aquí se indica que es una imagen JPEG, cambia si es otro formato
                
                $html .= '
                    <tr>
                        <td>' . htmlspecialchars($nombre) . '</td>
                        <td>$' . number_format($precio, 2) . '</td>
                        <td>' . htmlspecialchars($cantidad) . '</td>
                        <td>$' . number_format($subtotal, 2) . '</td>
                        <td><img src="' . $imgSrc . '" width="50" height="50" /></td>
                    </tr>';

                // Insertar cada producto en la tabla de compras
                $query_insert_product = "INSERT INTO compras (correo, total, nombre_producto, precio) 
                                         VALUES ('$correoDestino', $subtotal, '$nombre', $precio)";
                if (!mysqli_query($conexion, $query_insert_product)) {
                    echo "Error al registrar el producto con ID $id_producto: " . mysqli_error($conexion);
                }
            } else {
                echo "Error al obtener el producto con ID $id_producto: " . mysqli_error($conexion);
            }
        }
        
        $html .= '
                </tbody>
            </table>
            <h2 style="text-align: right; color: #333;">Total: $' . number_format($total, 2) . '</h2>
        </div>';
        
        // Generar el PDF
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        
        // Guardar el PDF en el sistema de archivos
        $pdfOutput = $pdf->output();
        $pdfFilePath = 'ticket_' . time() . '.pdf';
        file_put_contents($pdfFilePath, $pdfOutput);

        // Pantalla de carga
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cargando...</title>
            <style>
                body {
                    font-family: "Roboto", sans-serif;
                    background-color: #fff;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    flex-direction: column;
                }
                .loader {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .circle {
                    width: 15px;
                    height: 15px;
                    border-radius: 50%;
                    background-color: #000;
                    margin: 5px;
                    animation: bounce 0.6s infinite alternate;
                }
                .circle:nth-child(1) {
                    animation-delay: 0s;
                }
                .circle:nth-child(2) {
                    animation-delay: 0.2s;
                }
                .circle:nth-child(3) {
                    animation-delay: 0.4s;
                }
                .circle:nth-child(4) {
                    animation-delay: 0.6s;
                }
                @keyframes bounce {
                    to {
                        transform: translateY(-20px);
                    }
                }
                .loading-text {
                    margin-top: 20px;
                    font-size: 20px;
                    color: #333;
                }
            </style>
            <script>
                setTimeout(function() {
                    window.location.href = "inicio.php";
                }, 4000);
            </script>
        </head>
        <body>
            <div class="loader">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="loading-text">Loading...</div>
        </body>
        </html>';

        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rmartinezvargas74@gmail.com';
            $mail->Password = 'qvcw tosd yytd fkcz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            // Configuración del correo
            $mail->setFrom('rmartinezvargas74@gmail.com', 'Tienda Snikrs');
            $mail->addAddress($correoDestino); // Correo de destino
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Correo enviado desde formulario';
            $mail->Body    = "Tiket de compra";
            
            // Adjuntar el PDF
            $mail->addAttachment($pdfFilePath);
            
            // Enviar el correo
            $mail->send();
            
            // Eliminar el archivo PDF del servidor
            unlink($pdfFilePath);
            
            // Vaciar el carrito después de la compra
            $_SESSION['carrito'] = [];
            
            exit(); // Terminar el script aquí
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Por favor ingrese un correo válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Correo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #4CAF50;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Enviar Ticket</h1>
    <form method="POST" action="">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar PDF</button>
    </form>
</div>

</body>
</html>
