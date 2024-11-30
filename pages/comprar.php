<?php
session_start();

// Verificar si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

// Verificar si se ha enviado el formulario de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    include "./../includes/config.php";

    // Verificar el stock de cada producto en el carrito
    foreach ($_SESSION['carrito'] as $id_producto => $producto) {
        $cantidad_comprada = $producto['cantidad'];

        // Consultar el stock actual
        $query_check_stock = "SELECT stock FROM producto WHERE id = $id_producto";
        $result = mysqli_query($conexion, $query_check_stock);
        $producto_bd = mysqli_fetch_assoc($result);

        // Verificar que haya suficiente stock
        if ($producto_bd['stock'] < $cantidad_comprada) {
            echo "No hay suficiente stock para el producto: " . htmlspecialchars($producto['nombre']);
            exit(); // Detener la ejecución si no hay stock suficiente
        }
    }

    // Actualizar el stock de cada producto después de la compra y registrar la compra
    foreach ($_SESSION['carrito'] as $id_producto => $producto) {
        $cantidad_comprada = $producto['cantidad'];
        
        // Actualizar el stock en la base de datos
        $query_update_stock = "UPDATE producto SET stock = stock - $cantidad_comprada WHERE id = $id_producto";
        mysqli_query($conexion, $query_update_stock);

        // Insertar el producto comprado en la base de datos (sin imagen)
        $nombrep = $producto['nombre'];
        $precio = $producto['precio'];
        $cantidad = $producto['cantidad'];

        // Eliminar cualquier referencia a la imagen
        // No se agregará la imagen en la base de datos

        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'NombreDeUsuario';

        // Insertar en la tabla de productos comprados (sin imagen)
        $query_insert_compra = "INSERT INTO `compras` (`correo`, `total`, `fecha`, `nombre_producto`, `precio`) 
        VALUES ('$usuario', '$precio', CURRENT_TIMESTAMP, '$nombrep', '$precio')";
        
        if (mysqli_query($conexion, $query_insert_compra)) {
            echo "Producto comprado correctamente!";
        } else {
            echo "Error al insertar la compra: " . mysqli_error($conexion);
            exit();  // Terminar si ocurre un error al insertar
        }
    }

    // Comprobar si se debe enviar el PDF por correo
    $sendEmail = isset($_POST['sendEmail']) && $_POST['sendEmail'] == '1';

    // Redirigir al generador de PDF y pasar la opción de envío por correo
    header('Location: pdf.php?sendEmail=' . ($sendEmail ? '1' : '0'));
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }

        .card {
            position: relative;
            width: 300px;
            height: 350px;
            border-radius: 14px;
            z-index: 1111;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 14px;
            background: rgba(255, 0, 0, 0.5);
            filter: blur(10px);
            z-index: -1;
            animation: pulsate 2s infinite;
        }

        .bg {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 290px;
            height: 340px;
            z-index: 2;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(24px);
            border-radius: 10px;
            overflow: hidden;
            outline: 2px solid white;
        }

        .blob {
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 50%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ff0000;
            opacity: 1;
            filter: blur(12px);
            animation: blob-bounce 5s infinite ease;
        }

        @keyframes blob-bounce {
            0% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }
            25% {
                transform: translate(-100%, -100%) translate3d(100%, 0, 0);
            }
            50% {
                transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
            }
            75% {
                transform: translate(-100%, -100%) translate3d(0, 100%, 0);
            }
            100% {
                transform: translate(-100%, -100%) translate3d(0, 0, 0);
            }
        }

        @keyframes pulsate {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .container {
            position: relative;
            z-index: 3;
            text-align: center;
            padding: 20px;
        }
    </style>
    <script>
        function confirmPurchase() {
            const confirmation = confirm("¿Estás seguro de que deseas proceder con la compra?");
            if (confirmation) {
                document.getElementById("purchaseForm").submit();
                setTimeout(() => {
                    window.location.href = 'inicio.php'; // Cambia 'inicio.php' por la ruta de tu página de inicio
                }, 5000); // Espera 5 segundos antes de redirigir (ajusta el tiempo según sea necesario)
            }
        }

        function redirectToEnviarEmail() {
            window.location.href = 'enviar_email.php';
        }
    </script>
</head>
<body>
    <div class="card">
        <div class="bg"></div> 
        <div class="blob"></div> 
        <div class="container">
            <h1>Finalizar Compra</h1>
            <p>Confirma que deseas proceder con la compra.</p>
            <form method="POST" action="" id="purchaseForm">
                <input type="hidden" id="sendEmail" name="sendEmail" value="0" />
                <button type="button" onclick="confirmPurchase()" class="btn btn-primary">Comprar</button>
                <button type="button" onclick="redirectToEnviarEmail()" class="btn btn-secondary">Enviar Email</button>
            </form>
        </div>
    </div>
</body>
</html>
