<?php
require_once 'funciones.php';
$con = conectar();
$stmt = $con->prepare("DELETE from cursos where codigo = :codigo");
$stmt->execute([":codigo" => $_GET['id']]);
header("Location: panelAdmin.php");
