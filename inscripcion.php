<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 26px;
            text-align: center;
            border-bottom: 3px solid #2980b9;
            display: inline-block;
            padding-bottom: 5px;
        }

        div {
            width: 100%;
            max-width: 450px;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input[type="text"],
        input[type="date"],
        select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #fff;
            color: #333;
        }

        input:focus,
        select:focus {
            border-color: #2980b9;
            box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.1);
            outline: none;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
            margin-top: 10px;
            font-size: 14px;
        }

        .radio-group {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2980b9;
            margin: 10px 0;
        }

        .radio-group p {
            margin: 12px 0 5px 0;
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
        }

        .radio-group p:first-child {
            margin-top: 0;
        }

        .radio-group label {
            font-weight: normal;
            margin-right: 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
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

        button {
            background-color: #2980b9;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #1f6391;
        }

        button:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <div>
        <a href="index.php"><button>Inicio</button></a><br>
        <h1>Formulario de Registro</h1><br>
        <form method="post" action="inscripcion.php">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

            <label>Nombre</label>
            <input type="text" name="nombre">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['nombre'])) {
                echo "<p style='color: red;'>Introduce un nombre</p>";
            }
            ?>
            <label>Apellidos</label>
            <input type="text" name="apellido">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['apellido'])) {
                echo "<p style='color: red;'>Introduce un apellido</p>";
            }
            ?>
            <label>DNI</label>
            <input type="text" name="dni">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['dni'])) {
                echo "<p style='color: red;'>Introduce un dni valido</p>";
            }
            ?>
            <label>Contraseña</label>
            <input type="text" name="pass">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['pass'])) {
                echo "<p style='color: red;'>Introduce una contraseña</p>";
            }
            ?>
            <label>Teléfono</label>
            <input type="text" name="telefono">
            <label>Correo electrónico</label>
            <input type="text" name="correo">
            <label>Código Centro</label>
            <input type="text" name="codigocentro">
            <div class="radio-group">
                <p>¿Eres coordinador TIC?</p>
                <label>
                    <input type="radio" name="cordTIC" value="1"> Sí
                </label>
                <label>
                    <input type="radio" name="cordTIC" value="0" checked> No
                </label>
                <p>¿Perteneces al grupo TIC?</p>
                <label>
                    <input type="radio" name="grupTIC" value="1"> Sí
                </label>
                <label>
                    <input type="radio" name="grupTIC" value="0" checked> No
                </label><br>
                <input type="text" name="grupTICNombre" placeholder="Nombre del grupo TIC">
                <p>¿Perteneces al grupo Bilingüe?</p>
                <label>
                    <input type="radio" name="bilingue" value="1"> Sí
                </label>
                <label>
                    <input type="radio" name="bilingue" value="0" checked> No
                </label>
                <p>Tienes algun cargo en el centro?</p>
                <label>
                    <input type="radio" name="cargo" value="1"> Sí
                </label>
                <label>
                    <input type="radio" name="cargo" value="0" checked> No
                </label>
                <br>
                <select name="cargoNombre">
                    <option>Director</option>
                    <option>Jefe De Estudios</option>
                    <option>Secretario</option>
                    <option>Jefe de Departamento</option>
                </select>
            </div>
            <select name="situacion">
                <option>Activo</option>
                <option>Inactivo</option>
            </select>
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha">
            <label>Especialidad</label>
            <input type="text" name="especialidad">
            <input type="submit" name="enviar" value="Enviar Datos">
        </form>
    </div>
    <?php
    require_once 'funciones.php';
    if (isset($_POST['enviar']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni']) && !empty($_POST['pass'])) {
        //EJECUTAMOS LA FUNCION
        if ($_SESSION['token'] == $_POST['token']) {
            if (insertar(
                $_POST['dni'],
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['telefono'],
                $_POST['pass'],
                $_POST['correo'],
                $_POST['codigocentro'],
                $_POST['cordTIC'],
                $_POST['grupTIC'],
                $_POST['grupTICNombre'],
                $_POST['bilingue'],
                $_POST['cargo'],
                $_POST['cargoNombre'],
                $_POST['situacion'],
                $_POST['fecha'],
                $_POST['especialidad'],
                0
            )) {
                echo "<h1>Usuario registrado!</h1>";
                echo '<a href="index.php"><button>Inicio</button></a><br>';
            }
        }
    }

    ?>
</body>

</html>
