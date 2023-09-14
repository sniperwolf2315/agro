<?php
include('../../conection/conexion_pssql.php');

$conn_pssql = new  con_pssql('agrocampo');
$sql_pssql=("select * from res_users ru inner join res_partner rp on ru.partner_id  = rp.id where ru.active  = true ");
$rta = $conn_pssql->conectar($sql_pssql);
while($rta_data = pg_fetch_array($rta)){
    echo 
    $rta_data['login'].' | '.
    $rta_data['primer_nombre'].' | '.
    $rta_data['segundo_nombre'].' | '.
    $rta_data['primer_apellido'].' | '.
    $rta_data['segundo_apellido'].' | '.
    $rta_data['otros_nombres'].' | '.
    $rta_data['ref'].' | '.
    $rta_data['display_name'].' | '.
    '<br>'; 

}



?>