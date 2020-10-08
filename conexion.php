<?php
error_reporting(E_ALL); //Se activa el reporte completo de erroes
$PathImg = "http://localhost/web/Deber2/PHP-CRUD-Alumnos/Imagenes";
if ($pdo = new PDO('pgsql:host=crudphp.c99qtfcpgajs.us-east-2.rds.amazonaws.com;dbname=PHPDeber1', 'postgres', '123456789')) {
    echo "conectado";
} else {
    echo "error";
}
?>

