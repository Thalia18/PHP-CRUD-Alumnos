<?php
//Presenta los valores de un registro de la tabla persona para una edición
include("conexion.php");
$nombreMateria; $codigo; 
$id = $_GET["id"];
$sql = "SELECT * FROM alummat WHERE id = ".$id;
$sqlM= "SELECT * FROM materias";
$materiasA=array();
// echo("Se va a editar el registro ".$id."<br/>".$sql); exit();
try
{
    $resultado = $pdo->query($sql);

    foreach($resultado as $fila)
    {
        $idA = $fila["id"];
        $codigoMateria = $fila["codigo"];
        array_push($materiasA, $codigoMateria);
    }
    $resultado = null;
    // $pdo = null;
}
catch (PDOException $e)
{
    echo("Error: ".$e->getMessage()."<br/>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>

<h3>Editar Materias </h3>

<div>
  <form action="procesarAlumnoMateria.php" method="POST">

    <label for="txtCodigo">Materia:</label><br>
    <?php
        try 
        {
            // var_dump($materiasA);
            $cursor = $pdo->query($sqlM);
            foreach($cursor as $filaM)
            {
                $nombre= $filaM["nombre"];
                $codigo = $filaM["codigo"];               
            
            if(in_array($codigo, $materiasA)){
                echo('<label><input type="checkbox" name="list[]" checked value="'.$codigo.'">'.$nombre.'</label><br>');
                
            }else{
                echo('<label><input type="checkbox" name="list[]" value="'.$codigo.'">'.$nombre.'</label><br>');
                
            }
            }
        }
        catch(PDOException $e)
        {
            echo("Error!; ".$e->getMessage()."<br/>");
        }
        $cursor = null;
        $pdo = null;
    ?>
    <br><br>
   <div id="botones">
        <input type="submit" value="Editar">
        <input type="button" name="btnCancelar" value="Cancelar" onClick="javascript:location.href='inde.php';">
        <input type="hidden" name="txtAccion" value="editar" >
        <input type="hidden" name="id" value="<?php echo($id);?>">
   </div>
  </form>
</div>

</body>
</html>


