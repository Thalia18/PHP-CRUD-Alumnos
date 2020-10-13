<?php
require('../procesos/connection.php');
$nombre;
$apellido;
$genero;
$foto;


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="../Estilos/delete.css">

</head>

<body>

    <h3>Eliminar Alumno</h3>
    <form action="procesarAlumno.php" method="POST">
        <div>
            <table id="tabla">
                <tr>
                    <td><b>Id</b></td>
                    <td><b>Nombre</b></td>
                    <td><b>Apellido</b></td>
                    <td><b>Fecha de nacimiento</b></td>
                    <td><b>Genero</b></td>
                    <td><b>Foto</b></td>
                </tr>
                <?php
                if (isset($_POST["list"])) {
                    setcookie('V1', serialize($_POST['list']), time() + (60 * 60 * 24 * 365));
                    try {
                        foreach ($_POST["list"] as $id) {
                            $sql = "SELECT * FROM alumnos WHERE id = " . $id;
                            $cursor = $pdo->query($sql);
                            foreach ($cursor as $fila) {
                ?>
                                <tr>
                                    <td><?php echo ($fila["id"]); ?></td>
                                    <td><?php echo ($fila["nombre"]); ?></td>
                                    <td><?php echo ($fila["apellido"]); ?></td>
                                    <td><?php echo ($fila["fechanacimiento"]); ?></td>
                                    <td>
                                        <?php
                                        if ($fila["genero"])
                                            echo ("Masculino");
                                        else
                                            echo ("Femenino");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo ("<img src='../archivos/" . $fila["foto"] . "' width='80' height='80' />");
                                        ?>


                                    </td>
                                </tr>
                <?php
                            }
                        }
                    } catch (PDOException $e) {
                        echo ("Error!; " . $e->getMessage() . "<br/>");
                    }
                    $cursor = null;
                    $pdo = null;
                }
                ?>
                <tr>
            </table><br><br>
            <div id="botones">
                <input type="submit" value="Eliminar">
                <input type="button" name="btnCancelar" value="Cancelar" onClick="javascript:location.href='../indice/index.php';">
                <input type="hidden" name="txtAccion" value="eliminar">
            </div>
    </form>
    </div>

</body>

</html>