<?php
// Iniciar la sesión
session_start();

// Asegúrate de que el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger el correo del formulario
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';

    // Validar entrada
    if (empty($correo)) {
        die("Por favor, ingrese un correo válido.");
    }

    // Incluir archivo de conexión
    include "./../includes/config.php";

    // Preparar la consulta SQL para eliminar al usuario
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE correo=?");

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . htmlspecialchars($conexion->error));
    }

    // Vincular parámetros
    $stmt->bind_param("s", $correo);

    // Ejecutar la consulta
    $respuesta = $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($respuesta) {
        // Redirigir a la página de éxito con un mensaje
        header("Location: login.php?mensaje=usuarioeliminado");
        exit(); // Asegúrate de salir después de la redirección
    } else {
        // Mostrar un error en caso de que falle
        echo "Error al eliminar el usuario: " . htmlspecialchars($stmt->error);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    mysqli_close($conexion);
} else {
    die("Método de solicitud no permitido.");
}
?>
