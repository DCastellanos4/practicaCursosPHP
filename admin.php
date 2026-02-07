<?php
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = uniqid();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background-color: #ddd;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            text-align: center;
            border: 2px solid #2c3e50;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #31485fff;
            font-size: 20px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus {
            border-color: #2980b9;
            box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.1);
        }

        a button {
            background-color: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 25px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        input[type='submit'] {
            background-color: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 25px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #1f6391;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>Zona Admin</h2>
        <form method="POST" action="admin.php">
            <label>DNI</label>
            <input type="text" name="dni">
            <label>Contraseña</label>
            <input type="text" name="pass">
            <input type="submit" name="enviar" value="Entrar">
        </form>
        <a href="index.php"><button type="button">Inicio</button></a>

        <?php
        require_once 'funciones.php';
        if (isset($_POST['enviar']))
            if (login($_POST['dni'], $_POST['pass'],"admin")) {
                $_SESSION['admin'] = $_POST['dni'];
                header("Location: panelAdmin.php");
            }
        ?>
    </div>

</body>

</html>
