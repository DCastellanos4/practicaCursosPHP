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
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    //CALCULO DE LOS PUNTOS DE CADA SOLICITANTE
    session_start();
    if (!isset($_SESSION['admin'])) {
        echo "<h1>Entra aqui mediante el panel de admin</h1>";
        echo '<a href="index.php"><button>Inicio</button></a><br>';
        die();
    }
    require_once 'funciones.php';
    $con = conectar();
    $consulta = $con->prepare("SELECT * FROM solicitantes");
    $consulta->execute();
    echo "<table class='dynamic-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>NOMBRE</th>";
    echo "<th>APELLIDOS</th>";
    echo "<th>PUNTOS</th>";
    echo "</thead>";
    echo "</tr>";
    echo "<tbody>";
    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $puntos = 0;
        if ($fila['coordinadortic'] == 1) {
            $puntos += 4;
        }
        if ($fila['grupotic'] == 1) {
            $puntos += 3;
        }
        if ($fila['pbilin'] == 1) {
            $puntos += 3;
        }
        if ($fila['cargo'] == 1) {
            $cargos = ["Director", "Jefe De Estudios", "Secretario"];
            if (in_array($fila['nombrecargo'], $cargos)) {
                $puntos += 2;
            } else if ($fila['nombrecargo'] == "Jefe de Departamento") {
                $puntos += 1;
            }
        }
        $hoy = new DateTime('now');
        $añoActual = $hoy->format("Y");
        if (isset($fila['fechanac'])) {
            $añoSolicitanteSTR = strtotime($fila['fechanac']);
        }
        $ano = date("Y", $añoSolicitanteSTR);
        $antiguo = ($añoActual - $ano);
        if ($antiguo > 15) {
            $puntos += 1;
        }
        if ($fila['situacion'] == 'activo') {
            $puntos += 1;
        }
        $update = $con->prepare("UPDATE solicitantes set puntos = :puntos where dni = :dni");
        $update->execute([":puntos" => $puntos, ":dni" => $fila['dni']]);
        $query = $con->prepare("SELECT nombre,apellidos,puntos from solicitantes where dni= :dni");
        $query->execute([":dni" => $fila['dni']]);
        while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['apellidos']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['puntos']) . "</td>";
            echo "</tr>";
        }

        // header("Location: panelAdmin.php");
    }
    echo "</tbody></table>";
    ?>
    <a href="panelAdmin.php"><button type="button">Volver</button></a>

</body>

</html>
