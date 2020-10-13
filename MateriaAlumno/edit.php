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
      
        try {
            $materias = $pdo->query($sqlM);
            $cursor = $pdo->query($sql);
            foreach ($cursor as $fila) {
                $idA = $fila["id"];
                $codigo = $fila["codigo"];
                $profesor = $fila["profesor"];;
                $foto = $fila["foto"];
            }
            
            $cursor = null;
            // $materias = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo ("Error: " . $e->getMessage() . "<br/>");
        }

        ?>
        <form action="procesarAlumno.php?pagind=<?php echo ($pagind); ?>" method="POST" enctype="multipart/form-data">
            <label for="txtId">Id alumno:</label>
            <laber><?php echo (trim($id)) ?></laber><br><br>

            <label for="txtCodigo">Codigo de materia:</label>
            <laber><?php echo (trim($codigo)) ?></laber><br><br>

            <label for="txtNombre">Nombre materia:</label><br>
            <?php 
                foreach ($materias as $fila) {
                    if($fila["codigo"]==$codigo){
                        $select="selected";
                    }else{
                        $select="";
                    }
                }
                
            ?>

            <br><br>
            <label for="txtFoto">Foto:</label><br>
            <input type="file" name="txtFoto" value="<?php echo (trim($foto)) ?>"><br><br>
            
            <br><br>
            <div id="botones">
                <input type="submit" value="Editar">
                <?php
                $pagind = $_GET['pagind'];
                ?>
                <input type="button" name="btnCancelar" value="Cancelar" onClick="javascript:location.href='../indice/index.php?pag=<?php echo ($pagind); ?>';">
                <input type="hidden" name="txtAccion" value="editar">
                <input type="hidden" name="id" value="<?php echo ($id);  ?>">
            </div>
        </form>
    </div>

</body>
</html>


