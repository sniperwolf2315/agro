<? 
//$prueba ='TMP';

if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento

/* 
//magento 1
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//magento 2 1ra ver
$localhostL 	= 	'67.225.141.97'	; 	
$userA 		= 	'agrocom'	;//agroeva
$claveO		=	'M4scot4$-F1nalSv2018=!'; 	
$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
*/

//magento 2 2da ver
$localhostL 	= 	'3.233.60.4'	; 	
$userA 		= 	'nzwcsjbshb'	;//agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');


$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));


//if($hoy >= '2020-10-13'){ $hoy_1sem = '2020-10-13'; }

$hini = date("Y-m-d H:i:s");
// MAGENTO SACA DATOS DE ENCABEZADO DE ORDEN DE $HOY
$sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , if(customer_taxvat IS NULL,vat_id,customer_taxvat) AS IDCliente
    , CONCAT(customer_firstname,' ',customer_lastname) AS NombreCliente
    , '0' AS Estado
    , street AS Direccion
    , fax AS Telefono
    , telephone AS Celular
    , IF(postcode ='011001000','11001000',postcode) AS CodigoMunicipalidad
    , customer_email AS Email
    , '' AS IDordenAgro
    , '' AS IDestadoAgro
    , '' AS IDDescEstado
    , '' AS IDFacturaAgro
    , grand_total AS ValorOrden
    , shipping_amount AS ValorFlete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','G04',IF(shipping_method = 'amstrates_amstrates16','G04-4',''))) AS vBarrio
    , increment_id AS Sequence
    , A.created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    , if(A.status = 'ondelivery','contra',substr(C.comment,1,8)) AS Pago
    , base_discount_amount*-1 AS Descuento
    , coupon_code AS TipoDesc
    , CONCAT(if(coupon_code IS NULL,'',CONCAT('Dto ',coupon_code,': $',CAST(base_discount_amount AS SIGNED),'\r')),IFNULL((SELECT concat('Cliente escribe: ',comment) FROM agro_sales_order_status_history WHERE parent_id = A.entity_id AND status IS NULL AND is_customer_notified = 1 AND is_visible_on_front = 1),'' )) AS Notas
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address B  on A.shipping_address_id = B.entity_id
    LEFT JOIN 
    agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing'
    WHERE 
    A.created_at >='$hoy_1sem'
    AND
    ( (A.status = 'processing' AND substr(C.comment,1,8)= 'APPROVED' )
      OR
      A.status = 'ondelivery' 
    )
    
    "; 
 //   echo "$sql";die; 
$comaID ='';
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){

  $idPP = $row[IDPedidoPagina];
  $ides .= $comaID.$row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  
  foreach($row AS $titulo => $valor){
    $valor = trim(preg_replace('/\s+/', ' ', str_replace("'", '', str_replace('"', '', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERT["$idPP"] = "INSERT INTO magento_orden ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

// saca de magento los items de las ordenes traidas
//echo $ides;
$sql = "SELECT
      order_id AS IDPedidoPagina
    ,  sku AS IDProducto
    , qty_ordered AS Cantidad
    , '0' AS Estado
    , '' IDOrdenAgro
    , base_price AS ValorItems
    , free_shipping
    FROM agro_sales_order_item
    LEFT JOIN agro_sales_order b ON order_id = entity_id 
    WHERE
    order_id IN($ides)
    ";
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
  //$ides .= $comaID.$row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERTitem[] = "INSERT INTO magento_orden_item ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}



//inserta encabezados mysql local
//mysqli_query($mysqliL, "DELETE FROM magento_orden");
/*
foreach($sqlINSERT AS $idPP => $ins){
  // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
  if(mysqli_query($mysqliL, $ins)){
  //nada
  }else{
  $error = mysqli_error($mysqliL)."<br> $ins<br>";
  echo $error; 
  //mysqli_query($mysqliL,"INSERT INTO magento_orden_error (id, error) VALUES ('$idPP', '$error');");
  }
}*/
//inserta items mysql local
//mysqli_query($mysqliL, "DELETE FROM magento_orden_item");
/*
foreach($sqlINSERTitem AS $ins){
  mysqli_query($mysqliL, $ins) ; //or die(mysqli_error($mysqliL))
}*/

//busca codigos postales de las ordenes nuevas de Bogota 

$sqlMS = "SELECT IDPedidoPagina FROM CreacionEncabezadoVenta$prueba WHERE IDPedidoPagina IN ($ides) ";
$resultMS = mssql_query($sqlMS);
while($rowMS = mssql_fetch_row($resultMS)){
  //mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = 'ya' WHERE IDPedidoPagina ='$rowMS[0]';");
  }
  
require('../_lupap.php');
    $ciudad = '';
    $_POST[barrio] ='';
    $_POST[localidad] ='';
    $_POST[dir_norm] ='';
    $_POST[post_code] ='';  
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente FROM magento_orden WHERE Vbarrio ='' AND CodigoMunicipalidad = '11001000' AND Pago != 'contra' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
    
      $direccion = $row[1];
      $ciudad ='bogota';
      $resultLU = geocode($ciudad, $direccion);   
 // mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = 'D".substr($_POST[post_code],2,2)."' WHERE IDPedidoPagina ='$row[0]';");
  
    if($hoy >= '2020-10-06'){
    //odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='".substr($_POST[post_code],2,2)."'  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
    }
    
  } 
// quita destino auto enrutamiento para entrega oficina
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente FROM magento_orden WHERE Vbarrio ='G04' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      //odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST =''  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
  }
odbc_close();
//buscar ordenes local********************************************************************************************
$sql = "SELECT 
           IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,
           IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha,Pago,Notas 
        FROM magento_orden ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $msqlINSERT["$idPP"] = "INSERT INTO CreacionEncabezadoVenta$prueba ($campos) VALUES ('$valores'); ";
 //echo $msqlINSERT["$idPP"]."----<br>";
 $campos =''; $valores='';
}
//buscar
/*
'838310047' snickers 17 30 sept
*/
$sql = "SELECT * FROM magento_orden_item WHERE ValorItems > 0 OR free_shipping > 0";
//$sql = "SELECT * FROM magento_orden_item WHERE ValorItems > 0 OR IDProducto IN('818142136','818190475','818142033','868620691','868620692','838310058','838310047')"; //,'868620691','868620692'
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
  echo $campos."<br>";
 // exit();
 $msqlINSERTitem["$idPP"][] = "INSERT INTO CreacionItemsVenta$prueba ($campos) VALUES ('$valores'); ";
 echo $msqlINSERTitem["$idPP"][0]."<br>";
 $campos =''; $valores='';
 exit();
}

//inserta encabezados MSsql
/*foreach($msqlINSERT AS $idP => $ins){
  
  if(mssql_query($ins)){
   $contEncabezados += 1;
   $encabezados .= ", $idP";
    foreach($msqlINSERTitem["$idP"] AS $insItem){
      //inserta items de encabezados MSsql
      if(mssql_query($insItem)){
        //echo "Grabo $insItem <br>";
      }else{
        echo "Error $insItem <br>".mssql_get_last_message()."<br>";
      }
    }
  }else{
  //echo "error $ins<br>".mssql_get_last_message()."<br>";
  }
}*/

//guarda log
if(strlen($encabezados) > 0 ){
// mysqli_query($mysqliL," INSERT INTO magento_orden_log$prueba (reg_guardados, hora_i, cant_reg) VALUES ('$encabezados', '$hini' , '$contEncabezados')") ;
}

odbc_close();
?>
  
