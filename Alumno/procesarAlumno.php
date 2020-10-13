<?php
require('../procesos/connection.php');
$accion = $_POST["txtAccion"];

switch ($accion) {
    case "editar":
        $id = $_POST["id"];
        EditarRegistro($id);
        break;

    case "eliminar":
        EliminarRegistro();
        break;
}

$pagind = $_GET['pagind'];

header("location:../indice/index.php?pag=" . $pagind);

function EditarRegistro($id)
{
    $archivoNombre = $_FILES["txtFoto"]["name"];
    $archivoTipo = $_FILES["txtFoto"]["type"];
    $archivoSize = $_FILES["txtFoto"]["size"];

    $nombre = $_POST["txtNombre"];
    $apellido = $_POST["txtApellido"];
    $fecha = $_POST["txtFecha"];
    $foto = $_POST["txtFoto"];
    if ($_POST["genero"] == "masculino") {
        $genero = 'true';
    } else {
        $genero = 'false';
    }
    try {
        global $pdo;
        $sql = "UPDATE alumnos SET nombre=:nombre, apellido=:apellido, foto=:foto, fechanacimiento=:fecha, genero=:genero WHERE id=:id";
        $cursor = $pdo->Prepare($sql);
        $cursor->bindParam(':nombre', $nombre);
        $cursor->bindParam(':apellido', $apellido);
        $cursor->bindParam(':fecha', $fecha);
        $cursor->bindParam(':foto', $archivoNombre);
        $cursor->bindParam(':genero', $genero);
        $cursor->bindParam(':id', $id);

        if (!((strpos($archivoTipo, "png") || (strpos($archivoTipo, "jpeg")) || (strpos($archivoTipo, "jpg")) &&
            ($archivoSize < 300000)))) {
            echo ("Error al subir el archivo, recuerde que solo pueden ser imagenes.");
            echo "<a href='../index.php'>Regresar</a>";
        } else {
            if (move_uploaded_file($_FILES["txtFoto"]["tmp_name"], "../archivos/" . $archivoNombre)) {
                if ($cursor->execute()) {
                    header("location:../indice/index.php");
                } else {
                    echo "Error no se pudo almacenar los datos";
                    echo "<a href='../index.php'>Regresar</a>";
                }
            } else
                echo ("<br>error");
        }
    } catch (PDOException $e) {
        echo ("Error" . $e->getMessage() . "<br/>");
    }
    $cursor = null;
    $pdo = null;
}
function EliminarRegistro()
{
    try {
        global  $pdo;

        foreach (unserialize($_COOKIE["V1"]) as $id) {
            $sql = "SELECT foto FROM alumnos WHERE id=" . $id;
            $registros = $pdo->query($sql);
            $registro = $registros->fetch();
            unlink("../archivos/" . trim($registro['foto']));
            $sql = "DELETE FROM alumnos WHERE id=:id";
            $cursor = $pdo->Prepare($sql);
            $cursor->bindParam(':id', $id);
            $cursor->execute();
        }
    } catch (PDOException $e) {
        echo ("Error" . $e->getMessage() . "<br/>");
    }
    $cursor = null;
    $pdo = null;
}
