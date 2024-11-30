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

// Conexión a la base de datos
include "./../includes/config.php";

// Cargar Dompdf
require './../vendor/autoload.php';
use Dompdf\Dompdf;

$pdf = new Dompdf(); // Crear una nueva instancia de Dompdf
$html = '<h1>SNIKERS</h1>';
$html .= '<table border="1" width="100%" cellpadding="5">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Nombre del Producto</th>';
$html .= '<th>Precio</th>';
$html .= '<th>Cantidad</th>';
$html .= '<th>Imagen</th>';
$html .= '<th>Total</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

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

        // Imagen del producto
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
    } else {
        echo "Error al obtener el producto con ID $id_producto: " . mysqli_error($conexion);
    }
}

$html .= '</tbody>';
$html .= '</table>';
$html .= '<h2>Total: $' . number_format($total, 2) . '</h2>';

// Generar el PDF
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

// Descargar el PDF automáticamente
$pdf->stream('ticket.pdf', ['Attachment' => true]);

// Vaciar el carrito después de la compra
$_SESSION['carrito'] = [];

// Fin del script
exit();
?>
