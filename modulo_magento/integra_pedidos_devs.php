<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Dev Integra Pedidos </title>
</head>
<body>

<?php
include('../general_funciones.php');
$prueba ='TMP';
$prueba_mysql ='_d';
/* conexion my sql de usuario standard  \\/MYSQL/*/

if($prueba =='TMP'){
    echo "<center> <font size='20' color='red'>PRUEBAS HABILITADO</font></center><br><br>"; 
}

// BASE DE DATOS LOCAL AGROCAMPO PARA INTEGRAR LAS ORDENES DE MAGENTO PRODUCCION
$localhostL 	= 'localhost'	; 	
$userA 		    = 'sistemas'	;
$claveO		    =	'sistemasqgro'; 	
$base_datosL	=	'agrobase'	;
$mysqliL      = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_error()){ 
    echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); 
}

/*
 *  SERVIDOR DE DEV MAGENTO  IBS RUTAS TABLA   sbmcuutwnh
 * tiene la integracion de razon_social,tipo_doc,express,franjas
*/
/*
$localhostL	  = '164.92.100.82'; 	
$userA		    = 'sbmcuutwnh';   //agroeva
$claveO		    =	'QTBgAcy2qC*eV22'; 	
$base_datosL	=	'sbmcuutwnh';
$mysqliM      = new mysqli($localhostL,$userA,$claveO,$base_datosL);
*/ 
/* SERVIDOR BD DE AGROCAMPO */




/** SERVIDOR DE DEV MAGENTO  IBS  RAZON SOCIAL TABLA   bduufggxgg*/
/*
*/
$localhostL	  = '164.92.100.82'; 	
$userA		    = 'thxazeaznm';   //agroeva
$claveO		    =	'DDtk83xUUy'; 	
$base_datosL	=	'bduufggxgg';
$mysqliM      = new mysqli($localhostL,$userA,$claveO,$base_datosL);

  
  
  //magento 2 2da ver
  /*
  // $localhostL 	= '3.233.60.4'; 	
  // $userA 		    = 'nzwcsjbshb';   //agroeva
  // $claveO		    =	'k4SCnVuThJ'; 	
  // $base_datosL	=	'nzwcsjbshb';
  // $mysqliM      = new mysqli($localhostL,$userA,$claveO,$base_datosL);
  
  */

$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
// $db2con  = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');


$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));
// $hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 day"));


$año_actual = date('Y');
$mes_actual = date('m');
// echo remove_characters('pruebas ´p´p < as> asdasdó');

//if($hoy >= '2020-10-13'){ $hoy_1sem = '2021-07-15'; }
$hini = date("Y-m-d H:i:s");

/* 
04-11-2022 ERIK CIFUENTES
ORDENES QUE YA ESTAN EN SQL SERVER QUE NO DEBEN SER CONSULTADAS NUEVAMENTE EN IBS*/
// $existe_ped_sql = mssql_query("select distinct(IDPedidoPagina) from CreacionEncabezadoVenta$prueba where YEAR(FechaIngreso)=year(GETDATE()) and MONTH(FechaIngreso)=MONTH(GETDATE()) and day(FechaIngreso)>=day(GETDATE())-1");
$existe_ped_sql = mssql_query("select distinct(IDPedidoPagina) from CreacionEncabezadoVenta$prueba");
$no_incluir ='';


while($a = mssql_fetch_array($existe_ped_sql)){
  $no_incluir = $no_incluir.intval($a[IDPedidoPagina]).","; 
}
$no_incluir= substr($no_incluir,0,-1);



if(strlen($no_incluir)<=0 || $no_incluir==' ' ):
  $no_incluir_clausula='';
else:
  $no_incluir_clausula="AND A.entity_id not in ($no_incluir)";
endif;


