<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Estilos/delete.css">
    <title>Document</title>
    <?php
        require_once('../procesos/connection.php');
        $sql = "SELECT * FROM Alumnos";
        $registros = $pdo -> query($sql);
        $cont=$registros->rowCount();

        $pag = 0; 
        if (isset($_GET['pag']))
            if($_GET['pag']>0)
                $pag = $_GET['pag'];


        $max = 2; //limit
        $Nreg = $pag * $max; //offset

        $totalpag = ceil($cont/$max);

        
        $sql = "SELECT * FROM Alumnos ORDER BY id LIMIT ".$max." OFFSET ".$Nreg;
        $registros = $pdo -> query($sql);
    ?>
</head>

<body>
    <input type="button" value="Agregar nuevo registro" onClick="javascript:location.href='../Alumno/create.html';">
    <table style="width: 100%;" id="tabla">
        <tr>
            <td colspan="9" style="text-align: center;">
                <?php
                    for ($i=0; $i < $totalpag; $i++) {
                        $cad= "<a href=\"index.php?pag=";
                        $cad.=strval($i);
                        $cad.="\">".($i+1)."</a>  ";
                        echo ($cad);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><b>Id</b></td>
            <td><b>Nombre</b></td>
            <td><b>Apellido</b></td>
            <td><b>Fecha de Nacimiento</b></td>
            <td><b>Género</b></td>
            <td><b>Imagen</b></td>
            <td><b>&nbsp;</b></td>
            <td><b>&nbsp;</b></td>
            <td>
                <form action="../Alumno/delete.php" method="post">
                    <input type="submit" name="elimalum" src="../Alumno/delete.php?pagind=<?php echo($pag);?>" style="width: 100%;" value="Eliminar" onClick="javascript:location.href='../Alumno/delete.php?pagind=<?php echo($pag);?>';">
            </td>
        </tr>
        <?php
            try 
            {
                foreach($registros as $fila)
                {
        ?>
                    <tr>
                        <td><?php echo($fila["id"]); ?></td>
                        <td><?php echo($fila["nombre"]); ?></td>
                        <td><?php echo($fila["apellido"]); ?></td>
                        <td><?php echo($fila["fechanacimiento"]); ?></td>
                        <td><?php 
                            $gen=$fila["genero"];
                            if ($gen == 1) {
                                echo("Masculino");
                            }
                            else{
                                echo("Femenino");
                            }
                        ?></td>
                        <td>
                            <?php 
                                if(isset($fila["foto"]))
                                {
                                    /*
                                    $cad = "<img src=\"".$PathImg."/".$fila["Imagen"]."\">";
                                    echo($cad);
                                    */
                                    echo($fila["foto"]);
                                }
                                else
                                    echo("&nbsp;");
                            ?>
                        </td>
                        <td>
                            <input type="button" style="width: 100%;" value="Ver Materias" onClick="javascript:location.href='alumat.php?id=<?php echo($fila["id"]); ?>&pagind=<?php echo($pag);?>';">
                        </td>
                        <td>
                            <input type="button" style="width: 100%;" value="Editar" onClick="javascript:location.href='../Alumno/edit.php?id=<?php echo($fila["id"]); ?>&pagind=<?php echo($pag);?>';">
                        </td>
                        <td style="text-align: center;"> 
                            <input type="checkbox" name="list[]" id="" value="<?php echo($fila["id"]); ?>">
                        </td>
                        </form>

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