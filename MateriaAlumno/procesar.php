<?php 

require('../procesos/connection.php');   
$accion=$_POST["txtAccion"];
$id=null;
if(isset($_POST["txtAccion"])){
    $id=$_POST["id"];
        EditarRegistro($id);
}
$pagind=$_GET['pagind'];

header("location:../indice/alumat.php?id=".$id."&pagind=".$pagind);

function EditarRegistro($id){
    
    try{
        global $pdo;
        $sql = "DELETE FROM alummat WHERE id=:id";
            $cursor=$pdo->Prepare($sql);
            $cursor->bindParam(':id', $id);
            $cursor->execute();
        foreach($_POST["list"] as $codigo){
            $sql = "INSERT INTO alummat (id, codigo) VALUES (?, ?)";
            $cursor=$pdo->Prepare($sql);
            $cursor->bindParam(1, $id);
            $cursor->bindParam(2, $codigo);
            $cursor->execute();
        }
    }catch(PDOException $e){
        echo("Error".$e->getMessage()."<br/>");
    }
    $cursor=null;
    $pdo=null;
}
?>