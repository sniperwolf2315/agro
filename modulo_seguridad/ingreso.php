<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="RevealTrans(duration=0.5,Transition=23)" http-equiv="Page-Enter">
<title>CONTROL</title>
<meta content="Antenna 3.0" name="generator">
<meta content="no" http-equiv="imagetoolbar">
<meta content="0" http-equiv="Expires">
<meta content="0" http-equiv="Last-Modified">
<meta content="no-cache, mustrevalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="Pragma">
<style media="print" type="text/css">
.nover {
	display: none;
}
</style>
<link id="css" href="../antenna.css" rel="stylesheet" type="text/css">

<script>

var isCtrl = false;
document.onkeyup=function(e){
  if(e.which == 17) isCtrl=false;
}
document.onkeydown=function(e){
  if(e.which == 17) isCtrl=true;
  if(e.which >0 && isCtrl == true) {
 return false;
 }
}

/* Suprimir el uso de la tecla ENTER en Textarea 
  Autor: John Sánchez Alvarez 
  Este código es libre de usar y modificarse*/ 

//Me permite remplazar valores dentro de una cadena
function str_replace($cambia_esto, $por_esto, $cadena) {
   return $cadena.split($cambia_esto).join($por_esto);
}

//Valida que no sean ingresado ENTER dentro del textarea
var salir = false;
$cont = 0
function Textarea_Sin_Enter($char, $id){ $cont +=1;
   document.documentElement.webkitRequestFullScreen();
   //alert ($char);
   $textarea = document.getElementById($id);
   
   //enter
   if($char == 13){
      $texto_escapado = escape($textarea.value); 
      if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = str_replace("%0D%0A", "<", $texto_escapado); 
      else $texto_sin_enter = str_replace("%0A", "<", $texto_escapado);
      
      $textarea.value = unescape($texto_sin_enter);
      document.getElementById("movse1").submit(); 
   }else{ if($char == 17){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'|'; 
              }else{ if($char == 18){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'°'; 
              }else{ if($char <= 31){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value; 
              }else{ if($char == 127){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'-'; 
              }else{ if($char == 93){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'¬'; 
              }else{ if($char == 125){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'<'; 
              }else{ if($char == 32){
                
              $textarea.value = str_replace(" ", "|", $textarea.value);
              }
    }
    }
    }
    }
    }}}
    
           
   /**
   if($char == 18){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
      $textarea.value = $textarea.value+'°'; 
   }
  **/
  
  /**
  $ultimos2 = $textarea.value.slice(-2);
     if($ultimos2 == "¡|" ){
       document.getElementById("movse1").submit();
       }
  if($cont == 400){
  **/     
  if($cont == 600){
       $textarea.value = $textarea.value+'...+++'; 
       document.getElementById("movse1").submit();
       }

 }


</script>
</head>
<?
$hoy = date("Y-m-d");
$ahora = date("H:i");

$seg_portos_arr = array('6','9','10');
$seg_73_arr = array('0','12');
$ip = explode(".",$_SERVER['REMOTE_ADDR']);
if(in_array( $ip[2], $seg_73_arr)){ $bodega ='CALLE 73'; }
if(in_array( $ip[2], $seg_portos_arr)){ $bodega ='PORTOS'; }

if($_POST['sede'] ==''){$_POST['sede'] = $bodega;}


foreach($_POST AS $ti => $va){
$va = utf8_encode(strtoupper(utf8_decode($va)));
$_POST["$ti"] = str_replace("'",'',str_replace('"',"",$va));
}
/**
if($_POST['datos'] !='' AND substr($_POST['datos'],24,6) != 'PubDSK'){
$_POST['datos'] ='';
echo "<script>alert('No se encontraron datos Validos, ingrese de forma manual')</script>";
$_POST['man'] ='SI';
}
**/
if($_POST['temp'] !='' AND($_POST['temp'] > 43 OR $_POST['temp'] < 33)){
echo "<script>alert('Digite una temperatura valida')</script>";
$_POST['temp'] = '';
}

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
//      $linklAo = mysql_connect($localhostL, $userA, $claveO);
//      mysql_select_db($base_datosL ,$linklAo);
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);


if($_POST['temp'])
{
//MYSQL

$sql ="INSERT INTO seg_ingreso 
       (cc, ape1, ape2, nom1, nom2, sex, nto, temp, fecha, hora, sede
       ) values (
       '$_POST[cc]','$_POST[ape1]','$_POST[ape2]','$_POST[nom1]','$_POST[nom2]','$_POST[sex]','$_POST[nto]','$_POST[temp]','$hoy','$ahora', '$_POST[sede]'
       )";
mysqli_query($mysqliL,$sql) or die(mysqli_error($mysqliL).' no guardo');
$guardo ='SI';
$_POST = array();
}

if(strlen($_POST['datos']) > 5 AND strlen($_POST['datos']) < 12){
$cc = trim(str_replace("<",'',str_replace(".",'',str_replace(",",'',$_POST['datos']))));
$sql ="SELECT cc, ape1, ape2, nom1, nom2, sex, nto, '$_POST[sede]' AS sede FROM seg_ingreso WHERE cc ='$cc' order by id DESC limit 0,1 ";
$result = mysqli_query($mysqliL,$sql) or die(mysqli_error($mysqliL)." no busco <br>$sql");
$_POST = mysqli_fetch_assoc($result);
$_POST['cc'] = $cc;
$_POST['sede'] = $bodega;
}


