<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cuenta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffcccc; /* Fondo rojo claro */
            display: flex; /* Usar flexbox */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            height: 100vh; /* Altura completa de la ventana */
        }

        .form-container {
            position: relative; /* Necesario para el uso de posicionamiento absoluto en los campos */
            width: 400px; /* Ancho fijo */
            padding: 40px; /* Espaciado interno */
            background: rgba(255, 77, 77, 0.9); /* Fondo rojo semitransparente */
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6); /* Sombra más pronunciada */
            border-radius: 10px; /* Bordes redondeados */
        }

        h1 {
            color: #fff; /* Color blanco para el encabezado */
            text-align: center; /* Centrar el texto del encabezado */
            margin-bottom: 20px; /* Espacio debajo del encabezado */
            font-size: 24px; /* Tamaño de la fuente del encabezado */
        }

        .form-field {
            margin-bottom: 20px; /* Espaciado entre campos */
            position: relative; /* Para posicionar etiquetas absolutas */
        }

        .form-field input {
            width: 100%; /* Ancho completo del input */
            padding: 10px 0; /* Espaciado interno */
            font-size: 16px; /* Tamaño de la fuente */
            color: #fff; /* Texto blanco */
            margin-bottom: 30px; /* Espacio debajo del input */
            border: none; /* Sin borde */
            border-bottom: 1px solid #fff; /* Línea inferior blanca */
            outline: none; /* Sin contorno */
            background: transparent; /* Fondo transparente */
        }

        .form-field label {
            position: absolute; /* Para posicionar etiquetas */
            top: 0; /* Alinear arriba */
            left: 0; /* Alinera a la izquierda */
            padding: 10px 0; /* Espacio en la etiqueta */
            font-size: 16px; /* Tamaño de la fuente */
            color: #fff; /* Color de la etiqueta en blanco */
            pointer-events: none; /* Ignorar eventos en la etiqueta */
            transition: .5s; /* Transición suave */
        }

        .form-field input:focus ~ label,
        .form-field input:valid ~ label {
            top: -20px; /* Mover etiqueta arriba */
            left: 0; /* Mantener a la izquierda */
            color: #bdb8b8; /* Color gris claro */
            font-size: 12px; /* Tamaño de la fuente reducido */
        }

        .delete-button {
            background-color: #c70000; /* Color rojo oscuro para el botón */
            color: #fff; /* Texto blanco */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cursor tipo mano al pasar sobre el botón */
            font-size: 18px; /* Tamaño de la fuente del botón */
            transition: background-color 0.3s; /* Transición suave */
            width: 100%; /* Botón ancho completo */
            margin-top: 20px; /* Espacio encima del botón */
        }

        .delete-button:hover {
            background-color: #a60000; /* Color más oscuro al pasar el mouse */
        }

        .cancel-button {
            background-color: #ff4d4d; /* Color del botón cancelar */
            color: #fff; /* Texto blanco */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cursor tipo mano al pasar sobre el botón */
            font-size: 18px; /* Tamaño de la fuente del botón */
            transition: background-color 0.3s; /* Transición suave */
            width: 100%; /* Botón ancho completo */
            margin-top: 10px; /* Espacio encima del botón */
        }

        .cancel-button:hover {
            background-color: #d94f4f; /* Color más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="el.php" method="POST">
            <h1>Eliminar cuenta</h1>

            <div class="form-field">
                <input type="email" name="correo" id="correo" required>
                <label for="correo">Correo electrónico:</label>
            </div>

            <div class="form-field">
                <input type="text" name="usuario" id="usuario" required>
                <label for="usuario">Usuario:</label>
            </div>

            <div class="form-field">
                <input type="password" name="contrasena" id="contrasena" required>
                <label for="contrasena">Contraseña:</label>
            </div>

            <button type="submit" class="delete-button">Eliminar cuenta</button>
            <button type="button" class="cancel-button" onclick="window.location.href='login.php';">Cancelar</button> <!-- Botón de cancelar -->
        </form>
    </div>
</body>
</html>
        