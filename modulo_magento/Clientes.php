<?
sleep(2); 
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}

$db2con = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$nombrefile = "copias/pi_".date("Y-m-d_H").".txt";

$CoPC = ',' ;
$_POST[cons] ="
select
NANUM,
NANAME,
NANCA6
from AGR620CFAG.sr6nam AS sr6nam
where sr6nam.NASTAT <> 'D' 
and sr6nam.NANCA6 Like '%A%'
";

$cons = $_POST['cons'];
	      $primero = true;
	      $result = odbc_exec($db2con, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".odbc_errormsg());
		//   odbc_result_all($result);
	      while($row = odbc_fetch_array($result))
	      { 
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
            $i1=$row[NANUM];
            $p1=$row[NANAME];
            $v1=$row[NANCA6];
           
            $dato.="Item:".$i1."; Catalogo:".$p1."; Inv:".$v1."\n";
	      }  
/* scribe el resultado del while en el CON FECHA DE HOY EN LA CARPETA copias/ */
$myfile = file_put_contents($nombrefile, $dato.PHP_EOL , FILE_APPEND);
$filename = "pi_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header("Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
odbc_close();

?>
  
