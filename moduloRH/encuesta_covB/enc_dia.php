<? session_start();
include("../../user_con.php"); 
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
$hoy = date ("Y-m-d");
if(date ("H") > 12){
  $hoy_AoP = "PM";
  }else{
  $hoy_AoP = "AM";
  }
//titulo $titulo ="Formulario de Creacion de Plan";
$titulo ="Encuesta COVID-19 Diaria";

//preguntaspor linea: $preguntasxl = 1;
$preguntasxl = 1;

// TABLA $tabla = "prov_plan";
$tabla = "rh_covid_diaria";

// CAMPOS ONCHANGE SUBMIT FORM $onchange = array('CAMPO1','CAMPO2'); 
$onchange = array('Cedula'); 


// campos obligatorios $obligatorios = array('CAMPO1','CAMPO2'); Para todos los campos : $obligatorios = "todos";
$obligatorios = "todos";

//LISTAS DE ORIGEN SELECT : $lis[CAMPO] = "Opcion1|Opcion2|Opcion3|Opcion4";


// Valores Predeterminados: $lis[PRED][CAMPO] = "Valor";
$lis[PRED][FECHA] = "$hoy $hoy_AoP";

//-Campos bloqueados a escritura: $readonlys = array('id_plan')
$readonlys = array('FECHA');


//pagina cuando click boton cerrar formulario: $pagCierre = "index.php";
$pagCierre = "../../inicio.php";

//Control de Contenido $lis[CONT]["$CAMPO"] = ">= '$VALOR'"

$lis[CONT]["AÃ‘O"] = ">= '".date("Y")."'";


//busca datos de cedulas
if($_POST['Cedula'] != '' AND $_POST['Nombre'] =='' AND $_POST['Empresa'] ==''){
$sql = "SELECT EMPRESA, Nombre, Area FROM rh_covid_diaria where Cedula ='$_POST[Cedula]' ORDER  BY FECHA desc limit 0,1";
$result = mysqli_query($mysqli, $sql); // or die(mysqli_error($mysqli)." Error ");
while($row = mysqli_fetch_assoc($result))
    foreach($row AS $ca => $va){ 
    $_POST["$ca"] = $va;
    }
    
$sql = "SELECT temp AS 'Tome_su_temperatura_e_indique_su_nivel', Sede AS 'Donde_se_encuentra' FROM seg_ingreso where cc ='$_POST[Cedula]' and fecha ='$hoy' ORDER  BY fecha desc limit 0,1";
$result = mysqli_query($mysqli, $sql); // or die(mysqli_error($mysqli)." Error ");
while($row = mysqli_fetch_assoc($result))
    foreach($row AS $ca => $va){ 
    $_POST["$ca"] = $va;
    }
}
?>
<body class="global">
<div class="frl">
<br>
<br>
	
<ul><font color='$color' style='text-shadow: black 0.1em 0.1em 0.2em;'>ANTES DE REALIZAR LA ENCUESTA RECUERDE: </font>
<br><ul> 1. Los datos reportados serán manejados según política de Protección de Datos del talento humano
<br> 2. Sus respuestas deben ser concientes y sinceras.  Lo anterior para proporcionar adecuadamente el servicio que requiera
<br> 3. En el momento en que alguno de los datos reportados cambie, se debe informar inmediatamente al Dpto. de Gestión Humana por los diferentes medios proporcionados (correo, teléfono coorporativo, celular del área o por medio de su jefe inmediato si lo considera)
</ul></ul>
</div>
<form id="frm1" class="Aabs" action="enc_dia.php" method="post" name="frm1" enctype="multipart/form-data" autocomplete="off" >
<?
//respuestas "SI"
foreach($_POST AS $pre => $rta){
  $nombre = strtoupper($_POST['Nombre']);
  $temp = $_POST['Tome_su_temperatura_e_indique_su_nivel'];
  $sede = strtoupper($_POST['Donde_se_encuentra']);
  $empresa = strtoupper("$_POST[EMPRESA], $_POST[Area]");
  if ($pre != 'completo' AND $rta =='SI'){
  $pregsSI[] = $pre;
  }
}

