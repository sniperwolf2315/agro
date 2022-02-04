<? 
//$prueba ='TMP';
if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }

// validez de la orden creada por la integracion +X dias
$dias_val = 5;

// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento
/* 
//magento #1
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }
*/

// magento#2 2da ver
$localhostL 	= 	'3.233.60.4'	; 	
$userA 		= 	'nzwcsjbshb'	;//agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//POSTGRES
$host = "192.168.6.13"; //192.169.34.251 o localhost
$port = "5432";
$data = "capacitacion_agrocampo";
$user = "agrocampo"; //usuario de postgres sistemas
$pass = "AgroAvancys2021!"; //password de usuario de postgres sistemasqgro
$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string); 



$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

if($hoy == '2020-06-19'){ $hoy_1sem = $hoy; }

$hini = date("Y-m-d H:i:s");

// MAGENTO SACA DATOS DE ENCABEZADO DE ORDEN DE $cuantoAntes
$cuantoAntes = $hoy;
$sql ="SELECT 
      A.entity_id AS IDPedidoPagina
    , if(customer_taxvat IS NULL,bill.vat_id,customer_taxvat) AS IDCliente
    , ifnull((SELECT value FROM agro_customer_entity_int WHERE entity_id = A.customer_id  AND attribute_id ='157'),'5886') AS tipo_doc_mag
    , '0' AS Estado
    
    , CONCAT(ship.firstname,' ',ship.lastname) AS NombreCliente_env
    , ship.firstname AS PrimerNombre_env
    , ship.lastname AS PrimerApellido_env
    , ship.street AS Dir_env
    , ship.fax AS Tel_env
    , ship.telephone AS Cel_env
    , if(length(ship.postcode) = 9, substr(ship.postcode,2),ship.postcode) AS CodMun_env
    , ship.email AS Email_env
    
    , CONCAT(bill.firstname,' ',bill.lastname) AS NombreCliente_fac
    , bill.firstname AS PrimerNombre_fac
    , bill.lastname AS PrimerApellido_fac
    , bill.street AS Dir_fac
    , bill.fax AS Tel_fac
    , bill.telephone AS Cel_fac
    , if(length(bill.postcode) = 9, substr(bill.postcode,2),bill.postcode) AS CodMun_fac
    , bill.email AS Email_fac

    , grand_total AS ValorOrden
    , shipping_amount AS ValorFlete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','G04','')) AS vBarrio
    , increment_id AS Sequence
    , A.created_at AS Fecha
    , '0000-00-00' AS FechaIngreso 
    , '0000-00-00' AS FechaFacturacion
    , if(A.status = 'ondelivery','contra',substr(C.comment,1,8)) AS Pago
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address ship  on A.shipping_address_id = ship.entity_id
    inner join
    agro_sales_order_address bill  on A.billing_address_id = bill.entity_id
    LEFT JOIN 
    agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing'
    
    WHERE 
    
    (C.created_at >='$cuantoAntes' AND A.status = 'processing' AND substr(C.comment,1,8)= 'APPROVED' )
      OR
    (A.created_at >='$cuantoAntes' AND A.status = 'ondelivery') 
    
    
    limit 2
    
    ";
  
