<?php
include "./../includes/config.php"; // Incluye la conexión a la base de datos

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el ID del producto seleccionado
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consultar el producto por ID
$query = "SELECT nombre, img360 FROM producto WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Obtener los datos del producto
    $product = $result->fetch_assoc();
    $product_name = $product['nombre'];
    $model_data = $product['img360']; // Datos binarios del archivo 3D
    
    // Verificar si los datos existen y son válidos
    if (!empty($model_data)) {
        // Guardar el archivo en el servidor
        $file_name = 'model_' . $product_id . '.glb'; // Nombre dinámico basado en ID de producto
        $file_path = 'models/' . $file_name; // Guardar en la carpeta "models"
        file_put_contents($file_path, $model_data); // Guardar el archivo en el servidor
        
        // URL del archivo 3D (ajustar según la estructura del servidor)
        $model_url = '/gt/models/' . $file_name; // URL pública
    } else {
        $product_name = 'Producto no encontrado o sin modelo 3D';
        $model_url = '';
    }
} else {
    // Si no se encuentra el producto, mostrar un error
    $product_name = 'Producto no encontrado';
    $model_url = '';
}

$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modelo 3D - <?php echo htmlspecialchars($product_name); ?></title>
  <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
    }
    model-viewer {
      width: 100%;
      max-width: 800px;
      height: 600px;
    }
    #info {
      margin-top: 20px;
      padding: 10px;
      background: rgba(0, 0, 0, 0.7);
      color: #fff;
      border-radius: 8px;
      text-align: center;
    }
  </style>
</head>
<body>
  <?php if ($model_url): ?>
    <!-- Mostrar el modelo 3D -->
    <model-viewer 
      src="<?php echo htmlspecialchars($model_url); ?>" 
      alt="Modelo 3D de <?php echo htmlspecialchars($product_name); ?>" 
      auto-rotate 
      camera-controls 
      ar>
    </model-viewer>
    <div id="info">
      Visualizando: <strong><?php echo htmlspecialchars($product_name); ?></strong>
    </div>
  <?php else: ?>
    <!-- Mostrar mensaje de error si no se encuentra el producto -->
   <div id="info">
      <strong>El modelo 3D no está disponible para este producto.</strong> 
    </div>
  <?php endif; ?>
</body>
</html>
