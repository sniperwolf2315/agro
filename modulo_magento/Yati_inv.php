<?
// sleep(2); 
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
	echo "<h3>Lo sentimos no tiene permisos para esta consulta</h3>";
	die;
}

$db2con = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$nombrefile = "copias/pi_".date("Y-m-d_H").".txt";

$CoPC = ',' ;
$_POST[cons] ="
SELECT
NSCAEC AS PRODUCTO,
NSCASI AS CATALOGO,
SRSTHQ AS INVENTARIOFISICO,
PGPGRP AS GRUPOPRODUCTO,
CAST(PGLPCO*(100/(100-PSMMVA)) AS INT) AS PRECIO,
PJEANP as COD_EAN
FROM 
NSOPCAST 
left outer join SRBSRO on NSOPCAST.NSCAEC = SRBSRO.SRPRDC 
left outer join SRBPRG on NSOPCAST.NSCAEC = SRBPRG.PGPRDC 
left outer join SRBPRS on NSOPCAST.NSCAEC = SRBPRS.PSPRDC 
left outer join sroean  on sroean.PJPRDC = NSOPCAST.NSCAEC 
WHERE 
NSCASI Like 'YATI%' and SRBSRO.SRSROM = '005' 
and SRBPRS.PSPRIL='LIS01' and SRBPRS.PSUNIT='UN' AND SRBPRG.PGSTAT <>'D'
and SRSTHQ>=5
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
            $i1=$row[PRODUCTO];
            $p1=$row[CATALOGO];
            $v1=$row[INVENTARIOFISICO];
            $v1s=$row[GRUPOPRODUCTO];
            $price=$row[PRECIO];
            $dato.="Item:".$i1."; Catalogo:".$p1."; Inv:".$v1." ;Grupo:".$vis."Precio:".$price."\n";
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
  
