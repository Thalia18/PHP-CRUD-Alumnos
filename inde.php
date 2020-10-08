<?php

echo("index")
?>
<form method="POST" action="deleteAlumno.php">
    <input type="checkbox" name="list[]" value="1"><label>1</label>
    <input type="checkbox" name="list[]" value="2"><label>2</label>
    <input type="checkbox" name="list[]" value="3"><label>3</label>
    <input type="submit" value="Eliminar" src="deleteAlumno.php">
    <!-- <input type="hidden" name="txtAccion" value="eliminar" > -->
</div>
</form>