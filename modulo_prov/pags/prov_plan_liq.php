<? 
$sql ="SELECT 
           prov_plan_det.id AS ID
         , PAGO
         , DETALLE
         , PRESUPUESTO
         , PORCENTAJE_1
         , BASE_1
         , PORCENTAJE_2
         , BASE_2
         , DATE_FORMAT( prov_plan_det.FECHA_INICIAL, '%Y%m%d' ) AS FECHA_INICIAL
         , DATE_FORMAT( prov_plan_det.FECHA_FINAL, '%Y%m%d' ) AS FECHA_FINAL
         , SUM(if(TIPO = 'LIQUIDA', APORTE_LIQ, 0) ) AS LIQU
         , SUM(if(TIPO = 'GASTO', APORTE_LIQ, 0) ) AS GASTO
         , DATE_FORMAT( prov_plan_det.FECHA, '%b-%d' ) AS FECHA
         , (SELECT GROUP_CONCAT(CODIGO)  FROM prov_plan_det_art WHERE id_plan_det = '$_POST[editLiq]') AS PRODS
       FROM prov_plan_det
       LEFT JOIN prov_plan ON prov_plan.id = id_plan
       LEFT JOIN prov_plan_det_liq ON prov_plan_det_liq.id_plan_det = prov_plan_det.id
       WHERE 
       prov_plan_det.id = '$_POST[editLiq]' 
       ";
//echo $sql;
$result = mysqli_query($mysqli, utf8_decode($sql)) or die('List2res '.mysqli_error($mysqli)." : ".$sql);
$tit = mysqli_fetch_assoc($result);
$tit[PRODS] = str_replace(",","','",$tit[PRODS]);
//print_r($tit);
$sql = "SELECT               
        '$_POST[editLiq]' AS id_plan_det,
        'LIQUIDA' AS TIPO,
        '$hoy' AS FECHA,
        SRBISD.IDORDT AS TIPO_DOC,
        SRBISH.IHODAT AS FECHA_ORDEN,
        SRBISD.IDINVN AS DOC,
        SRBISD.IDIDAT AS FECHA_DOC,
        SRBISD.IDPRDC AS ITEM,
        SRBISD.IDDESC AS NOMBRE,
        CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END AS UNID,
        
        CASE SRBISD.IDTYPP WHEN 1 THEN (SRBISD.IDNSVA * SRBISD.IDITT) ELSE ((SRBISD.IDNSVA + SRBISD.IDITT)*-1) END AS VLR_INC_IVA,
        CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VALOR_VTA,
        (CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END)*SRBPRG.PGLPCO AS COSTO_ULTIMO  
		
		, CASE WHEN 
		    '$tit[BASE_1]' = 'COSTO' 
		  THEN
		    SRBISD.IDQTY * SRBPRG.PGLPCO
		  ELSE
		    CASE WHEN
		      '$tit[BASE_1]' = 'VENTA'
		    THEN
		      SRBISD.IDNSVA
		    END
		  END 
		  * $tit[PORCENTAJE_1]/100 as LIQU_1
		, CASE WHEN 
		    '$tit[BASE_2]' = 'COSTO' 
		  THEN
		    SRBISD.IDQTY * SRBPRG.PGLPCO
		  ELSE
		    CASE WHEN
		      '$tit[BASE_2]' = 'VENTA'
		    THEN
		      SRBISD.IDNSVA
		    END
		  END 
		  * $tit[PORCENTAJE_2]/100 as LIQU_2
			   
        FROM SROISDPL SRBISD
        LEFT JOIN SROISH SRBISH ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
        LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
              
        WHERE
        SRBISH.IHIDAT BETWEEN '$tit[FECHA_INICIAL]' AND '$tit[FECHA_FINAL]'
        AND 
        SRBISD.IDPRDC IN ('$tit[PRODS]')
        AND
        (CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0
	    AND
		SRBISD.IDORDT NOT IN('75','69','70','24','71','02','33','73','72','25','65','60','SG','SR','EG','ER','66',
			        	     '67','76','N2','77','68','SN','Z3','Z5','Z6','Z7','ZM','ZN','K9','R7','K4','Z4')
        ";
ECHO "<br>$sql<br>";       
$result = odbc_exec($db2conp,$sql);
while($row = odbc_fetch_array($result)){
  $comaC = '';
  $comaV = '';
  
  foreach($row AS $titulo => $valor){
    $tabla["$titulo"][] = $valor;
    $valor = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', '´', preg_replace('/\"/', '´´', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERT[] = "INSERT INTO magento_orden ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

?>

<section23 class="frr aut" >
    <!--<div align="center" class="aut" style="width: 97%; height: auto;"> -->
    <?
    echo "Desde: $tit[FECHA_INICIAL] Hasta: $tit[FECHA_FINAL] <BR> PORCE 1: $tit[PORCENTAJE_1] , BASE 1 $tit[BASE_1] <BR> PORCE 2: $tit[PORCENTAJE_2] , BASE 2 $tit[BASE_2] ";
    ?>
		<table class="frm" border="1" align="center" cellpadding="7" cellspacing="0" style="border-radius: 0;" width="98%">
			<tr>
			  <?
			  foreach($tabla AS $titulo => $valor){
			    echo "<th class='frr'>$titulo</th>";
			  }
			  ?>
			</tr>
			<?
			foreach($tabla['FECHA'] AS $linea => $valorLinea){
			  echo "<tr class='frr'>";
			  foreach($tabla AS $titulo => $valor){
			  echo "<td class='frr'>".$tabla[$titulo][$linea]."</td>";
			  }
			  echo "</tr>";
			}
			?>
			<tr class="frr">
				
			
			</tr>
		</table>
<!--	</div> -->
</section23>
