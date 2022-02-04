<?php
$mysqli = new mysqli('localhost', 'root', '') or die ("No se ha podido conectar al servidor de Base de datos");
$mysqli->select_db('agropremios'); 
if ($mysqli->connect_error) {
    die("Conneccion fallida a base: " . $mysqli->connect_error);
}
?>