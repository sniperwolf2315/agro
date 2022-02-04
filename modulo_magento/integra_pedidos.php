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
$localhostL 	= 	'3.233.60.4'; 	
$userA 		= 	'nzwcsjbshb';   //agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb';
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');


$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));


//if($hoy >= '2020-10-13'){ $hoy_1sem = '2021-07-15'; }

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
    , B.city as Ciudad
    , B.region as Departamento
    , A.shipping_description as tipoenvio
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
mysqli_query($mysqliL, "DELETE FROM magento_orden");
foreach($sqlINSERT AS $idPP => $ins){
  // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
  if(mysqli_query($mysqliL, $ins)){
  //nada
  }else{
  $error = mysqli_error($mysqliL)."<br> $ins<br>";
  echo $error; 
  mysqli_query($mysqliL,"INSERT INTO magento_orden_error (id, error) VALUES ('$idPP', '$error');");
  }
}
//inserta items mysql local
mysqli_query($mysqliL, "DELETE FROM magento_orden_item");
foreach($sqlINSERTitem AS $ins){
  mysqli_query($mysqliL, $ins) ; //or die(mysqli_error($mysqliL))
}

//busca codigos postales de las ordenes nuevas de Bogota 

$sqlMS = "SELECT IDPedidoPagina FROM CreacionEncabezadoVenta$prueba WHERE IDPedidoPagina IN ($ides) ";
$resultMS = mssql_query($sqlMS);
while($rowMS = mssql_fetch_row($resultMS)){
  mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = 'ya' WHERE IDPedidoPagina ='$rowMS[0]';");
  }
  
require('../_lupap.php');
    $ciudad = '';
    $_POST[barrio] ='';
    $_POST[localidad] ='';
    $_POST[dir_norm] ='';
    $_POST[post_code] ='';
 //agregado
 $idPedidoP = new ArrayIterator();
 $codLupapP = new ArrayIterator();
