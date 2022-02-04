<? 
//session_start();
if(session_start()===FALSE){
    session_start();
}
//include("../../user_con.php"); 
//echo "Favor bajar el informe por la plataforma de consulta de pedidos, BOTON (VERIFICAR ORDENES PAGINAS WEB) mediante la url: http://sia.agrocampo.vip/modulo_pedidos/";
//exit();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<link rel="stylesheet" type="text/css" href="../../antenna.css" id="css">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >


<style type="text/css">
td{
	padding-top:3px;
	padding-bottom:3px;
}
.campo{
	border:none;
	background-color:transparent;
	border-bottom-style:groove;
	border-bottom-width:thin;
	border-bottom-color:lightblue;
	border-radius:0;
	width:90%
	}
</style>



</head>


<? 
//$prueba ='TMP';
//if($isset[$_POST['boton-ver']]){
    
if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }
// MySQL local

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento

/*$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

$localhostL 	= 	'67.225.141.97'	; 	
$userA 		= 	'agrocom'	;//agroeva
$claveO		=	'M4scot4$-F1nalSv2018=!'; 	
$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
*/

$localhostL 	= 	'3.233.60.4'	; 	
$userA 		= 	'nzwcsjbshb'	;//agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

$hoy = date("Y-m-d");
$manana = date("Y-m-d", strtotime("$hoy + 1 day"));
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

foreach($_POST AS $ti => $va){
$_POST["$ti"] =  trim(preg_replace('/\s+/', ' ', str_replace("'", '', str_replace('"', '', $va))));
}



if($_POST['desde']==''){$_POST['desde'] = $manana ; }  //$hoy
  $desde5 = date("Y-m-d H:i:s",strtotime("$_POST[desde] + 5 hour"));
  //$desde5 = date("Y-m-d H:i:s",strtotime("$_POST[desde] + 29 hour"));
if($_POST['hasta']==''){$_POST['hasta'] = $manana ; }
  $hasta5 = date("Y-m-d H:i:s",strtotime("$_POST[hasta] + 29 hour")); 
if($_POST['estado']==''){$_POST['estado'] = 'processing,ondelivery' ;}
//if($_POST['estado']=='TODAS'){$_POST['estado'] = '' ;$valTodas = "value=''";}

// filtros
$filtros .= " AND (created_at BETWEEN '$desde5' AND '$hasta5') "; 
$filtrosLO .= " AND (Fecha BETWEEN '$_POST[desde] 00:00' AND '$_POST[hasta] 23:59:59') ";
if($_POST['estado'] != 'TODAS'){
  $_POST['estado'] = str_replace(",","','",$_POST['estado']);
  $filtros .= " AND status IN ('$_POST[estado]') " ;
  $filtrosLO .= " AND Estado IN ('$_POST[estado]') " ;
  }
  $_POST['estado'] = str_replace("','",",",$_POST['estado']);
if($_POST['cc'] != ''){
  $filtros .= " AND if(customer_taxvat IS NULL,ship.vat_id,customer_taxvat) = '$_POST[cc]' " ;
  $filtrosLO .= " AND IDCliente = '$_POST[cc]' " ;
  }
if($_POST['pedido'] != ''){
  $ceros = str_repeat('0', (9-strlen($_POST[pedido])));
  $filtros = " AND increment_id = '$ceros$_POST[pedido]' " ;
  $filtrosLO = " AND Pedido = '$_POST[pedido]' " ;
  }   
// MAGENTO SACA DATOS DE ENCABEZADO DE ORDEN DE $HOY
//$consultar_lupap=$_GET['boton-ver'];
//echo "aqui 1".$consultar_lupap;



