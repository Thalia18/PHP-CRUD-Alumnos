<?php 

require('../procesos/connection.php');   
$accion=$_POST["txtAccion"];
$id = $_POST["id"];

switch ($accion) {
    case "editar":
        $codigo=$_POST["codigo"];
        EditarRegistro($id, $codigo);
        break;
    case "eliminar":
        EliminarRegistro($id);
        break;
}
$pagind=$_GET['pagind'];
$pagalum=$_GET['pagalum'];

header("location:../indice/alumat.php?id=".$id."&pagind=".$pagind."&pagalum=".$pagalum);

function EditarRegistro($id, $codigo){
    
try {
    global $pdo;
    $archivoNombre = $_FILES["txtFoto"]["name"];
    $archivoTipo = $_FILES["txtFoto"]["type"];
    $archivoSize = $_FILES["txtFoto"]["size"];
     
    $id = $_POST["id"];
    $pagind=$_GET['pagind'];
    $pagalum=$_GET['pagalum'];
    $profesor = $_POST["txtProfesor"];

    $sql = "UPDATE alummat SET profesor=:profesor, foto=:foto WHERE id=:id AND codigo=:codigo";
    $cursor = $pdo->Prepare($sql);
    $cursor->bindParam(':id', $id);
    $cursor->bindParam(':codigo', $codigo);
    $cursor->bindParam(':profesor', $profesor);
    $cursor->bindParam(':foto', $archivoNombre);

    if (!((strpos($archivoTipo, "png") || (strpos($archivoTipo, "jpeg")) &&
            ($archivoSize < 300000)))) {
            echo ("Error al subir el archivo, recuerde que solo pueden ser imagenes.");
            echo "<a href='../index.php'>Regresar</a>";
        } else {
            if (move_uploaded_file($_FILES["txtFoto"]["tmp_name"], "../archivosalum/" . $archivoNombre)) {
                if ($cursor->execute()) {
                    header("location:../indice/alumat.php?id=".$id."&pagind=".$pagind."&pagalum=".$pagalum);
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
function EliminarRegistro($id)
{
    try {
        global  $pdo;

        foreach (unserialize($_COOKIE["V1"]) as $codigo) {
            $sql = "SELECT foto FROM alummat WHERE id=" . $id. "AND codigo=" .$codigo;
            $registros = $pdo->query($sql);
            $registro = $registros->fetch();
            unlink("../archivosalum/" . trim($registro['foto']));
            $sql = "DELETE FROM alummat WHERE id=:id AND codigo=:codigo";
            $cursor = $pdo->Prepare($sql);
            $cursor->bindParam(':id', $id);
            $cursor->bindParam(':codigo', $codigo);
            $cursor->execute();
        }
    } catch (PDOException $e) {
        echo ("Error" . $e->getMessage() . "<br/>");
    }
    $cursor = null;
    $pdo = null;
}

?>