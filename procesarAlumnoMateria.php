<?php 

include("conexion.php");   
$accion=$_POST["txtAccion"];

// switch($accion){
//     case "editar":
//         $id=$_POST["id"];
//         EditarRegistro($id);
//         break;
        
// }
if(isset($_POST["txtAccion"])){
    $id=$_POST["id"];
        EditarRegistro($id);
}

header("location:inde.php");

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