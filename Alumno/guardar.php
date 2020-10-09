<?php
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['nacimiento'])) {
    require_once('../procesos/connection.php');
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacimiento = $_POST['nacimiento'];
    if (isset($_POST['genero']))
        $genero = 1;
    else
        $genero = 0;


    $archivoNombre = $_FILES["foto"]["name"];
    $archivoTipo = $_FILES["foto"]["type"];
    $archivoSize = $_FILES["foto"]["size"];


    $consulta = $pdo->prepare("INSERT INTO alumnos(nombre,apellido,fechanacimiento,genero,foto) VALUES(?,?,?,?,?)");

    $consulta->bindParam(1, $nombre);
    $consulta->bindParam(2, $apellido);
    $consulta->bindParam(3, $nacimiento);
    $consulta->bindParam(4, $genero);
    $consulta->bindParam(5, $archivoNombre);

    if (!((strpos($archivoTipo, "png") || (strpos($archivoTipo, "jpeg")) &&
        ($archivoSize < 300000)))) {
        echo ("Error al subir el archivo, recuerde que solo pueden ser imagenes.");
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../archivos/" . $archivoNombre)) {
            if ($consulta->execute()) {
                header("location:../indice/index.php");
            } else {
                echo "Error no se pudo almacenar los datos";
                echo $genero;
            }
        } else
            echo ("<br>error");
    }
}