$sql = substr(base64_encode(date("siHdmY")),0,5)."SELECT 
      increment_id AS Pedido
    , status AS Estado  
    , if(customer_taxvat IS NULL,ship.vat_id,customer_taxvat)  AS IDCliente
    , '' AS Orden
    , '' AS Factura
    , CONCAT(ship.firstname,' ',ship.lastname) AS NombreCliente_env
    , ship.street AS Dir_env
    , ship.city AS Ciudad_env
    , '' AS Barrio_env
    , '' AS Localidad_env
    , '' AS Dir_env_norm
    , '' AS Post_code_env
    , ship.fax AS Tel_env
    , ship.telephone AS Cel_env
    , if(length(ship.postcode) = 9, substr(ship.postcode,2),ship.postcode) AS CodMun_env
    , ship.email AS Email_env
    
    , CONCAT(bill.firstname,' ',bill.lastname) AS NombreCliente_fac
    , bill.street AS Dir_fac
    , bill.city AS Ciudad_fac
    , bill.fax AS Tel_fac
    , bill.telephone AS Cel_fac
    , if(length(bill.postcode) = 9, substr(bill.postcode,2),bill.postcode) AS CodMun_fac
    , bill.email AS Email_fac

    , grand_total AS ValorOrden
    , shipping_amount AS ValorFlete
    , IF(shipping_method = 'amtable_amtable13','G03',IF(shipping_method = 'amstrates_amstrates14','ALMACEN','')) AS vBarrio
    
    , created_at AS Fecha
    , '$_SESSION[usuARio]' AS user
    FROM agro_sales_order A 
    inner join
    agro_sales_order_address ship  on A.shipping_address_id = ship.entity_id
    inner join
    agro_sales_order_address bill  on A.billing_address_id = bill.entity_id

    WHERE 
    1 = 1
    $filtros
     
    ";

//echo "<br><br><br>$sql<br><br><br><br>"; die;
$result = mysqli_query($mysqliM, substr($sql,5)) or die("<br> error : ".mysqli_error($mysqliM));
require('../../_lupap.php');

while($row = mysqli_fetch_assoc($result)){
  
  //$row['Fecha'] = date("Y-m-d H:i:s",strtotime("$row[Fecha] - 5 hour"));

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
  $camposSQLl = "$campos|$filtrosLO"; 
  $sqlINSERT[] = "INSERT INTO temp_OVmagento ($campos) VALUES ('$valores'); ";
  $campos =''; $valores='';

}

//inserta encabezados mysql local

mysqli_query($mysqliL, "DELETE FROM temp_OVmagento WHERE Estado !='processing' ");
foreach($sqlINSERT AS $ins){
  // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
  if(mysqli_query($mysqliL, $ins)){
    //none
    }else{
    //echo mysqli_error($mysqliL)."<br> $ins<br>"; 
    }
}