$ff=0;  
//require_once('user_con_magen.php');
//Vbarrio ='' AND CodigoMunicipalidad = '11001000'
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente, ciudad, Departamento, CodigoMunicipalidad FROM magento_orden WHERE Pago != 'contra' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      $idPed = trim($row[0]);   //agregado
      $direccion = $row[1];
      $direCliente=utf8_decode($direccion); //agregado
      $direClientesql=substr($direCliente,0,20); //agregado
      $idclienteord = trim($row[2]);    //agregado
      //$ciudad ='bogota';
      $ciudadaBuscar = trim($row[3]);
      //sequence
      $departamentoMg = trim($row[4]);     
      //cod municip
      $codigoMunicMg = trim($row[5]);
      
      //Reemplazamos tildes la A y a
		$ciudadaBuscar = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$ciudadaBuscar);
 
		//Reemplazamos la E y e
		$ciudadaBuscar = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$ciudadaBuscar);
 
		//Reemplazamos la I y i
		$ciudadaBuscar = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$ciudadaBuscar);
 
		//Reemplazamos la O y o
		$ciudadaBuscar = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$ciudadaBuscar);
 
		//Reemplazamos la U y u
		$ciudadaBuscar = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$ciudadaBuscar);
        
        //Reemplazamos la N, n, C y c
		$ciudadaBuscar = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$ciudadaBuscar);
      
      $ciudad=$ciudadaBuscar;
      
      //***AQUI CONSULTA TABLA agrCodigoPostal EN sqlSever para traer codigos postales o insertarlos***
      $copPostLupap="";
      $direClientesql=utf8_decode(substr($direccion,0,20)); //agregado
      $direClientesqlb=substr($direccion,0,20); //agregado
      $direClientesqlN= strtoupper(substr($direccion,0,20));
      //AND left(Direccion,20)='$direClientesql'
      // IdUsuario='$idclienteord'
      $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, Direccion as DirCliente, CodPostal as codPst  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE (left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN')");
      //$resultord = mssql_query($SqlLupa,$cLink);
      if (!mssql_num_rows($SqlLupa)) {
            //CODIGO POSTAL LUPAP
            $resultLU = geocode($ciudad, $direccion);
            $latitudLupa=$_POST[latitud];
            $longitudLupa=$_POST[longitud];
            $LocalidadLupa=utf8_decode($_POST[localidad]);
            $dirNormalizadaLupa=$_POST[dir_norm];
            $codPostaLup = $_POST[post_code];
            $barioLup = utf8_decode($_POST[barrio]);
            $cod_city = $_POST[city_code];
            if($codPostaLup != ""){
                $copPostLupap=$codPostaLup;
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud,Ciudad,Departamento) 
                VALUES('$idclienteord','$direCliente','$dirNormalizadaLupa','$LocalidadLupa','$codPostaLup','$barioLup','$latitudLupa','$longitudLupa','$ciudad','$departamentoMg')"; 
                mssql_query($sqlord,$cLink);
                $idclienteord='';
                $direCliente='';
                $dirNormalizadaLupa='';
                $LocalidadLupa='';
                $barioLup='';
                $latitudLupa='';
                $longitudLupa='';
                $departamentoMg='';
            }else{
                //$codPostaLup = '11001000';
                $codPostaLup = $codigoMunicMg;
                //$copPostLupap = '11001000';
                $copPostLupap = $codigoMunicMg;
                //$barioLup="Bogota D. C.";
                $barioLup = "";
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud,Ciudad,Departamento) 
                VALUES('$idclienteord','$direCliente','','','$codPostaLup','','0','0','$ciudadaBuscar','$departamentoMg')"; 
                mssql_query($sqlord,$cLink);
            }
      }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                //dir base
                $dirBuscarBd = $rowPed[DirCliente];
                $dirBuscarBd=trim($dirBuscarBd);
                //dir magento
                $direClienteMg=utf8_decode($direccion); //agregado
                $direClienteMg=trim($direClienteMg);
                
                $direClienteBad=substr($dirBuscarBd,0,10); //agregado
                $direClienteMag=substr($direClienteMg,0,10); //agregado
                if($direClienteBad == $direClienteMag){
                    //lee de base local codigoslupap
                    $copPostLupap = $rowPed[codPst];
                }else{
                    //consulta en lupap y actualiza codigo postal del cliente en base codigospostales por cambio de direccion
                    $resultLU = geocode($ciudad, $direccion);
                    $latitudLupa=$_POST[latitud];
                    $longitudLupa=$_POST[longitud];
                    $LocalidadLupa=$_POST[localidad];
                    $dirNormalizadaLupa=$_POST[dir_norm];
                    $codPostaLup = $_POST[post_code];
                    $barioLup = $_POST[barrio];
                    $cod_city = $_POST[city_code];
                    $copPostLupap=$codPostaLup;
                    if($codPostaLup != ""){
                        $sqlord = "UPDATE [sqlFacturas].[dbo].[agrCodigoPostal] SET Direccion='$direccion', Dirnormalizada='$dirNormalizadaLupa', Localidad='$LocalidadLupa', CodPostal='$codPostaLup', Barrio='$barioLup', Latitud='$latitudLupa', Longitud='$longitudLupa', Ciudad='$ciudad', Departamento='$departamentoMg' WHERE IdUsuario='$idclienteord'"; 
                        mssql_query($sqlord,$cLink);
                        $idclienteord='';
                        $direCliente='';
                        $dirNormalizadaLupa='';
                        $LocalidadLupa='';
                        $barioLup='';
                        $latitudLupa='';
                        $longitudLupa='';
                        $departamentoMg='';
                    }
                }
           } 
      }
      //fin AQUI*****
      //$resultLU = geocode($ciudad, $direccion);  //codigo old lino 
      //agregados new
      //if($_POST[post_code] != ""){
       if($copPostLupap != ""){
          $idPedidoP[$ff]=$idPed;
          $codLupapP[$ff]=trim($copPostLupap);
          $ff++;
      }else{
          $idPedidoP[$ff]=$idPed;
          if($ciudad == 'Bogota' || $ciudad == 'Bogotá' || $ciudad == 'bogota'){
            $codLupapP[$ff]='11001000'; 
          }else{
            $codLupapP[$ff]='';
          }
          $ff++;     
      }
      $ciudad='';
      //fin agregados new
    //mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = 'D".substr($_POST[post_code],2,2)."' WHERE IDPedidoPagina ='$row[0]';");        //lino
    mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = '".$copPostLupap."' WHERE IDPedidoPagina ='$row[0]';");
    
    /*if($copPostLupap != '11001000'){
        //mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = 'D".substr($copPostLupap,2,2)."' WHERE IDPedidoPagina ='$row[0]';");
        mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = '".$copPostLupap."' WHERE IDPedidoPagina ='$row[0]';");
    }else{
        mysqli_query($mysqliL,"UPDATE magento_orden SET vBarrio = '' WHERE IDPedidoPagina ='$row[0]';");
    }*/
    
    //ENRUTAMIENTO CLIENTES
    if($hoy >= '2020-10-06'){
    //odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='".substr($_POST[post_code],2,2)."'  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");  //lino
        //odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='".$copPostLupap."'  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
        /*
        if($copPostLupap != '11001000'){
            odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='D".$copPostLupap."'  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");  
        }else{
            odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST =''  WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
        }*/
    }
            
    
  } 


