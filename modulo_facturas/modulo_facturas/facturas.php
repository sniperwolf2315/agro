
<?php
session_start();
// $prueba = "TMP"; 

if($_POST['tipo'] == 'SALE'){
  // header("location:../user_conect_ver_la.php"); 
  session_destroy();
  echo('<meta http-equiv="refresh" content="0;url=../../modulo_facturas/user_conect.php">');
  die;
}


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
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes"> -->



<style type="text/css" media="print">.nover {display:none}</style>
<link rel="stylesheet" type="text/css" href="../antenna.css" id="css">
<script src="../aajquery.js"></script>
<link rel="stylesheet" href="../aajquery.css" >
<link rel="stylesheet" href="./css/facturas.css" >

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


function setReadonly()
{
    var myElement = document.getElementById("fact");
    myElement.readOnly = true;
    
}

function setDisabled()
{
    var myElement = document.getElementById("fact");
    myElement.disabled = true;
    
}

function sleepFor( sleepDuration ){
    var now = new Date().getTime();
    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
}


function popUp(URL) {
  window.open(URL, 'agrocampo config', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=300,left = 400,top = 250');
}


function valores_terminal(va_terminal){
  /* CAMBIAR EL VALOR DEL CAMPO $GUIA y #GUIA */
  // console.log(`El valor de la terminal es es : ${va_terminal}`);
  guia      = document.getElementById('guia'); 
  vlr_guia  = document.getElementById('vlrguia');
  
  if (va_terminal=='NO'){
    guia.value     = 'TER';
    vlr_guia.value = 0;
  }else if (va_terminal==''){
    guia.value      = 'TER';
    vlr_guia.value  = 0;
  }else{
    guia.value      = '';
    guia.focus();
  }
}



</script>




<body class="global" style=" background-color:white; background-repeat: no-repeat; background-attachment:fixed;  background-image: url('../../images/logopeq.jpg') 50% 50% no-repeat rgb(249,249,249);
 "  >
<?php

require('../user_con.php');
include('../../general_funciones.php');

//agruegue aqui el segemto de red correspondiente si ha cambiado en el correspondiente seg.....cuando no sale el consecutivo
$seg_portos_arr = array('6','9','10');
$seg_73_arr = array('12','0','1');
$ip = explode(".",$_SERVER['REMOTE_ADDR']);



/*ESTO ES PARA SABER DESDE QUE BOEDEGA SE CONSULTA EN BASE A SU IP */
if(in_array( $ip[2], $seg_73_arr)){ $bodega ='005'; }
if(in_array( $ip[2], $seg_portos_arr)){ $bodega ='008'; }


$bodega1 = substr($bodega,2,1);
$habilitar_check_carga ='disabled';
$usuario = $_SESSION['usuARioF'];
//echo $_SERVER['REMOTE_ADDR'];

// echo "
// <center>
//   <h1 id='msj_manetenimiento' name='msj_manetenimiento' class='msj_manetenimiento' >
//     Estamos en mantenimiento, modulo  cargue de facturas y la informacion puede no ser veridica
//   </h1>
// </center>
// ";


$hoy_1h = date("Y-m-d ");
$hoy_1h .= date("H")-1;
$hoy_1h .= date(":i");

$hoy_3h = date("Y-m-d ");
$hoy_3h .= date("H")-3;
$hoy_3h .= date(":i");


$hoy = date("Y-m-d");
$hoy_6mo = date("Y-m-d", strtotime("$hoy - 6 month"));

$_POST[fact] = strtoupper($_POST[fact]);

$autofocusF = "autofocus" ;
$autofocusG = "" ;

$fact = substr($_POST[fact],2);
$tipo = strtoupper(substr($_POST[fact],0,2));



$msjYAREG = "<div id='texto_head' style='border-style:groove; border-color:silver; height:20%'>
                       <font color='silver'>------------</font>
                       <br>
                       Ingrese 
                       <br>
                       <font color='silver'>Factura  <br/>------------</font> 
              </div>
            ";

//casa nombre y id de conductor separado
$ttes = explode("|", $_POST['tte']);
$_POST['tteNOM'] = trim($ttes[0]);
$_POST['tteID'] = trim($ttes[1]);

//CAMBIO PLACA - TTE
if( $_POST['placa'] == 'CAMBIO' ){
   $_POST['placa'] = ''; 
   $_POST['tte'] = '';
   $_POST['ter'] = '';  
  }

/* ESTO SOLO SE USA CUANDO SE VALIDAN FACTURAS PARA PRUEBAS */
$lista =['06-1001514382','S1-1001514332'];
$i=0;
while($i < count($lista) ){
    $campo =  $lista[$i]; 
    $campo =  substr($campo,3);
    $lista[$i] = $campo;
    $i++;    
}


echo (in_array($_POST['fact'],$lista))?'Este mensaje solo es informativo factura no necesita ser revidida':'';


//valida campos
if($_POST['placanew'] != ''){
	if(strpos($_POST['placanew']," ")){ echo "<script>alert('LA PLACA NO PUEDE TENER: ESPACIOS ')</script>"; $_POST['placa'] = 'OTRA'; }
	elseif(strpos($_POST['placanew'],"-")){echo "<script>alert('LA PLACA NO PUEDE TENER: - ')</script>"; $_POST['placa'] = 'OTRA'; }
	elseif(strlen($_POST['placanew']) > '6'){echo "<script>alert('LA PLACA NO PUEDE TENER MAS DE 6 CARACTERES')</script>"; $_POST['placa'] = 'OTRA'; }
	else{ 
	    $_POST['placa'] = $_POST['placanew']."(nueva)"; 
	    }
	}

  

//valida existencia de salida DE TRAS y guarda de no existir 
if($_POST['tipo'] == 'TRAS'){

  //consulta la factura en MSsql, que no haya sido registrada
  $sql ="select top 1 funcionariosalida, fechasalida from facListaEmpaque WHERE CodigoBarras='$_POST[fact]' ";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{
	if($row[fechasalida] != ''){
	  $row[valor] = number_format($row[valor],0,',','.'); 
	  $msjYAREG = "<div  style='border-style:groove; border-color:pink; height:20%'>
	               <font color='RED'>------------</font> <br/> Traslado $_POST[fact] <br/><font color='red'>YA REGISTRADO <br/> $row[fechasalida] <br/>-----------</font> 
	               </div>
	               ";
	  
	  $fact = '';
	  $tipo = '';
	  }else{
	  $sql ="UPDATE facListaEmpaque SET funcionariosalida ='$_SESSION[usuARioF]' ,fechasalida ='".date("Y-m-d H:i:s")."',terminalsalida= 'Web-Carga-$bodega' WHERE CodigoBarras='$_POST[fact]' ";
      //ECHO $sql;
      mssql_query($sql) or die(mssql_get_last_message());
      $msjYAREG = "<div  style='border-style:groove; border-color:lightgreen; height:20%'>
                    $msjConsec <BR><font color='GREEN'>------------</font> <br/> Traslado $_POST[fact] <br> <font color='GREEN'>REGISTRADO OK!!  <br/>------------</font> 
                   </div>";
	  }
	}
  $_POST[fact] ='';
}

//VALIDA EXISTENCIA DE LA FACTURA IBS PARA QUEMADO Y CARGA

if($_POST['tipo'] == 'CARGA' OR $_POST['tipo'] == 'QUEMADO'){

  //valida existencia de la factura IBS
 if($_POST[fact] != ''){
  $encontrada = 'NO';
  $sql ="select SRBISH.IHINVN AS FACT FROM SROISH SRBISH LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO where SRBISH.IHINVN = '$fact' AND SRBSOH.OHORDT ='$tipo'";
  $result = odbc_exec($db2conp, $sql); //echo odbc_errormsg(); 
  while($row = odbc_fetch_array($result)){
	      $encontrada = 'SI';
    }

  if($encontrada == 'NO'){ 
      $_POST[fact] = ''; 
    }
 }
 
//consulta la factura en MSsql, que no haya sido registrada
  
  $sql ="select top 1 nombres, valor, fecha, ingresa from facregistrofactura$prueba WHERE CONCAT(TIPO,FACTURA)='$_POST[fact]' ORDER BY IdRegistroFactura DESC";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{
	if($row[ingresa] == '0'){
	  $row[valor] = number_format($row[valor],0,',','.'); 
	  $msjYAREG = "<div  style='border-style:groove; border-color:pink; height:20%'>
	               <font color='RED'>------------</font> <br/> Factura $row[nombres]  $ $row[valor] <br/><font color='red'>YA REGISTRADA <br/> $row[fecha] <br/>-----------</font> 
	               </div>
	               ";
	  $_POST[fact] ='';
	  $fact = '';
	  $tipo = '';
	  }
	}
}
	
//en quemado busca guia, valor guia
if($_POST['tipo'] == 'CARGA' AND $_POST['fact'] != '' AND $_POST['guia'] == '' AND $_POST['vlrguia'] == ''  ){
  $sql ="select guia, valorguia from facregistroetiqueta$prueba WHERE FACTURAS ='$_POST[fact]' AND Guia != '0' ";
  $result = mssql_query($sql) or die(mssql_get_last_message());
  while($row = mssql_fetch_assoc($result))
	{
	$_POST['guia'] = $row["guia"];
	$_POST['vlrguia'] = "$row[valorguia]";
	}
  
  }// fin busca guia

// en carga D3 NO PIDE GUIA NI VALOR GUIA
if($tipo =='D3'){
	$_POST['guia'] = '0';
	$_POST['vlrguia'] = '0';
	}

// Terminal = SI guarda TER
if($_POST['ter'] =='NO'){
	$_POST['guia']       = 'TER';
	$_POST['vlrguia']    = '0';
	$_POST['updateGuia'] = 'SI';
}
/*
  20-09-2022 => Se obliga a que se actualice le numero de guia 
*/

if($_POST[ter] =='SI'){
  $_POST['guia']       = $_POST['guia'];
  $_POST['vlrguia']    = $_POST['vlrguia'];
  $_POST['updateGuia'] = 'SI';
} 



if( $_POST['tipo'] == 'CARGA' AND $_POST['fact'] !='' AND($_POST['guia'] == '' OR $_POST['vlrguia'] == '')
   ){
      $msjYAREG = "<div style='border-style:groove; border-color:orange; height:20%'>
	                 <font color='darkorange'> ------------ </font><br/> Ingrese <br/>
	                 <font color='darkorange'> Guia y $ Guia <br/> ------------ </font> 
	                </div>";
	  $autofocusF = "" ;
      $autofocusG = "autofocus" ;				
    }

$errores = 0;

//BLOQUEA LISTA DE TTE Y PLACA CUADO ESTA SELECCIONADO
if( $_POST['PLACA'] != '' AND $_POST['tte'] !='' ){
  $nolistPT = "NOlist";
  
  }

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



//VALIDA Y GUARDA quemado y carga
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
	      WHERE IHINVN = '$fact' AND OHORDT ='$tipo' LIMIT 0,1";
  //echo $sql;            
  $result = odbc_exec($db2conp, $sql); //echo odbc_errormsg();
  while($row = odbc_fetch_array($result)){  
          $encontrada = 'SI';
	      $_POST[vend] = $row['VENDEDOR'];
	      $row[TERMINAL] = "Web-Puertas";
          $row[RESPONSABLE] = $_SESSION[usuARioF];
		  $row[FECHA] = date("Y-m-d H:i:s");
		  $row[NOMBRES] = strtoupper($row[NOMBRES]);
		  $Direclient=$row['DIRECCION'];
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


/*
$sql2[0] ="select top 1 consecutivoCarga 
from facregistrofactura$prueba 
INNER JOIN FacVehiculo ON FacVehiculo.IdVehiculo = facregistrofactura$prueba.IdVehiculo
INNER JOIN FacConductor ON FacConductor.IdConductor = facregistrofactura$prueba.IdConductor
where 
Fecha >= '$hoy_3h' 
AND Placa ='$_POST[placa]'
AND FacConductor.IdConductor = '$_POST[tteID]' 
AND substring(cast(ConsecutivoCarga as char),1,1) = '$bodega1'
"; 
*/
      $sql2[0] ="SELECT 
                  top 1 
                    consecutivoCarga 
                  from 
                    facregistrofactura$prueba ff
	                  inner join PLACAS_DOMICILIOS_AGRO PDA on PDA.ID = ff.IdConductor
	                where 
                    Fecha >= '$hoy_1h'
                     AND PDA.NUMERO_PLACA ='$_POST[placa]'  
	                  AND ff.IdConductor = $_POST[tteID]
	                  AND substring(cast(ConsecutivoCarga as char),1,1) = '5'
              "; 
           
              // echo $sql2[0];
            $sql2[1] ="select valorentero + 1 AS consecutivoCarga from sklconfiguracion$prueba where Nombre ='Consecutivo.Carga' AND ValorTexto ='$bodega'";        
		    $contCON = -1;

		    while($_POST['consecutivo'] == ''){
		      $contCON += 1; 
              $result2 = mssql_query($sql2[$contCON]);
              while($row2 = mssql_fetch_assoc($result2)){
                  $_POST['consecutivo'] = $row2["consecutivoCarga"];
                  if($contCON == 1){
                    mssql_query("UPDATE sklconfiguracion$prueba SET ValorEntero = '$_POST[consecutivo]' where Nombre ='Consecutivo.Carga' AND ValorTexto ='$bodega'"); // or die(mssql_get_last_message()); 
                    }
              }
	        if($contCON > count($sql2)){ 
            break;
          }  
        }
		    $msjConsec = "Cons: $_POST[consecutivo] ";
            //placa nueva
            if(substr($_POST['placa'],6,7) == '(nueva)'){
              $_POST['placa'] = strtoupper(substr($_POST['placa'],0,6)); 
              // $sql3 = "SELECT Placa FROM FacVehiculo$prueba WHERE placa ='$_POST[placa]' AND FacVehiculo.ACTIVO = 1";
              $sql3 = "SELECT NUMERO_PLACA from PLACAS_DOMICILIOS_AGRO where ACTIVO=1 and NUMERO_PLACA='$_POST[placa]'";
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
          //$idplaca = "(select IdVehiculo from facvehiculo$prueba where Placa ='$_POST[placa]')";
          // $SQLidplaca = "select IdVehiculo from facvehiculo$prueba where Placa ='$_POST[placa]' AND ACTIVO = 1";
          $SQLidplaca = "SELECT ID as IdVehiculo from PLACAS_DOMICILIOS_AGRO where ACTIVO=1 and NUMERO_PLACA='$_POST[placa]'";

          $resultPlaca = mssql_query($SQLidplaca);
          if($row2Placa = mssql_fetch_assoc($resultPlaca)){
            $idplaca=$row2Placa['IdVehiculo'];        
          }
          /* 09092023 con el cambio el mismo id de la placa es el del conductor 
          // $idcond ="'$_POST[tteID]'";			
          */
		  // $idcond ="'$idplaca'";			
		  $idcond ="$idplaca";			
	  $VehiyCondVal = ", $idcond, $idplaca";
	  // $VehiyCondVal = ", 1, $idplaca";
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
		    $result4 = odbc_exec($db2conp, $sql4); //echo odbc_errormsg();
            $row4 = odbc_fetch_array($result4);
			//print_r($row4);
					 		
    


    } // finif garga
	$Dire=str_replace("'","",$Direclient);	
  

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
          , '$Dire'
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
	  // echo "<br>$sql5<br>";
	  
	  if($result5 = mssql_query($sql5)){
	    $row[VALOR] = number_format($row[VALOR],'0',',','.');
	    $result6 = mssql_query("select max(NumeroCajas) from facregistrovalidacion where NumeroFactura ='$fact' and TipoFactura = '$tipo'");
	    while($row6 = mssql_fetch_row($result6)){
		  $msjConsec .= " cajas:$row6[0]"
;	    }
	    $msjYAREG = "<div  style='border-style:groove; border-color:lightgreen; height:20%'>
                    $msjConsec <BR><font color='GREEN'>------------</font> <br/> Fac $row[TIPO]$row[FACTURA] <br> $row[NOMBRES]  $ $row[VALOR] <br/><font color='GREEN'>REGISTRADA OK!!  <br/>------------</font> 
                   </div>";

    if( $_POST['updateGuia'] == 'SI')
		{   $sqlUPg = "UPDATE facregistroetiqueta$prueba SET Guia ='".$_POST[guia]."', valorguia ='".$_POST[vlrguia]."' WHERE FACTURAS ='".$_POST[fact]."'"; 
      // echo $sqlUPg;
			mssql_query($sqlUPg) or die(mssql_get_last_message());
		}
		 
		// $_POST[fact] = null;
		$_POST[fact] = '';
    //habilita sanciones y lista sanciones
    $versan ='SI';
    
      // echo "reg ok 1";
      // $_POST['tipo'] = 'CARGA';
      // $checkedC = "checked";
      // echo("<meta http-equiv='refresh' content='3'; url = facturas.php?tipos=CARGA>");
   
  }else{ 
    $msjYAREG = "<font color='RED'>Error Insertando registro, contacte a Sistemas </font>".$sql5.mssql_get_last_message();
    $_POST[fact] = '';
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
  //BLOQUEA LISTA DE TTE Y PLACA CUADO ESTA SELECCIONADO
  if( $_POST['placa'] != '' AND $_POST['tte'] != '' ){
    $cambiaTTEyPLACA = "<option value='CAMBIO'>Cambiar Transportador </option>"; 
  }else{
    // $sql ="SELECT FacVehiculo.Placa as PLACA
    //       , max(fecha) as fecha 
	  //         FROM FacRegistroFactura 
		//         INNER JOIN FacVehiculo on FacVehiculo.IdVehiculo = FacRegistroFactura.IdVehiculo 
		//         where fecha >= '$hoy_6mo' 
    //         AND PLACA != 'AAA999' 
    //         group by FacVehiculo.Placa order by PLaca ASC";
    /* DESARROLLADOR QUERY DE PLACA */
    
    // $sql ="SELECT 
    // distinct 
    // FacVehiculo.Placa as PLACA
    // FROM FacRegistroFactura  frf
    // INNER JOIN FacVehiculo on FacVehiculo.IdVehiculo = frf.IdVehiculo 
    // where 
    // fecha >= '$hoy_6mo' 
    // and PLACA != 'AAA999' 
    // and activo = 1
    // group by FacVehiculo.Placa 
    // order by PLACA ASC";
    /* NUMERO DE PLACA */
    $sql = ("SELECT NUMERO_PLACA PLACA from PLACAS_DOMICILIOS_AGRO where ACTIVO=1 order by NUMERO_PLACA");
    // echo "$sql";
    
    $result = mssql_query($sql) or die(mssql_get_last_message());
    while($row = mssql_fetch_assoc($result))
	  { 
      $placas[] = $row['PLACA'];
	  }

    /* AGREGAR OPCION OTRA AL ARRAY DE PLACAS */
	  // $placas[] = 'OTRA';
    
    /* ID DE TRANSPORTADOR */
    $sql = ("SELECT CONCAT(EMPRESA_PERTENECE,'|',ID) from PLACAS_DOMICILIOS_AGRO where ACTIVO=1");

    // $sql ="SELECT 
    // concat(FacConductor.nombres,'|',FacConductor.IdConductor) as NOMBRES, 
    // max(fecha) as fecha 
    // FROM Facconductor 
	  // LEFT JOIN FacRegistroFactura on FacRegistroFactura.IdConductor = FacConductor.IdConductor 
		// where fecha >= '$hoy_6mo' OR fecha IS NULL  
		// group by concat(FacConductor.nombres,'|',FacConductor.IdConductor)
		// order by concat(FacConductor.nombres,'|',FacConductor.IdConductor) ";



$result = mssql_query($sql) or die(mssql_get_last_message());
    while($row = mssql_fetch_assoc($result))
	  { 
	    $conds[] = utf8_encode($row['NOMBRES']);
	  }
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




<!-- <div class="loader" ><br><br><br><br><br>Cargando.....</div> -->

<!-- <form id="sistema" action="facturas.php" method="post" name="submit button1" autocomplete="OFF" translate="no" style="width:100%;font-size:30px" >  -->
<form id="sistema" name="sistema"  class="sistema"  action="facturas.php" method="post" autocomplete="OFF" translate="no" style="width:100%;font-size:20px">

<table align="center" width="100%" style="min-width:600px;font-size:34px" class="frr" border="0">
  <tr>
    <!-- <td align="center" colspan="2" style="background-color:white; border-style:groove; height: 33px;" id="bar_menu" name="bar_menu" class="bar_menu"> -->
    <td align="center" colspan="2"  id="bar_menu" name="bar_menu" class="bar_menu">
      <?
      include('perfileria_sia.php');
      /* SECCION MENU BAR */
       if($_POST['tipo'] ==''){$_POST['tipo'] = 'QUEMADO';}
       if($_POST['tipo'] =='QUEMADO'){ $checkedQ = "checked";}
       if($_POST['tipo'] =='CARGA'){ $checkedC = "checked";}
       if($_POST['tipo'] =='TRAS'){ $checkedT = "checked";}
      
 /** SE VALIDA QUE SOLO CIERTOS USUARIOS O PERFILES TENGAN ACCESO A ESTE BOTON */
      if (in_array($_SESSION['usuARioF'],$usuarios_permitidos_seg) ){
        $habilitar_check_carga ='enable';
      }else if (in_array($_SESSION['usuARioF'],$usuarios_permitidos_aud)  ){
        $habilitar_check_carga ='enable';
      }else{
        $habilitar_check_carga ='disabled';
      }
      

      ?>
      <input type="hidden" id="tipoH" name="tipoH" value="<?= $_POST['tipo'] ?>" >
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedQ?> name="tipo" type="radio" value="MENU" > Menu 
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedQ?> name="tipo" type="radio" value="QUEMADO" >Quema Fact 
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedC?> name="tipo" type="radio" value="CARGA" <?=$habilitar_check_carga ?> >Reg-Carga 
      <input class="crr" onchange="this.form.submit()" id="tipo" <?= $checkedT?> name="tipo" type="radio" value="TRAS">Traslado 
      <input class="crr" onchange="this.form.submit()" id="tipo"                 name="tipo" type="radio" value="SALE">Salir 
    </td>
  </tr>
  <tr>
    <th align="center" colspan="2"><?= $msjYAREG.$prueba;?> &nbsp;
    </th>
  </tr>


<?
/* OPCION MENU  */
if($_POST[tipo]== 'MENU'){
  echo "
  <tr>
  <td>
    <ul> Menu
      <li>
      <a href=\"../../../nuevo_sia_v2/modules/mod_sanciones/index.php?usr_seg=$usuario\" target=\"_blank\" id=\"menu_sancion\" name=\"menu_sancion\" >Sanciones</a>
      </li>
    </ul>
  </td>
  </tr>
  ";
  return;
}


if($_POST[tipo]== 'CARGA'){
?>
  <tr>
    <td align="right">Placas </td>
    <td>
      <?
	  if($_POST[placa] == 'OTRA'){
		  echo " : <input class='frr campo' name='placanew' id='placanew' placeholder='???xxx' style='width:100%;' onchange='this.form.submit()' />";  
    }else{
      $placa_seleccionada =strtoupper($_POST["placa"]);
	  ?>	  
        <!-- : <input list="placas" class="frr campo" id="placa" name="placa" style=" border-color:<?= $color["placa"]?>; width:100%; font-size:3vw;" onchange='this.form.submit()'value="<?=$placa_seleccionada?>">
        <datalist id="placas"> -->
          : <select class="frr campo" id="placa" name="placa" style=" border-color:<?= $color["placa"]?>; width:100%; font-size:2vw;" onchange='this.form.submit()'>
    <?
        echo "<option>$_POST[placa]</option>";
        foreach($placas AS $placa){
          echo "<option>".strtoupper($placa)."</option>";
        }
        echo $cambiaTTEyPLACA;
    ?>
      <!-- </datalist>  -->
      </select> 
	  <?
    
	  }
   

	  ?>
    </td>
  </tr>
  <tr>
    <td align="right">Transp</td>
    <td>

    <?php
    /* SE AGREGA ESTE CONTROL PARA QUE EL CAMPO EMPRESA ESTE LIGADO A LA PLACA RESPONSABLE DE CARGA DE LA INFORMACION ES DOMICILIOS EL CONTROL QUEDA EN EL MODULO ADMIN RUTA TOTEM */
    /* LISTADO DE PLACAS */
    $es_nueva = $_POST[placa]; 
    $es_nueva = substr($es_nueva,6,7)   ;

    $ingresa_placa=$_POST[placa];


    // $sql_consulta_empresa= mssql_fetch_array(mssql_query("select EMPRESA_PERTENECE,NOMBRE_DOMICILIARIO from PLACAS_DOMICILIOS_AGRO where NUMERO_PLACA='$ingresa_placa'"));
    // $sql_consulta_empresa= mssql_fetch_array(mssql_query("
    // SELECT 
    // (case when pda.EMPRESA_PERTENECE='AGROCAMPO' then concat(pda.EMPRESA_PERTENECE +' '+ FC.Nombres,' | ',FC.IdConductor) else pda.EMPRESA_PERTENECE end)Placasnom
    // from
    // PLACAS_DOMICILIOS_AGRO PDA
    // left JOIN facVehiculo FV ON PDA.NUMERO_PLACA = FV.Placa AND FV.Activo=1
    // left JOIN facConductor FC ON pda.CEDULA=FC.Cedula
    // WHERE 
    // PDA.NUMERO_PLACA='$ingresa_placa'
    // "));
    $sql_consulta_empresa= mssql_fetch_array(mssql_query("
    SELECT 
    concat(pda.EMPRESA_PERTENECE,'|',PDA.ID) Placasnom
    from
    PLACAS_DOMICILIOS_AGRO PDA
    left JOIN facVehiculo FV ON PDA.NUMERO_PLACA = FV.Placa AND FV.Activo=1
    left JOIN facConductor FC ON pda.CEDULA=FC.Cedula
    WHERE 
    PDA.NUMERO_PLACA='$ingresa_placa'
    "));
     
    $tiene_empresa = count($sql_consulta_empresa);
    echo ': <select  onchange="this.form.submit()" class="frr campo" id="tte" name="tte" style=" border-color:<?= $color["tte"]?>" required';
    if ($_POST[placa]==""){
      echo "<option> -- </option>";
    }else if($es_nueva=='(nueva)'){
      $placa_nueva =mssql_query("SELECT 
        distinct 
        concat(FacConductor.nombres,'|',FacConductor.IdConductor) as Placasnom
        FROM Facconductor 
        JOIN FacRegistroFactura on FacRegistroFactura.IdConductor = FacConductor.IdConductor 
        group by concat(FacConductor.nombres,'|',FacConductor.IdConductor)
        order by concat(FacConductor.nombres,'|',FacConductor.IdConductor) 
      ");
      while($plc_new = mssql_fetch_assoc($placa_nueva)){
        echo "<option>".remove_characters($plc_new['Placasnom']).'</option>';
      }
    }else if ($tiene_empresa>0){
      // echo "entro al if else 2 ";      
      echo '<option>'.$sql_consulta_empresa[0].'</option>;';
    }else{
      echo "<option> </option> ";
      }
          echo '</select>'; 
    ?>
    </td>
  </tr>
  <tr>
    <td  align="right">
      Terminal
    <!-- <div class="tooltip">
      <span class="tooltiptext">
      ¿Ya tiene el número y valor de la guía?</span>
    </div> -->

    </td>
    <td> : 
      <select class="frr campo" id="ter" name="ter" onchange="valores_terminal(this.value)" required>
      <?
      if($_POST['ter'] == 'SI'){ $selectedS ="selected";}
      ?>
        <option></option>
        <option selected>NO</option>
        <option <?= $selectedS?> >SI</option>
      </select>
    </td>
  </tr>
  <? 




} //FINNF QUEMADO O CARGA  onKeyUp="sleepFor(3);"  ?>  
<!-- 
  <center>

    <h6>PRUEBAS FUNCIONALE PORTOS</h6><br>
    <h3>Continuar con normalidad</h3>
  </center> -->
<?
// if($_POST[tipo]== 'CARGA' && $_POST['fact'] !='' && ($_POST[guia]== '' OR $_POST[vlrguia]== '')){
// if($_POST[tipo]== 'CARGA' && $_POST['fact'] !='' && $_POST['ter']=='SI' ){
// if($_POST[tipo]== 'CARGA' && $_POST['fact'] !=''  ){
if($_POST[tipo]== 'CARGA' ){
  $num_guia_selec = ($_POST['ter']=='NO')?'TER':$_POST['guia'];
  $val_guia_selec = ($_POST['ter']=='NO')?'0':$_POST['vlrguia'];
?>  

  <tr>
    <td align="right" style="height: 30px"># Guia</td>
    <td style="height: 30px">
      <!-- : <input <?= $autofocusG?> type="text" id="guia" name="guia" class="frr campo" class="frr campo" value="<?= $_POST['guia']?>" style=" border-color:<?= $color["guia"]?>" /> -->
      : <input <?= $autofocusG?> type="text" id="guia" name="guia" class="frr campo" class="frr campo" style=" border-color:<?= $color["guia"]?>" value="<?=$num_guia_selec?>" />
        <input class="frr" type="hidden" id="updateGuia" name="updateGuia" value="SI" >
    </td>
  </tr>
  <tr>
    <td align="right">Vlr Guia $</td>
    <td> : 
      <input type="number" pattern="[0-9]*" id="vlrguia" name="vlrguia" class="frr campo" style=" border-color:<?= $color["vlrguia"]?>" value="<?=$val_guia_selec?>" />
    </td>
  </tr>
  
  
<? 

  $submitalo =" sleepFor(300); this.form.submit(); setDisabled() ;";
  } //FINNF QUEMADO O CARGA 2 
?>

<tr>
  <td style="width:25%" align="right"># 
      <? 
        if($_POST[tipo]== 'TRAS'){ 
          echo "Traslado"; 
        }else{ 
            echo "Factura"; 
            } 
      ?>
  </td>
  <td style="width:60%">
  <?php
  /** SE REALIZA ESTA VALIDACIÓN PARA QUE SEGURIDAD PORTOS PUEDA ESCRIBIR EL CODIGO DE LA FACTURA CUANDO VIENE EL QR TACHADO Y NO APLIQUE EL SUBMITED */
  
  if($_SESSION['usuARioF']=='MOLINAH'or $_SESSION['usuARioF']=='MONTANAL'or $_SESSION['usuARioF']=='VALENCIAY'){
   ?>
    : <input <?= $autofocusF?> onChange=" setReadonly() ; sleepFor(400); this.form.submit();" tabindex="1" type="text" id="fact" name="fact" class="frr campo" value="<?= $_POST['fact']?>" style=" border-color:<?= $color["fact"]?>" required/>
    <?php
  }else{
    ?>
    : <input <?= $autofocusF?> onChange=" setReadonly() ; sleepFor(300); this.form.submit();" tabindex="1" type="text" id="fact" name="fact" class="frr campo" value="<?= $_POST['fact']?>" style=" border-color:<?= $color["fact"]?>" required/>
<?php
  }
  
  ?>
    <!-- : <input <?= $autofocusF?> tabindex="1" type="text" id="fact" name="fact" class="frr campo" value="<?= $_POST['fact']?>" style=" border-color:<?= $color["fact"]?>; " required/> -->
  </td>
</tr>

  <tr>
<?php
  /** SI NO PERTENER AL GRUPO DE SEGURIDAD PORTOS  EL GUARDAR SOLO ES UNB  BOTON Y ESPERA EL LLAMADO DE LA LECTORA , PARA 73 CONTINUA IGUAL COM OVIENE FUNCIONANDO */
if($_SESSION['usuARioF']=='MOLINAH' || $_SESSION['usuARioF']=='MONTANAL' || $_SESSION['usuARioF']=='VALENCIAY'){
  
?>
      <td align="center" colspan="2">
        <br>
        <input class="frr" type="submit" id="guarda" name="guarda" value=" GUARDAR " style="cursor:pointer;background-color:lightgray;" >
      </td>

<?php
}else{
?>
  <td align="center" colspan="2">
    <br>
    <input class="frr" onclick="<?= $submitalo?>" type="button" id="guarda" name="guarda" value=" GUARDAR " style="cursor:pointer;background-color:lightgray;" >
  </td>
 
<?php
}
?>
</tr>
<tr>
    <td align="center" colspan="2" style="height: 23px">
      &nbsp;</td>
   </tr>
</table>
 </form> 
<div class="ventana_terminal">
<?php
if($_POST['tipo']=='QUEMADO'){
      echo "<a href="."javascript:popUp('facturas_terminal.php')"." class='nav-link link-dark' styke='color:black' >Terminal<span title='Ojo se limpia toda la tabla'></span></a> <br>";
    }

?>
  
</div>
</body>
<footer>
  @agr_V2.2
</footer>
</html>
