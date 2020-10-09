<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/forms.css">
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
    <a href="">Agregar nuevo registro</a><br/><br/>
    <table border="1" style="width: 100%;">
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
            <td><b>&nbsp;</b></td>
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
                            <a href="alumat.php?id=<?php echo($fila["id"]); ?>&pagind=<?php echo($pag);?>">
                                Ver materias
                            </a>
                        </td>
                        <td>
                            <a href="editar.php?id=<?php echo($fila["id"]); ?>&pagind=<?php echo($pag);?>">
                                Editar
                            </a>
                        </td>
                        <td>
                            <a href="eliminar.php?id=<?php echo($fila["id"]); ?>&pagind=<?php echo($pag);?>">
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