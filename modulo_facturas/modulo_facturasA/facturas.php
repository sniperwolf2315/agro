<? session_start();
//$prueba = "TMP"; 
if($_POST['tipo'] == 'SALE')
    {
    header("location:../user_conect_ver_la.php"); die;
    }
require('../user_con.php');

$seg_portos_arr = array('6','9','10');
$seg_73_arr = array('12');
$ip = explode(".",$_SERVER['REMOTE_ADDR']);
if(in_array( $ip[2], $seg_73_arr)){ $bodega ='005'; }
if(in_array( $ip[2], $seg_portos_arr)){ $bodega ='008'; }
$bodega1 = substr($bodega,2,1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<title>FACTURAS</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">

<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">

<style type="text/css" media="print">
.nover {display:none}
</style>
<link rel="stylesheet" type="text/css" href="../antenna.css" id="css">
<script src="../aajquery.js"></script>
<link rel="stylesheet" href="../aajquery.css" >

<style type="text/css">
.frr {
		font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;	
		font-size:63px;
		max-width:90%
		}
</style>

<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show();
    });
    
    $(".verloaderB").change(function(){
        $(".loader").show();
    });
    
    $(".select2").select2(); 
});

$(window).load(function() {
    $(".loader").fadeOut("slow");
});


$(window).load(function() {
	document.getElementById('ancho').value = screen.width;
	});


function setReadonly()
{
    var myElement = document.getElementById("fact");
    myElement.readOnly = true;
    
}

function sleepFor( sleepDuration ){
    var now = new Date().getTime();
    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
}
</script>

<?
$hoy_1h = date("Y-m-d ");
$hoy_1h .= date("H")-1;
$hoy_1h .= date(":i");

$_POST[fact] = strtoupper($_POST[fact]);

$autofocusF = "autofocus" ;
$autofocusG = "" ;

$fact = substr($_POST[fact],2);
$tipo = strtoupper(substr($_POST[fact],0,2));

$msjYAREG = "<div style='border-style:groove; border-color:silver; height:20%'>
                       <font color='silver'>------------</font> <br/> Ingrese <br/><font color='silver'>Factura  <br/>------------</font> 
                     </div>";

//valida campos
if($_POST['placanew'] != ''){
	if(strpos($_POST['placanew']," ")){ echo "<script>alert('LA PLACA NO PUEDE TENER: ESPACIOS ')</script>"; $_POST['placa'] = 'OTRA'; }
	elseif(strpos($_POST['placanew'],"-")){echo "<script>alert('LA PLACA NO PUEDE TENER: - ')</script>"; $_POST['placa'] = 'OTRA'; }
	elseif(strlen($_POST['placanew']) > '6'){echo "<script>alert('LA PLACA NO PUEDE TENER MAS DE 6 CARACTERES')</script>"; $_POST['placa'] = 'OTRA'; }
	else{ 
	    $_POST['placa'] = $_POST['placanew']."(nueva)"; 
	    }
	}
			  
//valida existencia de la factura IBS
if($_POST[fact] != ''){
  $encontrada = 'NO';
  $sql ="select SRBISH.IHINVN AS FACT FROM SROISH SRBISH
         LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
         where SRBISH.IHINVN = '$fact' AND SRBSOH.OHORDT ='$tipo'";
  $result = odbc_exec($db2conp, $sql); echo odbc_errormsg(); 
  while($row = odbc_fetch_array($result)){
	$encontrada = 'SI';
    }
  if($encontrada == 'NO'){ $_POST[fact] = ''; }
}

//consulta la factura en MSsql, que no haya sido registrada
  $sql ="select nombres, valor, fecha from facregistrofactura$prueba WHERE CONCAT(TIPO,FACTURA)='$_POST[fact]' AND Ingresa ='0'";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{
	$row[valor] = number_format($row[valor],0,',','.'); 
	$msjYAREG = "<div  style='border-style:groove; border-color:pink; height:20%'>
	             <font color='RED'>------------</font> <br/> Factura $row[nombres]  $ $row[valor] <br/><font color='red'>YA REGISTRADA <br/> $row[fecha] <br/>-----------</font> 
	             </div>
	             ";
	$_POST[fact] ='';
	$fact = '';
	$tipo = '';
	}
	