// buscar # ordene SISTEMA y if lupa 
  /*$sql = "SELECT Pedido, Orden, Factura, Barrio_env, Dir_env, Post_code_env, CodMun_env, (SELECT max(Barrio_env) FROM temp_OVmagento B WHERE B.IDCliente = A.IDCliente AND B.Dir_env = A.Dir_env ) AS Barrio_reuse 
          FROM temp_OVmagento A WHERE Estado IN('Processing','complete','ondelivery') $filtrosLO AND ( Orden IS NULL or Barrio_env ='') ";
          */
  $sql="
    SELECT A.Pedido, A.Orden, A.Factura, A.Barrio_env, A.Dir_env, A.Post_code_env, A.CodMun_env, B.Barrio_reuse
     FROM temp_OVmagento A 
    JOIN

    (SELECT IDCliente, Dir_env, MAX( Barrio_env ) AS Barrio_reuse 
     FROM temp_OVmagento GROUP BY IDCliente, Dir_env ) as B

     ON B.IDCliente = A.IDCliente AND B.Dir_env = A.Dir_env
    WHERE Estado IN('Processing','complete','ondelivery') $filtrosLO AND ( Orden IS NULL or Barrio_env ='')
  ";
  
  //echo $sql; die;
  $result = mysqli_query($mysqliL, $sql);
  while($row = mysqli_fetch_assoc($result)){
    if($row['Orden'] =='' OR $row['Factura'] ==''){
      $ordenes[] = $row['Pedido'];
    }
    
    if($row['Barrio_env'] ==''){
      $ped = $row['Pedido'];
      $barrios["$ped"] = $row['CodMun_env'];
      $dirs["$ped"] = $row['Dir_env'];
      $codes["$ped"] = $row['Post_code_env'];
      $barrios_reuse["$ped"] = $row['Barrio_reuse'];
    }

  }

  foreach($ordenes AS $orden){
  $sql = "SELECT TOP 1 idordenagro, IDFACTURAAGRO FROM CreacionEncabezadoVenta WHERE sequence ='$orden' "; //echo"<br>$sql";
  $result = mssql_query($sql);
  $res = mssql_fetch_row($result);
  mysqli_query($mysqliL,"UPDATE temp_OVmagento SET Orden ='$res[0]', Factura='$res[1]' WHERE Pedido ='$orden'");
  }
  //actualiza barrios ya guardados o lupap
  foreach($barrios AS $ped => $mun){
    
    $ciudad = '';
    $_POST[barrio] ='';
    $_POST[localidad] ='';
    $_POST[dir_norm] ='';
    $_POST[post_code] =''; 
       
    if($barrios_reuse["$ped"] !=''){
    // busca barrios ya guardados
    $sql ="SELECT Barrio_env AS barrio, Localidad_env AS localidad, Dir_env_norm AS dir_norm, Post_code_env AS post_code
           FROM temp_OVmagento WHERE Barrio_env = '$barrios_reuse[$ped]' ORDER BY Barrio_env DESC LIMIT 0,1";
    $result = mysqli_query($mysqliL,$sql);
    $reuse = mysqli_fetch_assoc($result);
    $_POST[barrio] = $reuse['barrio'];
    $_POST[localidad] = $reuse['localidad'];
    $_POST[dir_norm] = $reuse['dir_norm'];
    $_POST[post_code] = $reuse['post_code'];
    }
    
    //busca en lupap
    if($_POST['lupap'] =='SI' 
       AND $_POST[barrio] ==''
       AND substr($barrios["$ped"],0,5) == '11001'
       ){
    
      $direccion = $dirs["$ped"];
      $ciudad ='bogota';
      $direClientesql=utf8_decode(substr($direccion,0,20)); //agregado
      $direClientesqlb=substr($direccion,0,20); //agregado
      $direClientesqlN= strtoupper(substr($direccion,0,20));
      //aqui consulta baselupap por codusuario ingjairo
      //if($city == 'Bogotá D.C.'){
        $barioLup="";
        $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, CodPostal as codPst, Barrio as Barriolup, Localidad As localidad, Dirnormalizada as dirnorm FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE (left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN')",$cLink);
        if (!mssql_num_rows($SqlLupa)) {
            $resultLU = geocode($ciudad, $direccion); 
            $latitudLupa=$_POST[latitud];
            $longitudLupa=$_POST[longitud];
            $LocalidadLupa=utf8_decode($_POST[localidad]);
            $dirNormalizadaLupa=$_POST[dir_norm];
            $codPostaLup = $_POST[post_code];
            $barioLup = utf8_decode($_POST[barrio]);
            $cod_city = $_POST[city_code];
            //$codPostaLup = $_POST[post_code];
            $barioLup = $_POST[barrio]; 
            if($codPostaLup != ""){
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud,Ciudad,Departamento) 
                VALUES('0','$direccion','$dirNormalizadaLupa','$LocalidadLupa','$codPostaLup','$barioLup','$latitudLupa','$longitudLupa','$ciudad','Bogotá D.C.')"; 
                mssql_query($sqlord,$cLink);
            }else{
                //$codPostaLup = $codigoMunicMg;
                $copPostLupap = '11001000';
                //$barioLup="Bogota D. C.";
                $barioLup = "";
                $sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud,Ciudad,Departamento) 
                VALUES('0','$direccion','','','$copPostLupap','','0','0','bogota','Bogotá D.C.')"; 
                mssql_query($sqlord,$cLink);
            }
        }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                $barioLup = utf8_encode($rowPed[Barriolup]);
                $localidadLup = utf8_encode($rowPed[localidad]);
                $dirnormLup = utf8_encode($rowPed[dirnorm]);
                $codpostLup = utf8_encode($rowPed[codPst]);
                $_POST[barrio]=$barioLup;
                $_POST[localidad]=$localidadLup;
                $_POST[dir_norm]=$dirnormLup;
                $_POST[post_code]=$codpostLup;
            } 
        }  
      //fin aqui
      //$resultLU = geocode($ciudad, $direccion);       //old lino
    }
   
   //actualzia lo que se encuentre
   if($_POST[barrio] != '' || $barioLup != ''){
        $sql ="UPDATE temp_OVmagento SET 
                          Barrio_env = '$_POST[barrio]' 
                         ,Localidad_env= '$_POST[localidad]'
                         ,Dir_env_norm= '$_POST[dir_norm]'
                         ,Post_code_env= '$_POST[post_code]'
                         WHERE Pedido ='$ped'";
   mysqli_query($mysqliL,$sql);// or die(mysqli_error($mysqliL)."<br>$sql");
   } 
  }
  //echo $camposSQLl."<br>---<br>";
  $cyf = explode("|",$camposSQLl);
  $sql ="SELECT $cyf[0] FROM temp_OVmagento WHERE 1=1 $cyf[1] ORDER BY Pedido DESC";
  //echo $sql; die;
  $result = mysqli_query($mysqliL,$sql); // or die(mysqli_error($mysqliL)."<br> - $camposSQLl<br>-- $sql");
  while($row = mysqli_fetch_assoc($result)){
    foreach($row AS $titulo => $valor){ 
      $pedidos["$titulo"][] = utf8_encode($valor);
    }
  $conB64 = base64_encode($sql);
  }
