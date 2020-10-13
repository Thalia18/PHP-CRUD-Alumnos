<?php

require('../procesos/connection.php');
$nombreMateria; 
$id = $_GET["id"];
$codigo = $_GET["codigo"];
$sql = "SELECT * FROM alummat WHERE id = ".$id . "AND codigo = ". "$codigo";
$sqlM= "SELECT * FROM materias";

?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="../Estilos/edit.css">
</head>
<body>

    <h3>Editar Alumno</h3>

    <div>
        <?php
        $pagind = $_GET['pagind'];
        $pagalum=$_GET['pagalum'];


        try {
            $materias = $pdo->query($sqlM);
            $cursor = $pdo->query($sql);
            foreach ($cursor as $fila) {
                $idA = $fila["id"];
                $codigo = $fila["codigo"];
                $profesor = $fila["profesor"];;
                $foto = $fila["foto"];
                foreach($materias as $value){
                    if($value["codigo"]==$fila["codigo"]){
                        $nombre=$value["nombre"];
                    }
                }
            }
            
            $cursor = null;
            $materias = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo ("Error: " . $e->getMessage() . "<br/>");
        }

        ?>
        <form action="procesar.php?pagind=<?php echo ($pagind);?>&pagalum=<?php echo($pagalum);?>" method="POST" enctype="multipart/form-data">
            <label for="txtId">Id alumno:</label>
            <laber><?php echo (trim($id)) ?></laber><br><br>

            <label for="txtCodigo">Codigo de materia:</label>
            <laber><?php echo (trim($codigo)) ?></laber><br><br>

            <label for="txtNombre">Materia:</label>
            <laber><?php echo (trim($nombre)) ?></laber><br><br>

            <label for="txtProfesor">Profesor:</label>
            <input type="text" name="txtProfesor"></input><br><br>
            
            <label for="txtFoto">Portada:</label><br>
            <input type="file" name="txtFoto" required="" value="<?php echo (trim($foto)) ?>"><br><br>
            
            <br><br>
            <div id="botones">
                <input type="submit" value="Editar">
                <input type="button" name="btnCancelar" value="Cancelar" onClick="javascript:location.href='../indice/alumat.php?id=<?php echo($id);?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo($pagalum);?>';">
                <input type="hidden" name="txtAccion" value="editar">
                <input type="hidden" name="id" value="<?php echo ($id);  ?>">
                <input type="hidden" name="codigo" value="<?php echo ($codigo);  ?>">
            </div>
        </form>
    </div>

</body>
</html>


