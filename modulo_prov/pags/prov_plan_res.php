<?
$sql ="SELECT 
           prov_plan_det.id AS ID
         , PAGO
         , DETALLE
         , PRESUPUESTO
         , SUM(if(TIPO = 'LIQUIDA', APORTE_LIQ, 0) ) AS LIQU
         , SUM(if(TIPO = 'GASTO', APORTE_LIQ, 0) ) AS GASTO
         , DATE_FORMAT( prov_plan_det.FECHA, '%b-%d' ) AS FECHA
         , CONCAT('Del ',DATE_FORMAT( prov_plan_det.FECHA_INICIAL, '%b-%d' ),' al ',DATE_FORMAT( prov_plan_det.FECHA_FINAL, '%b-%d' )) as FECHAS
       FROM prov_plan_det
       LEFT JOIN prov_plan ON prov_plan.id = id_plan
       LEFT JOIN prov_plan_det_liq ON prov_plan_det_liq.id_plan_det = prov_plan_det.id
       WHERE 
       AÑO = '$_POST[ano]'
       $filtros_det
       GROUP BY prov_plan_det.id, PAGO, DETALLE, PRESUPUESTO
       ORDER BY PAGO, DETALLE, prov_plan_det.id 
";
//echo $sql;
$result = mysqli_query($mysqli, utf8_decode($sql)) or die('List2res '.$sql);
//$tiPLAN = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
   $detalle =$row[DETALLE]; 
   foreach($row As $tit => $val){
     $tiDET["TOTAL X CONCEPTO"][$tit][$detalle] += $val;
   }
   $pago = $row["PAGO"];
   
   if($_POST['id_plan']){
     $detalle = $row["ID"]."-".$row["DETALLE"]." ".$row["FECHA"];
     }
   foreach($row As $tit => $val){
     if($tit =='FECHAS'){
       $tiDET[$pago][$tit][$detalle] = $val;
       }else{
       $tiDET[$pago][$tit][$detalle] += $val;
       }
   }
   $tiDETt["$pago"] += $row["PRESUPUESTO"];
   $tiDETtt += $row["PRESUPUESTO"];
}
$tiDET["TOTAL X CONCEPTO"][DETALLE]["NUEVO"] = "0";
?>

<section23 class="frr aut" >
    <!--<div align="center" class="aut" style="width: 97%; height: auto;"> -->
		<table class="frm" border="1" align="center" cellpadding="7" cellspacing="0" style="border-radius: 0;" width="98%">
			<tr class="frr">
				
			<?	
			$contPAGO = 0;
			$cols = 2 ;
	  	    $anchoCol = number_format(100/$cols,0)."%";
	  	    $colorC ='Silver';
			foreach($tiDET AS $titulo => $valor){
	  	    $contPAGO += 1 ; 
	  	    echo "<td bgcolor='$colorC' width='$anchoCol'>
	  	            <table class='frm'>
	  	              <tr>
	  	                <th colspan='6'>$titulo</th>
	  	              </tr>
	  	              <tr>
	  	                <th>Concepto</th>
	  	                <th>Presup</th>
	  	                <th>Liqu</th>
	  	                <th>Gasto</th>
	  	                <th>Pagado</th>
	  	                <th>Saldo</th>
						<th></th>
	  	              </tr>
	  	                
	  	         ";       
	  	    $contDET = -1; $colorC ='';
	  	    foreach($tiDET[$titulo][DETALLE] AS $detalle => $valor2 ){
	  	        if($detalle =='NUEVO' AND $_POST['id_plan'] != '' ){
	  	        echo "  <tr>
	  	                  <th colspan='55'>NUEVO &#x21E8; <input onChange='this.form.submit()' type='radio' class='frr' id='queVer' name='queVer' value='nuevoDetalle' ></th>
	  	                </tr>
	  	             ";
	  	        }else{
				if($titulo != 'TOTAL X CONCEPTO' AND $_POST['id_plan'] != ''){
					$editDet = "<input onChange='this.form.submit()' type='radio' class='frr' id='editDet' name='editDet' value='".$tiDET[$titulo][ID][$detalle]."' >";
				    $titFechas = $tiDET[$titulo][FECHAS][$detalle]; 
				  }else{
					$editDet = "";
				  }	
	  	        if(($titulo != 'TOTAL X CONCEPTO' AND $_POST['id_plan'] != '') AND $tiDET[$titulo][LIQU][$detalle] == 0 ){
					$liquidacion = "<input onChange='this.form.submit()' type='checkbox' class='frr' id='editLiq' name='editLiq' value='".$tiDET[$titulo][ID][$detalle]."' >";
					
				  }else{
					$liquidacion = number_format($tiDET[$titulo][LIQU][$detalle]/1000,0,',','.');
				  }
	  	        echo "  <tr>
	  	                <td title='$titFechas'>$detalle</td>
	  	                <td align='right'>".number_format($tiDET[$titulo][PRESUPUESTO][$detalle]/1000,0,',','.')."</td>
	  	                <td bgcolor='gainsboro' align='right'>$liquidacion</td>
	  	                <td align='right'>".number_format($tiDET[$titulo][GASTO][$detalle]/1000,0,',','.')."</td>
	  	                <td bgcolor='gainsboro'></td>
	  	                <td></td>
						<th>$editDet</th>
	  	              </tr>  
	  	             ";
	  	        }     
	  	      }
	  	    echo "    
	  	            </table>
	  	          </td>
	  	          ";
	  	    if($contPAGO == $cols){
	  	      echo "</tr><tr>";
	  	      $contPAGO = 0;
	  	      }
	  	    }
	  	    for($i=$contPAGO; $i < $cols; $i++  ){
	  	    echo "<td>$i</td>";
	  	    }
	  	    ?>
			</tr>
					</table>
<!--	</div> -->
</section23>
