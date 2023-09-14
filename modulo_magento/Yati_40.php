<?
sleep(2); 
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
	echo "<h3>Lo sentimos no tiene permiso para esta consulta</h3> ";
die;
}

$db2con = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$nombrefile = "copias/pi_".date("Y-m-d_H").".txt";

$CoPC = ',' ;
$_POST[cons] ="
SELECT                                              
NSCAEC AS PRODUCTO,                                 
NSCASI AS CATALOGO,                                 
SR3DID.DDCDMC AS METODO,                            
SR3DID.DDDIS1 AS DESCUENTO                          
FROM NSOPCAST                                       
INNER JOIN SR3DID on NSOPCAST.NSCAEC = SR3DID.DDDMK2
INNER JOIN SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC
where NSCASI Like 'YATI%'                           
and SR3DID.DDCDMC = 'MET40'                         
and SR3DID.DDDMK1 = '901333960'                     
AND SRBPRG.PGSTAT <>'D'
";

$cons = $_POST['cons'];
 
//$cons = str_replace("Â´","'",utf8_decode($_POST['cons']));
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);
	      $primero = true;
	      $result = odbc_exec($db2con, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".odbc_errormsg());
		//   odbc_result_all($result );
	      while($row = odbc_fetch_array($result))
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
	      	$csv_output .= $coma.trim($valor);
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
            //crea archivo
            $d1=$row[NSCAEC];
            $d2=$row[NSCAET];
            $d3=$row[NSCASI];
            $d4=$row[NSPAEC];
            $d5=$row[NSSQ5P];
            $d6=$row[DDCDMC];
            $d7=$row[DDDIS1];
            // $dato.="Item:".$i1."; Precio:".$p1."; Cant:".$v1."\n";
            $dato.="Item:".$d1."; Precio:".$d2."; Cant:".$d3."; d4 :".$d4."; d5: ".$d5."; d6:".$d6."; d7:".$d7."\n";
	      }  
/* scribe el resultado del while en el CON FECHA DE HOY EN LA CARPETA copias/ */
$myfile = file_put_contents($nombrefile, $dato.PHP_EOL , FILE_APPEND);
$filename = "pi_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
odbc_close();

?>
  
