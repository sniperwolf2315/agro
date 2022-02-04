<?
sleep(2); 
if($_GET['desde'] =='' OR $_GET['hasta'] =='' ){
die;
}
$desde = str_replace("'","-",str_replace('"','--',str_replace("A"," A",str_replace("P"," P",strtoupper($_GET['desde'])))));
$hasta = str_replace("'","-",str_replace('"','--',str_replace("A"," A",str_replace("P"," P",strtoupper($_GET['hasta'])))));



$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

$CoPC = ';' ;
$_POST[cons] =" select * from rh_covid_diaria WHERE FECHA BETWEEN '$desde' AND '$hasta' ";

// _____________________ solo actualiza inventario EL 3 DE JULIO
$hoy = date("Y-m-d");


$cons = $_POST['cons'];
//echo $cons; die; 
//$cons = str_replace("´","'",utf8_decode($_POST['cons']));
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);
	      $primero = true;
	      $result = mysqli_query($mysqliL, $cons);// OR die ("<BR>ERROR query<BR>$cons<br> ".odbc_errormsg());
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
	      		//if(is_numeric($valor)){
	      		//$valor = number_format($valor,0,"","");
	      		//}
	      	$csv_output .= $coma.trim(utf8_decode($valor));
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	

//$filename = "diaria_".date("Y-m-d_Hi");
$filename = "diaria_".$desde."_".$hasta;
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
