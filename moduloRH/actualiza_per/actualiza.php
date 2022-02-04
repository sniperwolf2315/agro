<? session_start();
include("../../user_con.php"); 

// if($_SESSION["clAVe"] == '') {ECHO "<br>Debe iniciar sesion"; DIE;}
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
// if($_POST['cols'] == ''){ $submi ="alert('algo ;)'); document.frm1.submit();"; }
?> 
<body class="global">

<? 
  $hoy = date ("Y-m-d");
//preguntaspor linea

echo "cols $_POST[cols].";
$preguntasxl = 2;

// CAMPOS ONCHANGE SUBMIT FORM 

$onchange = array('CUANTOS_HIJOS');

// campos obligatorios

$obligatorios = array('PRIMER_NOMBRE','PRIMER_APELLIDO','SEXO','TIPO_DE_ID','DIRECCION_DE_RESIDENCIA','NUMERO_DE_CELULAR','E_MAIL','FECHA_DE_NACIMIENTO','CUANTOS_HIJOS','ID','con1','con2');

//VALIDA OBLIGATORIOS

foreach($_POST as $campoP => $valorP){
	
	if(in_array("$campoP",$obligatorios)){
		if($valorP ==''){ $errores+= 1; $colorE["$campoP"] = "background-color:LIGHTpink;"; }
	}
}
if(count($obligatorios)== $errores){ $colorE = array(); }
 	
//SACA campos
$sql = "SHOW FULL COLUMNS FROM rh_personal ";
$result = $mysqli->query($sql) or die ('error: '.mysqli_error());
$coma ="";
while($campo = $result->fetch_array())
	{
	$tit[] = $campo['Field'];
	  $tipo = explode('(',$campo['Type']); 
	$typ[] = $tipo[0];
	  $longitud = explode('(',$campo['Type']);
	$lon[] = str_replace(')','',$longitud[1]) + 0 ;
	$lis[] = explode('|',utf8_encode($campo['Comment']));  
	}

//inserta datos
if(count($_POST) > 0 AND $errores == 0){
	$coma = '';
	foreach($tit as $line => $campo){
	$campos .= "$coma$campo";
	
	$values .= "$coma'".$_POST["$campo"]."'";
	$coma =',';
	}
	
	$sql = "INSERT INTO rh_personal ($campos) VALUES ($values) "; //echo $sql;
	$mysqli->query($sql);
	$errorMS = $mysqli->errno;
	
	$campos = '';
	$values = '';
	
	$siga ='NO';
	
	if($errorMS == ''){ $siga='SI';}
	if($errorMS == '1062'){ 
		echo '<script>alert(" ***** \n Cedula \n '.$_POST['ID'].' \n ya tiene informacion almacenada \n *******")</script>';
		}elseif($errorMS != ''){
		echo '<script>alert(" ***** \n Error !\n Tome nota de este error y reporte el caso: \n '.$mysqli->error.' \n *******")</script>';
		}
	if( $siga=='SI' ){
		$coma ='';
		for($i =1; $i <= $_POST["CUANTOS_HIJOS"]  ; $i ++){
		$values .= "$coma('$_POST[ID]','HIJO','".$_POST["nom$i"]."','".$_POST["fe$i"]."','".$_POST["sex$i"]."','','')";
		$coma = ',';
		}	
		
		for($i =1; $i <= 3  ; $i ++){
			if($_POST["con$i"] !=''){
			$values .= "$coma('$_POST[ID]','CONTACTO','".$_POST["con$i"]."','0000-00-00','','".$_POST["pa$i"]."','".$_POST["tel$i"]."')";
			$coma = ',';
			}
		}
	$sql ="INSERT INTO rh_personal_otros (`id_per`, `tipo_otros`, `nombre_otros`, `fecha_nto_otros`, `sexo_otros`, `paren_otros`, `tel_otros`) 
			VALUES $values";
	$mysqli->query($sql);
	if($mysqli->error){
	echo $mysqli->error." $sql"; 
	}else{
	echo '<script>alert(" ***** \n Informacion de \n '.$_POST['PRIMER_NOMBRE'].' \n Almacenada con exito !! \n *******")</script>';
	$_POST = array();
	};
	
	}	
		
} //fin if errores
?>