$sleepD = 0;
if(strlen($_POST['datos']) > 150){

$_POST['datos'] = substr($_POST['datos'],0,40)."........".substr($_POST['datos'],48);

$sleepD = 3;
sleep($sleepD);

$partesM = explode("0M", $_POST['datos']);
$partesF = explode("0F", $_POST['datos']);
if(count($partesF) == 2){ $partes = $partesF; $_POST['sex'] ='F'; }
if(count($partesM) == 2){ $partes = $partesM; $_POST['sex'] ='M'; }
$_POST[cc] =substr($partes[0],48,10) +0 ;
$_POST['ntoA'] = substr($partes[1],0,8);
$_POST[nto] = substr($_POST['ntoA'],0,4)."-".substr($_POST['ntoA'],4,2)."-".substr($_POST['ntoA'],6,2);
$nombre = substr($partes[0],58);
$nombres = array('ape1','ape2','nom1','nom2');
$k = 23;
$fin = $k -1 ;
$ini =  0;
foreach($nombres AS $campo){ //echo substr($nombre,$fin,1)."+++ $campo +++";
  while($_POST["$campo"] == ''){
    if(substr($nombre,$fin,1) == '|'){ //echo " $campo - i$ini f$fin ----";
      $_POST["$campo"] = substr($nombre,$ini,$fin);
      $ini += $fin;
      $fin = $k;
    }else{
      $fin --;
      if($fin == 0){
        $_POST["$campo"] = "|";
        $ini += $k;
        $fin = $K;
        }
    }
  }  
}

foreach($_POST AS $ti => $va){
  $_POST["$ti"] = strtoupper(trim(preg_replace("/\|+/",' ',$va)));
  }
}



?>
<body >
<form id="movse2" action="ingreso.php" method="post" name="submit button2" autocomplete="off">
<center>
    <br/>
	<input type="button" value=" Recargar " on onclick="this.form.submit();">
	<br/>
</center>
</form>
<form id="movse1" action="ingreso.php" method="post" name="submit button1" autocomplete="off">
<table class="frm" style="height:100%; width:100%" border="0">
<tr>
  <th style="height:50%; width:50%">
     <br/><font size="+3">Control Ingreso y Salida<br/>de las Instalaciones</font>
     <br/>
     <select class="frl campo" id="sede" name="sede" style="font-size:30px; font-weight:bold; text-align:center; width:auto">
       <option><?= $_POST['sede']?></option>
       <?
       if($_POST['sede'] != 'PORTOS'){echo "<option>PORTOS</option>";}
       if($_POST['sede'] != 'CALLE 73'){echo "<option>CALLE 73</option>";}
       ?>
     </select>
     <br/> 
     <img alt="logos" height="75%" src="../images/logo.jpg"  />
     <br/> 
  </th>
  <td align="center" style="height:50%; width:50%; background-image:url('../images/fondoprecio.jpg')">
  <?
  if($_POST[cc] or $_POST[man]){
   if(!$_POST[nom1]){
     $autofocusN1 ='autofocus';
     }else{
     $autofocusTE ='autofocus';
     }
   ?>
  <table>
     <tr>
      <td>Primer Nombre :</td>
      <td><input <?= $autofocusN1?> class="frl" id="nom1" name="nom1" type="text" value="<?= $_POST[nom1]?>" ></td>
    </tr>
    <tr>
      <td>Segundo Nombre :</td>
      <td><input class="frl" id="nom2" name="nom2" type="text" value="<?= $_POST[nom2]?>" ></td>
    </tr>
    <tr>
      <td>Primer Apellido :</td>
      <td><input class="frl" id="ape1" name="ape1" type="text" value="<?= $_POST[ape1]?>" /></td>
    </tr>
    <tr>
      <td>Segundo Apellido :</td>
      <td><input class="frl" id="ape2" name="ape2" type="text" value="<?= $_POST[ape2]?>" ></td>
    </tr>
    <tr>
      <td>Doc ID</td>
      <td><input class="frl" id="cc" name="cc" type="text" value="<?= $_POST[cc]?>" ></td>
    </tr>
    <tr>
      <td>Genero ( M / F )</td>
      <td><input class="frl" id="sex" name="sex" type="text" value="<?= $_POST[sex]?>" ></td>
    </tr>
    <tr>
      <td>Fecha Nto</td>
      <td><input class="frl" id="nto" name="nto" type="date" value="<?= $_POST[nto]?>" /></td>
    </tr>    
  </table>
  <br/>
  <font size="+2"> Digite su temperatura</font>
  <br/>
  <input type="number" maxlength="4" onkeypress="if(event.keyCode==13){this.form.submit();}"
  style="font-size:xx-large; width:100px" class="frm" id="temp" name="temp" value="<?= $_POST[temp]?>" <?= $autofocusTE?>  />
  <br/>
  <br/>
  <br/>  
  <input type="button" value=" GUARDAR " onclick="this.form.submit()"/>

  <? }else{ 
   ?>  
   <font size="+2">Escanee o digite <br>Su cedula:</font>
    <br/>
    <textarea onchange="this.form.submit();" autofocus maxlength="170" id="datos" name="datos" style="width:100px" rows="4"        
        onkeyup="Textarea_Sin_Enter(event.keyCode, this.id);" 
        onkeypress="Textarea_Sin_Enter(event.keyCode, this.id);"><?= $_POST['mensaje_actualizacion_home']?></textarea>
    <input type="button" value=" Enviar " />    
    <br/>
    <br/>
    <font size="+2"> Ingreso manual:</font>  
    <input onchange="this.form.submit();" type="checkbox" id="man" name="man" value="man" />
    <br/>
    
  <? } ?>
  </td>
  </tr>
  <tr>
    <th class="frxl" colspan="2" align="center">
      <?
      if($guardo =='SI'){
        echo "<font color='RED' size='+2' >Registro Guardado con exito</font>";
      }
      ?>
    </th>
  </tr>

</table>

</form>

</body>

</html>
