<?php
/**llamamos la clase que se conecta a ibs */
require('../../conection/conexion_ibs.php');

/**creamos le objeto que tiene la clase de coneción y consulta la vista de IBS */
$con_ibs = new con_ibs('CONSULTAS','CONSULTAS');
$sql_ibs=("SELECT * FROM VISRAPPI02 LIMIT 10");
// $sql_ibs=("SELECT * FROM VISRAPPI02");
$data_vis   = $con_ibs->conectar($sql_ibs);
$data_vis_1 = $con_ibs->conectar($sql_ibs);
?>