//en quemado busca guia, valor guia
if($_POST['tipo'] == 'CARGA' AND $_POST['fact'] != ''
  AND $_POST['guia'] == '' AND $_POST['vlrguia'] == ''
  ){
  $sql ="select guia, valorguia from facregistroetiqueta WHERE FACTURAS ='$_POST[fact]'";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{
	$_POST['guia'] = $row["guia"];
	$_POST['vlrguia'] = "$row[valorguia]";
	}
  
  }// fin busca guia
if( $_POST['tipo'] == 'CARGA' AND $_POST['fact'] !='' AND
    ($_POST['guia'] == '' OR $_POST['vlrguia'] == '')
   ){
      $msjYAREG = "<div style='border-style:groove; border-color:orange; height:20%'>
	                 <font color='darkorange'> ------------ </font><br/> Ingrese <br/>
	                 <font color='darkorange'> Guia y $ Guia <br/> ------------ </font> 
	                </div>";
	  $autofocusF = "" ;
      $autofocusG = "autofocus" ;				
    }

$errores = 0;

//campos obligatorios
$camposQ = array('fact');
$camposC = array('placa','tte','fact','guia','vlrguia');

//que formulario se controlara
if($_POST['tipo'] == 'QUEMADO' ){
  $camposQC = $camposQ;
  }elseif($_POST['tipo'] == 'CARGA' ){
    $camposQC = $camposC;
  }else{
    $camposQC = array('1');
  }

//recorre los campos del formulario a controlar  
foreach($camposQC AS $campo){
  if($_POST["$campo"] == ''){ $color["$campo"] = "RED;border-width:2;"; $errores += 1; }
}

//mssql_connect
//    $cLink = mssql_connect('10.10.0.5', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message());
//    mssql_select_db('SqlFacturas',$cLink);



