<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #00796b;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 350px;
            width: 100%;
        }
        label {
            font-size: 1.1em;
            color: #00796b;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #b0bec5;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s ease, transform 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus {
            border-color: #00796b;
            transform: scale(1.05);
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #00796b;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }
        input[type="submit"]:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <form action="procesar_registro.php" method="POST">
        <h1>Registrarse</h1>
        <label for="nombre">Nombre completo:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required><br>

        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required><br>

        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