//}
  mssql_close();
?>

<body class="global">
<section>
<form id="frm1" class="Aabs" action="integra_lupa.php" method="post" name="frm1" enctype="multipart/form-data" autocomplete="off" >

<table width="100%" class="frr">
  <tr>
    <td>Desde</td>
    <td><input type="date" class="frr campo" id="desde" name="desde" value="<?= $_POST['desde']?>" ></td>
  </tr>
  <tr>
    <td>Hasta</td>
    <td><input type="date" class="frr campo" id="hasta" name="hasta" value="<?= $_POST['hasta']?>" ></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><select class="frr campo" id="estado" name="estado">
        <option><?= $_POST['estado']?></option>
        <option>pending</option>
        <option>complete</option>
        <option>ondelivery</option>
        <option>processing,ondelivery</option>
        <option>processing</option>
        <option>billed</option>
        <option>canceled</option>
        <option>TODAS</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Cedula</td>
    <td><input type="number" class="frr campo" id="cc" name="cc" value="<?= $_POST['cc']?>" ></td>
  </tr>
  <tr>
    <td># Pedido</td>
    <td><input type="number" class="frr campo" id="pedido" name="pedido" value="<?= $_POST['pedido']?>" ></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input type="checkbox" class="frr" id="lupap" name="lupap" value="SI">Barrios-Localidades LUPAP <br>(*ojo* tiene costo)</td>
  </tr>
  <tr align="center">
    <td colspan="2"><input onclick="this.form.submit();" type="button" class="frr" id="boton-ver" name="boton-ver" value=" VER "></td>
  </tr>

</table>
</form>
<form id="frm2" class="Aabs" action="integra_lupa_csv.php" method="post" name="frm2" enctype="multipart/form-data" autocomplete="off" >
<br>
<br>
<? if(count($pedidos) > 0){ ?>
<table width="100%"  class="frr">
  <tr>
    <th>Descargar CSV</th>
  </tr>
  <tr>
    <td align="center">
    <input type="hidden" id="CONsu" name="CONsu" value="<?= $conB64?>">
    </td>
  </tr>
  <tr>
    <th><input onclick="this.form.submit(); document.getElementById('lupap').checked = false;" type="button" class="frr" id="boton-ver" name="boton-ver" value=" DESCARGAR "></th>
  </tr>
</table>
<? } ?>
</form>

</section>

<section23>
<div class="aut" style="width:100%; height:100%">
<table cellspacing="0" class="frr" style=" border:thin; border-color:gray; border-style:groove;">
  <?
  echo "<tr bgcolor='LIGHTGRAY'>";
  foreach($pedidos AS $titulos => $valores){
  echo "<th>$titulos</th>";
  }
  echo "</tr>";
  $color = 'WhiteSmoke';
  for( $i=0 ; $i<count($pedidos["$titulos"]) ; $i++){
    if($color == ''){
      $color = 'GAINSBORO';
      }else{
      $color = '';
      }
    echo "<tr bgcolor='$color'>";
    foreach($pedidos AS $titulos => $valores){
      echo "<td style='padding-left:3px; padding-right:3px; border-left-width:thin; border-left-style:groove; border-left-color:grey; border-radius:0;'>".$pedidos["$titulos"]["$i"]."</td>";
    }
    echo "</tr>";
  }
  
  ?>
</table>
</div>

</section23>

</body>
</html>

  