<div id="ifra724vlrhy2" align="center" class="aut " style="width:100%; height:98%; ">
<br>
<form id="frm1" class="Aabs" action="actualiza.php" method="post" name="frm1" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" id='cols' name="cols">
<table align="center" class="frs" width="85%" border="0" cellspacing="0">
	<tr>
		<td bgcolor="white" align="center" valign="middle" colspan="<?= $preguntasxl*2?>" ><img src="../../images/logoAG.jpg" height="50%"><br><font size="+3" >Formulario de actualización de datos</font></td>
	</tr> 
	<tr>
	<?
	foreach($tit as $fila => $titulo){
	if($lon["$fila"] <= 0){
		$anchoC = "90%";
		}elseif($lon["$fila"] <= 5){
		$anchoC = "15%";
		}elseif($lon["$fila"] <= 10){
		$anchoC = "50%";
		}else{
		$anchoC = "90%";
		}
		
	$tipo = "type='text'";	
	if($typ["$fila"] == 'date'){ $tipo = "type='date'";	}
	if($typ["$fila"] == 'int'){ $tipo = "type='number'";	}

	if(in_array("$titulo",$onchange)){
		$onchageS =" onchange='this.form.submit();' ";
		}else{
		$onchageS ="";
		}
	
	if( count($lis["$fila"]) > 1 ){
		$campo = "<select $onchageS class='frm campo' style='width:25%;".$colorE["$titulo"]."' id='$titulo' name='$titulo'>
					<option>".$_POST[$titulo]."</option>";
		foreach($lis["$fila"] as $valorl){
			if ($_POST[$titulo] != $valorl ){$campo .= "<option>$valorl</option>";}	
			}
		$campo .= "</select>";	
		}else{
		$campo = "<input $onchageS $tipo class='frm campo' style='width:$anchoC;".$colorE["$titulo"]."' id='$titulo' name='$titulo' value='".$_POST[$titulo]."'>";
		}
	$anchoCT = 40/$preguntasxl;
	$anchoCC = 60/$preguntasxl;	
	
	echo "<td align='right' width='".$anchoCT."%'>".str_replace('_',' ',$titulo)."</td>
		  <td  width='".$anchoCC."%'> : $campo</td>
		  ";
    	if(($fila+1) % $preguntasxl == 0){ 
    	if($color ==''){ $color = "bgcolor='whitesmoke'"; }else{ $color = ''; }
    	echo "</tr><tr $color >"; 
    	}
	}
    echo "</tr>
    	  <tr>
    	  	<td align='center' colspan='".($preguntasxl*2)."'>";
	if($_POST['CUANTOS_HIJOS'] > 0){    
		echo "<table class='frm' width='75%'>
    	  		<tr>
    	  			<th colspan='3'>INFORMACION DE LOS HIJOS</th>
    	  		</tr>
    	  		<tr>
    				<th style='width:60%'>NOMBRE</th>
    				<th style='width:30%'>FECHA NTO</th>
    				<th style='width:10%'>SEXO</th>
    	  		</tr>	";
    		for($i=1; $i <= $_POST['CUANTOS_HIJOS']; $i ++){
    			echo "<tr>
    				<td><input type='text' class='frm campo' id='nom$i' name='nom$i' value='".$_POST["nom$i"]."' ></td>
    				<td><input type='date' class='frm campo' id='fe$i' name='fe$i' value='".$_POST["fe$i"]."' ></td>
    				<td><select type='text' class='frm campo' id='sex$i' name='sex$i'>
    						<option>".$_POST["sex$i"]."</option>
    						<option>M</option>
    						<option>F</option>
    					</select>
    				</td>
    	  		</tr>	";
    		}
    echo "</table>
    	</td></tr>";
    } //FIN IF CUANTOS HIJOS	
    
	echo "</tr>
    	  <tr>
    	  	<td align='center' colspan='".($preguntasxl*2)."'>";
		echo "<table class='frm' width='75%'>
    	  		<tr>
    	  			<th colspan='3'>CONTACTOS DE EMERGENCIA</th>
    	  		</tr>
    	  		<tr>
    				<th style='width:60%'>NOMBRE</th>
    				<th style='width:30%'>PARENTESCO</th>
    				<th style='width:10%'>TELEFONO</th>
    	  		</tr>	";
    		for($i=1; $i <= 3; $i ++){
    			echo "<tr>
    				<td><input type='text' class='frm campo' id='con$i' name='con$i' value='".$_POST["con$i"]."' style='".$colorE["con$i"]."' ></td>
    				<td><input type='text' class='frm campo' id='pa$i' name='pa$i' value='".$_POST["pa$i"]."' style='".$colorE["con$i"]."' ></td>
    				<td><input type='text' class='frm campo' id='tel$i' name='tel$i' value='".$_POST["tel$i"]."' style='".$colorE["con$i"]."' ></td>
    	  		</tr>	";
    		}
    echo "</table>
    	</td></tr>";
    ?>
	<tr bgcolor="white" >
		<td align="center" colspan="<?= $preguntasxl*2?>" style="height:auto" >