$result = mysqli_query($mysqliM, $sql) or die(mysqli_error($mysqliM));
while($row = mysqli_fetch_assoc($result)){
  $comaC = '';
  $comaV = '';
  $idPP = $row['IDPedidoPagina'];
  
  //normaliza cedula
  $IDCliente = explode('-',str_replace('.','',str_replace(',','',$row['IDCliente'])));
  $row['IDCliente'] = $IDCliente[0];
  foreach($row AS $titulo => $valor){
    //$valor = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¾ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¾ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â´', $valor))));
    $valor = trim(preg_replace('/\s+/', ' ', str_replace("'", '', str_replace('"', '', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERT["$idPP"] = "INSERT INTO odoo_magento_orden ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

//inserta encabezados mysql local 
$coma ='';
foreach($sqlINSERT AS $ide => $ins){
  // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
  mysqli_query($mysqliL, $ins);
  
   if(mysqli_errno($mysqliL) == '0'){
     $ides .= $coma.$ide;
     $coma =',';
   }else{
    if(mysqli_errno($mysqliL) =='1062'){ 
     //echo "<br> duplicado <br>"; 
     }else{
     $idMAG = explode("','",$ins);
     $idMAG = explode("'", $idMAG[0]);
     $error_mysql = str_replace("'",'',mysqli_error($mysqliL)." --- $ins");
     //echo "$idMAG[1]<br>$error_mysql<br>";
     $sqlLOG ="INSERT INTO odoo_magento_orden_log_error (id, error_mysql)VALUES('$idMAG[1]','$error_mysql')";
     mysqli_query($mysqliL,$sqlLOG);// or die(mysqli_error($mysqliL)." $sqlLOG");
     }
   } 
}

//busca items de las guardadas y lleva a mysql
$sql = "SELECT
      order_id AS IDPedidoPagina
    ,  sku AS IDProducto
    , qty_ordered AS Cantidad
    , '0' AS Estado
    , base_price AS ValorItems
    FROM agro_sales_order_item
    LEFT JOIN agro_sales_order b ON order_id = entity_id 
    WHERE
    order_id IN($ides)
    ";
$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERTitem[] = "INSERT INTO odoo_magento_orden_item ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

//inserta items mysql local de los encabezados guardados
foreach($sqlINSERTitem AS $ins){
  mysqli_query($mysqliL, $ins);// or die(mysqli_error($mysqliL));
}
//guarda log de registros importados
mysqli_query($mysqliL, "INSERT INTO odoo_magento_orden_log_reg (registros) VALUES('$ides')");

//Actualiza ids de Odoo en Mysql
//ids de estado y ciudad
  $sql ="SELECT distinct(CodMun_fac) FROM odoo_magento_orden WHERE state_id_fac IS NULL
           union
         SELECT distinct(CodMun_env) FROM odoo_magento_orden 
         WHERE 
         state_id_env IS NULL
           AND
         CodMun_env not in (SELECT distinct(CodMun_fac) FROM odoo_magento_orden WHERE state_id_fac IS NULL)";
  $result = mysqli_query($mysqliL, $sql);
  while($row = mysqli_fetch_row($result)){
    //echo "<br>$row[0] State ".substr($row[0],0,2).", City ".substr($row[0],2,3);
    $state = substr($row[0],0,2);
    $city = substr($row[0],2,3);
    $psql ="SELECT S.id, C.id FROM res_city C
              INNER JOIN
              res_country_state S ON S.id = C.provincia_id  
            WHERE  S.country_id= '50' 
               AND S.code = '$state' 
               AND C.code = '$city'
            ";
    $presult = pg_query($pg13, $psql);
    while($prow = pg_fetch_row($presult)){
    //echo "<br>$state state : $prow[0] , $city ciudad : $prow[1]  ";
    $state_id = $prow[0];
    $city_id = $prow[1];
    
    //IDS DE ESTADO Y CIUDAD DE FACTURACION
    $sqlUP = "UPDATE odoo_magento_orden 
              SET  
                state_id_fac = '$state_id'
               ,city_id_fac = '$city_id'
              WHERE (state_id_fac IS NULL OR city_id_fac IS NULL) 
                AND  CodMun_fac = '$row[0]' 
             ";
    mysqli_query($mysqliL, $sqlUP) or die(mysqli_error($mysqliL));
    //IDS DE ESTADO Y CIUDAD DE ENVIO
    $sqlUP = "UPDATE odoo_magento_orden 
              SET  
                state_id_env = '$state_id'
               ,city_id_env = '$city_id'
              WHERE (state_id_env IS NULL OR city_id_env IS NULL) 
                AND  CodMun_env = '$row[0]' 
             ";
    mysqli_query($mysqliL, $sqlUP) or die(mysqli_error($mysqliL));
    }
  }
  
// ids de prodcutos odoo
  $sql ="SELECT distinct(IDProducto) FROM odoo_magento_orden_item WHERE odoo_product_id IS NULL ";
  $result = mysqli_query($mysqliL, $sql);
  while($row = mysqli_fetch_row($result)){
  $psql ="SELECT id FROM product_product
            WHERE default_code ='$row[0]'
            ";
            
  //busca por ref interna y perfiles Ref IBS          
  $psql ="SELECT pp.id FROM product_product pp
             left join product_template pt on pt.id = pp.product_tmpl_id
               left join 
                   product_template_profiling_rel ptp_WEB left join crm_profiling_answer cpa_WEB ON cpa_WEB.id = answers
                 ON ptp_WEB.template = pt.id
               left join 
                   product_template_profiling_rel ptp_COD left join crm_profiling_answer cpa_COD ON cpa_COD.id = answers
                 ON ptp_COD.template = pt.id
           WHERE 
           (default_code ='$row[0]' or cpa_COD.name ='$row[0]')
           AND
           (cpa_WEB.question_id =25 AND cpa_WEB.name ='G07')
           AND cpa_COD.question_id =28 ";  
            
    $presult = pg_query($pg13, $psql);
    while($prow = pg_fetch_row($presult)){
    //echo "<br>cod: $row[0] = id $prow[0]";
    //IDS DE ESTADO Y CIUDAD DE ENVIO
    $sqlUP = "UPDATE odoo_magento_orden_item 
              SET  
                odoo_product_id = '$prow[0]'
              WHERE IDProducto ='$row[0]' AND odoo_product_id IS NULL
              ";
    mysqli_query($mysqliL, $sqlUP) or die(mysqli_error($mysqliL));
    }
  }  

// actualiza tipos de documento segun tabla odoo_magento_tipodoc
$sqlUP ="UPDATE odoo_magento_orden LEFT JOIN odoo_magento_tipodoc on tipo_doc_mag = mag 
       set tipo_doc_odoo = odoo
       where tipo_doc_odoo IS NULL OR tipo_doc_odoo = '' ";
mysqli_query($mysqliL, $sqlUP) or die(mysqli_error($mysqliL));
    

//buscar ordenes local y envia a odoo
$sql = "SELECT
            IDPedidoPagina
           , IDCliente
           ,if(tipo_doc_odoo ='',10,tipo_doc_odoo) as ref_type
           ,Sequence as Sequence
           
           ,NombreCliente_fac
           ,PrimerNombre_fac
           ,PrimerApellido_fac
           ,Email_fac
           ,'2' as type_costumer
           ,Tel_fac 
           ,Cel_fac
           ,Dir_fac
           ,city_id_fac
           ,state_id_fac
           
           ,NombreCliente_env
           ,PrimerNombre_env
           ,PrimerApellido_env
           ,Email_env
           ,Tel_env 
           ,Cel_env
           ,Dir_env
           ,city_id_env
           ,state_id_env
           
           ,ValorFlete
           FROM odoo_magento_orden 
           
           WHERE
           (OrdenOdoo='' OR OrdenOdoo IS NULL )
           ";
$result = $result = mysqli_query($mysqliL, $sql) or die(mysqli_error($mysqliL));
while($row = mysqli_fetch_assoc($result)){
//datos para _create.php

$datosOV['partner_id'] ='';
$datosOV['partner_shipping_id'] = '';
$datosOV['quotation_type_id'] = 16;

$datosOV['client_order_ref'] = $row['Sequence'];
$datosOV['expiry_date'] = date("Y-m-d 23:59:59", strtotime("$hoy + $dias_val day") );
$datosOV['user_id'] = 2526;
$datosOV['in_charge'] = 2526;
$datosOV['warehouse_id'] = 34;

$datosCLI['name'] = mb_strtoupper($row['NombreCliente_fac'],'windows-1252') ;
$datosCLI['primer_nombre'] = mb_strtoupper($row['PrimerNombre_fac'],'windows-1252') ;
$datosCLI['primer_apellido'] = mb_strtoupper($row['PrimerApellido_fac'],'windows-1252') ;
$datosCLI['email'] = $row['Email_fac'];
$datosCLI['type_customer'] = 2;
$datosCLI['phone'] = $row['Tel_fac'];
$datosCLI['mobile'] = $row['Cel_fac'];
$datosCLI['ref'] = $row['IDCliente'];
$datosCLI['ref_type'] = $row['ref_type'];
$datosCLI['street'] = $row['Dir_fac'];
$datosCLI['state_id'] = $row['state_id_fac'];
$datosCLI['city_id'] = $row['city_id_fac'];

$datosCLI['comment'] = "Crea Integracion $hoy";
$datosCLI['ciiu_id'] = 773;
$datosCLI['category_id'] = 20;

foreach($datosCLI AS $ti => $val ){
  $datosCLI["$ti"] = utf8_encode($val);
}
//print_r($datosCLI);die;
$datosCONT['name'] = mb_strtoupper($row['NombreCliente_env'],'windows-1252');
$datosCONT['primer_nombre'] = mb_strtoupper($row['PrimerNombre_env'],'windows-1252');
$datosCONT['primer_apellido'] = mb_strtoupper($row['PrimerApellido_env'],'windows-1252');
$datosCONT['email'] = $row['Email_env'];
$datosCONT['type_customer'] = $row['type_costumer'];
$datosCONT['phone'] = $row['Tel_env'];
$datosCONT['mobile'] = $row['Cel_env'];
$datosCONT['ref'] = $row['IDCliente'];
$datosCONT['ref_type'] = $row['$ref_type'];
$datosCONT['street'] = $row['Dir_env'];
$datosCONT['state_id'] = $row['state_id_env'];
$datosCONT['city_id'] = $row['city_id_env'];
$datosCONT['customer'] = false;
$datosCONT['comment'] = "Crea Integracion P.Web $hoy";

foreach($datosCONT AS $ti => $val ){
  $datosCONT["$ti"] = utf8_encode($val);
}

// organiza array con items asi: $lines[0] = array('order_id' => '', 'product_id'=> 83555,'name'=>'test','product_uom_qty' => 100);  
  $lines = array();
  $sqlLIN ="SELECT odoo_product_id, Cantidad, IDProducto FROM odoo_magento_orden_item WHERE 
            IDPedidoPagina = '$row[IDPedidoPagina]'
            AND
            (ValorItems > 0 OR IDProducto IN( '818190475','818142033' ))
            ";
  $resultLIN = mysqli_query($mysqliL, $sqlLIN) or die(mysqli_error($mysqliL));
  while($rowLIN = mysqli_fetch_assoc($resultLIN)){
    $rowLIN[odoo_product_id] += 0;
    $lines[] = array('order_id' => '', 'product_id'=> $rowLIN[odoo_product_id], 'product_uom_qty' => $rowLIN[Cantidad], 'InfoAdd' =>$rowLIN[IDProducto]);
  }
  if($row['ValorFlete'] > 0){
    $lines[] = array('order_id' => '', 'product_id'=> 102894, 'product_uom_qty' => 1, 'InfoAdd' =>'FLETE WEB', 'price_unit' =>$row['ValorFlete'] );
  }
//print_r($datosCLI); print_r($lines); die;
include('_create.php');

//registra exito / error en base MySQL
  if($errorCon !='' ){
    echo "<br><br><br>Error en la conexion:<br>$errorCon";
    }else{
    $hUP = date("Y-m-d H:i:s");
    $error = str_replace("'","-",str_replace('"',"--",$error));
    $sqlRES ="UPDATE odoo_magento_orden SET OrdenOdoo ='$exito', FechaIngreso = '$hUP', error ='$error' WHERE IDPedidoPagina = '$row[IDPedidoPagina]' ";
    mysqli_query($mysqliL, $sqlRES) ;
    foreach($msjLINE AS $myid => $myid_v){
       $myid_v = str_replace("'","-",str_replace('"',"--",$myid_v));
       $sqlRES ="UPDATE odoo_magento_orden_item SET OrdenOdoo = '$exito' , resultado = '$myid_v'  
                 WHERE IDPedidoPagina = '$row[IDPedidoPagina]' AND IDProducto ='$myid' ";
       mysqli_query($mysqliL, $sqlRES) or die(mysqli_error($mysqliL)." $sqlRES");
    }

}
 echo "<br>exito : $exito;";
 echo "<br>errorCon : $errorCon;";
 echo "<br>error : $error;";
 echo "<br>msjLine ".implode("->",$msjLINE)."<br>---- fin msjLINE";


if($contOVs <= 1){
 $contOVs ++;
}else{
 break;}

 }


die;
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
  
