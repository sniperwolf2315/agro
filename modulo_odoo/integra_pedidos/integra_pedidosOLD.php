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
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

if($hoy == '2020-07-03'){ $hoy_1sem = $hoy; }

$hini = date("Y-m-d H:i:s");
// MAGENTO SACA DATOS DE ENCABEZADO DE ORDEN DE $HOY
$sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , customer_taxvat AS IDCliente
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
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amtable_amtable14','G04',IF(postcode ='011001000','G04-4',''))) AS vBarrio
    , increment_id AS Sequence
    , created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    FROM agro_sales_flat_order A 
    inner join
    agro_sales_flat_order_address B  on A.shipping_address_id = B.entity_id
    WHERE 
    status = 'processing'
    AND
    total_paid > 0
    AND
    created_at >='$hoy_1sem'
    ";
$comaID ='';
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
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
 $sqlINSERT[] = "INSERT INTO magento_orden ($campos) VALUES ('$valores'); ";
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
    , price AS ValorItems
    FROM agro_sales_flat_order_item
    LEFT JOIN agro_sales_flat_order b ON order_id = entity_id 
    WHERE
    order_id IN($ides)
    ";
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
  $ides .= $comaID.$row[IDPedidoPagina];
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
mysqli_query($mysqliL, "DELETE FROM magento_orden");
foreach($sqlINSERT AS $ins){
  // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
  if(mysqli_query($mysqliL, $ins)){}else{echo mysqli_error($mysqliL)."<br> $ins<br>"; }
}
//inserta items mysql local
mysqli_query($mysqliL, "DELETE FROM magento_orden_item");
foreach($sqlINSERTitem AS $ins){
  mysqli_query($mysqliL, $ins) ; //or die(mysqli_error($mysqliL))
}

//buscar ordenes local
$sql = "SELECT 
           IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,
           IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha 
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
 $campos =''; $valores='';
}
//buscar
$sql = "SELECT * FROM magento_orden_item WHERE ValorItems > 0 OR IDProducto IN( '818190475','818142033' )";
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
 $msqlINSERTitem["$idPP"][] = "INSERT INTO CreacionItemsVenta$prueba ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

//inserta encabezados MSsql
foreach($msqlINSERT AS $idP => $ins){
  
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
}

//guarda log
if(strlen($encabezados) > 0 ){
 mysqli_query($mysqliL," INSERT INTO magento_orden_log$prueba (reg_guardados, hora_i, cant_reg) VALUES ('$encabezados', '$hini' , '$contEncabezados')") ;
}
?>
  
