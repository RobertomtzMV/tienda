<?php
// Recoger datos del formulario
$correo = $_POST['correo'];
$nuevo_usuario = $_POST['usuario'];
$nueva_contrasena = $_POST['contrasena'];

// Incluir archivo de conexión
include "./../includes/config.php";

// Corregir la consulta SQL (asegúrate de que los nombres de columnas son correctos)
$peticion = "UPDATE usuarios SET usuario='$nuevo_usuario', contraseña='$nueva_contrasena' WHERE correo='$correo'";

// Ejecutar la consulta
$respuesta = mysqli_query($conexion, $peticion);

// Verificar si la actualización fue exitosa
if ($respuesta) {
    // Redirigir a la página de login con un mensaje
    header("Location: login.php?mensaje=actualizacionexitosa");
} else {
    // Mostrar un error en caso de que falle
    echo "Error al actualizar los datos: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