//VALIDA Y GUARDA
if( $_POST['tipo'] == $_POST['tipoH'] AND $errores == 0 ){
  
  $_POST['facs'] = $fact;
  $sql = "SELECT 
            IHINVN AS FACTURA
	        ,trim(NANAME)AS NOMBRES
	        ,trim(IHCUNO) AS CEDULA
	        ,OHORDT AS TIPO
	        ,NAADR2 AS DIRECCION
	        ,NFPHNO AS TELEFONO
	        ,trim(NANSNO) AS CELULAR
	        ,IHORNO AS ORDEN
	        ,IHIAIT AS VALOR
	        ,IHSALE AS VENDEDOR
				
	      FROM VISINFOFACT 
	      WHERE IHINVN = '$fact' AND OHORDT ='$tipo' ";
  //echo $sql;            
  $result = odbc_exec($db2conp, $sql); //echo odbc_errormsg();
  while($row = odbc_fetch_array($result)){  
          $encontrada = 'SI';
	      $_POST[vend] = $row['VENDEDOR'];
	      $row[TERMINAL] = "Web-Puertas";
          $row[RESPONSABLE] = $_SESSION[usuARioF];
		  $row[FECHA] = date("Y-m-d H:i:s");
		  $row[NOMBRES] = strtoupper($row[NOMBRES]);
		  
                  $VehiyCond = "";
                   //$idplaca = 'null';
		  //$idcond = 'null';
		  
                  // para quemado
		  if($_POST['tipo'] == 'QUEMADO'){
			 $carga = '0'; 
		  }
		  //para carga
		  if($_POST['tipo']=='CARGA'){
		    $carga = '1';
			$row[TERMINAL] = "Web-Carga-$bodega";
		    $sql2[0] ="select top 1 consecutivoCarga 
                    from facregistrofactura$prueba 
                    INNER JOIN FacVehiculo ON FacVehiculo.IdVehiculo = facregistrofactura$prueba.IdVehiculo
                    INNER JOIN FacConductor ON FacConductor.IdConductor = facregistrofactura$prueba.IdConductor
                    where 
                    Fecha >= '$hoy_1h' 
                    AND Placa ='$_POST[placa]'
                    AND FacConductor.nombres = '$_POST[tte]' 
                    AND substring(cast(ConsecutivoCarga as char),1,1) = '$bodega1'
                    ";
            $sql2[1] ="select valorentero + 1 AS consecutivoCarga from sklconfiguracion$prueba where Nombre ='Consecutivo.Carga' AND ValorTexto ='$bodega'";        
		    $contCON = -1;
		    while($_POST['consecutivo'] == ''){
		      $contCON += 1;
              $result2 = mssql_query($sql2[$contCON]);
              while($row2 = mssql_fetch_assoc($result2))
	            {
	            $_POST['consecutivo'] = $row2["consecutivoCarga"];
	            if($contCON == 1){
					mssql_query("UPDATE sklconfiguracion$prueba SET ValorEntero = '$_POST[consecutivo]' where Nombre ='Consecutivo.Carga' AND ValorTexto ='$bodega'"); // or die(mssql_get_last_message()); 
				  }
				}
	        if($contCON > count($sql2)){ break;}  
            }
		    $msjConsec = "Cons: $_POST[consecutivo] ";
            //placa nueva
            if(substr($_POST['placa'],6,7) == '(nueva)'){
			  $_POST['placa'] = strtoupper(substr($_POST['placa'],0,6)); 
			  $sql3 = "SELECT Placa FROM FacVehiculo$prueba WHERE placa ='$_POST[placa]'";
			  $result3 = mssql_query($sql3);
              $exiteono ='NO' ;
			  while($row3 = mssql_fetch_assoc($result3)){
				$exiteono ='SI' ;  
			  }			  
			  if($exiteono == 'NO'){
				  $sql3 = "INSERT INTO FacVehiculo$prueba (placa, codigo, descripcion, activo)VALUES('$_POST[placa]','$_POST[placa]','$_POST[placa]','1')";
			  mssql_query($sql3);
			  }
		    }
          $idplaca = "(select IdVehiculo from facvehiculo$prueba where Placa ='$_POST[placa]')";
		  $idcond ="(SELECT IdConductor FROM FacConductor WHERE NOMBRES = '".utf8_decode($_POST[tte])."')";			
	  $VehiyCondVal = ", $idcond, $idplaca";
      $VehiyCond = ", IdConductor, IdVehiculo";
                   //$idplaca = 'null';
		  //$idcond = 'null';	  
		  // DATOS RUTA, DEST SHIPMENT
		   $sql4 ="select 
		              MAX(IDROUT) as RUTA
                     ,MAX(IDDEST) AS DESTID
                     ,MAX(DTDESC) AS DEST
                     ,MAX(SLSPNO) AS SHIP
                   FROM VISDETFAC 
				   WHERE IDINVN = '$fact' AND OHORDT = '$tipo'
				   ";
		    $result4 = odbc_exec($db2conp, $sql4); echo odbc_errormsg();
            $row4 = odbc_fetch_array($result4);
			//print_r($row4);
					 		
		  } // finif garga
		  
	$sql5 = "INSERT INTO facregistrofactura$prueba (
            cedula
          , nombres
          , fecha
          , terminal
          , responsable
          , valor
          , factura
          , problema
          , Carga
		    , ConsecutivoCarga
			$VehiyCond
			, IdRuta
			, Secuencia
			, IdDestino
			, Destino
			, ShipmentNumber
          , Tipo
          , Direccion
          , Telefono
          , Celular
          , orden
          ,unidades
          ,ingresa
          ,forzarguia
          )VALUES(
            '$row[CEDULA]'
          , '$row[NOMBRES]'
          , '$row[FECHA]'
          , '$row[TERMINAL]'
          , '$row[RESPONSABLE]'
          , '$row[VALOR]'
          , '$row[FACTURA]'
          , '$row[PROBLEMA]'
          , '$carga'
		    , '$_POST[consecutivo]'
			$VehiyCondVal
			, '$row4[RUTA]'
			, '0'
			, '$row4[DESTID]'
			, '$row4[DEST]'
			, '$row4[SHIP]'
          , '$row[TIPO]'
          , '$row[DIRECCION]'
          , '$row[TELEFONO]'
          , '$row[CELULAR]'
          , '$row[ORDEN]'
          
          , '0'
          , '0'
          , '0'
          )";
	  //mssql_query($sql2) or die(mssql_get_last_message());	
	  flush();
      ob_flush();
	  
	  
	  if($result5 = mssql_query($sql5)){
	    $row[VALOR] = number_format($row[VALOR],'0',',','.');
	    $result6 = mssql_query("select max(NumeroCajas) from facregistrovalidacion where NumeroFactura ='$fact' and TipoFactura = '$tipo'");
	    while($row6 = mssql_fetch_row($result6)){
		  $msjConsec .= " cajas:$row6[0]"
;	    }
	    $msjYAREG = "<div  style='border-style:groove; border-color:lightgreen; height:20%'>
                    $msjConsec <BR><font color='GREEN'>------------</font> <br/> Fac $row[TIPO]$row[FACTURA] <br> $row[NOMBRES]  $ $row[VALOR] <br/><font color='GREEN'>REGISTRADA OK!!  <br/>------------</font> 
                   </div>";
	    
	    if($updateGuia =='SI')
		{   $sqlUPg = "UPDATE facregistroetiqueta$prueba SET guia ='$_POST[guia]', valorguia ='$_POST[vlrguia]' WHERE FACTURAS ='$_POST[fact]'"; echo $sqlUPg;
			mssql_query($sqlUPg) or die(mssql_get_last_message());
		}
		 
		$_POST[fact] = null;
	    //habilita sanciones y lista sanciones
	    $versan ='SI';
	    
	  }else{ 
	    //echo"error mssql:<br>$sql5 <br> ".mssql_get_last_message();
	    $msjYAREG = "<font color='RED'>Error Insertando registro, contacte a Sistemas </font>".$sql5.mssql_get_last_message();
	  }
	  
    } //while

	    
} // finif quema && errores 0