// codigo constructor de formulario
include("../../_crud.php");

if($_POST['guardo'] =='SI'){
echo '<script>alert(" ***** \n \n Encuesta COVID-19 \n Guardada con exito \n Gracias por tu tiempo! \n \n *******")</script>';
$_POST = array();

// correo si hubo respuestas en SI
if(count($pregsSI)>0){

$sisas = count($pregsSI);
if($temp > '37.8'){ 
  $sisas += 2;
  $pregsSI[] = "Posible fiebre";
  }
if($sisas == 1){ 
  $asuntotxt = "⚠️Aviso Encuesta COVID" ; $color = "";
  }elseif($sisas == 2){
  $asuntotxt = "⚠️Alerta Amarilla Encuesta COVID"; $color = "Gold";
  }elseif($sisas == 3){
  $asuntotxt = "🚨 Alerta Naranja Encuesta COVID"; $color = "DarkOrange";
  }elseif($sisas > 3){
  $asuntotxt = "🚨 Alerta Roja Encuesta COVID"; $color = "red";
  }
$sintomas = "<ul>";  
foreach($pregsSI AS $preg => $rta){
$sintomas .= "<li>".str_replace("_"," ",$rta)."</li>";
}
$sintomas .= "</ul>";

if($sede =='PORTOS'){ $dest .= "felipe.baron@agrocampo.com.co"; }
if($sede =='CALLE 73'){ $dest .= "david.rodriguez@agrocampo.com.co"; }  
//correo electronico 
            $destinatario ="$dest"; 
			$copiados = "gerencia@agrocampo.com.co; maria.nino@agrocampo.com.co; proyectosagro@agrocampo.com.co";
			
			$asunto = $asuntotxt; 
			$cuerpo = " 
			<html> 
			<head> 
   			<title>NOTIFICACION ENCUESTA COVID-19 DEL $hoy</title> 
				</head> 
				<body>
				<br>
				<H>NOTIFICACION ENCUESTA COVID-19 DEL $hoy</H>
				<br>
				<br>
				<font color='$color' style='text-shadow: black 0.1em 0.1em 0.2em'>$asuntotxt</font>
				<br>
				<br>
				<table>
                  <tr>
                    <td>Colaborador</td>
                    <td>: $nombre</td>
                  </tr>
                  <tr>
                    <td>Empresa</td>
                    <td>: $empresa</td>
                  </tr>
                  <tr>
                    <td>Localizacion</td>
                    <td>: $sede</td>
                  </tr>
                </table>

				<br>
				<br>
				Sintomas:
				<br>
				$sintomas
				<br>
				<br>
                Cordialmente
                <br>
                Encuesta COVID Agrocampo
                <br>
                Feliz dia!
				<br>
				$ahora
				
				</body> 
				</html> 
				";

				//para el envÃƒÂ­o en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=utf8\r\n"; 

				//direcciÃƒÂ³n del remitente 
				$headers .= 'From: Encuesta COVID Agrocampo <no_responder@agrocampo.com.co>' ."\r\n"; 
				
				//con copia a 
				$headers .= 'Cc: '.$copiados.'' . "\r\n";


				//direcciÃƒÂ³n de respuesta, si queremos que sea distinta que la del remitente 
				$headers .= "Reply-To: No responder a este correo <no_responder@agrocampo.com.co>\r\n"; 
 
				
				if( mail("$destinatario",$asunto,$cuerpo,$headers) )
				{ 
				//echo $cuerpo;  //echo "Correo enviado con exito"; 
				} else { 
				  echo "Error al enviar correo";  
				}

}

echo '<script onload="recarga()" onClick="recarga()"></script> ';
}
?>
</form>
</body>
</html>