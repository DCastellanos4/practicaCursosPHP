<?php
function conectar()
{
    $host = 'localhost';
    $db   = 'cursoscp';
    $user = 'cursos';
    $pass = '1234';
    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass);

        // Configuración de seguridad y errores
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
function login($user, $pass, $tabla)
{
    $con = conectar();
    $stmt = $con->prepare("SELECT pass from $tabla where dni=:dni");
    $stmt->execute([':dni' => $user]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario) {
        if ($pass == $usuario['pass']) {
            echo "<p style='color: green;'>Correcto</p>";
            return true;
        } else {
            echo "<p style='color: red;'>Contraseña Incorrecta</p>";
        }
    } else {
        echo "<p style='color: red;'>Usuario Incorrecto</p>";
    }
    $con = null;
}

function insertar($dni, $nombre, $apellidos, $telefono, $pass, $correo, $codcen, $coordinadortic, $grupotic, $nomgrupo, $pbilin, $cargo, $nombrecargo, $situacion, $fechanac, $especialidad, $puntos)
{
    $con = conectar();
    if (empty($fechanac)) {
        $hoy = new DateTime('2026-02-03');
        $fechanac = $hoy->format("Y-m-d");
    }
    $datos = [
        ':dni'            => $dni,
        ':nombre'         => $nombre,
        ':apellidos'      => $apellidos,
        ':telefono'       => $telefono,
        ':pass'           => $pass,
        ':correo'         => $correo,
        ':codcen'         => $codcen,
        ':coordinadortic' => $coordinadortic,
        ':grupotic'       => $grupotic,
        ':nomgrupo'       => $nomgrupo,
        ':pbilin'         => $pbilin,
        ':cargo'          => $cargo,
        ':nombrecargo'    => $nombrecargo,
        ':situacion'      => $situacion,
        ':fechanac'       => $fechanac,
        ':especialidad'   => $especialidad,
        ':puntos'         => $puntos
    ];
    $stmt = $con->prepare("INSERT into solicitantes (dni,nombre,apellidos,telefono,pass,correo,codcen,coordinadortic,grupotic,nomgrupo,pbilin,cargo,nombrecargo,situacion,fechanac,especialidad,puntos)
     values (:dni,:nombre,:apellidos,:telefono,:pass,:correo,:codcen,:coordinadortic,:grupotic,:nomgrupo,:pbilin,:cargo,:nombrecargo,:situacion,:fechanac,:especialidad,:puntos);");
    try {
        $stmt->execute($datos);
        // echo "Registro insertado";
        return true;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
function insertarSolicitud($dni, $codigocurso, $admitido)
{
    $con = conectar();
    $hoy = new DateTime('2026-02-03');
    $fechasolicitud = $hoy->format("Y-m-d");
    $datos = [
        ':dni'            => $dni,
        ':codigocurso'         => $codigocurso,
        ':fechasolicitud'         => $fechasolicitud,
        ':admitido'         => $admitido,
    ];
    $stmt = $con->prepare("INSERT INTO solicitudes (dni,codigocurso,fechasolicitud,admitido) values (:dni,:codigocurso,:fechasolicitud,:admitido)");
    try {
        $stmt->execute($datos);
        // echo "registrado";
        return true;
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
    }
}
function enviarEmail($email, $asunto, $body, $attach)
{
    // require './PHPMailer-master/src/Exception.php';
    // require './PHPMailer-master/src/PHPMailer.php';
    // require './PHPMailer-master/src/SMTP.php';

    $recipients = $email;
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    //         $mail->SMTPDebug = 0; // Esto no mostrará ningun rastro
    //         $mail->SMTPDebug = 2; // Esto mostrará todo el rastro de la conexión
    $mail->isSMTP();
    $mail->Mailer = "SMTP";
    $mail->SMTPAuth = false;
    $mail->isHTML(true);
    $mail->SMTPAutoTLS = false;
    $mail->Port = 25;
    $mail->CharSet = 'UTF-8';
    $mail->Host = "localhost";
    $mail->Username = "postmaster@domenico.es";
    $mail->Password = "12345678";
    $mail->setFrom('postmaster@domenico.es');

    if (isset($attach)) {
        $mail->addAttachment($attach);
    }
    //Compruebo si es un correo o son varios
    if (is_array($email)) {
        foreach ($recipients as $correo) {
            $mail->addAddress($correo);
        }
    } else {
        $mail->addAddress($email);
    }
    $mail->Subject = $asunto;
    $mail->Body = $body;

    if (!$mail->send()) {
        echo $mail->ErrorInfo;
    } else {
        // echo 'El mensaje ha sido enviado correctamente. Revise su bandeja de entrada.';
        // echo "<br>";
        // echo "<a href='inicio.php'>[inicio]</a>";
    }
}
