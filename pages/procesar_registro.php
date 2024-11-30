<?php
session_start();

// Asegúrate de que el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = $_POST['nombre'];
    $us = $_POST['usuario'];
    $co = $_POST['contrasena'];
    $cr = $_POST['correo'];
    $tipo = 1; // Asumiendo que '1' representa al tipo 'user'

    // Incluir archivo de configuración
    include "./../includes/config.php";

    // Preparar la consulta
    $peticion = "INSERT INTO usuarios (usuario, contraseña, nombre, correo, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $peticion);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    // Vincular parámetros
    mysqli_stmt_bind_param($stmt, 'ssssi', $us, $co, $n, $cr, $tipo);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        header("Location: inicio.php?mensaje=registroexitoso");
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt); // Mostrar error específico
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
