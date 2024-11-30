<?php
// Incluir la conexión a la base de datos
include "./../includes/config.php";

// Verificar si se ha proporcionado un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta de eliminación
    $sql = "DELETE FROM producto WHERE id = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular la variable a la declaración preparada
        $stmt->bind_param("i", $id); // 'i' para integer

        // Ejecutar la declaración
        if ($stmt->execute()) {
            echo "Producto eliminado con éxito.";
        } else {
            echo "Error al eliminar el producto: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    echo "No se ha proporcionado un ID para eliminar.";
}

// Cerrar la conexión
$conexion->close();

// Redirigir a la lista de productos después de eliminar
header("Location:admin.php");
exit;
?>
