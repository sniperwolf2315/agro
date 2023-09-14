<?
sleep(2); 
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}
// require '../nuevo_sia_v2/conection/conexion_pssql.php';
require 'consulta_odoo.php';
/*██████████████████████████████████████████████████████████████████  VARIABLES ██████████████████████████████████████████████████████████████████████████ */

$nombrefile = "copias/pi_".date("Y-m-d_H")."_odoo.txt";
$result 	= '';
$CoPC 		= ',' ;
$primero 	= true;

/*██████████████████████████████████████████████████████████████████  VARIABLES ██████████████████████████████████████████████████████████████████████████ */
$result = $conn_pssql->conectar($sql_pssql);
$repite = '';


while($row = pg_fetch_array($result)){
	/* RGL-SEC  SI EL PRECIO ES MENOS A $600.000 Y CANTIDAD ES MENOS QUE 3 CANTIDAD Y STOCK  CANTIDAD =0 STOCK = FALSE */
	if($row[price] < '600000' AND $row[qty] < '3' ){
		$row[qty] = '0';
		$row[is_in_stock] = '0';
	}
	
		//encabezados
	if($primero == true){
	$primero = false;
	$coma = "";
		foreach($row as $titulo => $valor_t){
			if(!is_numeric($titulo)){
				$csv_output .= $coma.strtolower($titulo);
				$coma = $CoPC;
				}
			}
		$csv_output .="\n"; 
		}	        
	$coma = "";

	//valores
	$csv_output  .= "$row[sku],$row[price],$row[status],$row[qty],$row[is_in_stock]\n";

	//crea archivo
	$i1   = $row[sku];
	$p1   = $row[price];
	$v1   = $row[qty];
	$v1s  = $row[is_in_stock];
	$dato.= "Item:".$i1."; Precio:".$p1."; Cant:".$v1."\n";
}  
$myfile = file_put_contents($nombrefile, $dato.PHP_EOL , FILE_APPEND);
$filename = "pi_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;

shell_exec( 'sync; echo 3 > /proc/sys/vm/drop_caches' );
shell_exec( 'swapoff -a && swapon -a' );

exit;
pg_close();

?>
  
