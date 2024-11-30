<?php
session_start();
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

include "./../includes/config.php";

// Asegúrate de que tipo_usuario es un campo en tu tabla usuarios
// Donde 0 es para admin y 1 es para usuario normal
$peticion = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contrasena'";
$respuesta = mysqli_query($conexion, $peticion);
$contador = 0;

while($fila = mysqli_fetch_array($respuesta)) {
    $contador++;
    $_SESSION['idu'] = $fila['id'];
    $_SESSION['usuario'] = $usuario;
    $_SESSION['tipo'] = $fila['tipo'];  // Almacena el tipo de usuario en la sesión
}

if ($contador > 0) {
    // Verifica si el usuario es admin (0) o usuario normal (1)
    if ($_SESSION['tipo'] == 0) {
        header("location:admin.php");  // Redirige a la página de admin
    } else if ($_SESSION['tipo'] == 1) {
      header("location:inicio.php");  // Redirige a la página de usuario normal
    }
} else {
    header("location:login.php");  // Si no hay coincidencias, redirige al login
}
?>