<?php
include "./../includes/config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['tmp_name'];

    // Leer la imagen y convertirla en BLOB
    $imagenBlob = file_get_contents($imagen);

    // Consulta para insertar el producto
    $query = "INSERT INTO producto (nombre, marca, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdis", $nombre, $marca, $precio, $stock, $imagenBlob);
    
    if ($stmt->execute()) {
        // Redirigir a phpMyAdmin después de agregar el producto
        header("Location: admin.php"); // Cambia la URL si es necesario
        exit(); // Asegúrate de llamar a exit() después de header()
    } else {
        echo "Error al agregar el producto: " . $conexion->error;
    }
    
    $stmt->close();
    $conexion->close();
}
?>
