<? 
//session_start();
if(session_start()===FALSE){
        session_start();
    }


if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    {
        header("location:user_conect.php"); die;
    }
$Pasa=false;
if($_SESSION['usuARio'] == 'MORANTESN')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'TORRESC')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'GOMEZD')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'CARDOZOJ')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'SUAREZM')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'RODRIGUEZD')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'GERENCIA')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'SILVAJ')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'BARONF')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'RODRIGUEZF')
    {
        $Pasa=true;
    }else if($_SESSION['usuARio'] == 'PINILLOSM')
    {
        $Pasa=true;
    }
    else if($_SESSION['usuARio'] == 'VILLALOBOS')
    {
        $Pasa=true;
    }
if($Pasa==false)
    {
        $_SESSION['acc']='1';
        header("location:user_conect.php"); die;
    }
?>
<script language="JavaScript">
            function Salir(){
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'cerrarSesion.php' , true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert("Usted a salido.");
                                setTimeout("location.reload(true);", 500);
                                location.href="user_conect.php";
                            }
                        }
                    }    
            }
            function ActualizarPag(){
                setTimeout("location.reload(true);", 500);
            }
</script>
<?
//if($_SESSION["dIr"] != 'SI'){die;} 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}
//echo "Dato:".$_SESSION["dIr"];
//echo "Dato2:".$_SESSION['emp']."--".$_POST['empresa'];
//exit();

//parametros del evento
include('config.php');

$lineas = array('ALMACEN','PLATAFORMAS DIGITALES','PAGINA WEB','CALL (NO VTA EXT)','ZONAS VENTA EXTERNA','TOTAL','APOYO CALL V.EXT') ;
//$cols = array('VAR %','ANI_2021','ANI_2020','AGR_2021');
$cols = array('VAR %','ANI_2021','AGR_2021','AGR_2022');
//$cols = array('VAR %','AGR_2020','AGR_2021');
$hoy = date("Y-m-d");
if($hoy > $finaliza){
  $hoy = $finaliza;
  }
$year = date("Y");  
$year_1 = date("Y")-1;
$dias = 1+(strtotime("$hoy")-strtotime("$inicia"))/86400;
$evenDim = substr($evento,0,3)."_$year";
$evenDim_1 = substr($evento,0,3)."_$year_1";

//include("../../user_con.php");
//if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}

//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

$sql = "select
           dia AS DIA
          ,diasem AS DIASEM
          ,area AS AREA
          ,sum(if(evento='ANIVERSARIO',venta,0)) AS ANI_2021
          ,sum(if(evento='AGROMANIA',if(year='$year_1',venta,0),0)) AS AGR_2021
          ,sum(if(evento='AGROMANIA',if(year='$year',venta,0),0)) AS AGR_2022 
          ,(SELECT max(actualizado) FROM tablero_eventos WHERE YEAR = '$year' AND EVENTO = '$evento') AS ACTUALIZADO 
        from tablero_eventos
        WHERE
         (year = '$year' 
         OR (year = '$year_1' AND evento ='$evento')
         )
         AND
         dia <= $dias
        GROUP BY area, dia  
         ";
         
/*$sql = "select
           dia AS DIA
          ,diasem AS DIASEM
          ,area AS AREA
          ,sum(if(evento='agromania',if(year='$year_1',venta,0),0)) AS AGR_2020
          ,sum(if(evento='agromania',if(year='$year',venta,0),0)) AS AGR_2021
          ,(SELECT max(actualizado) FROM tablero_eventos WHERE YEAR = '$year' AND EVENTO = '$evento') AS ACTUALIZADO 
        from tablero_eventos
        WHERE
         (year = '$year' 
         OR (year = '$year_1' AND evento ='$evento')
         )
         AND
         dia <= $dias
        GROUP BY area, dia
        ";*/
  $result = mysqli_query($mysqliL, $sql) ; //echo "<br>$sql<br>";
	while($row = mysqli_fetch_assoc($result)){
		$actualizado = $row["ACTUALIZADO"];
		
		$dia = $row["DIA"];
		$area = $row["AREA"];
		$diasem[$dia] = strtoupper($row["DIASEM"]);
		$row['VAR %'] = number_format(-100+$row["$evenDim"]/$row["$evenDim_1"]*100,0,',','.');
		
		foreach($row as $campo => $valor){
		  //datos tablero
		  $ti["$dia"]["$area"]["$campo"]= utf8_encode(strtoupper($valor));
		  $tiT["$area"]["$campo"] += utf8_encode(strtoupper($valor));
		}
		 
    }


?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../../antenna/auto.js"></script>
<script src="../../../aajquery.js"></script>
<link rel="stylesheet" href="../../../aajquery.css" >

<style type="text/css" media="print">
.nover {display:none}
</style>

<style type="text/css" >
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }
.campo{ width:90%	}
.boton{ width:33%	}
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
    
    $("select").select2(); 
});

$(window).load(function() {
    $(".loader").fadeOut("slow");
});

