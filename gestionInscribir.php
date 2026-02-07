<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

<body style="text-align: center;">
    <?php
    require_once 'funciones.php';
    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/SMTP.php';
    session_start();
    if (isset($_SESSION['user'])) {
        if (insertarSolicitud($_SESSION['user'], $_GET['id'], 0)) {
            $con = conectar();
            $stmt3 = $con->prepare("SELECT nombre from cursos where codigo = :codigo");
            $stmt3->execute([":codigo" => $_GET['id']]);
            $nombre = $stmt3->fetchColumn();
            $body = "Se ha inscrito el alumno con DNI: " . $_SESSION['user'] . ", en el curso: " . $nombre;
            enviarEmail("carmen@domenico.es", "Inscripcion", $body, null);
            echo "<h1>Solicitud Registrada</h1>";
            echo '<a href="index.php"><button>Inicio</button></a><br>';
        } else {
            echo "<h1>Ya estas inscrito</h1>";
            echo '<a href="index.php"><button>Inicio</button></a><br>';
        }
    }

    ?>
</body>

</html>
