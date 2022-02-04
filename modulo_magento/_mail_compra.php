<?

$copiados = "proyectosagro@agrocampo.com.co;sistemas@agrocampo.com.co";

//compradores y sus correos || COSTOS Y SUS CORREOS
$accion = $_GET['accion'];
$acciones = explode(" ",$accion);
$accion = $acciones[0];
$dest = $acciones[1];

if($dest == 'costos' or $dest == 'compra'){}else{echo "d ".$dest."-";die;}
if($accion == 'VER' or $accion == 'ENVIAR'){}else{echo "a ".$accion;die;}

if($dest == 'costos'){
  $comprador['CONSOLIDADO TODOS LOS COMPRADORES'] = "juan.silva@agrocampo.com.co";
  $comprador["PINILLOSM','SUAREZM','BARONF"] = "costos2@agrocampo.com.co";
  $comprador['RODRIGUEZF'] = "costos@agrocampo.com.co";
  //$comprador["RODRIGUEZF','BARONF"] = "fanny.rodriguez@agrocampo.com.co";
  }


if($dest == 'compra'){
  $comprador['CONSOLIDADO TODOS LOS COMPRADORES'] = "david.rodriguez@agrocampo.com.co;lina.cardenas@agrocampo.com.co;ccifuentes@estrategiavirtual.co";
  $comprador['RODRIGUEZF'] = "fanny.rodriguez@agrocampo.com.co";
  $comprador['BARONF'] = "felipe.baron@agrocampo.com.co";
  $comprador['PINILLOSM'] = "martha.pinillos@agrocampo.com.co";
  $comprador['SUAREZM'] = "marcela.suarez@agrocampo.com.co";
  }

include("user_con.php");
$hoy = date("Y-m-d");
$ahora = date("Y-m-d H:i");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));
$hoy_1sem_Ibs = str_replace("-","", $hoy_1sem);


//ECHO date("H:i:s");

$sql = "SELECT sku, qty, qty AS qty_mag, price AS PRECIO_MAG, 'NO EXISTE EN IBS' AS MARCA_IBS, '$hoy' as FECHA_AUDITORIA 
        FROM agro_catalog_product_entity_int eint 
        inner join
          agro_catalog_product_entity ent ON ent.entity_id = eint.entity_id
        inner join
          agro_cataloginventory_stock_item ite ON ite.product_id = eint.entity_id
        inner join 
          agro_catalog_product_index_price pri ON pri.entity_id = eint.entity_id AND pri.customer_group_id = 1  
        WHERE attribute_id = 97 
          AND value = 1
          AND is_in_stock = 1

        "; // attribute_id 97 es status, value 1 activo , 2 inactivo . is_in_sotck =1 lo muestra en la pagina ... quite AND is_in_stock = 1
          
