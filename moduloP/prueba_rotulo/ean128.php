<? include("../../user_con.php");

// if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registres de nuevo aqui<a href='../../index.php'></a>"; DIE;}
// error_reporting(1);
// ini_set('error_reporting', E_ALL);
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
th,td{border-radius:12px}
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }
.txtv{ writing-mode: vertical-lr; transform: rotate(180deg); }
</style>

<style type="text/css" media="print">
@page{
   size: landscape;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>


<script type="text/javascript">

var eventoControlado = false;

window.onload = function() { document.onkeypress = mostrarInformacionCaracter;

document.onkeyup = mostrarInformacionTecla; }

function mostrarInformacionCaracter(evObject) {

                var msg = ''; var elCaracter = String.fromCharCode(evObject.which);

                if (evObject.which!=0 && evObject.which!=13) {

                msg = 'Tecla pulsada: ' + elCaracter;

                control.innerHTML += msg + '-----------------------------<br/>'; }

                else { msg = 'Enter';

                control.innerHTML += msg + '-----------------------------<br/>';}

                eventoControlado=true;

}

function mostrarInformacionTecla(evObject) {

                var msg = ''; var teclaPulsada = evObject.keyCode;

                if (teclaPulsada == 20) { msg = 'Pulsado caps lock (act/des mayúsculas)';}

                else if (teclaPulsada == 16) { msg = 'Pulsado shift';}
                
                else if (teclaPulsada == 17) { msg = 'Pulsado control';}
                
                else if (teclaPulsada == 18) { msg = 'Pulsado Alt';}
                
                else if (teclaPulsada >= 112 && teclaPulsada <= 123 ) { msg = 'Pulsado Funcion';}

                else if (eventoControlado == false) { msg = 'Cod '+ teclaPulsada;}

                if (msg) {control.innerHTML += msg + '-----------------------------<br/>';}

                eventoControlado = false;

}

</script>



<script type="text/javascript">
// Solo permite ingresar numeros.
function soloNumeros(e){
    //var miau ='miau';
	var key = window.Event ? e.which : e.keyCode
	//{alert('Control ' + key);}
	//return(key >= 48 && key <= 57);
}
</script>

<script type="text/jаvascript">
 
 function displayKeyCode(evt)
 {
var textBox = getObject('txtChar');
var charCode = (evt.which) ? evt.which : event.keyCode
textBox.value = String.fromCharCode(charCode);
if (charCode == 8) textBox.value = "backspace"; //  backspace
if (charCode == 9) textBox.value = "tab"; //  tab
if (charCode == 13) textBox.value = "enter"; //  enter
if (charCode == 16) textBox.value = "shift"; //  shift
if (charCode == 17) textBox.value = "ctrl"; //  ctrl
if (charCode == 18) textBox.value = "alt"; //  alt
if (charCode == 19) textBox.value = "pause/break"; //  pause/break
if (charCode == 20) textBox.value = "caps lock"; //  caps lock
if (charCode == 27) textBox.value = "escape"; //  escape
if (charCode == 33) textBox.value = "page up"; // page up, to avoid displaying alternate character and confusing people         
if (charCode == 34) textBox.value = "page down"; // page down
if (charCode == 35) textBox.value = "end"; // end
if (charCode == 36) textBox.value = "home"; // home
if (charCode == 37) textBox.value = "left arrow"; // left arrow
if (charCode == 38) textBox.value = "up arrow"; // up arrow
if (charCode == 39) textBox.value = "right arrow"; // right arrow
if (charCode == 40) textBox.value = "down arrow"; // down arrow
if (charCode == 45) textBox.value = "insert"; // insert
if (charCode == 46) textBox.value = "delete"; // delete
if (charCode == 91) textBox.value = "left window"; // left window
if (charCode == 92) textBox.value = "right window"; // right window
if (charCode == 93) textBox.value = "select key"; // select key
if (charCode == 96) textBox.value = "numpad 0"; // numpad 0
if (charCode == 97) textBox.value = "numpad 1"; // numpad 1
if (charCode == 98) textBox.value = "numpad 2"; // numpad 2
if (charCode == 99) textBox.value = "numpad 3"; // numpad 3
if (charCode == 100) textBox.value = "numpad 4"; // numpad 4
if (charCode == 101) textBox.value = "numpad 5"; // numpad 5
if (charCode == 102) textBox.value = "numpad 6"; // numpad 6
if (charCode == 103) textBox.value = "numpad 7"; // numpad 7
if (charCode == 104) textBox.value = "numpad 8"; // numpad 8
if (charCode == 105) textBox.value = "numpad 9"; // numpad 9
if (charCode == 106) textBox.value = "multiply"; // multiply
if (charCode == 107) textBox.value = "add"; // add
if (charCode == 109) textBox.value = "subtract"; // subtract
if (charCode == 110) textBox.value = "decimal point"; // decimal point
if (charCode == 111) textBox.value = "divide"; // divide
if (charCode == 112) textBox.value = "F1"; // F1
if (charCode == 113) textBox.value = "F2"; // F2
if (charCode == 114) textBox.value = "F3"; // F3
if (charCode == 115) textBox.value = "F4"; // F4
if (charCode == 116) textBox.value = "F5"; // F5
if (charCode == 117) textBox.value = "F6"; // F6
if (charCode == 118) textBox.value = "F7"; // F7
if (charCode == 119) textBox.value = "F8"; // F8
if (charCode == 120) textBox.value = "F9"; // F9
if (charCode == 121) textBox.value = "F10"; // F10
if (charCode == 122) textBox.value = "F11"; // F11
if (charCode == 123) textBox.value = "F12"; // F12
if (charCode == 144) textBox.value = "num lock"; // num lock
if (charCode == 145) textBox.value = "scroll lock"; // scroll lock
if (charCode == 186) textBox.value = ";"; // semi-colon
if (charCode == 187) textBox.value = "="; // equal-sign
if (charCode == 188) textBox.value = ","; // comma
if (charCode == 189) textBox.value = "-"; // dash
if (charCode == 190) textBox.value = "."; // period
if (charCode == 191) textBox.value = "/"; // forward slash
if (charCode == 192) textBox.value = "`"; // grave accent
if (charCode == 219) textBox.value = "["; // open bracket
if (charCode == 220) textBox.value = "\\"; // back slash
if (charCode == 221) textBox.value = "]"; // close bracket
if (charCode == 222) textBox.value = "'"; // single quote

var lblCharCode = getObject('spnCode');
lblCharCode.innerHTML = 'KeyCode:  ' + charCode;

return false;

 }
 function getObject(obj)
  {
 var theObj;
 if (document.all) {
 if (typeof obj=='string') {
 return document.all(obj);
 } else {
 return obj.style;
 }
 }
 if (document.getElementById) {
 if (typeof obj=='string') {
 return document.getElementById(obj);
 } else {
 return obj.style;
 }
 }
 return null;
  }
 
</script> 

</head>
<?  
    $ancho = '780px';
    
    

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	


//consulta de factura
if($_POST['fac']){
    $sql ="SELECT DISTINCT
			CONCAT( SRBSOH.OHORDT, SRBISH.IHINVN )  AS FACTURA,
            SRBSOH.OHORDT AS TIPO,
            '' AS AREA,
            SRBISH.IHIDAT AS FECHA_FACTURA,
            SRBISH.IHORNO AS NUMERO_ORDEN,
            SRBISH.IHODAT AS FECHA_ORDEN,
            SRBISD.IDCUNO AS NIT,
            SRBNAM.NAADR2 AS DIRECCION,
            SRBNAM.NANSNO AS TELEFONO,
            SRBNAM.NANAME AS RAZON_SOCIAL,
            DNMNAM AS MUNICIPIO,
            SRBISD.IDSROM AS BODEGA,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBISH.IHSALE ELSE SRBISH_1.IHSALE END AS VENDEDOR,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTNAME ELSE SRBCTLSD_1.CTNAME END AS DES_VENDE,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBSOH.OHHAND ELSE SRBSOH_1.OHHAND END AS CALL,
            CASE SRBISD.IDINUM WHEN 0 THEN SRBCTLSD.CTSMAN ELSE SRBCTLSD_1.CTSMAN END AS MANEJADOR,
            CASE SRBISD.IDTYPP WHEN 1 THEN SRBISH.IHIAET ELSE SRBISH.IHIAET*-1 END AS VLRT_EXC_IVA,
            CASE SRBISD.IDTYPP WHEN 1 THEN SRBISH.IHITTA ELSE SRBISH.IHITTA*-1 END AS VLRT_IVA,
            CASE SRBISD.IDTYPP WHEN 1 THEN (SRBISH.IHIAIT) ELSE (SRBISH.IHIAIT)*-1 END AS VLRT_INC_IVA,
            ( SELECT SUBSTRING(CMUFA1,3,1)  FROM SROCMA WHERE CMCUNO = SRBISD.IDCUNO) AS AUTO_RETENEDOR,
            SRBISA.IAAMOU AS VLR_FLETE
          , CONCAT(SRBISD.IDOLIN,CONCAT( SRBSOH.OHORDT, SRBISH.IHINVN ))                          
          , SRBISD.IDOLIN AS LINEA_ORDEN
          , SRBPRG.PGPRDC AS CODIGO
          , SRBPRG.PGDESC AS DESCRIPCION
          , CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END AS CANTIDAD
          , CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END AS VLR_EXC_IVA  
          , SRBCTLSQ.SQSETD AS SEGMENTO
            
		  FROM SROISH SRBISH

            LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
            LEFT JOIN SROPRG SRBPRG ON SRBISD.IDPRDC = SRBPRG.PGPRDC
            LEFT JOIN SROHNH SROHNH ON SRBISD.IDINUM = SROHNH.IHINUM
            LEFT JOIN SROISH SRBISH_1 ON SROHNH.IHRFNR = SRBISH_1.IHINVN AND SROHNH.IHCUNO = SRBISH_1.IHCUNO
            LEFT JOIN SROORSHE SRBSOH_1 ON SRBISH_1.IHORNO = SRBSOH_1.OHORNO
            LEFT JOIN SROORSHE SRBSOH ON SRBISH.IHORNO = SRBSOH.OHORNO
            LEFT JOIN SROCTLSD SRBCTLSD ON SRBISH.IHSALE = SRBCTLSD.CTSIGN
            LEFT JOIN SROCTLSD SRBCTLSD_1 ON SRBISH_1.IHSALE = SRBCTLSD_1.CTSIGN
            LEFT JOIN SRONAM SRBNAM ON SRBISD.IDCUNO = SRBNAM.NANUM
            LEFT JOIN SROCTLC4 ON CTNCA4 = NANCA4 
            LEFT JOIN Z3ONAM ON SRBNAM.NANUM = Z3ONAM.Z3NANUM 
            LEFT JOIN COOCTLDN ON Z3NAMCOD = DNMCOD
            LEFT JOIN SROISA SRBISA ON SRBISH.IHORNO = SRBISA.IAORNO AND SRBISH.IHINVN = SRBISA.IAINVN AND IACODE = 21
            LEFT JOIN SROCTLSQ SRBCTLSQ ON SRBPRG.PGISET= SRBCTLSQ.SQISET
            WHERE (((CASE SRBISH.IHTYPP WHEN 1 THEN SRBISD.IDQTY ELSE SRBISD.IDQTY * -1 END )<> 0)
            AND (SRBSOH.OHORDT NOT IN ('03','13','19','Z3','Z4','Z5','Z6','Z7','ZN','67','68','72','25','93','K4'))
            AND CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END > 0
            AND SRBISH.IHINVN = '".substr($_POST[fac],2,20)."'
            )
            ";
//echo $sql;            
$result = odbc_exec($db2conp, $sql);
	while($row = odbc_fetch_array($result)){
		foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	
	if($row['SEGMENTO']==''){
	$seg = "OTROS";
	}else{$seg =  $row['SEGMENTO'];}	
	$valorSEG["$seg"] += $row['VLR_EXC_IVA'];
	}
} //FINIF
//print_r($valorSEG);		
$autoprint = 'onload="javascript:window.print()"';	
?>
<body class="global" bgcolor="white">
<form id="movse1" action="ean128.php" method="post" name="submit button1">
<table class="frl" style="width:12.5cm; height:10.3cm; border:none" border="1">
	<tr>
		<td align="center" style="height:1cm; border: none">														
		LECTOR ean-218
		<?
		//foreach($_POST AS $a => $b ) { $_POST["$a"] = preg_replace("/\n\r\f/", '|',$b); }
		foreach($_POST AS $a => $b ) { $_POST["$a"] = htmlentities($b); }
		?>
		<br>
		<INPUT ID="txtChar" ONKEYDOWN="javascript:return displayKeyCode(event)" TYPE="text" NAME="txtChar">   <SPAN ID="spnCode" NAME="spnCode"></SPAN>
		<br>
		<input onchange="this.form.submit();" id="inpu" name="inpu" value="<?= $_POST['inpu']?>" style="width: 355px">
		<br>
		<textarea onKeyPress="return soloNumeros(event)"  onchange="this.form.submit();" id="tex" name="tex" style="width: 368px; height: 115px"><?= $_POST['tex']?></textarea>
		<?
		echo $_POST['inpu']. "<br>" . $_POST['tex']; 
		?>
		<br>
		<div id="control"> </div>
		</td>
	</tr>
	<tr>
		<td style="height:4cm">
			<table class="frl">
				<tr>
					<td>Direccion</td>
					<td></td>
				</tr>
				<tr>
					<td>Destino</td>
					<td></td>
				</tr>
				<tr>
					<td>Razon Social</td>
					<td></td>
				</tr>
				<tr>
					<td>Cliente</td>
					<td></td>
				</tr>
				<tr>
					<td>Telefono</td>
					<td></td>
				</tr>
				<tr>
					<td>Fax</td>
					<td></td>
				</tr>
			</table>
		
		</td>
	</tr>
	<tr>
		<td style="width:5cm; ">
		&nbsp;</td>
	</tr>
	<tr>
		<td style="height:2.3cm" valign="top">Observaciones:</td>
	</tr>

</table>
 
   
</form>
</body>
</html>
<? 
echo "
<script languaje='javascript' type='text/javascript'>
setTimeout(function(){window.close();},3000);
</script>"; 
?>