if($encontrada == 'NO'){
	  $msjYAREG = "<div style='border-style:groove; border-color:orange; height:20%'>
	                 <font color='darkorange'>
	                   ------------
	                 </font> 
	                 <br/>
	                 Factura $_POST[fact] 
	                 <br/>
	                 <font color='darkorange'>
	                   NO ESTA EN EL SISTEMA 
	                   <br/>
	                   ------------
	                 </font> 
	                </div>";
	  $_POST[fact] ='';
	}


//registro sancion
if($_POST['san'] != '' OR $_POST['obs'] != '' ){
  if($_POST['san'] != '' AND $_POST['obs'] != '' ){
    
    $fecha = date("Y-m-d H:i");
    $sanT = explode("|", $_POST[san]);
    $sanT[0] = trim($sanT[0]);
    $sql2 = "INSERT INTO facregistrosancion (
            Fecha
          , IdTiposancion
          , Idauxiliar
          , Factura  
          , Vendedor
          , Funcionario
          , Terminal
          , Observaciones
          )VALUES(
            '$fecha'
          , '$sanT[0]'
          , '13'
          , '$_POST[facs]'
          , '$_POST[vend]'
          , '$_SESSION[usuARioF]'
          , 'Web-Puertas'
          , '$_POST[obs]'
          )";

	  //mssql_query($sql2) or die(mssql_get_last_message());	
	  if(mssql_query($sql2)){
	    $row[VALOR] = number_format($row[VALOR],'0',',','.');
	    $msjYAREG = "<div style='border-style:groove; border-color:lightgreen; height:20%'>
                       <font color='GREEN'>------------</font> <br/> Sanción $_POST[vend] <br/><font color='GREEN'>REGISTRADA OK!!  <br/>------------</font> 
                     </div>";
	    $_POST[fact] ='';
	  }else{
	    echo "$sql2 ".mssql_get_last_message();
	  }

  }else{
    $versan = 'SI';
    if($_POST['san'] == ''){
      $msjYAREG = "<div style='border-style:groove; border-color:orange; height:20%'>
                     <font color='darkorange'>------------</font> <br/> <font color='darkorange'>Seleccione una sanción de la lista<br/>------------</font>
                   </div>";
      }
    if($_POST['obs'] == '' ){
      $msjYAREG = "<div style='border-style:groove; border-color:orange; height:20%'>
                     <font color='darkorange'>------------</font> <br/> <font color='darkorange'>Escriba una observación<br/>------------</font>
                   </div>";
      }
  }
} // FINIF SANCION



