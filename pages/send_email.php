<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

include "./../includes/config.php";
require './../vendor/autoload.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf = new Dompdf();
    $html = '<h1>SNIKERS</h1>';
    $html .= '<table border="1" width="100%" cellpadding="5">';

    $total = 0;

    foreach ($_SESSION['carrito'] as $id_producto => $producto) {
        $query_product = "SELECT nombre, precio, imagen FROM producto WHERE id = $id_producto";
        $result = mysqli_query($conexion, $query_product);

        if ($result && mysqli_num_rows($result) > 0) {
            $producto_bd = mysqli_fetch_assoc($result);
            $nombre = $producto_bd['nombre'];
            $precio = $producto_bd['precio'];
            $cantidad = $producto['cantidad'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;
            $imagen = $producto_bd['imagen'];
            $imagen_base64 = base64_encode($imagen);
            $src = 'data:image/jpeg;base64,' . $imagen_base64;

            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($nombre) . '</td>';
            $html .= '<td>$' . number_format($precio, 2) . '</td>';
            $html .= '<td>' . htmlspecialchars($cantidad) . '</td>';
            $html .= '<td><img src="' . $src . '" width="50" height="50" /></td>';
            $html .= '<td>$' . number_format($subtotal, 2) . '</td>';
            $html .= '</tr>';
        }
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '<h2>Total: $' . number_format($total, 2) . '</h2>';

    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    echo '<script>
        const sendEmail = confirm("¿Deseas enviar el correo?");
        if (sendEmail) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "";
            form.appendChild(document.createElement("input").setAttribute("name", "email"));
            form.submit();
        }
    </script>';
    $_SESSION['carrito'] = [];
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = 'rmartinezvargas74@gmail.com';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rmartinezvargas74@gmail.com';
        $mail->Password = 'qvcw tosd yytd fkcz'; // Reemplaza con tu contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rmartinezvargas74@gmail.com', 'Sneaker Store');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Tu Ticket de Compra';
        $mail->Body = 'Gracias por tu compra en Sneaker Store.';

        $mail->send();
        echo 'El correo ha sido enviado a ' . $email;
    } catch (Exception $e) {
        echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
}
?>
