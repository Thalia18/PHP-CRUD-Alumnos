<?php
require('../procesos/connection.php');
$id = $_GET["id"];
$pagind = $_GET['pagind'];
$pagalum=$_GET['pagalum'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="../Estilos/delete.css">

</head>

<body>

    <h3>Eliminar Materia</h3>
    <form action="procesar.php?pagind=<?php echo ($pagind);?>&pagalum=<?php echo($pagalum);?>" method="POST">
        <div>
            <table id="tabla">
                <tr>
                    <td><b>Id alumno</b></td>
                    <td><b>Código materia</b></td>
                    <td><b>Materia</b></td>
                    <td><b>Profesor</b></td>
                    <td><b>Portada</b></td>
                </tr>
                <?php
                if (isset($_POST["list"])) {
                    setcookie('V1', serialize($_POST['list']), time() + (60 * 60 * 24 * 365));
                    try {
                        foreach ($_POST["list"] as $codigo) {
                            $sql = "SELECT * FROM alummat WHERE id = ".$id. "AND codigo = ".$codigo;
                            $cursor = $pdo->query($sql);
                            foreach ($cursor as $fila) {
                                $sqlM = "SELECT * FROM materias";
                                     $cursorM = $pdo->query($sqlM);
                                        foreach($cursorM as $value){
                                            if($fila["codigo"]==$value["codigo"]){
                                                $nombre=$value["nombre"];
                                            }
                                        }
                ?>
                                <tr>
                                    <td><?php echo ($fila["id"]); ?></td>
                                    <td><?php echo ($fila["codigo"]); ?></td>
                                    <td><?php echo ($nombre); ?></td>
                                    <td><?php echo ($fila["profesor"]); ?></td>
                                    <td>
                                        <?php
                                        echo ("<img src='../archivosalum/" . $fila["foto"] . "' width='80' height='80' />");
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

                $id=$_GET['id'];
                $pagind = $_GET['pagind'];
                $pagalum=$_GET['pagalum'];
                ?>
                <tr>
            </table><br><br>
            <div id="botones">
                <input type="submit" value="Eliminar">
                <input type="button" name="btnCancelar" value="Cancelar" onClick="javascript:location.href='../indice/alumat.php?id=<?php echo($id);?>&pagind=<?php echo ($pagind); ?>&pagalum=<?php echo($pagalum);?>';">
                <input type="hidden" name="txtAccion" value="eliminar">
                <input type="hidden" name="id" value="<?php echo($id);?>">
            </div>
    </form>
    </div>

</body>

</html>