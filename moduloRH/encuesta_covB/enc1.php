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

//titulo $titulo ="Formulario de Creacion de Plan";
$titulo ="Encuesta COVID-19 1ra Vez";

//preguntaspor linea: $preguntasxl = 1;
$preguntasxl = 1;

// TABLA $tabla = "prov_plan";
$tabla = "rh_covid";

// CAMPOS ONCHANGE SUBMIT FORM $onchange = array('CAMPO1','CAMPO2'); 


// campos obligatorios $obligatorios = array('CAMPO1','CAMPO2'); Para todos los campos : $obligatorios = "todos";
$obligatorios = "todos";

//LISTAS DE ORIGEN SELECT : $lis[CAMPO] = "Opcion1|Opcion2|Opcion3|Opcion4";


// Valores Predeterminados: $lis[PRED][CAMPO] = "Valor";
$lis[PRED][AÃ‘O] = "2020";

//pagina cuando click boton cerrar formulario: $pagCierre = "index.php";
$pagCierre = "../../inicio.php";

//Control de Contenido $lis[CONT]["$CAMPO"] = ">= '$VALOR'"

$lis[CONT]["AÃ‘O"] = ">= '".date("Y")."'";
?>
<body class="global">
<div class="frl">
<br>
<br>
ANTES DE REALIZAR LA ENCUESTA RECUERDE: 
<br>1. Los datos reportados serán manejados según política de Protección de Datos del talento humano
<br>2. Sus respuestas deben ser concientes y sinceras.  Lo anterior para proporcionar adecuadamente el servicio que requiera
<br>3. En el momento en que alguno de los datos reportados cambie, se debe informar inmediatamente al Dpto. de Gestión Humana por los diferentes medios proporcionados (correo, teléfono coorporativo, celular del área o por medio de su jefe inmediato si lo considera)
</div>
<form id="frm1" class="Aabs" action="enc1.php" method="post" name="frm1" enctype="multipart/form-data" autocomplete="off">
<?
// codigo constructor de formulario
include("../../_crud.php");

if($guardo =='SI'){
$_POST = array();

echo '<script onload="recarga()" onClick="recarga()"></script> ';
}else{
echo '<input checked onChange="this.form.submit()" type="radio" class="frr" id="queVer" name="queVer" value="nuevoPlan" >';
}
?>
</form>
</body>
</html>