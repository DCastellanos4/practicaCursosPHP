<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        input[type="number"],
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
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        echo '<body><div>';
        echo "<h1>Entra aquí mediante el panel de admin</h1><br>";
        echo '<a href="index.php"><button>Inicio</button></a>';
        echo '</div></body>';
        die();
    }
    ?>
</head>

<body>
    <div>
        <a href="panelAdmin.php"><button>Volver</button></a><br>
        <h1>Creacion De Curso</h1><br>
        <form method="post" action="creaCurso.php">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <label>Nombre</label>
            <input type="text" name="nombre">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['nombre'])) {
                echo "<p style='color: red;'>Introduce un nombre</p>";
            }
            ?>
            <label>numeroplazas</label>
            <input type="number" name="plazas">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['plazas'])) {
                echo "<p style='color: red;'>Introduce una cantidad de plazas</p>";
            }
            ?>
            <label>Plazo</label>
            <input type="date" name="fecha">
            <?php
            if (isset($_POST['enviar']) && empty($_POST['fecha'])) {
                echo "<p style='color: red;'>Introduce una fecha valida</p>";
            }
            ?>
            <div class="radio-group">
                <p>¿Esta abierto al publico?</p>
                <label>
                    <input type="radio" name="abierto" value="1" checked> Sí
                    <input type="radio" name="abierto" value="0"> No
                </label>
            </div>
            <input type="submit" name="enviar" value="Enviar Datos">
        </form>

        <?php
        require_once 'funciones.php';
        if (isset($_POST['enviar']) && !empty($_POST['nombre']) && !empty($_POST['plazas']) && !empty($_POST['fecha'])) {
            //EJECUTAMOS LA FUNCION
            if ($_SESSION['token'] == $_POST['token']) {
                try {
                    $con = conectar();
                    $stmt = $con->prepare("INSERT INTO cursos (nombre,abierto,numeroplazas,plazoinscripcion) values (:nombre,:abierto,:numeroplazas,:plazoinscripcion)");
                    $datos = [
                        ":nombre" => $_POST['nombre'],
                        ":abierto" => $_POST['abierto'],
                        ":numeroplazas" => $_POST['plazas'],
                        ":plazoinscripcion" => $_POST['fecha']

                    ];
                    $stmt->execute($datos);
                    echo "<h1>Curso Creado!</h1>";
                    echo "<br>";
                    echo '<a href="panelAdmin.php"><button>Inicio</button></a><br>';
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        ?>
    </div>
</body>


</html>
