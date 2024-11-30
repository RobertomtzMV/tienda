<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        /* From Uiverse.io by guilhermeyohan */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-box {
            position: relative;
            width: 400px;
            padding: 40px;
            background: rgba(24, 20, 20, 0.987);
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff; /* Set input text color to white */
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff; /* Border color is white */
            outline: none;
            background: transparent;
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff; /* Set label text color to white */
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus ~ label,
        .login-box .user-box input:valid ~ label {
            top: -20px;
            left: 0;
            color: #bdb8b8; /* Label color when focused */
            font-size: 12px;
        }

        .submit {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff; /* Set button text color to white */
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 20px;
            letter-spacing: 4px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .submit:hover {
            background: #03f40f;
            border-radius: 5px;
            box-shadow: 0 0 5px #03f40f,
                        0 0 25px #03f40f,
                        0 0 50px #03f40f,
                        0 0 100px #03f40f;
        }

        .cancel {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff; /* Set button text color to white */
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 20px;
            letter-spacing: 4px;
            background-color: red; /* Set cancel button background color */
            border: none;
            cursor: pointer;
        }

        .cancel:hover {
            background: darkred; /* Darker shade on hover */
            border-radius: 5px;
            box-shadow: 0 0 5px darkred,
                        0 0 25px darkred,
                        0 0 50px darkred,
                        0 0 100px darkred;
        }

        .submit span, .cancel span {
            position: absolute;
            display: block;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }
            50%, 100% {
                left: 100%;
            }
        }

        .submit span:nth-child(1), .cancel span:nth-child(1) {
            bottom: 2px;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #03f40f);
            animation: btn-anim1 2s linear infinite;
        }
    </style>
    <script>
        function validateForm() {
            const password = document.getElementById('contrasena').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden. Inténtalo de nuevo.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="login-box">
        <form action="actua.php" method="POST" onsubmit="return validateForm()">
            <h1 class="title" style="color: white;">Cambiar Contraseña</h1> <!-- Set title color to white -->

            <div class="user-box">
                <input type="email" name="correo" id="correo" required>
                <label for="correo">Correo electrónico:</label>
            </div>

            <div class="user-box">
                <input type="text" name="usuario" id="usuario" required>
                <label for="usuario">Usuario:</label>
            </div>

            <div class="user-box">
                <input type="password" name="contrasena" id="contrasena" required>
                <label for="contrasena">Nueva Contraseña:</label>
            </div>

            <div class="user-box">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <label for="confirm_password">Confirmar nueva contraseña:</label>
            </div>

            <button type="submit" class="submit"><span></span>Confirmar</button>
            <button type="button" class="cancel" onclick="window.location.href='homepage.php';"><span></span>Cancelar</button> <!-- Add cancel button -->
        </form>
    </div>
</body>
</html>