//submit
}
//onLoad="setInterval('fsubmit()',10000);" 
</script>

<style type="text/css" media="print">
@page{
   size: letter portrait;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>


<link rel="stylesheet" type="text/css" href="../../../_tableFilter/filtergrid.css" media="screen" />
<script type="text/javascript" src="../../../_tableFilter/tablefilter_all.js"></script>



</head>
<body class="global" onLoad="setInterval('fsubmit()',900000);">
            <div style="float: right;">
                <br /><b>Usuario:&nbsp;<? echo $_SESSION['usuARio'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br /><a href="javascript:Salir()" style="font-size: 1.1em; font-weight: bold; color: red;">Salir</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>

<form id="form1" name="form1" action="evento.php" method="post" name="submit button1">
<div align="center" class="frr">
 <font size="+2" color="navy"><br> <b>AVANCE <?= $evento." ".$year?> a </b></font>
 <font size="+2" color="crimsom"><b><?= $actualizado;?></b></font> 
</div>

<section33 align="center" style=" height:40%; background-color:<?= $bgcolor?>">

  <font color="<?= $color?>" size="+2" >ACUMULADO</font>
  
  <table align="center" class="frr" width="100%">
    <?
    echo "<tr><td></td>";
    foreach($cols AS $val){
      if($evenDim == $val){
        $bgcolor = "gainsboro";
        }else{
        $bgcolor = "";
        }
      echo "<th bgcolor='$bgcolor'>$val</th>";
      }
    echo "</tr>";  
    foreach($lineas AS $area){
    echo "<tr><th>$area</th>";
      $color ='';
      foreach($cols AS $val){
      if($area != 'TOTAL' AND $val != 'VAR %' ){ $tiT['TOTAL']["$val"] += $tiT[$area][$val];}
      if($val == 'VAR %' ){ $tiT["$area"]['VAR %'] = number_format(-100+$tiT[$area][$evenDim]/$tiT[$area][$evenDim_1]*100,0,',','.');}

      if($tiT[$area]["VAR %"] >= 1){
         $color = "Green";
         }elseif($tiT[$area]["VAR %"] >= -10){
         $color = "DarkOrange";
         }elseif($tiT[$area]["VAR %"] < -10){
         $color = "Red";
         }
      if($evenDim == $val){
        $bgcolor = "gainsboro";
        }else{
        $bgcolor = "";
        }
   
      echo "<td align ='right' style='border-radius:0;border-bottom:thin;border-bottom-style:solid;border-bottom-color:$color' bgcolor='$bgcolor'>
              <br>".number_format($tiT[$area][$val],0,',','.')."
            </td>";
      }
    echo "</tr>";
    }
    ?>  
        
  </table>
</section33>

<?

for($dia = $dias ;$dia >= 1; $dia-- ){
  if($dia == $dias){
    $txtHoy ="HOY";
    }else{
    $txtHoy ="";
    }
?>
<section33 align="center" style=" height:40%; background-color:<?= $bgcolor?>">

  <font color="<?= $color?>" size="+2" ><?= $txtHoy?> <?= $diasem["$dia"]?></font>
  
  <table align="center" class="frr" width="100%">
    <?
    echo "<tr><td></td>";
    foreach($cols AS $val){
      if($evenDim == $val){
        $bgcolor = "gainsboro";
        }else{
        $bgcolor = "";
        }
      echo "<th bgcolor='$bgcolor'>$val</th>";
      }
    echo "</tr>";  
    foreach($lineas AS $area){
    echo "<tr><th>$area</th>";
      $color ='';
      foreach($cols AS $val){
      if($area != 'TOTAL' AND $val != 'VAR %' ){ $ti["$dia"]['TOTAL']["$val"] += $ti["$dia"][$area][$val];}
      if($area == 'TOTAL' AND $val == 'VAR %' ){ $ti["$dia"]['TOTAL']["$val"] = number_format(-100+$ti[$dia][$area][$evenDim]/$ti["$dia"][$area][$evenDim_1]*100,0,',','.');}

      if($ti["$dia"][$area]["VAR %"] >= 1){
         $color = "Green";
         }elseif($ti["$dia"][$area]["VAR %"] >= -10){
         $color = "DarkOrange";
         }elseif($ti["$dia"][$area]["VAR %"] < -10){
         $color = "Red";
         }
      if($evenDim == $val){
        $bgcolor = "gainsboro";
        }else{
        $bgcolor = "";
        }
      echo "<td align ='right' style='border-radius:0;border-bottom:thin;border-bottom-style:solid;border-bottom-color:$color' bgcolor='$bgcolor'>
              <br>".number_format($ti[$dia][$area][$val],0,',','.')."
            </td>";
      }
    echo "</tr>";
    }
    ?>  
        
  </table>
</section33>
<? } //fin foreach?>
</form>
</body>
</html>

<script>
//submit
function fsubmit(){
		var idform = 'form1';
        document.forms[idform].submit();
}
//onLoad="setInterval('fsubmit()',10000);" 
</script>
<?
odbc_close();
mssql_close();
?>
