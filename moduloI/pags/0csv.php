<? session_start();
include("../../user_con.php");
$_POST[cons] ="
select 
I.ITEM_AGRO AS sku
, CAST(P.PRECIO_ITEM AS INT) as price
, '1' AS status
, I.CANTIDAD_DISPONIBLE AS qty
, CASE WHEN I.CANTIDAD_DISPONIBLE >0 THEN '1' ELSE '0' END AS is_in_stock
 from VITEMSRISEINVtmp I left join VITEMSRISEPRC1tmp P ON I.item_agro = p.item_agro
 ";

$cons = $_POST['cons'];
 
//$cons = str_replace("´","'",utf8_decode($_POST['cons']));
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);
	      $primero = true;
	      $result = odbc_exec($db2con, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".odbc_errormsg());
	      while($row = odbc_fetch_array($result))
	      { 
	        //encabezados
			if($primero == true){
			$primero = false;
			foreach($row as $titulo => $valor){
				$csv_output .=''.$titulo.';';
				}
			$csv_output .="\n"; 
			}	        
  			//valores
     	
	      	foreach($row as $valor){
	      		if(is_numeric($valor)){
	      		$valor = number_format($valor,0,"","");
	      		}
	      	$csv_output .=''.trim($valor).';';
	      	}
	      	$csv_output .="\n";
	      }  
	

$filename = "base_".$_POST[desde]."_A_".$_POST[hasta];
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
