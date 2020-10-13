<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Estilos/delete.css">
    <title>Document</title>
    <?php
    $id = $_GET['id'];
    require_once('../procesos/connection.php');
    $sql = "SELECT * FROM alummat WHERE id=" . $id;
    $registros = $pdo->query($sql);
    $cont = $registros->rowCount();

    $pagalum = 0;
    if (isset($_GET['pagalum']))
        if ($_GET['pagalum'] > 0)
            $pagalum = $_GET['pagalum'];


    $max = 3; //limit
    $Nreg = $pagalum * $max; //offset

    $totalpag = ceil($cont / $max);


    require_once('../procesos/connection.php');
    $pagind = $_GET['pagind'];
    $sql = "SELECT * FROM alummat NATURAL JOIN materias WHERE id=" . $id . " ORDER BY codigo LIMIT " . $max . " OFFSET " . $Nreg;
    $registros = $pdo->query($sql);
    ?>
</head>

<body>
    <form action="../MateriaAlumno/delete.php?id=<?php echo($id);?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo($pagalum);?>" method="post">
        <input type="button" value="Regresar" onClick="javascript:location.href='index.php?pag=<?php echo ($pagind); ?>';">
        <input type="button" value="Agregar Materia" onClick="javascript:location.href='../MateriaAlumno/create.php?id=<?php echo ($id); ?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo ($pagalum); ?>';">

        <table style="width: 100%;" id="tabla1">
            <tr style="height: 30px;"></tr>
            <tr>
                <td id="td1">Página <?php
                                    if (isset($_GET['pagalum']))
                                        if ($_GET['pagalum'] > 0) {
                                            $pagalum = $_GET['pagalum'];
                                            echo ($pagalum + 1);
                                        } else
                                            echo ("1");
                                    ?>
                </td>
                <td id="td2">
                    <?php
                    for ($i = 0; $i < $totalpag; $i++) {
                        $cad = "<a href=\"alumat.php?id=" . $id . "&pagind=" . $pagind . "&pagalum=";
                        $cad .= strval($i);
                        $cad .= "\">" . ($i + 1) . "</a>  ";
                        echo ($cad);
                    }
                    ?>
                </td>
            </tr>
        </table>


        <table style="width: 100%;" id="tabla">
            <tr>
                <th onclick="sortTable(0, 'int')">Código de la Materia</th>
                <th onclick="sortTable(1, 'str')">Nombre de la Materia</th>
                <th onclick="sortTable(2, 'str')">Nombre del profesor</th>
                <th>Carátula</th>
                <th>&nbsp;</th>
                <th>
                    <input type="submit" name="elimalum" src="../MateriaAlumno/delete.php?id=<?php echo($id);?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo($pagalum);?>" style="width: 100%;" value="Eliminar" onClick="javascript:location.href='../MateriaAlumno/delete.php?id=<?php echo($id);?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo($pagalum);?>';">
                </th>


            </tr>
            <?php
            try {
                foreach ($registros as $fila) {
            ?>
                    <tr>
                        <td><?php echo ($fila["codigo"]); ?></td>
                        <td><?php echo ($fila["nombre"]); ?></td>
                        <td><?php echo ($fila["profesor"]); ?></td>
                        <td>
                            <?php
                            if (isset($fila["foto"])) {
                                echo ("<img src='../archivosalum/" . $fila["foto"] . "' width='80' height='80' />");
                            } else
                                echo ("&nbsp;");
                            ?>
                        </td>
                        <td>
                            <input type="button" style="width: 100%;" value="Editar" onClick="javascript:location.href='../MateriaAlumno/edit.php?id=<?php echo ($id); ?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo ($pagalum); ?>&codigo=<?php echo ($fila["codigo"]); ?>';">
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" name="list[]" id="" value="<?php echo ($fila["codigo"]); ?>">
                        </td>
    </form>
    </tr>
<?php
                }
            } catch (PDOException $e) {
                echo ("Error!; " . $e->getMessage() . "<br/>");
            }
            $registros = null;
            $pdo = null;
?>
</table>

</body>

<script>
    function sortTable(n, type) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;

        table = document.getElementById("tabla");
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if ((type == "str" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) || (type == "int" && parseFloat(x.innerHTML) > parseFloat(y.innerHTML))) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if ((type == "str" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) || (type == "int" && parseFloat(x.innerHTML) < parseFloat(y.innerHTML))) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

</html>