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
    $registros = $pdo->query($sql);
    $cont = $registros->rowCount();

    $pag = 0;
    if (isset($_GET['pag']))
        if ($_GET['pag'] > 0)
            $pag = $_GET['pag'];


    $max = 5; //limit
    $Nreg = $pag * $max; //offset

    $totalpag = ceil($cont / $max);


    $sql = "SELECT * FROM Alumnos ORDER BY id LIMIT " . $max . " OFFSET " . $Nreg;
    $registros = $pdo->query($sql);
    ?>
</head>

<body>
    <form action="../Alumno/delete.php" method="post">
        <input type="button" value="Agregar nuevo registro" onClick="javascript:location.href='../Alumno/create.html';">
        <table style="width: 100%;" id="tabla1">
            <tr style="height: 30px;"></tr>
            <tr>
                <td id="td1">Página <?php
                                    if (isset($_GET['pag']))
                                        if ($_GET['pag'] > 0) {
                                            $pag = $_GET['pag'];
                                            echo ($pag + 1);
                                        } else
                                            echo ("1");
                                    ?>
                </td>
                <td id="td2">
                    <?php
                    for ($i = 0; $i < $totalpag; $i++) {
                        $cad = "<a href=\"index.php?pag=";
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
                <th onclick="sortTable(0, 'int')">Id</th>
                <th onclick="sortTable(1, 'str')">Nombre</th>
                <th onclick="sortTable(2, 'str')">Apellido</th>
                <th onclick="sortTable(3, 'str')">Fecha de Nacimiento</th>
                <th onclick="sortTable(4, 'str')">Género</th>
                <th>Imagen</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <td>

                    <input type="submit" name="elimalum" src="../Alumno/delete.php?pagind=<?php echo ($pag); ?>" style="width: 100%;" value="Eliminar" onClick="javascript:location.href='../Alumno/delete.php?pagind=<?php echo ($pag); ?>';">
                </td>
            </tr>
            <?php
            try {
                foreach ($registros as $fila) {
            ?>
                    <tr>
                        <td><?php echo ($fila["id"]); ?></td>
                        <td><?php echo ($fila["nombre"]); ?></td>
                        <td><?php echo ($fila["apellido"]); ?></td>
                        <td><?php echo ($fila["fechanacimiento"]); ?></td>
                        <td><?php
                            $gen = $fila["genero"];
                            if ($gen == 1) {
                                echo ("Masculino");
                            } else {
                                echo ("Femenino");
                            }
                            ?></td>
                        <td>
                            <?php
                            if (isset($fila["foto"])) {
                                echo ("<img src='../archivos/" . $fila["foto"] . "' width='80' height='80' />");
                            } else
                                echo ("&nbsp;");
                            ?>
                        </td>
                        <td>
                            <input type="button" style="width: 100%;" value="Ver Materias" onClick="javascript:location.href='alumat.php?id=<?php echo ($fila["id"]); ?>&pagind=<?php echo ($pag); ?>';">
                        </td>
                        <td>
                            <input type="button" style="width: 100%;" value="Editar" onClick="javascript:location.href='../Alumno/edit.php?id=<?php echo ($fila["id"]); ?>&pagind=<?php echo ($pag); ?>';">
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" name="list[]" id="" value="<?php echo ($fila["id"]); ?>">
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