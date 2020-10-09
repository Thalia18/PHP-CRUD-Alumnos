<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/forms.css">
    <title>Document</title>
    <?php
        require_once('../procesos/connection.php');
        $id = $_GET['id'];
        $sql = "SELECT * FROM alummat NATURAL JOIN materias WHERE id=".$id;
        $registros = $pdo -> query($sql);
        $cont=$registros->rowCount();

        $pag = 0; 
        if (isset($_GET['pag']))
            if($_GET['pag']>0)
                $pag = $_GET['pag'];

        $pagind=$_GET['pagind'];
        $max = 2; //limit
        $Nreg = $pag * $max; //offset

        $totalpag = ceil($cont/$max);
        
        $sql = "SELECT * FROM alummat NATURAL JOIN materias WHERE id=".$id." ORDER BY id LIMIT ".$max." OFFSET ".$Nreg;
        $registros = $pdo -> query($sql);
    ?>
</head>

<body>
    <a href="index.php?pag=<?php echo($pagind);?>">Regresar</a><br>
    <a href="">Agregar nuevo registro</a><br/><br/>
    <table border="1" style="width: 100%;">
        <tr>
            <td colspan="4" style="text-align: center;">
                <?php
                    for ($i=0; $i < $totalpag; $i++) {
                        $cad= "<a href=\"alumat.php?pag=";
                        $cad.=strval($i);
                        $cad.="\">".($i+1)."</a>  ";
                        echo ($cad);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><b>Código de la Materia</b></td>
            <td><b>Nombre de la Materia</b></td>
            <td><b>&nbsp;</b></td>
            <td><b>&nbsp;</b></td>
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
                        <td>
                            <a href="editar.php?id=<?php echo($fila["id"]); ?>">
                                Editar
                            </a>
                        </td>
                        <td>
                            <a href="eliminar.php?id=<?php echo($fila["id"]); ?>">
                                Eliminar
                            </a>
                        </td>
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