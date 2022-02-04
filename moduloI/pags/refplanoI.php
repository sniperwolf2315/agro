<? session_start();

 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	}

include("../../user_con.php"); 

if($_SESSION["clAVe"] == '') {ECHO "<br>Debe iniciar sesion"; DIE;}
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
<link rel="stylesheet" type="text/css" href="../../modulo1/forms/view.css" media="all">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script type="text/javascript" src="../../modulo1/forms/view.js"></script>
<script type="text/javascript" src="../../modulo1/forms/calendar.js"></script>

<script type="text/javascript" src="../../antenna/auto.js"></script>
<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >

<script>

var campo;
function actualiza(campo){
	var valorActual; 
	valorActual = document.getElementById(campo).value;	
	document.getElementById(campo + '2').value = valorActual;
}

</script>

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
</script>



</head>
 
<body class="global">

<?  //foreach ($_POST as $a=>$b) $_POST[$a]=strtoupper($b);
	//IF($_POST[ref] != $_POST[sref] ){ $REFtem = $_POST[ref]; $_POST = array(); $_POST[ref] = $REFtem ; }
	//error_reporting(E_ALL);
    //ini_set("display_errors", 1);
  
  $meses = array('0','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
  
  $hoy = date ("Y-m-d");
  $dia30 = date("Y-m-d", strtotime(" $hoy - 30 day ")); 
  $dia1me = date("Y-m-d", strtotime(" $hoy + 1 month "));
  $year1 = date("Y-m-d", strtotime(" $hoy - 1 year "));
  
  	
    if(strlen($_POST['desde']) == ""){ $_POST['desde'] = $hoy; $_POST['hasta'] = $hoy; }
    
    if(strlen($_POST['desde']) != "") 
    { 
    if(strlen($_POST['hasta'] == "")){$dia1a = date("Y-m-d", strtotime(" $hoy + 1 year ")); $_POST['hasta'] = $dia1a; }    
    $fmes = " AND entrega BETWEEN '$_POST[desde]' AND '$_POST[hasta]' ";  
    }else{$fmes = "";}

	if($_POST['informe'] == ''){ $_POST['informe'] = 'VENTA'; }
	
//SACA VENDEDORES POR AREA y areas
$sql = "select AREA, IDVEND from VENDCUOTA2 order by IDVEND";
$result = $mysqli->query($sql);
$coma ="";
while($row = $result->fetch_array())
	{
	if(!in_array($row['AREA'],$areas)){
		$areas[] = $row[AREA];
		}
 	$area = $row['AREA'];
 	$vend["$area"] .= $coma."'".$row[IDVEND]."'"; 
 	$coma = ",";
	}

	
	if($_POST['area'] != '' ){
$area = $_POST['area'];
$fnom = $vend["$area"];
}

$vend = explode("," , str_replace("'","",$fnom) );

$sql = "select CTSIGN, CTNAME from SRBCTLSD WHERE SRBCTLSD.CTSIGN IN($fnom) order by CTSIGN";
$result = odbc_exec($db2con, $sql);
while($row = odbc_fetch_array($result)){
	$nom = utf8_encode($row['CTNAME']);
	$cod = $row['CTSIGN'];
	$nombres["$cod"] = $nom;
}
?>

<div id="ifra724vlrhy2" align="center" class="hid " style="width:100%; height:98%; ">
<br>
<font size="+3">
	<b>DESCARGAR ARCHIVO PLANO
<form id="movse" class="Aabs" action="refplanoI.php" method="post" name="submit button" enctype="multipart/form-data">	
	    <select onchange="this.form.submit();" id="empresa" class="frm " style="width:300px; font-size:20px" name="empresa" tabindex="2">
        <option><?= $_POST['empresa']?></option>
        <?
        foreach($_SESSION['empresA'] as $emp){
        if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        }
        ?> 
       </select>
</form>       
 </b></font>
	<br>
<form id="movse1" class="Aabs" action="refplanoI.php" method="post" name="submit button2" enctype="multipart/form-data">
	<input type="hidden" id="sref" class="frm Aabs" name="sref" tabindex="2" value="<?=$_POST[ref]?>">
	<input type="hidden" id="sref" class="frm Aabs" name="sref" tabindex="2" value="<?=$_POST[ref]?>">
<table align="center" class="frl" width="1000PX" border="0" cellspacing="0">
    
      <tr>
       <td align="center" bgcolor="#85FD77" valign="bottom" colspan="4" style="height: 42px" >
	   <b>ENTRE
	   <br><input onkeyup="actualiza('desde')" id="desde" class="frs" type="date" style="width:130px; height:28px" name="desde" value="<?=$_POST[desde]?>" tabindex="2"> 
	   A
       <input onkeyup="actualiza('hasta')" id="hasta" class="frs" type="date" style="width:130px; height:28px" name="hasta" value="<?=$_POST[hasta]?>" tabindex="2">
       </b>
         </td>
     </tr>

      <tr>
       <td align="right" bgcolor="#85FD77" class="hd3" style="width: 25%">
	   <b>AREA</b>&nbsp;
	  </td>
       <td align="left" bgcolor="#85FD77" style="width: 25%" >
         :&nbsp; 
       <select onchange="this.form.submit();" id="area" class="frm select2" style="width:90%;" name="area" tabindex="2">
        <option><?= $_POST['area']?></option>
        <option value="" >TODAS</option>
        <?
        foreach($areas as $area){
        if($_POST['area'] != $area){echo "<option>$area</option>";}
        }
        ?> 
       </select>
       
       </td>
       <td align="right" bgcolor="#85FD77" style="width: 25%" >
       <strong>SEGMENTO </strong></td>
       <td width="50%" align="left" bgcolor="#85FD77" >:&nbsp;
       <select id="seg" name="seg" class="frm select2" onchange="this.form.submit();" style="width:90%;" tabindex="2">
         <option><?= $_POST['seg']?></option>
         <option value="" >TODOS</option>
         <? $sql = "SELECT SQISET AS COD, SQSETD AS NOMBRE FROM SROCTLSQ";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option VALUE ='".trim($row['COD'])."' >".$row['NOMBRE']."</option>";
            } 
         ?>
       </select></td>
     </tr>
     
     <tr>
       <td align="right" bgcolor="#85FD77"  class="hd3" style="width: 25%">
	   <b>VENDEDOR</b>&nbsp;
	  </td>
       <td align="left" bgcolor="#85FD77" style="width: 25%" >
         :&nbsp;
       <?
       if($_POST['area'] ==''){
       echo '<input onkeyup="actualiza('."'vend'".')" id="vend" name="vend" class="frm" style="width:90%; height:25px;" value="'.$_POST[vend].'" tabindex="2">';
       }else{
       ?>   
       <select onchange="actualiza('vend')" id="vend" name="vend" class="frm select2"	style="width:90%;" tabindex="2">
        <option><?= $_POST['vend']?></option>
        <option value="" >TODOS</option>
        <?
        foreach($vend as $vende){
        if($vende != $_POST[vend] ){echo "<option>$vende</option>";}
        }
        ?>
       </select>
       <? } ?>
       </td>
       <td align="right" bgcolor="#85FD77" style="width: 25%" >
        <strong>GRUPO</strong></td>
       <td width="50%" align="left" bgcolor="#85FD77" >:&nbsp;
        <select id="gru" name="gru" class="frm select2" onchange="this.form.submit();" style="width:90%;" tabindex="2">
         <option><? echo "$_POST[gru]";?></option>
         <option value="" >TODAS</option>
          <? if($_POST['seg'] != ''){$fseg =" AND IVISET = '$_POST[seg]' ";} 
            $sql = "SELECT IVSGVA AS COD, IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '1' $fseg ORDER BY NOMBRE";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option value='".trim($row['COD'])."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])."</option>";
            } 
          ?>
         </select></td>
     </tr>

     <tr>
       <td align="right" bgcolor="#85FD77" style=" font-weight: bold; width: 25%;">
       FAMILIA</td>
       <td align="left" bgcolor="#85FD77" style="width: 25%" >:&nbsp;
        <select onchange="actualiza('fam')" id="fam" class="frm select2" style="width:90%;" name="fam" tabindex="2">
         <option><?= $_POST['fam']?></option>
         <option value="" >TODAS</option>
         <?	$sql = "SELECT PBDESC FROM SROCTLPB";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option >".$row['PBDESC']."</option>";
            } 
         ?>
      </select>
       </td>
       <td align="right" bgcolor="#85FD77" style="width: 25%" >
        <strong>CATEGORIA</strong></td>
       <td align="left" bgcolor="#85FD77" >:&nbsp;
        <select id="cat" class="frm select2" onchange="this.form.submit();" style="width:90%;" name="cat" tabindex="2">
         <option><? echo "$_POST[cat]";?></option>
         <option value="" >TODAS</option>
          <? if($_POST['gru'] != ''){$fseg =" AND substr(IVSGVA,1,2) = substr('$_POST[gru]',1,2) "; 
            	$sql = "SELECT IVSGVA AS COD, IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '2' $fseg";
	        	$result = odbc_exec($db2con, $sql);
            	while($row = odbc_fetch_array($result)){ 
            	   echo "<option value='".trim($row['COD'])."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])."</option>";
            	}
            } 
          ?>
         </select>
       </td>
     </tr>

      <tr>
       <td align="right" bgcolor="#85FD77" style="width: 25%">
        <strong>GRUPO PROV</strong></td>
       <td align="left" bgcolor="#85FD77" style="width: 25%" >:&nbsp;
        <select id="prov" name="prov" class="frm select2" onchange="actualiza('prov');" style="width:90%;" tabindex="2">
         <option><? echo "$_POST[prov]";?></option>
         <option value="" >TODAS</option>
          <? 
            $sql = "select CTPPGN AS COD, CTPPGD AS NOMBRE FROM SROCTLDB  SRBCTLDB ";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option value='".$row['COD']."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])." ($row[COD])</option>";
            } 
          ?>
         </select>
       </td>
       <td align="right" bgcolor="#85FD77" style="width: 25%" ><strong>SUB-CATEGORIA</strong></td>
       <td align="left" bgcolor="#85FD77" >:&nbsp;
        <select id="subcat" class="frm select2"	onchange="this.form.submit();" style="width:90%;" name="subcat" tabindex="2">
         <option><? echo "$_POST[subcat]";?></option>
         <option value="" >TODAS</option>
         <? if($_POST['cat'] != ''){$fseg =" AND substr(IVSGVA,1,3) = substr('$_POST[cat]',1,3) "; 
            	$sql = "SELECT IVSGVA AS COD, IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '3' $fseg";
	        	$result = odbc_exec($db2con, $sql);
            	while($row = odbc_fetch_array($result)){ 
            	   echo "<option value='".trim($row['COD'])."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])."</option>";
            	} 
            }
          ?>
      </select></td>
     </tr>

     <tr>
       <td align="right" bgcolor="#85FD77" style=" font-weight: bold; height: 28px; width: 25%;">
       <strong>SOCIO DE NEGOCIO</strong></td>
       <td align="left" bgcolor="#85FD77" style="height: 28px; width: 25%;" >:&nbsp;
       <?
       if($_POST['AREA'] != '' or $_POST['VEND'] !='' ANd 'lino' == 'andres'){
       ?>
       <select id="socio" class="frm select2" style="width:90%;" name="socio" tabindex="2">
         <option><? echo "$_POST[socio]";?></option>
         <option value="" >TODOS</option>
         <?	$sql = "SELECT DISTINCT prove FROM SApedido ORDER BY prove ASC";
	        $result = mysql_query($sql);?>
         <? while($row = mysql_fetch_assoc($result)){ 
         echo "<option >$row[prove]</option>";
         } ?>
       </select>
       <? }else{
         //echo "<input onkeyup='actualiza(socio)' placeholder='CEDULA O NIT' id='socio' class='frm' type='text' style='width:90%; height:25px;' name='socio' value='$_POST[socio]' tabindex='2'>";
         echo '<input onkeyup="actualiza('."'socio'".')" placeholder="CEDULA O NIT" id="socio" name="socio" class="frm" style="width:90%; height:25px;" value="'.$_POST[socio].'" tabindex="2">';

         } ?>
       </td>
       <td align="right" bgcolor="#85FD77" style="height: 28px; width: 25%;" >
	   <strong>PRINCIPIO ACTIVO</strong></td>
       <td align="left" bgcolor="#85FD77" style="height: 28px" >:&nbsp;
        <?
       if($_POST['seg'] != '' or $_POST['gru'] != '' or $_POST['cat'] != '' or $_POST['subcat'] != ''){
       ?>
        <select id="pac" class="frm select2" onchange="actualiza('pac')" style="width:90%;" name="pac" tabindex="2">
         <option><? echo "$_POST[pac]";?></option>
         <option value="" >TODAS</option>
         <? if($_POST['subcat'] != ''){$fseg =" AND substr(IVSGVA,1,4) = substr('$_POST[subcat]',1,4)  ";} 
            $sql = "SELECT IVSGVA AS COD, IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '4' $fseg";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option value='".trim($row['COD'])." - ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])."</option>";
            } 
          ?>
      </select>
      <? }else{
      		//echo "<input onkeyup='actualiza(pac)' name='pac' id='pac' class='frm' type='text' style='width:90%; height:25px;'  value='$_POST[pac]' tabindex='2'>";
      		echo '<input onkeyup="actualiza('."'pac'".')" placeholder="" id="pac" name="pac" class="frm" style="width:90%; height:25px;" value="'.$_POST[pac].'" tabindex="2">';

      }?></td>
     </tr>
     
     <tr>
       <td align="right" bgcolor="#85FD77" valign="bottom" style=" font-weight: bold; width: 25%;">
       &nbsp;</td>
       <td align="right" bgcolor="#85FD77" style="width: 25%" >
       <strong>INFORME DE</strong></td>
       <td align="left" bgcolor="#85FD77" style="width: 25%" >:&nbsp;
         <select id="informe" class="frm select2" style="width:90%;" name="informe" tabindex="2">
         <option ><?= $_POST['informe']?></option>
         <?
         $informes = array('VENTA','COMPRA','TRASLADO','INVENTARIO');
         foreach($informes as $informe){
         if($_POST['informe'] != $informe){ echo "<option >$informe</option>"; }
         } 
         ?>
         
       </select></td>
       <td align="left" bgcolor="#85FD77" >&nbsp;</td>
	<tr>
       <td bgcolor="#85FD77" style=" font-weight: bold; height: 19px; width: 25%;" align="right">
	   &nbsp;</td>
       <td bgcolor="#85FD77" style="height: 19px; width: 25%;">&nbsp;</td>
       <td bgcolor="#85FD77" style="height: 19px; width: 25%;">&nbsp;</td>
       <td width="21%" bgcolor="#85FD77" style="height: 19px">&nbsp;</td>
     </tr>
     
     </table>     
