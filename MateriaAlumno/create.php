<?php
require_once('../procesos/connection.php');
$consulta = $pdo->prepare("SELECT * FROM MATERIAS");
$consulta->execute();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Estilos/forms.css" />
    <title>Document</title>
</head>

<body>
    <form action="guardar.php?id=<?php echo $_GET["id"]; ?>" method="POST" enctype="multipart/form-data">
        <h1>Crear Matarias</h1>
        <div class="but">
            <a href="../index.php" class="">Regresar</a>
        </div>
        <br />
        <div class="mainContainer">
            <div class="imgContainer">
                <img src="../Assets/pucelogo.png" alt="foto" class="imagen" />
                <br />
                <br />
                <br />
                <label class="imgTitle">Ingresar Nueva Materia</label>
            </div>
            <div class="formContainer">
                <label>Materia:</label>
                <br>
                <select name="selector">
                    <?php
                    if ($consulta->rowCount() >= 1) :
                        while ($fila = $consulta->fetch()) :
                    ?>
                            <option value="<?php
                                            echo $fila["codigo"];
                                            ?>">
                                <?php
                                echo $fila["nombre"];
                                ?>
                            </option>
                    <?php
                        endwhile;
                    endif;
                    ?>
                </select>
                <br>
                <br>
                <label>Profesor:</label>
                <br>
                <input type="text" name="profesor" required="" class="inputs">
                <br>
                <br>
                <label>Foto:</label>
                <br />
                <input type="file" name="foto" required="" class="inputs" />
                <br />
                <br />
                <input type="submit" value="Guardar" class="but2" />
            </div>
        </div>
    </form>
</body>

</html>