$result = mysqli_query($mysqliM, $sql) or die("algo paso MY2 ".mysql_error($mysqlM));
while($row = mysqli_fetch_assoc($result)){
  $comaC = '';
  $comaV = '';
  
  foreach($row AS $titulo => $valor){
    $valor = trim(preg_replace('/\s+/', ' ', str_replace("'", 'Â´', str_replace('"', 'Â´Â´', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERT[] = "INSERT INTO magento_itemibs ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
 $skus .= $comaSKU.str_replace("'","´",$row['sku']);
 $comaSKU = "','";
 }


//inserta skus en mysql local
mysqli_query($mysqliL, "DELETE FROM magento_itemibs");
foreach($sqlINSERT AS $ins){
  mysqli_query($mysqliL, $ins); 
  if(mysqli_errno($mysqliL) > 0 AND mysqli_errno($mysqliL) != 1062  ){
  die(mysqli_error($mysqliL)."<br>A $ins");
  }
}
 

//DATOS de sku EN IBS
$sql = "select
        PGPRDC AS COD 
		, (SELECT PRECIO_ITEM FROM VITEMSRISEPRC1TMP WHERE ITEM_AGRO = PGPRDC) AS PRECIO_IBS
		,PGDESC AS NOMBRE
		,PGPGRP AS GRUPO
		,PGPLAN AS RESPONSABLE
		,PGSTAT AS ESTADO
		,CASE WHEN PGSTAT ='D'
		   THEN
		     'DESCONTINUADO'
		   ELSE  
		     CASE WHEN (PGPDGR = 'G05' OR PGPDGR = 'G07' OR PGPDGR ='G08' OR PGPDGR ='G09')
		     THEN  
		      'OK IBS - OK PAG'
		     ELSE
		      'FALTA IBS - OK PAG' 
		     END 
		   END
		 AS MARCA_IBS
   
		FROM AGR620CFAG.SROPRG SRBPRG
		where PGPRDC IN ('$skus')
";
//echo $sql;
$result = odbc_exec($db2conp, $sql) or die(odbc_errormsg($db2conp)."--ibs");
  while($row = odbc_fetch_array($result)){
   $comaS = '';
   if($row['PRECIO_IBS'] ==''){$row['PRECIO_IBS'] = '0';}
    foreach($row AS $tituloSET => $valorSET){
      if($tituloSET =='COD'){continue;}
      $valorSET = trim(preg_replace('/\s+/', ' ', str_replace("'", 'Â´', str_replace('"/', 'Â´Â´', $valorSET))));
      $sets .= "$comaS $tituloSET = '$valorSET'";
      $comaS = ',';
    }
   $sqlUPDATE[] = "UPDATE magento_itemibs SET $sets WHERE sku = '$row[COD]' ; ";
   $sets ='';
  
   }

foreach($sqlUPDATE AS $ins){
  mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
}

//sku EN IBS y no en la pagina
$sql = "select 
		 ITEM_AGRO AS sku 
		,CANTIDAD_DISPONIBLE AS qty
		,CANTIDAD_DISPONIBLE AS qty_ibs 
		, (SELECT PRECIO_ITEM FROM VITEMSRISEPRC1TMP WHERE ITEM_AGRO = PGPRDC) AS PRECIO_IBS
		,DESCRIPCION_ITEM AS NOMBRE 
		,PGPGRP AS GRUPO
		,PGPLAN AS RESPONSABLE 
		,PGSTAT AS ESTADO 
		,'OK IBS - FALTA PAG' AS MARCA_IBS
		,'$hoy' AS FECHA_AUDITORIA 
		FROM VITEMSRISEINVtmp
		  left join SROPRG ON PGPRDC = ITEM_AGRO 
		where 
		 CANTIDAD_DISPONIBLE >= 1
		 and
		ITEM_AGRO NOT IN ('$skus')
       ";
//echo $sql;
$result = odbc_exec($db2conp, $sql);
$sqlINSERT = array(); 
 while($row = odbc_fetch_array($result)){ //print_r($row); die;
   $comaC = '';
   $comaV = '';
   if($row[PRECIO_IBS] < '600000' AND $row[QTY] < '3' ){
	  continue;
	  }          
   foreach($row AS $titulo => $valor){
    $valor = trim(preg_replace('/\s+/', ' ', str_replace("'", 'Â´', str_replace('"', 'Â´Â´', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
    }
 $sqlINSERT[] = "INSERT INTO magento_itemibs ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
 
 }

foreach($sqlINSERT AS $ins){
  mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
}

//busca agotados en la pagina con stock en IBS
$sql = "SELECT sku, qty  FROM `magento_itemibs` WHERE `MARCA_IBS` LIKE 'OK IBS - FALTA PAG'";
$result = mysqli_query($mysqliL, $sql) or die("algo paso MYL1 ".mysql_error($mysqlL));
$coma ='';
while($row = mysqli_fetch_assoc($result)){
   $skusOKIBS .= $coma.$row[sku];
   $coma ="','";
   }
$coma ='';


mysqli_close();
include("user_con.php");


$sql = "SELECT sku AS SKU
        FROM agro_catalog_product_entity_int eint 
        inner join
          agro_catalog_product_entity ent ON ent.entity_id = eint.entity_id
        inner join
          agro_cataloginventory_stock_item ite ON ite.product_id = eint.entity_id
        inner join 
          agro_catalog_product_index_price pri ON pri.entity_id = eint.entity_id AND pri.customer_group_id = 1  
        WHERE sku IN('$skusOKIBS')
          AND attribute_id = 97 
          AND value = 1
          AND is_in_stock = 0

        "; // attribute_id 97 es status, value 1 activo , 2 inactivo . is_in_sotck =1 lo muestra en la pagina ... quite AND is_in_stock = 1          
//echo $sql; die;
$result = mysqli_query($mysqliM, $sql) or die("algo paso MY3 ".mysqli_error($mysqliM));
while($row = mysqli_fetch_assoc($result)){
   
   $sqlUPDATE[] = "UPDATE magento_itemibs SET MARCA_IBS = 'OK IBS - AGOTADO PAG' WHERE sku = '$row[SKU]' ; ";
   $sets ='';
  
   }
foreach($sqlUPDATE AS $ins){
  mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
}



//CAMBIA ESTADO DE AGOTADOS
mysqli_query($mysqliL, "UPDATE magento_itemibs set MARCA_IBS = 'AGOTADO IBS - OK PAG' WHERE qty = 0 AND NOMBRE NOT LIKE 'KIT %' ");
mysqli_query($mysqliL, "UPDATE magento_itemibs set RESPONSABLE = 'DIGITAL' WHERE RESPONSABLE IS NULL ");

//CAMBIA ESTADO A DIF DE PRECIOS
mysqli_query($mysqliL, "UPDATE magento_itemibs set MARCA_IBS = 'OK IBS - OK PAG - DIF PRECIO' 
                        WHERE
                        marca_ibs = 'OK IBS - OK PAG'
                         AND
                        SUBSTR(NOMBRE,1,4) != 'kit '
                         AND
                        ((precio_mag - precio_ibs) > 3 
                          or
                          (precio_mag - precio_ibs) < -3
                        )   
                        ");


//mensaje a compradores

//echo $pendientesItem; die;
//correo electronico  
			 
			$cuerpo1 = " 
			<html> 
			<head> 
   			<title>REPORTE DE AUDITORIA MAGENTO - IBS</title> 
				</head> 
				<body>
				<br>
				<H>REPORTE DE AUDITORIA MAGENTO - IBS</H> 
			    ";	
			$cuerpo3 = "	
			    <br>
				<br>
				Atentamente
				<br>
				Integracion Magento-IBS
				<br>
				$ahora
				
				</body> 
				</html> 
				";

				//para el envÃƒÆ’Ã‚Â­o en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=utf8\r\n"; 

				//direcciÃƒÆ’Ã‚Â³n del remitente 
				$headers .= 'From: Integracion Magento-IBS <no_responder@agrocampo.com.co>' ."\r\n"; 
				
				//con copia a 
				$headers .= 'Cc: '.$copiados.'' . "\r\n";

				//direcciÃƒÆ’Ã‚Â³n de respuesta, si queremos que sea distinta que la del remitente 
				$headers .= "Reply-To: Integracion Magento - IBS <no_responder@agrocampo.com.co>\r\n"; 
 

foreach($comprador AS $responsable => $correo ){
  $asunto = "$responsable: Reporte Auditoria MAGENTO-IBS $hoy";
  $destinatario = "$correo" ;
  //$destinatario = "proyectosagro@agrocampo.com.co";
  $cuerpo2 = "<br>
              <br>Respetado comprador 
              <br>
              <br><b>$responsable</b>
              <br>
              <br>A continuacion el resultado de la auditoria automatica de los productos en IBS y la pagina web
              <br>
              <br>
              <table width='95%' border='1'>
              <tr>
                <th colspan='2'>CONVENCIONES</th>
              </tr>

              <tr>
                <td>DESCONTINUADO</td>
                <td>Activo en la pagina web, marcado como inactivo en IBS</td>
              </tr>
              <tr>
                <td>OK IBS - FALTA PAG</td>
                <td>Marcado en IBS como producto para web y no esta activo en la pagina</td>
              </tr>
              <tr>
                <td>FALTA IBS - OK PAG</td>
                <td>Activo en la pagina web y NO marcado en IBS para pagina web</td>
              </tr>
              <tr>
                <td>AGOTADO IBS - OK PAG</td>
                <td>Sin exitecias disponibles en IBS, disponible en la pagina web</td>
              </tr>
              <tr>
                <td>OK IBS - OK PAG - DIF PRECIO</td>
                <td>Producto bien IBS, bien en Pag, con Diferencias en precios base</td>
              </tr>
              </table>
              
              <br>
              <br>
              <table border='1'>
                <tr>
                  <th colspan='2'>RESULTADO DE LA AUDITORIA</th>
                </tr>
                <tr>
                  <th> Hallazgo </th>
                  <th> Productos </th>
                </tr>  
              ";
  if(substr($responsable,0,11) == 'CONSOLIDADO'){
    $fresp ='';
    }else{
    $fresp =" and RESPONSABLE IN('$responsable') ";
    }            
  $sql = "SELECT marca_ibs AS HA , count(*) AS PROD FROM `magento_itemibs` WHERE MARCA_IBS != 'OK IBS - OK PAG' AND GRUPO !='PPO' $fresp group by  MARCA_IBS";
  $result = mysqli_query($mysqliL, $sql );
  $hay = '';
  while($row = mysqli_fetch_assoc($result)){
      $cuerpo2 .= "<tr>
                   <td> $row[HA] </td>
                   <td align='center'>$row[PROD]</td>
                   </tr>
                   ";
      $hay = 'si';               
    }
  if( $hay == ''){ 
    $cuerpo2 .= "<tr><td colspan='2' align='center'>SIN HALLAZGOS</td></tr>";
    }
  $cuerpo2 .= "</table>";    
  if( $hay == 'si'){
    $responsable = str_replace("','","|", $responsable);
    $cuerpo2 .= "<br>
                 <a href='http://sia.agrocampo.vip/modulo_magento/_mail_compra_csv.php?buyer=$responsable'>
                 <b>Click aca para descargar archivo Excel con el detalle</b>
                 </a>   
                ";
    }
  
  $cuerpo = $cuerpo1.$cuerpo2.$cuerpo3;
  if($accion == 'ENVIAR'){  
    
    if( mail("$destinatario",$asunto,$cuerpo,$headers) )
				{ 
				//echo $cuerpo;  //echo "Correo enviado con exito"; 
				} else { 
				  echo "Error al enviar correo";  
				}
    }elseif($accion == 'VER'){
    
    echo "<br>******************<br>$cuerpo<br>";
    
    }
  }

//ECHO "<br>".date("H:i:s");
odbc_close();
die;
?>
  
