<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php"; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Procesar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        // Obtener datos de la imagen
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']); // Cargar el contenido del archivo

        // Preparar la consulta de actualización
        $sql = "UPDATE producto SET nombre=?, marca=?, precio=?, stock=?, imagen=? WHERE id=?";
        
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular las variables a la declaración preparada
            $stmt->bind_param("ssdisi", $nombre, $marca, $precio, $stock, $imagen, $id);
            
            // Ejecutar la declaración
            if ($stmt->execute()) {
                // Redirigir al archivo de administración
                header("Location: admin.php"); // Cambia 'admin.php' al nombre correcto de tu archivo
                exit(); // Asegúrate de salir después de redirigir
            } else {
                echo "Error al actualizar el producto: " . $stmt->error;
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conexion->error;
        }
    } else {
        // Si no se seleccionó una nueva imagen, actualiza solo los demás campos
        $sql = "UPDATE producto SET nombre=?, marca=?, precio=?, stock=? WHERE id=?";
        
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("ssdii", $nombre, $marca, $precio, $stock, $id);
            
            if ($stmt->execute()) {
                // Redirigir al archivo de administración
                header("Location: admin.php"); // Cambia 'admin.php' al nombre correcto de tu archivo
                exit(); // Asegúrate de salir después de redirigir
            } else {
                echo "Error al actualizar el producto: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conexion->error;
        }
    }
}

// Cerrar la conexión
$conexion->close();
?>
