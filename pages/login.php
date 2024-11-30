<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4; /* Color de fondo suave */
            color: black; /* Color del texto negro por defecto */
        }

        /* Estilo del fondo de la sección hero */
        .hero {
            background-image: url('./../assets/img/fo.jpg'); /* Cambia esto por la ruta de tu imagen */
            background-size: cover; /* Para que la imagen cubra todo el fondo */
            background-position: center; /* Centrar la imagen en el fondo */
            height: 100vh; /* Asegura que la sección cubra toda la altura de la ventana */
            display: flex; /* Activar flexbox */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
        }

        .transparent-box {
            background: rgba(255, 255, 255, 0.7); /* Fondo blanco más opaco */
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); /* Sombra más pronunciada */
            max-width: 400px;
            width: 100%; /* Asegurar que el cuadro no se exceda del contenedor */
            margin: 1rem; /* Espaciado en dispositivos más pequeños */
            text-align: center; /* Centrar el texto */
        }

        h1.title {
            margin-bottom: 1.5rem;
            color: black; /* Asegurar que el título sea negro */
        }

        label {
            display: block; /* Hacer que las etiquetas ocupen el 100% del ancho */
            margin-bottom: 0.5rem; /* Espaciado inferior en las etiquetas */
            text-align: left; /* Alinear texto a la izquierda */
            color: black; /* Asegurar que las etiquetas sean negras */
        }

        input[type="text"], input[type="password"] {
            width: 100%; /* Ancho completo */
            padding: 0.75rem; /* Espaciado interno */
            margin-bottom: 1rem; /* Espaciado inferior entre campos */
            border: 1px solid #ccc; /* Bordes sutiles */
            border-radius: 5px; /* Bordes redondeados */
            transition: border-color 0.3s; /* Transición suave para el borde */
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #3273dc; /* Color del borde al enfocar */
            outline: none; /* Quitar contorno por defecto */
        }

        .button-container {
            margin-top: 1rem;
        }

        .button-container .button {
            margin: 0.5rem 0; /* Espaciado entre botones */
            width: 100%; /* Botones ocupan el 100% del ancho del contenedor */
            border-radius: 5px; /* Bordes redondeados */
            font-weight: bold; /* Texto en negrita */
            padding: 0.8rem; /* Espaciado interno ajustado para tamaño mediano */
            font-size: 1rem; /* Tamaño de fuente ajustado para tamaño mediano */
            transition: background-color 0.3s, color 0.3s, transform 0.3s; /* Transición suave para los colores y transformaciones */
            color: white; /* Color del texto blanco por defecto en los botones */
        }

        /* Estilo del botón de iniciar sesión */
        .button.is-primary {
            background-color: #4CAF50; /* Color de fondo verde */
        }

        .button.is-primary:hover {
            background-color: #45a049; /* Color de fondo al pasar el mouse */
            transform: translateY(-2px); /* Efecto de elevación al pasar el mouse */
        }

        /* Estilo del botón de eliminar */
        .button.is-danger {
            background-color: #FF5733; /* Color de fondo rojo brillante */
        }

        .button.is-danger:hover {
            background-color: #C70039; /* Color de fondo al pasar el mouse */
            transform: translateY(-2px); /* Efecto de elevación al pasar el mouse */
        }

        /* Estilo del botón de registrarse */
        .button.is-link {
            background-color: #3498db; /* Color de fondo azul */
        }

        .button.is-link:hover {
            background-color: #2980b9; /* Color de fondo al pasar el mouse */
            transform: translateY(-2px); /* Efecto de elevación al pasar el mouse */
        }

        .ac {
            color: #3498db; /* Color del enlace de recuperación */
            text-decoration: none;
            margin-top: 1rem; /* Espaciado superior */
            display: inline-block; /* Asegurar que el margen funcione */
        }

        .ac:hover {
            text-decoration: underline; /* Efecto al pasar el mouse */
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="transparent-box">
            <form action="comprobar.php" method="post">
                <h1 class="title">Iniciar Sesión</h1>
                <label for="username">Usuario:</label>
                <input type="text" name="usuario" id="username" class="input" required>

                <label for="password">Contraseña:</label>
                <input type="password" name="contrasena" id="password" class="input" required>

                <input type="submit" class="button is-primary" value="Iniciar Sesión">

                <div class="button-container">
                    <a href="eliminar.php" class="button is-danger">Eliminar cuenta</a>
                    <a href="registro.php" class="button is-link">Registrarte</a>
                </div>
                
                <a href="actualizar.php" class="ac">¿Se te olvidó algún dato?</a>
            </form>
        </div>
    </section>
</body>
</html>
