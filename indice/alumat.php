<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Estilos/delete.css">
    <title>Document</title>
    <?php
        require_once('../procesos/connection.php');
        $id = $_GET['id'];
        $pagind=$_GET['pagind'];
        $sql = "SELECT * FROM alummat NATURAL JOIN materias WHERE id=".$id." ORDER BY codigo";
        $registros = $pdo -> query($sql);
    ?>
</head>

<body>
    <input type="button" value="Regresar" onClick="javascript:location.href='index.php?pag=<?php echo($pagind);?>';">
    <input type="button" value="Editar materias" onClick="javascript:location.href='../MateriaAlumno/edit.php?id=<?php echo($id); ?>&pagind=<?php echo($pagind);?>';">

    <table style="width: 100%;" id="tabla">
        <tr>
            <td><b>Código de la Materia</b></td>
            <td><b>Nombre de la Materia</b></td>
        </tr>
        <?php
            try 
            {
                foreach($registros as $fila)
                {
        ?>
                    <tr>
                        <td><?php echo($fila["codigo"]); ?></td>
                        <td><?php echo($fila["nombre"]); ?></td>
                    </tr>
        <?php
                }
            }
            catch(PDOException $e)
            {
                echo("Error!; ".$e->getMessage()."<br/>");
            }
            $registros = null;
            $pdo = null;
        ?>
    </table>

</body>

</html>