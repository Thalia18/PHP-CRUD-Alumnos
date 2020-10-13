<?php
require_once('../procesos/connection.php');
$codigo_materia = $_POST['selector'];
$profesor = $_POST['profesor'];
$alumno_id = $_GET["id"];
////////archivo
$archivoNombre = $_FILES["foto"]["name"];
$archivoTipo = $_FILES["foto"]["type"];
$archivoSize = $_FILES["foto"]["size"];

$pagind=$_GET['pagind'];
$pagalum=$_GET['pagalum'];

$consulta = $pdo->prepare("INSERT INTO alummat(id,codigo,profesor,foto) VALUES(?,?,?,?)");

$consulta->bindParam(1, $alumno_id);
$consulta->bindParam(2, $codigo_materia);
$consulta->bindParam(3, $profesor);
$consulta->bindParam(4, $archivoNombre);

if (!((strpos($archivoTipo, "png") || (strpos($archivoTipo, "jpeg")) &&
    ($archivoSize < 300000)))) {
    echo ("Error al subir el archivo, recuerde que solo pueden ser imagenes.");
    echo "<a href='../index.php'>Regresar</a>";
} else {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../archivosalum/" . $archivoNombre)) {
        if ($consulta->execute()) {
            header("location:../indice/alumat.php?id=" .$_GET["id"]."&pagind=".$pagind."&pagalum=".$pagalum);
        } else {
            echo "Error no se pudo almacenar los datos";
            echo "<a href='../index.php'>Regresar</a>";
        }
    } else
        echo ("<br>error");
}