// MAGENTO SACA DATOS DE ENCABEZADO DE ORDEN DE $HOY
/* ESTE SELECT YA INCORPORA EN LA BASE SBMCUUT 
    NO EXISTE LA TABLA AADDO EN BDUUFGG
1 RAZON SOCIAL
2 GRUPO COMPRADORES
3 ENVIO EXPRES
4 FRANJAS HORARIAS

*/
$sql ="SELECT
DISTINCT 
A.entity_id AS IDPedidoPagina ,
if(customer_taxvat IS NULL,vat_id,customer_taxvat) as IDCliente,
CONCAT(customer_firstname,' ',customer_lastname) NombreCliente,
'0' AS Estado ,
street AS Direccion ,
fax AS Telefono ,
telephone AS Celular ,
IF(postcode = '011001000',
'11001000',
postcode) AS CodigoMunicipalidad ,
customer_email AS Email ,
'' AS IDordenAgro ,
'' AS IDestadoAgro ,
'' AS IDDescEstado ,
'' AS IDFacturaAgro ,
grand_total AS ValorOrden ,
A.shipping_amount AS ValorFlete ,
IF(shipping_method = 'amstrates_amstrates1' ,'G01',
IF(shipping_method = 'amtable_amtable13'    ,'G03',
IF(shipping_method = 'amstrates_amstrates14','G04',
IF(shipping_method = 'amstrates_amstrates15','G05',
IF(shipping_method = 'amstrates_amstrates16','G04-4',
IF(shipping_method = 'amstrates_amstrates18','G08',
IF(shipping_method = 'amstrates_amstrates19','G09',
''))))))) AS vBarrio ,
A.increment_id AS Sequence ,
A.created_at AS Fecha ,
'0000-00-00' AS FechaIngreso ,
'0000-00-00' AS FechaFacturacion ,
if(A.status = 'ondelivery',	'contra',substr(C.comment, 1, 8)) AS Pago ,	
base_discount_amount *-1 AS Descuento ,
coupon_code AS TipoDesc ,
CONCAT(if(coupon_code IS NULL, '', CONCAT('Dto ', coupon_code, ': $', CAST(base_discount_amount AS SIGNED), ' ')), IFNULL((SELECT concat('Cliente escribe: ', comment) FROM agro_sales_order_status_history WHERE parent_id = A.entity_id AND status IS NULL AND is_customer_notified = 1 AND is_visible_on_front = 1), '' )) AS Notas ,
B.city as Ciudad ,
B.region as Departamento ,
A.shipping_description as tipoenvio ,
ifnull(A.customer_group_id, 0) as group_id ,
aaddo.date as FechaEntrega ,
aaddo.time_from as Ruta,
aaddo.comment as Comentario,
(case 
  WHEN acei.value  is not null then acei.value  
  else aacag.id_type end
) TipoDocumento
FROM
agro_sales_order A
JOIN agro_sales_order_address B 			      			          ON A.shipping_address_id = B.entity_id
JOIn agro_sales_order_payment asop 			      			        on asop.parent_id  = A.entity_id 
LEFT JOIN agro_sales_order_status_history C       			    ON C.parent_id = A.entity_id AND C.status = 'processing'
LEFT JOIN agro_customer_entity ent 			      			        ON ent.taxvat = A.customer_taxvat
LEFT JOIN agro_customer_entity_int acei 		  			        ON acei.entity_id = ent.entity_id 
LEFT JOIN agro_customer_entity_varchar acev 	  			      ON acev.entity_id = A.entity_id 
LEFT JOIN agro_amasty_deliverydate_deliverydate_order aaddo ON aaddo.order_id = A. entity_id
LEFT join agro_amasty_customer_attributes_guest aacag 		  on aacag.order_id = A.entity_id
WHERE 
(( A.status = 'processing'	AND substr(C.comment, 1, 8)= 'APPROVED' )	OR A.status = 'ondelivery' ) 
and A.created_at >='$hoy_1sem'
$no_incluir_clausula
"; 

// echo "$sql  <br><br><hr> " ;
// return;

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
  
 $sqlINSERT["$idPP"] = "INSERT INTO magento_orden$prueba_mysql ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

