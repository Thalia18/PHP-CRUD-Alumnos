<?php
if ($pdo = new PDO('pgsql:host=crudphp.c99qtfcpgajs.us-east-2.rds.amazonaws.com;dbname=PHPDeber1', 'postgres', '123456789')) {
    echo "conectado";
} else {
    echo "no nos hemos repartido";
}
?>
