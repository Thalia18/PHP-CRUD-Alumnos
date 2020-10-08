<?php
if (isset($_POST['nombre'])) {
    require_once('../procesos/connection.php');
    $nombre = $_POST['nombre'];

    $consulta = $pdo->prepare("INSERT INTO materias(nombre) VALUES(?)");

    $consulta->bindParam(1, $nombre);

    if ($consulta->execute()) {
        echo "Datos almacenados";
    } else {
        echo "Error no se pudo almacenar los datos";
    }
}
