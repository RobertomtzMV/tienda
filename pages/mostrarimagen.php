<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php";

// Verificar que se ha pasado un ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Preparar y ejecutar la consulta
    $query = "SELECT imagen FROM producto WHERE id = ?";
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        
        // Verificar si se encontró el producto
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($imagen);
            $stmt->fetch();

            // Configurar los headers para mostrar la imagen
            header("Content-Type: image/jpeg");
            echo $imagen; // Mostrar la imagen
        } else {
            echo "No se encontró la imagen.";
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    echo "No se proporcionó un ID.";
}

// Cerrar la conexión
$conexion->close();
?>
