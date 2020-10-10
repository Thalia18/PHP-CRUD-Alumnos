<?php
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['nacimiento']) && isset($_POST['foto'])) {
    require_once('../procesos/connection.php');
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacimiento = $_POST['nacimiento'];
    $foto = $_POST['foto'];
    if (isset($_POST['genero']))
        $genero = 1;
    else
        $genero = 0;


    $consulta = $pdo->prepare("INSERT INTO alumnos(nombre,apellido,fechanacimiento,genero,foto) VALUES(?,?,?,?,?)");

    $consulta->bindParam(1, $nombre);
    $consulta->bindParam(2, $apellido);
    $consulta->bindParam(3, $nacimiento);
    $consulta->bindParam(4, $genero);
    $consulta->bindParam(5, $foto);

    if ($consulta->execute()) {
        header("location:../indice/index.php");
    } else {
        echo "Error no se pudo almacenar los datos";
        echo $genero;
    }
}