<div class="frxs" style="text-align:justify">		
"Mediante la autorización del Titular de la información para el tratamiento de sus datos personales, da su consentimiento de manera voluntaria, explicita, inequívoca e informada a AGROCAMPO S.A.S. para el tratamiento de sus datos personales con la finalidad principal de almacenarlos en las bases de datos de la compañía y archivos físicos que la empresa disponga y hacer uso de ellos segun se requiera. Así mismo, las partes conocen que:
<br>a) El ingreso de su información personal lo realizan de manera voluntaria, entendiendo que esta información permanecerá de manera segura en los archivos y bases de datos de la empresa.
<br>b) AGROCAMPO S.A.S utilizará la información personal que le sea entregada para los fines aquí descritos, según sea el caso.
<br>c) El Titular de la información podrá formular requerimiento mediante documento escrito enviado a la Calle 73 20-62 de la ciudad de Bogotá D.C. o a través del correo proteccion.datos@agrocampo.com.co.
<br>d) En cualquier momento el titular de la información tendrá el derecho a conocer que tratamiento se le están dando a sus datos personales.
<br>e)  AGROCAMPO S.A.S se compromete a dar cumplimiento con la ley de protección de datos  establecido en la ley 1581 de 2012 y el Decreto 1377 de 2013.
<br>g) Cualquier cambio sustancial en las políticas de Tratamiento, será comunicado oportunamente a los Titulares de la información mediante Circular Interna."							
<br><br>
Declaro que conozco y acepto el Manual de Tratamiento de Datos Personales de AGROCAMPO S.A.S y que la información proporcionada es veraz, completa, exacta, actualizada y verificable. 							
</div>
</td>
	</tr>
	<tr bgcolor="white" >
		<td align="center" colspan="<?= $preguntasxl*2?>" style="height: 31px" ><input onclick="this.form.submit()" type="button" value=" Acepto y Enviar "></td>
	</tr>	    
</table>

</form>

</div>

<script>
var v2 = 0;
var cols = 6;
function myFunction(x) {
  if (x.matches) { // If media query matches
    cols = 4;
    document.getElementById("cols").value = cols;
    v2 = "<? echo $_POST[cols]; ?>";
      } else {
   document.getElementById("cols").value = cols;
   v2 = "<? echo $_POST[cols]; ?>";
  }
}

function myFunctiony(y) {
  if (y.matches) { // If media query matches
    cols = 2;
    document.getElementById("cols").value = cols;
    v2 = "<? echo $_POST[cols]; ?>";
  }
}

function myFunctionz(z) {
  if (z.matches) { // If media query matches
    cols = 1;
    document.getElementById("cols").value = cols;
    v2 = "<? echo $_POST[cols]; ?>";
  }
}



var x = window.matchMedia("(max-width: 1600px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes

var y = window.matchMedia("(max-width: 1300px)")
myFunctiony(y) // Call listener function at run time
y.addListener(myFunctiony) // Attach listener function on state changes

var z = window.matchMedia("(max-width: 700px)")
myFunctionz(z) // Call listener function at run time
z.addListener(myFunctionz) // Attach listener function on state changes

  	if(cols != v2){
	document.frm1.submit()
	}


</script>

</body>

</html>
