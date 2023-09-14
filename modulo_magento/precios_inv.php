<?
/*
http://192.168.1.115/modulo_magento/precios_inv.php?AAMkAGE4ODJhY=jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO115
*/
sleep(1); 
// if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO115'){
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}


$db2con = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$nombrefile = "copias/pi_".date("Y-m-d_H").".txt";

$CoPC = ',' ;
/*ORIGINAl */
/*
$_POST[cons] ="
select 
I.ITEM_AGRO AS sku
, CAST(P.PRECIO_ITEM AS INT) as price
, '1' AS status
, I.CANTIDAD_DISPONIBLE AS qty
, CASE WHEN I.CANTIDAD_DISPONIBLE >0 THEN '1' ELSE '0' END AS is_in_stock
from VITEMSRISEINVtmp I left join VITEMSRISEPRC1tmp P ON I.item_agro = p.item_agro
";
$_POST[cons] ="
select 
(case 
when I.ITEM_AGRO ='5151151105110440096' then '5151151105110440001'
when I.ITEM_AGRO ='5151151105110440097' then '5151151105110440002'
when I.ITEM_AGRO ='5151151105110440098' then '5151151105110440003'
when I.ITEM_AGRO ='5151151105110440099' then '5151151105110440004'
else I.ITEM_AGRO end )sku,
(case 
when I.ITEM_AGRO ='5151151105110440096' then  (select CAST(PRECIO_ITEM AS INT) from VITEMSRISEPRC1tmp where item_agro ='5151151105110440001') 
when I.ITEM_AGRO ='5151151105110440097' then  (select CAST(PRECIO_ITEM AS INT) from VITEMSRISEPRC1tmp where item_agro ='5151151105110440002') 
when I.ITEM_AGRO ='5151151105110440098'  then (select CAST(PRECIO_ITEM AS INT) from VITEMSRISEPRC1tmp where item_agro ='5151151105110440003') 
when I.ITEM_AGRO ='5151151105110440099' then  (select CAST(PRECIO_ITEM AS INT) from VITEMSRISEPRC1tmp where item_agro ='5151151105110440004') 
else CAST(P.PRECIO_ITEM AS INT) end )price,
'1' AS status,
(case 
when I.ITEM_AGRO ='5151151105110440001'  then  (select CANTIDAD_DISPONIBLE from VITEMSRISEINVtmp where item_agro ='5151151105110440096') 
when I.ITEM_AGRO ='5151151105110440002'  then  (select CANTIDAD_DISPONIBLE from VITEMSRISEINVtmp where item_agro ='5151151105110440097') 
when I.ITEM_AGRO ='5151151105110440003'  then (select CANTIDAD_DISPONIBLE from VITEMSRISEINVtmp where item_agro ='5151151105110440098') 
when I.ITEM_AGRO ='5151151105110440004'  then (select CANTIDAD_DISPONIBLE from VITEMSRISEINVtmp where item_agro ='5151151105110440099') 
else I.CANTIDAD_DISPONIBLE end ) qty,
(CASE WHEN sum(I.CANTIDAD_DISPONIBLE) >0 THEN '1' ELSE '0' END ) AS is_in_stock
from VITEMSRISEINVtmp I left join VITEMSRISEPRC1tmp P ON I.item_agro = p.item_agro
where
I.CANTIDAD_DISPONIBLE > 0 
group by 
I.ITEM_AGRO,
P.PRECIO_ITEM,
I.CANTIDAD_DISPONIBLE 
";
*/
$_POST[cons] ="
select 
(case 
when I.ITEM_AGRO ='5151151105110440096' then '5151151105110440001'
else I.ITEM_AGRO end )sku,
(case 
when I.ITEM_AGRO ='5151151105110440096' then  (select CAST(PRECIO_ITEM AS INT) from VITEMSRISEPRC1tmp where item_agro ='5151151105110440001') 
else CAST(P.PRECIO_ITEM AS INT) end )price,
'1' AS status,
(case 
when I.ITEM_AGRO ='5151151105110440001'  then  (select CANTIDAD_DISPONIBLE from VITEMSRISEINVtmp where item_agro ='5151151105110440096') 
else I.CANTIDAD_DISPONIBLE end ) qty,
(CASE WHEN sum(I.CANTIDAD_DISPONIBLE) >0 THEN '1' ELSE '0' END ) AS is_in_stock
from VITEMSRISEINVtmp I left join VITEMSRISEPRC1tmp P ON I.item_agro = p.item_agro
where
I.CANTIDAD_DISPONIBLE > 0 
group by 
I.ITEM_AGRO,
P.PRECIO_ITEM,
I.CANTIDAD_DISPONIBLE 
";





// _____________________ solo actualiza inventario *para dia sin iva
$hoy = date("Y-m-d");
if($hoy <= '2021-11-19'){
	$_POST[cons] ="
	select 
	ITEM_AGRO AS sku
	, '1' AS status
	, CANTIDAD_DISPONIBLE AS qty
	, CASE WHEN CANTIDAD_DISPONIBLE >0 THEN '1' ELSE '0' END AS is_in_stock
	from VITEMSRISEINVtmp I 
	where 1 =1
	";
} 


$cons = $_POST['cons'];
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);
	      $primero = true;
	      $result = odbc_exec($db2con, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".odbc_errormsg());
	      while($row = odbc_fetch_array($result))
	      { 
			if($row[PRICE] < '600000' AND $row[QTY] < '3' ){
	          $row[QTY] = '0';
	          $row[IS_IN_STOCK] = '0';
	          }
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
            $i1=$row[SKU];
            $p1=$row[PRICE];
            $v1=$row[QTY];
            $v1s=$row[IS_IN_STOCK];
            $dato.="Item:".$i1."; Precio:".$p1."; Cant:".$v1."\n";
	      
		}  


$myfile = file_put_contents($nombrefile, $dato.PHP_EOL , FILE_APPEND);
$filename = "pi_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
odbc_close();

?>
  