//Listados
if($_POST['tipo'] =='CARGA'){
$sql ="SELECT TOP 1000 PLACA FROM FACVEHICULO ORDER BY PLACA ASC";
$result = mssql_query($sql) or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{ 
	$placas[] = $row['PLACA'];
	}

$sql ="SELECT TOP 1000 NOMBRE FROM AGRTRANSPORTADOR order by NOMBRE";
$result = mssql_query($sql) or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{ 
	$ttes[] = $row['NOMBRE'];
	}
$sql ="SELECT TOP 1000 NOMBRES FROM FACCONDUCTOR order by NOMBRES";
$result = mssql_query($sql) or die(mssql_get_last_message());
while($row = mssql_fetch_assoc($result))
	{ 
	$conds[] = utf8_encode($row['NOMBRES']);
	}

}

if($versan =='SI'){
  $sql ="SELECT TOP 1000 CONCAT(IDTIPOSANCION,' | ',NOMBRE) AS SAN FROM FACTIPOSANCION";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{ 
	$sans[] = utf8_encode($row['SAN']);
	}
}
	
?>
<style type="text/css">
.auto-style1 {
	text-decoration: underline;
}
</style>
</head>
<body class="global" style=" background-color:white; background-repeat: no-repeat; background-attachment:fixed;  background-image: url('../../images/logopeq.jpg') 50% 50% no-repeat rgb(249,249,249);
 " >
<!-- <div class="loader" ><br><br><br><br><br>Cargando.....</div>
  -->



<form id="sistema" action="facturas.php" method="post" name="submit button1" autocomplete="off" style="width:100%">

<table align="center" width="100%" style="min-width:700px" class="frr" border="0">
  <tr>
    <td align="center" colspan="2" style="background-color:lightgrey; border-style:groove; height: 33px;">
      <?
       if($_POST['tipo'] ==''){$_POST['tipo'] = 'QUEMADO';}
       if($_POST['tipo'] =='QUEMADO'){ $checkedQ = "checked";}
       if($_POST['tipo'] =='CARGA'){ $checkedC = "checked";}
      ?>
      <input type="hidden" id="tipoH" name="tipoH" value="<?= $_POST['tipo'] ?>" >
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedQ?> name="tipo" type="radio" value="QUEMADO" >Quema Fact
      &nbsp;&nbsp;
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedC?> name="tipo" type="radio" value="CARGA">Reg-Carga
      &nbsp;&nbsp;
      <input class="crr" onchange="this.form.submit()" id="tipo"  name="tipo" type="radio" value="SALE">Salir
    </td>
  </tr>
  <tr>
    <th align="center" colspan="2"><?= $msjYAREG;?> &nbsp;
    </th>
  </tr>
