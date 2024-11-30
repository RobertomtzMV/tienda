<?php
// Incluir el archivo de conexión
include "./../includes/config.php";
// Verificar si se ha pasado el ID del usuario por la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Variables para almacenar los datos del usuario
$usuario = '';
$contraseña = '';
$nombre = '';
$correo = '';
$tipo = '';

// Si el ID está definido, obtenemos los datos del usuario
if ($id) {
    $query = "SELECT usuario, contraseña, nombre, correo, tipo FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // Suponiendo que el ID es un entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Asignar los valores a las variables
        $usuario = $user['usuario'];
        $contraseña = $user['contraseña'];
        $nombre = $user['nombre'];
        $correo = $user['correo'];
        $tipo = $user['tipo'];
    } else {
        // Manejar el caso donde no se encuentra el usuario
        echo "Usuario no encontrado.";
    }
}
?>

<!-- Ahora puedes usar las variables en el formulario -->
<form action="actualizarus.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario); ?>" required>

    <label for="contraseña">Contraseña:</label>
    <input type="password" name="contraseña" id="contraseña" value="<?php echo htmlspecialchars($contraseña); ?>" required>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" required>

    <label for="tipo">Tipo:</label>
    <input type="number" name="tipo" id="tipo" value="<?php echo htmlspecialchars($tipo); ?>" required>

    <button type="submit">Actualizar</button>
</form>
