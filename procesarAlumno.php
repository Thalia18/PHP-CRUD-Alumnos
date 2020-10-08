<?php 

include("conexion.php");   
$accion=$_POST["txtAccion"];

switch($accion){
    case "editar":
        $id=$_POST["id"];
        EditarRegistro($id);
        break;
        
    case "eliminar":
        // $id=$_POST["id"];
        EliminarRegistro();
        break;
        
}

header("location:inde.php");

function EditarRegistro($id){
    $nombre=$_POST["txtNombre"];
    $apellido=$_POST["txtApellido"];
    $fecha=$_POST["txtFecha"];
    $foto=$_POST["txtFoto"];
    if($_POST["genero"]=="masculino"){
        $genero='true';
    }else{
        $genero='false';
    }
    try{
        global $pdo;
        $sql = "UPDATE alumnos SET nombre=:nombre, apellido=:apellido, foto=:foto, fechanacimiento=:fecha, genero=:genero WHERE id=:id";
        $cursor=$pdo->Prepare($sql);
        $cursor->bindParam(':nombre', $nombre);
        $cursor->bindParam(':apellido', $apellido);
        $cursor->bindParam(':fecha', $fecha);
        $cursor->bindParam(':foto', $foto);
        $cursor->bindParam(':genero', $genero);
        $cursor->bindParam(':id', $id);
        $cursor->execute();

    }catch(PDOException $e){
        echo("Error".$e->getMessage()."<br/>");
    }
    $cursor=null;
    $pdo=null;
}
function EliminarRegistro(){
    try{
        global  $pdo;

        foreach(unserialize($_COOKIE["V1"]) as $id){
            $sql = "DELETE FROM alumnos WHERE id=:id";
            $cursor=$pdo->Prepare($sql);
            $cursor->bindParam(':id', $id);
            $cursor->execute();
        }
  
    }catch(PDOException $e){
        echo("Error".$e->getMessage()."<br/>");
    }
    $cursor=null;
    $pdo=null;
}
?>