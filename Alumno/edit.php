<?php
require('../procesos/connection.php');
$nombre;
$apellido;
$apellido;
$genero;
$foto;
$id = $_GET["id"];
$sql = "SELECT * FROM alumnos WHERE id = " . $id;
try {
    $resultado = $pdo->query($sql);
    foreach ($resultado as $fila) {
        $nombre = $fila["nombre"];
        $apellido = $fila["apellido"];
        $fecha = $fila["fechanacimiento"];
        $genero = $fila["genero"];
        $foto = $fila["foto"];
    }
    $resultado = null;
    $pdo = null;
} catch (PDOException $e) {
    echo ("Error: " . $e->getMessage() . "<br/>");
}
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
        ?>
        <form action="procesarAlumno.php?pagind=<?php echo ($pagind); ?>" method="POST" enctype="multipart/form-data">
            <label for="txtNombre">Nombre:</label><br>
            <input type="text" name="txtNombre" value="<?php echo (trim($nombre)) ?>"><br><br>

            <label for="txtApellido">Apellido:</label><br>
            <input type="text" name="txtApellido" value="<?php echo (trim($apellido)) ?>"><br><br>

            <label for="txtFecha">Fecha de nacimiento:</label><br>
            <input type="date" name="txtFecha" value="<?php echo ($fecha) ?>"><br><br><br>

            <label for="genero">Genero:</label><br>

            <input type="radio" name="genero" value="masculino" <?php
                                                                if ($genero) {
                                                                    $check = "checked";
                                                                } else {
                                                                    $check = "";
                                                                }
                                                                echo ($check)
                                                                ?>>
            <label id="genLabel" for="masculino">Masculino</label><br>
            <input type="radio" name="genero" value="femenino" <?php
                                                                if (!$genero) {
                                                                    $check = "checked";
                                                                } else {
                                                                    $check = "";
                                                                }
                                                                echo ($check)
                                                                ?>>
            <label id="genLabel" for="femenino">Femenino</label><br><br>
            <label for="txtFoto">Foto:</label><br>
            <input type="file" name="txtFoto" value="<?php echo (trim($foto)) ?>"><br><br>
            <!-- <?php
                    if (isset($foto))
                        echo ("<img src=\"" . $PathImg . "/" . $foto . "\"><br/>");
                    ?> -->
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
