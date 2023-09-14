<? include("user_con.php");
sleep(2); 
/*
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}
*/

$resp = trim(preg_replace('/\s+/', ' ', str_replace("'", 'Â´', str_replace('"', 'Â´Â´', $_GET['buyer']))));
if($resp =='CONSOLIDADO TODOS LOS COMPRADORES'){
  $fresp ='';
  }else{
  $resp  = str_replace("|","','", $resp);
  $fresp =" and RESPONSABLE IN('$resp') ";
  } 


//archivo camilo digital o compradores
if($_GET['AAMkAGE4ODJhY'] =='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
  $CoPC = ';' ;
  $cons = "SELECT 
                  sku AS sku
                  , `PRECIO_IBS` AS price
                  , '1' AS status
                  , `qty`
                  , '0' AS is_in_stock
                  , `NOMBRE` AS name
                  , `NOMBRE` AS description 
                FROM `magento_itemibs` 
                WHERE MARCA_IBS = 'OK IBS - FALTA PAG' AND GRUPO !='PPO'
              ";

}else{
	$CoPC = ';' ;
	$comilla = "'";
	$cons = "SELECT 
                  CONCAT(".'"'.$comilla.'"'.",sku) AS SKU
                  , `qty_ibs` AS DISPONIBLE_IBS
                  , `qty_mag` AS DISPONIBLE_WEB
                  , `NOMBRE`
                  , `GRUPO`
                  , `RESPONSABLE`
                  , `MARCA_IBS`
                  , `FECHA_AUDITORIA` 
                FROM `magento_itemibs` 
                WHERE MARCA_IBS != 'OK IBS - OK PAG' AND GRUPO !='PPO' $fresp 
              ";
}              
//$cons = str_replace("Â´","'",utf8_decode($_POST['cons']));
error_reporting(E_PARSE);
ini_set("display_errors", 1);
	      $primero = true;
	      $result = mysqli_query($mysqliL, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".mysqli_error($mysqliL));
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
	      	$csv_output .= $coma.trim($valor);
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	
 odbc_close();
$filename = "audit_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
