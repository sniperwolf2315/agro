<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script>

 
var isCtrl = false;
document.onkeyup=function(e){
if(e.which == 17) isCtrl=false;
//if(e.which == 18) isCtrl=false;
//if(e.which == 18 && e.which == 17) isCtrl=false;
}
document.onkeydown=function(e){
if(e.which == 17) isCtrl=true;
//if(e.which == 18) isCtrl=true;
if(e.which > 0 && isCtrl == true) {
//Combinancion de teclas CTRL+P y bloquear su ejecucion en el navegador
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
function Textarea_Sin_Enter($char, $id){
   document.documentElement.webkitRequestFullScreen();
   //alert ($char);
   $textarea = document.getElementById($id);
   
   //enter
   if($char == 13){
      $texto_escapado = escape($textarea.value); 
      if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = str_replace("%0D%0A", "<", $texto_escapado); 
      else $texto_sin_enter = str_replace("%0A", "<", $texto_escapado);
      
      $textarea.value = unescape($texto_sin_enter); 
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
      
              $textarea.value = $textarea.value+'¬'; 
              }else{ if($char == 93){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'¬'; 
              }else{ if($char == 125){
      //$texto_escapado17 = escape($textarea.value); //alert($texto_escapado);
      //if(navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter = $textarea.value.slice(0,-1);
      //else $texto_sin_enter = $texto_sin_enter = $textarea.value.slice(0,-1);
      
              $textarea.value = $textarea.value+'¬'; 
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
  $ultimos2 = $textarea.value.slice(-2);
  //alert($ultimos3);
     if($ultimos2 == "¡|"){ 
       document.getElementById("movse1").submit();
       }
 }

</script>

<?
$hoy = date("Y-m-d");
$ahora = date("H:i");

foreach($_POST AS $ti => $va){
$_POST["$ti"] = str_replace("'",'',str_replace('"',"",$va));
}
if($_POST['datos'] !='' AND substr($_POST['datos'],24,6) != 'PubDSK'){
$_POST['datos'] ='';
echo "<script>alert('No se encontraron datos Validos, ingrese de forma manual')</script>";
$_POST['man'] ='SI';
}

if($_POST['datos']){
sleep(3);
$_POST[cc] =substr($_POST['datos'],48,10) +0 ;
$_POST[ape1] =substr($_POST['datos'],58,23);
$_POST[ape2] =substr($_POST['datos'],81,23);
$_POST[nom1] =substr($_POST['datos'],104,23);
$_POST[nom2] =substr($_POST['datos'],127,23);
$_POST[sex] =substr($_POST['datos'],151,1);
$_POST[ntoA] = substr($_POST['datos'],152,8);
$_POST[nto] = substr($_POST['ntoA'],0,4)."-".substr($_POST['ntoA'],4,2)."-".substr($_POST['ntoA'],6,2);
foreach($_POST AS $ti => $va){
$_POST["$ti"] = strtoupper(trim(str_replace("|",'',$va)));
}
}

if($_POST['temp'] !='' AND($_POST['temp'] > 43 OR $_POST['temp'] < 33)){
echo "<script>alert('Digite una temperatura valida')</script>";
$_POST['temp'] = '';
}

if($_POST['temp'])
{
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
//      $linklAo = mysql_connect($localhostL, $userA, $claveO);
//      mysql_select_db($base_datosL ,$linklAo);
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

$sql ="INSERT INTO seg_ingreso 
       (cc, ape1, ape2, nom1, nom2, sex, nto, temp, fecha, hora
       ) values (
       '$_POST[cc]','$_POST[ape1]','$_POST[ape2]','$_POST[nom1]','$_POST[nom2]','$_POST[sex]','$_POST[nto]','$_POST[temp]','$hoy','$ahora'
       )";
mysqli_query($mysqliL,$sql) or die(mysqli_error($mysqliL).' no guardo');
$guardo ='SI';
$_POST = array();
}

?>


<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="ofi/antenna.css" id="css" />

<title>Untitled 1</title>

</head>

<body>
<form id="movse1" action="zzesp.php" method="post" name="submit button1" autocomplete="off">
<table class="frm" style="height:100%; width:100%" border="1">
<tr>
  <td style="height:50%">
     Agrocamp <br> Control de temperartura al ingreso y salida
  </td>
  <td align="center">
  <?
  if($_POST[cc] or $_POST[man]){
   ?>
  <table>
    <tr>
      <td>Primer Apellido :</td>
      <td><input class="frm" id="ape1" name="ape1" type="text" value="<?= $_POST[ape1]?>" ></td>
    </tr>
    <tr>
      <td>Segundo Apellido :</td>
      <td><input class="frm" id="ape2" name="ape2" type="text" value="<?= $_POST[ape2]?>" ></td>
    </tr>

    <tr>
      <td>Primer Nombre :</td>
      <td><input class="frm" id="nom1" name="nom1" type="text" value="<?= $_POST[nom1]?>" ></td>
    </tr>
    <tr>
      <td>Segundo Nombre :</td>
      <td><input class="frm" id="nom2" name="nom2" type="text" value="<?= $_POST[nom2]?>" ></td>
    </tr>
    <tr>
      <td>Doc ID</td>
      <td><input class="frm" id="cc" name="cc" type="text" value="<?= $_POST[cc]?>" ></td>
    </tr>
    <tr>
      <td>Genero</td>
      <td><input class="frm" id="sex" name="sex" type="text" value="<?= $_POST[sex]?>" ></td>
    </tr>
    <tr>
      <td>Nto</td>
      <td><input class="frm" id="nto" name="nto" type="date" value="<?= $_POST[nto]?>" /></td>
    </tr>    
  </table>
  <br/>
  Digite su temperatura
  <br/>
  <input type="number" maxlength="4" class="frxl" id="temp" name="temp" value="<?= $_POST[temp]?>" autofocus  />
    <input type="button" value=" EXECUTE " onclick="this.form.submit()"/>

  <? }else{ 
   ?>  
   Escanee su cedula:
    <br/>
    <textarea onchange="this.form.submit();" autofocus maxlength="170" id="datos" name="datos" style="width:40px" rows="3"        
        onkeyup="Textarea_Sin_Enter(event.keyCode, this.id);" 
        onkeypress="Textarea_Sin_Enter(event.keyCode, this.id);"><?= $_POST['mensaje_actualizacion_home']?></textarea>
    <input type="button" value=" Enviar " />    
    <br/>
    <br/>Ingreso manual: <input onchange="this.form.submit();" type="checkbox" id="man" name="man" value="man" />
    <br/>
    
  <? } ?>
  </td>
  <tr>
    <td colspan="2" align="center">
      <?
      if($guardo =='SI'){
        echo "<font color='RED' >Registro Guardado con exito</font>";
        sleep(2);
        header('zzesp.php');
      }
      ?>
    </td>
  </tr>
</tr>

</table>

</form>

</body>

</html>

