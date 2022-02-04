<?php

//require_once('usercon_odoo.php');
/*$host = "186.154.147.164"; //192.169.34.251 o localhost
$port = "5499";
$data = "capacitacion_agrocampo";
$user = "tecnocalidad"; //usuario de postgres sistemas
$pass = "TecnoAvancys2019!"; //password de usuario de postgres sistemasqgro
$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;
$pg13 = pg_connect($conn_string);
//$sql ="SELECT * FROM public.stock_report_kardex_line where product_id='98389';";
$sql ="SELECT *  FROM project_project WHERE id='180';";
$result = pg_query($pg13, $sql) or die( pg_last_error($pg13));
if($row = pg_fetch_assoc($result)){
  $nombre=$row['id']."-";    
  $cant=$row['alias_id']."-";
}
echo $nombre." alias: ".$cant."\n";
*/
/*
$host = "186.154.147.164"; //192.169.34.251 o localhost
$port = "5499";
$data = "capacitacion_agrocampo";
$user = "tecnocalidad"; //usuario de postgres sistemas
$pass = "TecnoAvancys2019!"; //password de usuario de postgres sistemasqgro
$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string); 
*/
/*$dbconn = pg_connect("host=186.154.147.164:5499 dbname=capacitacion_agrocampo user=tecnocalidad password=TecnoAvancys2019!")
    or die('No se ha podido conectar: ' . pg_last_error());

$query = 'SELECT * FROM project_project where id="180"';
$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";
*/
pg_free_result($result);

pg_close($dbconn);
?>