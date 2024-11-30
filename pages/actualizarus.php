<?php
// Incluir archivo de conexión
include "./../includes/config.php"; // Asegúrate de que la ruta a tu archivo de conexión es correcta

// Verificar si los datos han sido enviados mediante POST
if (isset($_POST['id'], $_POST['usuario'], $_POST['contraseña'], $_POST['nombre'], $_POST['correo'], $_POST['tipo'])) {
    // Recoger los datos del formulario
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $tipo = $_POST['tipo'];

    // Crear la consulta SQL
    $consulta = "UPDATE usuarios SET usuario=?, contraseña=?, nombre=?, correo=?, tipo=? WHERE id=?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular las variables a la declaración preparada
        $stmt->bind_param("sssssi", $usuario, $contraseña, $nombre, $correo, $tipo, $id);
        
        // Ejecutar la declaración
        if ($stmt->execute()) {
            // Redirigir al archivo de administración
            header("Location: usuadmin.php?mensaje=actualizacionexitosa"); // Cambia 'usuadmin.php' al nombre correcto de tu archivo
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    echo "No se han enviado los datos correctamente.";
}

// Cerrar la conexión
$conexion->close();
?>
