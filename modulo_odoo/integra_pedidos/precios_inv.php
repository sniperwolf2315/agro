<?
//parametros:
$wareHouse_id = 34; //34 para bodega 005

sleep(2); 
if($_GET['AAMkAGE4ODJhY'] !='jQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO'){
die;
}
//POSTGRES
$host = "192.168.6.13"; //192.169.34.251 o localhost
$port = "5432";
$data = "capacitacion_agrocampo_copia_produccion";
$user = "tecnocalidad"; //usuario de postgres sistemas
$pass = "TecnoAvancys2019!"; //password de usuario de postgres sistemasqgro
$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string); 


$CoPC = ',' ;
$_POST[cons] ="
SELECT 
  pp.default_code AS sku_new
, cpa_COD.name AS sku_old
, ROUND(max(pt.list_price)+0.4) AS price
, CASE WHEN
    (SELECT coalesce(max(amount),0) FROM product_taxes_rel ptr INNER JOIN account_tax at ON tax_id = at.id WHERE prod_id = pt.id AND tax_id IN(371,468) ) > 0
  THEN
    (SELECT coalesce(max(amount),0) FROM product_taxes_rel ptr INNER JOIN account_tax at ON tax_id = at.id WHERE prod_id = pt.id AND tax_id IN(371,468) )
  ELSE
    (SELECT coalesce(max(amount),0) FROM product_category_taxes_rel pctr INNER JOIN account_tax at ON tax_id = at.id WHERE product_category_id = pt.categ_id AND tax_id IN(371,468))
  END
  AS IVA 
, max('1') AS status
, sum(sq.qty)-(SELECT coalesce(sum(product_qty),0) FROM stock_move WHERE product_id = sq.product_id AND state ='confirmed' AND warehouse_id = $wareHouse_id ) AS qty
, CASE WHEN 
    sum(sq.qty)-(SELECT coalesce(sum(product_qty),0) FROM stock_move WHERE product_id = sq.product_id AND state ='confirmed' AND warehouse_id = $wareHouse_id ) > 0
  THEN
    1
  ELSE
    0
  END
  AS is_in_stock
,sum(sq.qty) as cant_tot
,(SELECT coalesce(sum(product_qty),0) FROM stock_move WHERE product_id = sq.product_id AND state ='confirmed' AND warehouse_id = $wareHouse_id ) as reserv
, 
 (SELECT coalesce(max(amount),0) FROM product_taxes_rel ptr INNER JOIN account_tax at ON tax_id = at.id WHERE prod_id = pt.id AND tax_id IN(371,468) )
AS IVA_prod
,
(SELECT coalesce(max(amount),0) FROM product_category_taxes_rel pctr INNER JOIN account_tax at ON tax_id = at.id WHERE product_category_id = pt.categ_id AND tax_id IN(371,468) )
as IVA_cat

FROM stock_quant sq
left join stock_location sl ON sl.id = sq.location_id
left join product_product pp ON pp.id = sq.product_id
left join product_template pt on pt.id = pp.product_tmpl_id

left join 
    product_template_profiling_rel ptp_WEB left join crm_profiling_answer cpa_WEB ON cpa_WEB.id = answers
  ON ptp_WEB.template = pt.id
left join 
    product_template_profiling_rel ptp_COD left join crm_profiling_answer cpa_COD ON cpa_COD.id = answers
  ON ptp_COD.template = pt.id 

 
where 
(sl.usage = 'internal' AND sl.warehouse_id = $wareHouse_id) 
AND
 (cpa_WEB.question_id =25 AND cpa_WEB.name ='G07')
AND cpa_COD.question_id =28 

GROUP BY pp.default_code,cpa_COD.name, sq.product_id, pt.id 
";


$cons = $_POST['cons'];
 
//$cons = str_replace("´","'",utf8_decode($_POST['cons']));
//error_reporting(E_PARSE);
//ini_set("display_errors", 1);
	      $primero = true;
	      $result = pg_query($pg13, $cons) OR die ("<BR>ERROR query<BR>$cons<br> ".pg_error($pg13));
	      while($row = pg_fetch_assoc($result))
	      { if($row[price] < '600000' AND $row[qty] < '3' ){
	          $row[qty] = '0';
	          $row[is_in_stock] = '0';
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
	      		//if(is_numeric($valor)){
	      		//$valor = number_format($valor,0,"","");
	      		//}
	      	$csv_output .= $coma.trim($valor);
	      	$coma = $CoPC;
	      	}
	      	$csv_output .="\n";
	      }  
	

$filename = "pi_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
odbc_close();

?>
  
