<?php
require_once "funciones.php";
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = uniqid();
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
            background-color: #2980b9;
            color: white;
            padding: 7px;
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

        #boton {
            margin: 1%;
        }
    </style>
</head>
<?php
if (!isset($_SESSION['admin'])) {
    echo "<h1>Entra aqui mediante el panel de admin</h1>";
    echo '<a href="index.php"><button>Inicio</button></a><br>';
    die();
}
?>

<body style="text-align: center;">
    <h1>ZONA ADMIN</h1>
    <h1>TODOS LOS CURSOS</h1>
    <div id="boton">
        <a href="creaCurso.php"><button>Crear Curso</button></a>
        <a href="calculaPuntos.php"><button>Calcular Puntos</button></a>
        <a href="darPlazas.php"><button>Dar Plazas</button></a>
    </div>
    <?php
    require_once "funciones.php";
    $pdo = conectar();
    $stmt = $pdo->prepare("SELECT * FROM cursos");
    $boton = false;
    if (isset($_SESSION['admin'])) {
        $boton = true;
    }
    echo "<table class='dynamic-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Código</th>";
    echo "<th>Nombre</th>";
    echo "<th>Abierto</th>";
    echo "<th>Plazas</th>";
    echo "<th>Plazo</th>";
    if ($boton) {
        echo "<th>Estado</th>";
        echo "<th>Eliminar</th>";
    }
    echo "</thead>";
    echo "</tr>";
    echo "<tbody>";
    $fecha = new DateTime('2026-02-03');
    $hoy = $fecha->format("Y-m-d");
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['abierto']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['numeroplazas']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['plazoinscripcion']) . "</td>";
        if ($boton) {
            echo "<td><a href='activar.php?id={$fila['codigo']}'><button>Activar/Desactivar</button></a></td>";
            echo "<td><a href='eliminar.php?id={$fila['codigo']}'><button>Eliminar</button></a></td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
    ?>
    <a href="index.php"><button>Inicio</button></a><br>
</body>

</html>
