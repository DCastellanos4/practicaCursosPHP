<?php
require_once "funciones.php";
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = uniqid();
}
if (isset($_SESSION['user'])) {
    $con = conectar();
    $stmt = $con->prepare("SELECT nombre,apellidos from solicitantes where dni= :dni");
    $stmt->execute([":dni" => $_SESSION['user']]);
    $nombre = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Bienvenid@ " . $nombre['nombre'] . " " . $nombre['apellidos'] . "!";
}
?>
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
            padding: 40px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .dynamic-table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .admitidos {
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: 1px solid #333;
            margin: 10px;
        }

        .dynamic-table thead {
            background-color: #2980b9;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dynamic-table th,
        .dynamic-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .dynamic-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .dynamic-table tbody tr:hover {
            background-color: #ebf5fb;
            transition: background-color 0.3s ease;
        }

        .dynamic-table tbody tr:last-child td {
            border-bottom: none;
        }

        button {
            margin: 10px;
            background-color: #2980b9;
            color: white;
            padding: 12px 20px;
            border: 1px solid #333;
            border-radius: 6px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
    </style>
</head>

<body style="text-align: center;">
    <h1>Cursos disponibles</h1>
    <!-- FUNCIONAL -->
    <?php
    require_once "funciones.php";
    $con = conectar();
    $stmt = $con->prepare("SELECT * FROM cursos");
    $boton = false;
    if (isset($_SESSION['user'])) {
        $boton = true;
    }
    echo "<table class='dynamic-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Código</th>";
    echo "<th>Nombre</th>";
    echo "<th>Plazas</th>";
    echo "<th>Plazo</th>";
    if ($boton) {
        echo "<th>Acción</th>";
    }
    echo "<th>Admitidos</th>";
    echo "</thead>";
    echo "</tr>";
    echo "<tbody>";
    $fecha = new DateTime('2026-02-03');
    $hoy = $fecha->format("Y-m-d");
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (($fila['abierto']) == 1 && ($fila['plazoinscripcion'] >= $hoy) && !($fila['numeroplazas'] <= 0)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['numeroplazas']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['plazoinscripcion']) . "</td>";
            if ($boton) {
                echo "<td><a href='gestionInscribir.php?id={$fila['codigo']}'><button>Inscribirme</button></a></td>";
            }
            echo "<td><a href='listaAdmitidos.php?id={$fila['codigo']}'><button class='admitidos'>Admitidos</button></a></td>";
            echo "</tr>";
        }
    }
    echo "</tbody></table>";
    ?>
    <!-- LOGIN FUNCIONAL -->
    <a href="login.php"><button>LOGIN</button></a>
    <!-- REGISTRO FUNCIONAL -->
    <a href="inscripcion.php"><button>REGISTRO</button></a>
    <a href="admin.php"><button>ZONA ADMIN</button></a>

</body>

</html>
