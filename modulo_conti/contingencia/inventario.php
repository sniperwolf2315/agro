<?php
/*
http://192.168.1.115/modulo_conti/contingencia/inventario.php$con_ibs
*/
include ("../../nuevo_sia_v2/conection/conexion_ibs.php");
$conibs = new con_ibs('','CONSULTA','CONSULTA');


 $CoPC = ';' ;
 $comilla = "'";

$sql_inve ="
SELECT SRPRDC as \"ITEM\", 
SRBPRG.PGDESC as \"DESCRIPCION\", 
PGPRFA as \"FAMILIA\",
SRBPRG.PGPGRP as \"GRUPO\",
CTPPGD AS \"DESCRIPCIONGRUPO\",
SRSROM as \"BODEGA\", 
SRSTHQ - SRPICQ - SRCUSQ as \"DISPONIBLE\", 
SRSTHQ as \"EXISTEN\", 
SRPICQ as \"RESERVADO_LISTA_EMPAQUE\", 
SRCUSQ as \"RESERVADO_EN_ORDEN\", 
SRPURQ as \"CANTIDAD_EN_OC\", 
SRBPRG.PGAPCO as \"COSTO_PROMEDIO\", 
SRISDT as \"FECHA_TRASACCION\", 
(SRSTHQ - SRPICQ) * SRBPRG.PGAPCO as \"COSTO_TOTAL\", 
PGISET as \"SEGMENTACION\", 
PGPLAN as \"RESPONSABLE\",
VISNETPRC.NETO1 as \"NET1\",
VISNETPRC.NETO2 as \"NET2\"
from AGR620CFAG.SRBSRO SRBSRO
left outer join AGR620CFAG.SRBPRG SRBPRG
LEFT JOIN AGR620CFAG.VISNETPRC VISNETPRC ON SRBPRG.PGPRDC = VISNETPRC.PGPRDC on SRBSRO.SRPRDC = SRBPRG.PGPRDC 
LEFT JOIN AGR620CFAG.SROCTLDB ON SRBPRG.PGPGRP=CTPPGN
where SRBPRG.PGSTAT <> 'D'
";

// echo $sql_inve;
$inventario = $conibs->conectar($sql_inve);
$primero = true;


// while($inventario_item = odbc_fetch_array($inventario) ){
//     echo 
//     $inventario_item['ITEM'] .' | '.
//     $inventario_item['DESCRIPCION'] .' | '.
//     $inventario_item['FAMILIA'] .' | '.
//     $inventario_item['GRUPO'] .' | '.
//     $inventario_item['DESCRIPCIONGRUPO'] .' | '.
//     $inventario_item['BODEGA'] .' | '.
//     $inventario_item['DISPONIBLE'] .' | '.
//     $inventario_item['EXISTEN'] .' | '.
//     $inventario_item['RESERVADO_LISTA_EMPAQUE'] .' | '.
//     $inventario_item['RESERVADO_EN_ORDEN'] .' | '.
//     $inventario_item['CANTIDAD_EN_OC'].' | '.
//     $inventario_item['COSTO_PROMEDIO'].' | '.
//     $inventario_item['FECHA_TRASACCION'].' | '.
//     $inventario_item['COSTO_TOTAL'].' | '.
//     $inventario_item['SEGMENTACION'].' | '.
//     $inventario_item['RESPONSABLE'].' | '.
//     $inventario_item['NET1'].' | '.
//     $inventario_item['NET2'].' | '.
//     "<br>";
// }



	    //   $result = mysqli_query($mysqliL, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".mysqli_error($mysqliL));
	      while($inventario_item = odbc_fetch_array($inventario) ){
	      { 
            // print_r($inventario_item);
	        //encabezados
			if($primero == true){
			$primero = false;
			$coma = "";
                foreach($inventario_item as $titulo => $valor){
                    $csv_output .= $coma.strtolower($titulo);
                    $coma = $CoPC;
                    }
			$csv_output .="\n"; 
			}	        
  			//valores
     	    $coma = "";
	      	foreach($inventario_item as $valor){
	      		//if(is_numeric($valor)){
	      		//$valor = number_format($valor,0,"","");
	      		//}
	      	$csv_output .= $coma.trim($valor);
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	      }  
	
odbc_close();
$filename = "audit_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;






?>
