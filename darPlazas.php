    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        echo "<h1>Entra aqui mediante el panel de admin</h1>";
        echo '<a href="index.php"><button>Inicio</button></a><br>';
        die();
    }
    require_once 'funciones.php';
    $con = conectar();
    //USO EL MAX PARA VER SI AL MENOS UNA DE LAS SOLICITUDES ESTA ADMITIDA
    $stmt = $con->prepare("SELECT dni, puntos,
        (SELECT MAX(admitido) FROM solicitudes WHERE solicitudes.dni = solicitantes.dni) as admitido
        FROM solicitantes");
    $stmt->execute();
    $admitidos = [];
    $noAdmitidos = [];
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //VEO EL ADMITIDO Y ASI PUEDO CONSTRUIR LA COLA, SI EL USUARIO ES ADMITIDO SE VA AL FINAL
        if ($fila['admitido'] == 1) {
            $admitidos[$fila['dni']] = $fila['puntos'];
        } else {
            $noAdmitidos[$fila['dni']] = $fila['puntos'];
        }
    }
    //ORDENO POR PUNTOS AMBOS ARRAYS ANTES DE FUSIONARLOS
    arsort($noAdmitidos);
    arsort($admitidos);
    $cola = $noAdmitidos + $admitidos;
    $plazasRestantes = [];
    foreach ($cola as $dni => $puntos) {
        //HACEMOS UNA VUELTA POR CADA SOLICITUD EN LA COLA
        $query = $con->prepare("SELECT codigocurso,
            (SELECT numeroplazas FROM cursos WHERE cursos.codigo = solicitudes.codigocurso LIMIT 1) as plazas
            FROM solicitudes
            WHERE dni = :dni");
        $query->execute([':dni' => $dni]);
        while ($linea = $query->fetch(PDO::FETCH_ASSOC)) {
            $curso = $linea['codigocurso'];
            //SI NO EXISTE LA CANTIDAD DE PLAZAS DE UN CURSO LAS REGISTRAMOS EN EL ARRAY ASOCIATIVO DE PLAZAS
            if (!isset($plazasRestantes[$curso])) {
                $plazasRestantes[$curso] = $linea['plazas'];
            }
            //SI EL CURSO TIENE PLAZAS, GUARDAMOS LA SOLICITUD Y HACEMOS EL UPDATE EN LA BASE DE DATOS
            if ($plazasRestantes[$curso] > 0) {
                //RESTAMOS UNA PLAZA PARA LA SIGUIENTE VUELTA DEL BUCLE
                $plazasRestantes[$curso]--;
                $update = $con->prepare("UPDATE solicitudes set admitido = 1 where dni= :dni");
                $update2 = $con->prepare("UPDATE cursos set numeroplazas = numeroplazas-1 where codigo = :codigo");
                $update->execute([":dni" => $dni]);
                $update2->execute([":codigo" => $curso]);
            }
        }
    }
    //HEADER PARA VOLVER
    header("Location: panelAdmin.php");
    ?>