<?
if($_POST['seg'] != ''){$fclas .=" AND PGISET = '$_POST[seg]' ";} 
if($_POST['gru'] != ''){ $var = explode(" - ",$_POST[gru]); $fclas .=" AND PGIS01 = '$var[0]' ";} 
if($_POST['cat'] != ''){ $var = explode(" - ",$_POST[cat]); $fclas .=" AND PGIS02 = '$var[0]' ";} 
if($_POST['subcat'] != ''){$var = explode(" - ",$_POST[subcat]); $fclas .=" AND PGIS03 = '$var[0]' ";} 
if($_POST['pac'] != ''){
	$var = explode(" - ",$_POST[pac]);
	if(count($var) > 1){
		$fclas .=" AND PGIS04 = '$var[0]' ";
		}else{
		$fclas .=" AND (SELECT CTPCT4 FROM PGPCA4 WHERE PGPCA4 = PGIS04 ) LIKE '%$var[0]%' ";
		}
	} 

  $sql =" SELECT DISTINCT
	 CONCAT(PGPCA1, CONCAT('- ',CTPCT1)) AS CT1
	,CONCAT(PGPCA2, CONCAT('- ',CTPCT2)) AS CT2
	,CONCAT(PGPCA3, CONCAT('- ',CTPCT3)) AS CT3
	,CONCAT(PGPCA4, CONCAT('- ',CTPCT4)) AS CT4
	,CONCAT(PGPCA5, CONCAT('- ',CTPCT5)) AS CT5
	,CONCAT(PGPCA6, CONCAT('- ',CTPCT6)) AS CT6
	
	from SROPRG SRBPRG 
	LEFT JOIN SROCTLP1 SRBCTLP1 ON SRBPRG.PGPCA1 = SRBCTLP1.CTPCA1
	LEFT JOIN SROCTLP2 SRBCTLP2 ON SRBPRG.PGPCA2 = SRBCTLP2.CTPCA2
	LEFT JOIN SROCTLP3 SRBCTLP3 ON SRBPRG.PGPCA3 = SRBCTLP3.CTPCA3
	LEFT JOIN SROCTLP4 SRBCTLP4 ON SRBPRG.PGPCA4 = SRBCTLP4.CTPCA4
	LEFT JOIN SROCTLP5 SRBCTLP5 ON SRBPRG.PGPCA5 = SRBCTLP5.CTPCA5
	LEFT JOIN SROCTLP6 SRBCTLP6 ON SRBPRG.PGPCA6 = SRBCTLP6.CTPCA6
	WHERE 1 = 1
	$fclas
  "; 
	$result = odbc_exec($db2con, $sql) or die ($sql.odbc_errormsg());
	while($row = odbc_fetch_array($result)){ 
	$cat[1][] = utf8_encode(trim($row['CT1']));
	$cat[2][] = utf8_encode(trim($row['CT2']));	
	$cat[3][] = utf8_encode(trim($row['CT3']));	
	$cat[4][] = utf8_encode(trim($row['CT4']));	
	$cat[5][] = utf8_encode(trim($row['CT5']));	
	$cat[6][] = utf8_encode(trim($row['CT6']));	
		
	}
	$cat[1] = array_unique($cat[1]); sort($cat[1]); $cat[1] = array_diff($cat[1], array('N/A','NO APLICA','')); 
	$cat[2] = array_unique($cat[2]); sort($cat[2]); $cat[2] = array_diff($cat[2], array('N/A','NO APLICA','')); 
	$cat[3] = array_unique($cat[3]); sort($cat[3]); $cat[3] = array_diff($cat[3], array('N/A','NO APLICA','')); 
	$cat[4] = array_unique($cat[4]); sort($cat[4]); $cat[4] = array_diff($cat[4], array('N/A','NO APLICA','')); 
	$cat[5] = array_unique($cat[5]); sort($cat[5]); $cat[5] = array_diff($cat[5], array('N/A','NO APLICA','')); 
	$cat[6] = array_unique($cat[6]); sort($cat[6]); $cat[6] = array_diff($cat[6], array('N/A','NO APLICA','')); 
    //print_r($cat1);
	?>
