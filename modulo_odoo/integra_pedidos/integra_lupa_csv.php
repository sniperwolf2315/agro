<?
sleep(2); 

$CoPC = ';' ;
$_POST[CONsu] = str_replace("'", '', str_replace('"', '', $_POST[CONsu]));

$cons = base64_decode($_POST['CONsu']);

//MySQL Local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//$cons = str_replace("´","'",utf8_decode($_POST['cons']));
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);

	      $primero = true;
	      $result = mysqli_query($mysqliL, $cons) OR die ("<BR>ERROR");
	      while($row = mysqli_fetch_assoc($result))
	      { 
	        
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
	      		if(is_numeric($valor)){
	      		$valor = number_format($valor,0,"","");
	      		}
	      	$csv_output .= $coma.trim(preg_replace('/\n/',' ',$valor));
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	

$filename = "pedWEB_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
