<? session_start();
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}

//include("../../user_con.php");
//if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}

//db2
	$db2con = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);



$hoy = date("Ymd");
$hoy_1 = date("Ymd",strtotime("$hoy - 1 day"));

$n = 1;
$hoy_n = date("Ymd",strtotime("$hoy - $n day"));

$ahora = date("M-d H:i");  

$area ='Moto';
if($area == 'Portos'){}
if($area == 'Calle73'){}
if($area == 'Moto'){ $farea =" AND SROORSHE.OHDEST IN ('5') ";}

  $sql ="SELECT
			SROORSHE.OHORNO AS ORDEN
			, SUBSTR(SROORSHE.OHODAT,1,4)||'-'||SUBSTR(SROORSHE.OHODAT,5,2)||'-'||SUBSTR(SROORSHE.OHODAT,7,2) AS FECHA_ORDEN
			, (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) AS ESTADO
			, ( SELECT DTDESC FROM AGR620CFAG.SRODST WHERE DTDEST = SROORSHE.OHDEST)  AS DEST
			, '' AS HORA_LIB
			, '' AS OBS
		FROM AGR620CFAG.SROORSHE SROORSHE
		WHERE
		((
		  SROORSHE.OHODAT >= '$hoy_n' 
		  AND 
		  (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) BETWEEN '20' AND '59' 
	 	))
	 	
	 	$farea 
		
		ORDER BY SROORSHE.OHORNO DESC
		
";
  $result = odbc_exec($db2conp, $sql);
  while($row = odbc_fetch_array($result)){
     $orden = $row["ORDEN"];
     $row["FECHA_ORDEN"] = DATE("M-d",strtotime($row["FECHA_ORDEN"])); 
       if($_POST["$orden"] == "" OR $row["ESTADO"] =='60' ){
       		if($row["ESTADO"] =='60'){$estado ='60';}else{$estado ='20';} 
           $sqlM = "select CAMBIO from OC_ESTADO_AG WHERE ORDEN = '$orden' AND ESTADO >= '$estado' ORDER BY CAMBIO LIMIT 0,1 ";
           $resultM = $mysqli->query($sqlM);
           $hora = '';
           while($rowM = $resultM->fetch_array())
	         {
	         $hora = date("M-d H:i",strtotime($rowM[0]));; 
	         }
	       if($hora == ''){
	       	$hora = $ahora ;
	       	}
	     $row["HORA_LIB"] = $hora ;  	  
         }else{
         $row["HORA_LIB"] = $_POST["$orden"];
         }
     
    
     if(date("H",strtotime($hora)) >= 17){
     	if(date("D",strtotime($hora)) == 'Sat'){ $_dias = 2; }else{ $_dias = 1; }
     	$hora = date("M-d 08:00",strtotime("$hora + $_dias day"));
     	}
     
     $mins = (strtotime($ahora) - strtotime($hora))/60;
     
     if( date("Y-m-d",strtotime($ahora)) != date("Y-m-d",strtotime($hora)) ){
     $atraso = (strtotime(date("Y-m-d",strtotime($ahora)))-strtotime(date("Y-m-d",strtotime($hora))))/(24*60*60);
       if($atraso == 1){
       $atraso .=" Dia";
       }else{
       $atraso .=" Dias";
       }  
     }else{
     $atraso = (strtotime($ahora) - strtotime($hora))/60;
       if($atraso >= '60'){
       $atraso = number_format(($atraso/60),1,',','')." horas";
       }else{
       $atraso = number_format($atraso,0,'','')." min";
       }
     }
     if($row["ESTADO"] == '20'){
       if($mins < 15){
       $row["OBS"] = "A Tiempo $atraso";
       $color["$orden"] = "lightgreen"; $color2["$orden"] = "green";
       }elseif($mins >= 15){
       $row["OBS"] = "Retraso $atraso";
       $color["$orden"] = "PINK"; $color2["$orden"] = "red";
       }
     }
     
     if($row["ESTADO"] > '20'){
       $row["OBS"] = "Abordando";
       $color["$orden"] = "LightBlue"; $color2["$orden"] = "Blue";
     }
     if($row["ESTADO"] > '59'){
       $row["OBS"] = "Salió";
       $color["$orden"] = ""; $color2["$orden"] = "";
     }

       
  foreach($row as $titulo => $valor){
    $ti["$titulo"]["$orden"] = "$valor";
    }
  if($row['ESTADO'] =='60'){
    $hora2 = $ahora;
  }else{
    $hora2 = $row['HORA_LIB'];
  }
  $tiHORA["$hora2 | $orden"] = $orden;   
  }
  ksort($tiHORA);
  
  if(count($tiHORA) == 0){ $ti[" ----- SIN PEDIDOS PENDIENTES ----- "] = ''; $tiHORA[] = '';} 
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >

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


</head>
<body class="global" onLoad="setInterval('fsubmit()',60000);">


<form id="form1" name="form1" action="oc_rutaB.php" method="post" name="submit button1">

<table class="frs" align="center" width="100%" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" > 
<tr>
<td align="center" valign="top" style="width:98% ; background-color:white; border-color:white;">
<img height="70" src="../../images/salidas.png">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a style="font-size:8mm; font-weight:bolder"><?= date("d-M , H:i",strtotime($ahora))?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ESTADO DE DESPACHO DE PEDIDOS </a>
</td>
<tr>
<td align="center" valign="top" style="width:98% ; background-color:white; height: 176px; border-color:white;">
<?	//tabla de ordenes	
	$cont = 0;
	$lineas = count($tiHORA);
	if($lineas <= 20){
	  $font_size = "font-size:6mm";
	  }elseif($lineas <= 23){
	  $font_size = "font-size:5mm";
	  }elseif($lineas <= 25){
	  $font_size = "font-size:4mm";
	  }else{
	  $font_size = "font-size:3.5mm";
	  }
	foreach($tiHORA AS $orden ){
	    if($cont == 0 or $cont > '30'){
	        if($cont > '30'){
	        $cont = 0;
	        echo "</tr></table></td><td>";
	        } 
	    	echo '<br><table align="center" class="frs" border="1" style="'.$font_size.'">
	    		  <tr>
	    		  ';
	   		foreach($ti as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
        echo "</tr>";
	    }
		echo "<tr>";
		foreach($ti as $titulo => $valor){
			if(is_numeric($ti["$titulo"]["$orden"])){
	      		if($titulo =="TOTAL_EXC_IVA"){$mil=".";}else{$mil="";}
	      		$ti["$titulo"]["$orden"] = number_format($ti["$titulo"]["$orden"],0,"","$mil");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      	if($ti["$titulo"]["$orden"] == '0'){ $ti["$titulo"]["$orden"] =''; }
	      	if($titulo =='HORA'){ 
	      	    $ordenH = $ti["ORDEN"]["$orden"];  
	      	    $ordenHV = $ti["$titulo"]["$orden"]; 
	      	    $horaH ="<input name='$ordenH' id='$ordenH' type='hidden' value='$ordenHV'>"; 
	      	  }else{ 
	      	    $horaH = "";} 
	      	echo "<td $alri style='padding-right:5px;border-radius:0; background-color:".$color["$orden"]."; border-color:".$color2["$orden"]."; border-width: medium; border-left-style:none; border-top-style:none; border-right-style:solid; border-bottom-style:solid; '>$horaH".substr($ti["$titulo"]["$orden"],0,15)."</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	if($cont > 0){
	    	echo '</table>';
	   		}


?></td>
</table>
 
   
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

