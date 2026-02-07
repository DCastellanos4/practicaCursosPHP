<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
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
    </style>
</head>

<body>
    <?php

    require_once 'funciones.php';
    $con = conectar();
    $stmt = $con->prepare("SELECT * FROM solicitudes where admitido = 1 and codigocurso= :codigocurso");
    $stmt->execute([":codigocurso" => $_GET['id']]);
    $consulta = $con->prepare("SELECT nombre from cursos where codigo = :codigocurso");
    $consulta->execute([":codigocurso" => $_GET['id']]);
    $nombreCurso = $consulta->fetchColumn();
    echo "<h1>Admitidos en " . $nombreCurso . "</h1>";
    echo "<table class='dynamic-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>DNI</th>";
    echo "<th>NOMBRE</th>";
    echo "<th>CODIGOCURSO</th>";
    echo "<th>FECHASOLICITUD</th>";
    echo "</thead>";
    echo "</tr>";
    echo "<tbody>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query = $con->prepare("SELECT nombre,apellidos from solicitantes where dni = :dni");
        $query->execute([":dni" => $fila['dni']]);
        $nombreAdmitido = $query->fetch(PDO::FETCH_ASSOC);
        $nombreMostrar = $nombreAdmitido['apellidos'] . " ," . $nombreAdmitido['nombre'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['dni']) . "</td>";
        echo "<td>" . htmlspecialchars($nombreMostrar) . "</td>";
        echo "<td>" . htmlspecialchars($fila['codigocurso']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['fechasolicitud']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    ?>
    <a href="index.php"><button type="button">Inicio</button></a>

</body>

</html>