// quita destino auto enrutamiento para entrega oficina
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente FROM magento_orden WHERE Vbarrio ='G04' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='' WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
  }
//odbc_close();
//buscar ordenes local********************************************************************************************
//require_once('user_con_magen.php');
$direabuscar="";  //nuevo
$codPostLupap=""; //nuevo
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
  //agregados
  $contarLupas = count($idPedidoP);
  $idPedP=trim($idPP);
  //fin agregados
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    //nuevos
    /*if($titulo=='Direccion'){
       $direabuscar=$valor;
    }*/
    $codigoDestinoL="";
    if($titulo=='CodigoMunicipalidad'){
        $codCity=trim($valor);
        //if($codCity == '11001000' || $codCity == '011001000'){
            //nuevo ciclo
            $ff=0;
            while($ff < $contarLupas){
                if($idPedP == $idPedidoP[$ff]){
                    $valor=trim($codLupapP[$ff]);
                    $codigoDestinoL=$valor;
                    $ff=$contarLupas+1;
                }
                $ff++;
            }
      //}
    }
    if($titulo == 'vBarrio'){
       if((substr($valor,0,1) == 'G') || (substr($valor,0,1) == 'D')){
            $valor='11001000';
       }
    }
    if($titulo=='Sequence'){
        $codigoSequence=$valor;
    }
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
//aqui es
 $msqlINSERT["$idPP"] = "INSERT INTO CreacionEncabezadoVenta$prueba ($campos) VALUES ('$valores'); ";
 //new saca el codpostal y el sequence
 $cdPostalis=explode("','",$valores); 
 $campos =''; $valores='';
 //new ING. JAIRO
 $idPedPagNew=$cdPostalis[0];
 $CodPostalNew=$cdPostalis[7];
 $SequenceNew=$cdPostalis[16];
 if($CodPostalNew != '' && $SequenceNew != ''){
    $sql2 = "SELECT 
           ciudad, Departamento 
        FROM magento_orden WHERE IDPedidoPagina='$idPedPagNew'";
        $result2 = $result2 = mysqli_query($mysqliL, $sql2);
        if($row2 = mysqli_fetch_assoc($result2)){
          $ciudadP = $row2[ciudad];
          $dptoP = $row2[Departamento];
          $ciudadP2=strtoupper($ciudadP);
          $dptoP2=strtoupper($dptoP);
          $Dpto=$ciudadP2."-".$dptoP2;
          //ibs
          $resultDestino=odbc_exec($db2conp ,"SELECT *FROM AGR620CFAG.SRODST WHERE DTDEST='$CodPostalNew'");
          $rcD=odbc_num_rows($resultDestino);
          if($rcD == 0){
              $rcD=1;
              //odbc_exec($db2conp ,"UPDATE AGR620CFAG.SRODST SET DTDESC='$Dpto' WHERE DTDEST='$CodPostalNew'");           
              odbc_exec($db2conp ,"INSERT INTO AGR620CFAG.SRODST (DTDEST,DTDESC)VALUES('$CodPostalNew','$Dpto')");
          }
          $resultDestino2=odbc_exec($db2conp ,"SELECT *FROM AGR620CFAG.COBCTLDN WHERE DNMCOD='$CodPostalNew'");
          $rcD=odbc_num_rows($resultDestino2);
          if($rcD == 0){
              $rcD=1;  
              $CodCity=substr($CodPostalNew,0,2);
              //odbc_exec($db2conp ,"UPDATE AGR620CFAG.SRODST SET DTDESC='$Dpto' WHERE DTDEST='$CodPostalNew'");           
              odbc_exec($db2conp ,"INSERT INTO AGR620CFAG.COBCTLDN (DNDCOD, DNDNAM, DNMCOD, DNMNAM) VALUES ('$CodCity','$dptoP2','$CodPostalNew','$ciudadP2')");
          }
        }
 }
}
//buscar
/*
'838310047' snickers 17 30 sept
*/
//odbc_close();
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
mssql_close();
mysqli_close();
odbc_close();

?>
  