<?
if($_POST[tipo]== 'CARGA'){
?>
  <tr>
    <td align="right">Placas</td>
    <td>
      <?
	  if($_POST[placa] == 'OTRA'){
		echo " : <input class='frr campo' name='placanew' id='placanew' placeholder='???xxx' style='width:50%' />";  
	  }else{
	  ?>	  
	  : <select class="frr campo" onchange="this.form.submit()" id="placa" name="placa" style=" border-color:<?= $color["placa"]?>; width:50%">
        <?
        echo "<option>$_POST[placa]</option>";
        foreach($placas AS $placa){
          echo "<option>$placa</option>";
        }
        ?>
		<option>OTRA</option>
      </select>
	  <?
	  }
	  ?>
    </td>
  </tr>
  <tr>
    <td align="right">Transp</td>
    <td>
      : <select onchange="this.form.submit()" class="frr campo" id="tte" name="tte" style=" border-color:<?= $color["tte"]?>">
        <?
        echo "<option>$_POST[tte]</option>";
        foreach($conds AS $cond){
          echo "<option>$cond</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
<? } //FINNF QUEMADO O CARGA  onKeyUp="sleepFor(3);"  ?>  
    <td style="width:40%" align="right"># Factura</td>
    <td style="width:60%">
      : <input <?= $autofocusF?> onChange=" setReadonly() ; sleepFor(300); this.form.submit();" tabindex="1" type="text" id="fact" name="fact" class="frr campo" value="<?= $_POST['fact']?>" style=" border-color:<?= $color["fact"]?>" />
    </td>
  </tr>
<?
if($_POST[tipo]== 'CARGA' AND $_POST['fact'] !='' AND 
    ($_POST[guia]== '' OR $_POST[vlrguia]== '')
  ){
?>  
  <tr>
    <td align="right" style="height: 30px"># Guia</td>
    <td style="height: 30px">
      : <input <?= $autofocusG?> type="text" id="guia" name="guia" class="frr campo" class="frr campo" value="<?= $_POST['guia']?>" style=" border-color:<?= $color["guia"]?>" />
    </td>
  </tr>
  <tr>
    <td align="right">Vlr Guia $</td>
    <td>
      <input type="number" pattern="[0-9]*" id="vlrguia" name="vlrguia" class="frr campo" value="<?= $_POST['vlrguia']?>" style=" border-color:<?= $color["vlrguia"]?>" />
    </td>
  </tr>
<? $submitalo ="this.form.submit()"; } //FINNF QUEMADO O CARGA 2 ?>
  <tr>
    <td align="center" colspan="2">
      <br><input class="frr" onclick="<?= $submitalo?>" type="button" id="guarda" name="guarda" value=" GUARDAR " >
    </td>
  </tr>
<?   
   if($_POST['tipo']== 'QUEMADO' and $versan=='SI'){
?>  
    <tr>
    <td align="center" colspan="2" style=" border-style:groove;" >
    Sanciones Colaborador <b><?= $_POST['vend'] ?></b>? :<br/>
      <input type="hidden" id="facs" name="facs" value="<?= $_POST['facs'] ?>" >
      <input type="hidden" id="vend" name="vend" value="<?= $_POST['vend'] ?>" >
      <select class="frr campo" id="san" name="san" style=" border-color:<?= $color["san"]?>; background-color:lightyellow">
        <?
        echo "<option>$_POST[san]</option>";
        foreach($sans AS $san){
          echo "<option>$san</option>";
        }
        ?>
      </select>
      <textarea placeholder="Observaciones..."  type="text" id="obs" name="obs" class="frr campo" rows="3" style="width:99%; background-color:lightgrey"><?= $_POST['obs']?></textarea>
      <input class="frr" onclick="this.form.submit()" type="button" id="guarda" name="guarda" value=" GUARDAR " >
    </td>
  </tr>
  
<? } //finif versan ?>    
<tr>
    <td align="center" colspan="2" style="height: 23px">
      &nbsp;</td>
   </tr>
</table>
 </form> 

</body>
</html>