<table align="center" class="frl" width="1200PX" border="0" cellspacing="0">
     <tr>
       <?
       $cont = 0;
       $cols = 6;
       while($cont < $cols){
       $cont++;
       $cats .= ",cat$cont";
       ?>
       <td bgcolor="#85FD77" width="<?= 100/$cols ?>%" style=" font-weight: bold; height: 19px;" align="right">
       <select onChange="actualiza('cat'+<?= $cont?>)" multiple id="cat<?= $cont?>" name="cat<?= $cont?>" class="frxs" style="width:90%;" tabindex="2" size="10">
        <option value="">TODOS</option>
         <? foreach($cat["$cont"] as $cate){ 
               echo "<option>".utf8_encode($cate)."</option>";
            } 
          ?>
       </select>
       </td>
       <? } //finwhile ?>
     </tr>
</table>
</form>
<table align="center" class="frl" width="1200PX" border="0" cellspacing="0">
<tr>
       <td bgcolor="#85FD77" align="center" colspan="6"><?=$msgVACIO?>
       
       <form id="movse1a" class="Aabs" action="refplanoII.php" method="post" name="submit button2a" enctype="multipart/form-data">
       <?
       $campoL = "desde,hasta,area,vend,fam,prov,socio,seg,gru,cat,subcat,pac,informe".$cats;
       $campos = explode(",",$campoL);
       //print_r($campos);
       foreach($campos as $campo){
       echo "<input id='".$campo."2' type='hidden' name='$campo' value='$_POST[$campo]' >";
       }
       ?>
       <br>
       <input class="frl" onClick="this.form.submit();" type="button" value="DESCARGAR" style="width:100px; height:25px;">
       <br>&nbsp;
       </form>
         </td>
     </tr></table>

</div>

</body>

</html>
