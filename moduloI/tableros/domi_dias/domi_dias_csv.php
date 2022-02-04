<? include("user_con.php");
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

sleep(2); 
/*
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}
*/
$consF = base64_decode(substr($_GET[k],5));
$cons ="select * FROM tablero_dias WHERE $consF";

	$CoPC = ';' ;
	$comilla = "'";
	
error_reporting(E_PARSE);
ini_set("display_errors", 1);
	      $primero = true;
	      $result = mysqli_query($mysqliL, $cons) ;
	      while($row = mysqli_fetch_assoc($result))
	      { //print_r($row);
	        //encabezados
			if($primero == true){
			$primero = false;
			$coma = "";
			foreach($row as $titulo => $valor){
				$csv_output .= $coma.strtolower($titulo);
				$coma = $CoPC;
				}
			$csv_output .="\n"; 
			}	        
  			//valores
     	    $coma = "";
	      	foreach($row as $valor){
	      		//if(is_numeric($valor)){
	      		//$valor = number_format($valor,0,"","");
	      		//}
	      	$csv_output .= $coma.trim(str_replace($CoPC,'',$valor));
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	
odbc_close();
$filename = "pend_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