$sql = "SELECT
       order_id AS IDPedidoPagina
    ,  sku      AS IDProducto
    ,  qty_ordered AS Cantidad
    , '0' AS Estado
    , ''  AS  IDOrdenAgro
    , base_price AS ValorItems
    , free_shipping
    FROM agro_sales_order_item
    LEFT JOIN agro_sales_order b ON order_id = entity_id 
    WHERE
    order_id IN($ides)
    ";


$result = mysqli_query($mysqliM, $sql);
while($row = mysqli_fetch_assoc($result)){
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERTitem[] = "INSERT INTO magento_orden_item$prueba_mysql ($campos) VALUES ('$valores'); ";
 $campos =''; 
 $valores='';
}

//inserta encabezados mysql local
mysqli_query($mysqliL, "DELETE FROM magento_orden$prueba_mysql");
foreach($sqlINSERT AS $idPP => $ins){
    // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins"); /** ESTA LINEA DUPLICA LOS INSERT MAGENTO_ORDEN */
  if(mysqli_query($mysqliL, $ins)){
  // echo $ins;
  }else{
  $error = mysqli_error($mysqliL)."<br> $ins<br>";
  echo $error; 
  mysqli_query($mysqliL,"INSERT INTO magento_orden_error (id, error) VALUES ('$idPP', '$error');");
  }
}



//inserta items mysql local
mysqli_query($mysqliL, "DELETE FROM magento_orden_item$prueba_mysql");
foreach($sqlINSERTitem AS $ins){
  mysqli_query($mysqliL, $ins) ;// or die(mysqli_error($mysqliL));
}

//busca codigos postales de las ordenes nuevas de Bogota 

$sqlMS = "SELECT IDPedidoPagina FROM CreacionEncabezadoVenta$prueba WHERE IDPedidoPagina IN ($ides) ";
$resultMS = mssql_query($sqlMS);
while($rowMS = mssql_fetch_row($resultMS)){
  mysqli_query($mysqliL,"UPDATE magento_orden$prueba_mysql SET vBarrio = 'ya' WHERE IDPedidoPagina ='$rowMS[0]';");
  }
  
// require('../_lupap.php');
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
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente, ciudad, Departamento, CodigoMunicipalidad FROM magento_orden$prueba_mysql WHERE Pago != 'contra' ";
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

    $ciudadaBuscar = strval($ciudadaBuscar);
    $ciudad= remove_characters( $ciudadaBuscar );
      // =$ciudadaBuscar;

      //***AQUI CONSULTA TABLA agrCodigoPostal EN sqlSever para traer codigos postales o insertarlos***
      $copPostLupap="";
      $direClientesql=utf8_decode(substr($direccion,0,20)); //agregado
      $direClientesqlb=substr($direccion,0,20); //agregado
      $direClientesqlN= strtoupper(substr($direccion,0,20));
      $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, Direccion as DirCliente, CodPostal as codPst  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE (left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN')");
      $resultord = mssql_query($SqlLupa,$cLink);
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
      
       if($copPostLupap != ""){
          $idPedidoP[$ff]=$idPed;
          $codLupapP[$ff]=trim($copPostLupap);
          $ff++;
      }else{
          $idPedidoP[$ff]=$idPed;
          if($ciudad == 'Bogota' || $ciudad == 'Bogot�' || $ciudad == 'bogota'){
            $codLupapP[$ff]='11001000'; 
          }else{
            $codLupapP[$ff]='';
          }
          $ff++;     
      }
      $ciudad='';
      //fin agregados new
    
  } 


// QUITA DESTINO AUTO ENRUTAMIENTO PARA ENTREGA OFICINA
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente FROM magento_orden$prueba_mysql WHERE Vbarrio ='G04' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      // odbc_exec($db2conp ,"UPDATE SRONAD SET ADDEST ='' WHERE ADNUM = '$row[2]' AND ADADNO  = 1");
  }


