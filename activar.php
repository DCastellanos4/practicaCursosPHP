<?php
require_once 'funciones.php';
try {
    $con = conectar();
    $stmt = $con->prepare("SELECT abierto from cursos where codigo = :codigo");
    $stmt->execute([":codigo" => $_GET['id']]);
    $abierto = $stmt->fetchColumn();
    $estado = 0;
    if ($abierto == 1) {
        $estado = 0;
    } else if ($abierto == 0) {
        $estado = 1;
    }
    $update = $con->prepare("UPDATE cursos set abierto = :estado where codigo = :codigo");
    $update->execute([":estado" => $estado, ":codigo" => $_GET['id']]);
    header("Location: panelAdmin.php");
} catch (Exception $e) {
    echo $e->getMessage();
}