$direabuscar="";  //nuevo
$codPostLupap=""; //nuevo
/**EN ESTE SELECT VAMOS A LLAMAR LOS CAMPOS A INSERTAR A SQL SERVER */
$sql = "SELECT IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha,Pago,Descuento,Notas, group_id,FechaEntrega,Ruta,Comentario,TipoDocumento FROM magento_orden$prueba_mysql ";
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
    
    $codigoDestinoL="";
    if($titulo=='CodigoMunicipalidad'){
        $codCity=trim($valor);
            $ff=0;
            while($ff < $contarLupas){
                if($idPedP == $idPedidoP[$ff]){
                    $valor=trim($codLupapP[$ff]);
                    $codigoDestinoL=$valor;
                    $ff=$contarLupas+1;
                }
                $ff++;
            }
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
    $sql2 = "SELECT ciudad, Departamento FROM magento_orden$prueba_mysql WHERE IDPedidoPagina='$idPedPagNew'";
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
              odbc_exec($db2conp ,"INSERT INTO AGR620CFAG.SRODST (DTDEST,DTDESC)VALUES('$CodPostalNew','$Dpto')");
          }
          $resultDestino2=odbc_exec($db2conp ,"SELECT *FROM AGR620CFAG.COBCTLDN WHERE DNMCOD='$CodPostalNew'");
          $rcD=odbc_num_rows($resultDestino2);
          if($rcD == 0){
              $rcD=1;  
              $CodCity=substr($CodPostalNew,0,2);
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
$sql = "SELECT * FROM magento_orden_item$prueba_mysql WHERE ValorItems > 0 OR free_shipping > 0";
//$sql = "SELECT * FROM magento_orden_item_d WHERE ValorItems > 0 OR IDProducto IN('818142136','818190475','818142033','868620691','868620692','838310058','838310047')"; //,'868620691','868620692'
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

   /* 20220714 CIFUENTESE ESTE FRAGMENTO DE CODIGO REGISTRARA EL RESULTADO DEL Arreglo */
  // TODO:DESOCMENTAR
  // include('class_logs.php');
  // log::crear_logs($nombre_arch, $msqlINSERTitem);
}

//inserta encabezados MSsql
foreach($msqlINSERT AS $idP => $ins){
  
  if(mssql_query($ins)){
   $contEncabezados += 1;
   $encabezados .= ", $idP";
    foreach($msqlINSERTitem["$idP"] AS $insItem){
      //inserta items de encabezados MSsql
      if(mssql_query($insItem)){
        /** SI LA CONDICION ES VERDADERA MUESTA EL INSERT */
        // echo "Grabo $insItem <br>";
      }else{
        echo "Error $insItem <br>".mssql_get_last_message()."<br>";
      }
    }
    
  }else{
  echo "<br> Else error  <br> $ins<br>".mssql_get_last_message()."<br>";
  }
}

//guarda log
if(strlen($encabezados) > 0 ){
 mysqli_query($mysqliL," INSERT INTO magento_orden_log$prueba (reg_guardados, hora_i, cant_reg) VALUES ('$encabezados', '$hini' , '$contEncabezados')") ;
}

/* se eliminan las ordenes duplicadas de la tabla CreacionItemsVenta  */
/** 
 * 04-11-2022 se asigna esta regla dado que estan llegando ordenes duplicadas 
 * */
$sql_elimina_duplicado = ("
WITH C AS
 (
  SELECT 
   IDPedidoPagina
  ,idproducto
  ,Cantidad
  ,Estado
  ,IDOrdenAgro
  ,ValorItems
  ,free_shipping
  ,FechaRegistro
  ,ROW_NUMBER() OVER (PARTITION BY IDPedidoPagina,idproducto ORDER BY IDPedidoPagina) AS DUPLICADO
  --FROM #tblpruebas
  FROM CreacionItemsVenta$prueba 
  WHERE YEAR(FECHAREGISTRO)=$año_actual  AND MONTH(FECHAREGISTRO)=$mes_actual 
 )
 DELETE FROM C WHERE DUPLICADO > 1;
");

mssql_query($sql_elimina_duplicado);

mssql_close();
mysqli_close();
odbc_close();
// echo "Todo con exito";
?>
 </body>
</html>