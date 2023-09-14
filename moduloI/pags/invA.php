<? session_start();

if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	}
if($_SESSION['emp'] =='X1- PESTAR'){
	$_SESSION['emp'] = 'AG- AGROCAMPO';
	$_POST['bod'] = "008";
	$gruposPE  ="'CPH','TEC','CMV','QUA'
				 ,'003','018','019','039','045','047','058','059','063','064','070','072','149','156','160','162','163','172','182','183','188','195','360','440','444','524','963','973'
				 , 'PPO'
				 ";
	$fpprov = "WHERE CTPPGN IN($gruposPE)";
	$filtros .= " AND PGPGRP IN($gruposPE)";
	}

require('../../user_con.php');

$_SESSION['emp'] = 'X1- PESTAR';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<title>AMBIENTAL</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">

<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">

<style type="text/css" media="print">
.nover {display:none}
</style>
<style>
select{width:90%}
</style>

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
<?
//registros por pag paginador
	if($_POST['bod'] ==''){ $_POST['bod'] = '5 Y 8'; }
	if($_POST['mostrar'] ==''){ $_POST['mostrar'] = 'CON SALDO'; }
	
	if($_POST['orden'] ==''){ $_POST['orden'] = 'DESCRIPCION'; }
	if($_POST['aod'] ==''){ $_POST['aod'] = 'A-Z' ;} 
	if($_POST['regsxpag'] ==''){$_POST['regsxpag'] = 25;}
	if($_POST['pag'] ==''){$_POST['pag'] = 1;}
	$regsxpag = $_POST['regsxpag'];
	
	$limit[0] = ($regsxpag * $_POST['pag']) - $regsxpag ; 
	$limit[1] = $regsxpag;
	$flimit = " LIMIT $limit[0],$limit[1] ";
	
	$aod = "ASC";
	if($_POST[aod] == 'Z-A'){ $aod = "DESC"; }
	$forder = " ORDER BY $_POST[orden] $aod ";
	
	if($_POST['bod'] == 'TODAS'){
		}
		elseif($_POST['bod'] == '5 Y 8'){
		$filtros .= " AND SRSROM IN('005','008') ";
		}else{
		$filtros .= " AND SRSROM = '$_POST[bod]' ";
		}
	
	if($_POST[mostrar] == 'CON SALDO'){ $filtros .= " AND CASE WHEN SUBSTR(PGDESC,1,3) ='KIT' OR SUBSTR(PGDESC,1,5) ='COMBO' OR SUBSTR(PGDESC,1,9) ='AGROPACHA' THEN 1 ELSE SRSTHQ END > 0 ";} //SRSTHQ }
    
    if($_POST['prov'] != ''){ 
    	$var = explode("-",$_POST[prov]); $filtros .=" AND PGPGRP = '$var[0]' ";
    	}else{
    	$filtros .=" AND PGPGRP != 'PPO' ";
       	} 
    
	if($_POST['seg'] != ''){$filtros .=" AND PGISET = '$_POST[seg]' ";} 
	if($_POST['gru'] != ''){ $var = explode("-",$_POST[gru]); $filtros .=" AND PGIS01 = '$var[0]' ";} 
	if($_POST['cat'] != ''){ $var = explode("-",$_POST[cat]); $filtros .=" AND PGIS02 = '$var[0]' ";} 
	if($_POST['subcat'] != ''){$var = explode("-",$_POST[subcat]); $filtros .=" AND PGIS03 = '$var[0]' ";} 
	if($_POST['pac'] != ''){
		$_POST['pac'] = trim(mb_strtoupper($_POST['pac'],utf8));
		$var = explode(" - ",$_POST[pac]);
			if(count($var) > 1){
			$filtros .=" AND PGIS04 = '$var[0]' ";
			}else{
			$filtros .=" AND UPPER((SELECT IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '4' AND IVSGVA = PGIS04 )) LIKE '%$var[0]%' ";
			}
	}
	
	if($_POST['prod'] != ''){
		$_POST['prod'] = trim(mb_strtoupper($_POST['prod'],utf8));
		$filtros .=" AND PGDESC LIKE '%$_POST[prod]%' ";
	} 

    if($_POST['oraculo'] != ''){
    	$_POST['oraculo'] = trim(mb_strtoupper($_POST['oraculo'],utf8));
    	$_POST['oraculo'] = str_replace(
        				 array('Á', 'À', 'Â', 'Ä', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Ï', 'Î', 'Ó', 'Ò', 'Ö', 'Ô', 'Ú', 'Ù', 'Û', 'Ü')
        				,array('A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U')
        				,$_POST['oraculo'] );
    	
    	$oraculo = str_replace(" DE "," ",utf8_decode($_POST['oraculo']));
    	$oraculo = str_replace(" DEL "," ",$oraculo);
    	$oraculo = str_replace(" EL "," ",$oraculo);
    	$oraculo = str_replace(" LA "," ",$oraculo);
    	$oraculo = str_replace(" LOS "," ",$oraculo);
    	$oraculo = str_replace(" LAS "," ",$oraculo);
    	$oraculo = str_replace(" Y "," ",$oraculo);
    	$oraculo = str_replace(" O "," ",$oraculo);
    	$oraculo = str_replace(" PARA "," ",$oraculo);
    	$oraculo = str_replace("ES "," ",$oraculo);
    	$oraculo = str_replace('S ',' ',$oraculo);
    	
    	$oraculo = preg_replace('/\s+/', ' ',$oraculo);
    	if(substr($oraculo,(strlen($oraculo)-1),1) =='S'){ 
    		$oraculo = substr($oraculo,0,(strlen($oraculo)-1));
    		}
    $oraculo = str_replace(" ","%' OR SFFILD LIKE '%",$oraculo);
    $oraculo = "SFFILD LIKE '%".trim($oraculo)."%'"; 
    //echo $oraculo;
    $sql= "SELECT SFPRDC as REF, COUNT(SFFILD) AS ACIERTOS 
    		FROM SROPSFV1 WHERE SFCTLC = '11' AND ($oraculo) GROUP BY SFPRDC 
    		UNION 
    		(SELECT SFPRDC as REF, COUNT(SFFILD) AS ACIERTOS 
    		FROM SROPSF WHERE SFCTLC = '11' AND ($oraculo) GROUP BY SFPRDC) 
    		ORDER BY ACIERTOS DESC limit 0 , $_POST[regsxpag] "; 
    //echo "<br>",$sql;
    $result = odbc_exec($db2conp, $sql) or die(odbc_errormsg($db2conp)."<br>$sql");
		$coma="";
		while($row = odbc_fetch_array($result)){
		$frefs .= "$coma '$row[REF]'";
		$coma = ",";
		}
	$coma="";
	
	if($frefs ==''){$frefs = "''"; }
    //$filtros .= " AND SRPRDC IN($frefs)"; 
    //$forder = "ORDER BY (SELECT COUNT(SFFILD) AS ACIERTOS FROM SROPSF WHERE SFCTLC = '11' AND SFPRDC = SRPRDC AND ($oraculo) GROUP BY SFPRDC) DESC";
    $refARR = explode(",",str_replace("'","",$frefs));
    }
    
    if('JEFE' == 'PATRON'){ 
    	$costo = " , PGAPCO as COSTO_PROM, '' as PRECIO ";
    	}
   
   $SELcampos = "SELECT
		SRPRDC as ITEM
		, PGDESC as DESCRIPCION
		, PGPGRP as GRUPO
		, SRSROM as BOD
		, CASE WHEN SUBSTR(PGDESC,1,3) ='KIT' OR SUBSTR(PGDESC,1,5) ='COMBO' OR SUBSTR(PGDESC,1,9) ='AGROPACHA' THEN 1 ELSE SRSTHQ END as EXIST
		, SRPICQ as RESER_LI
		, SRCUSQ as RESER_OR
		$costo
		, SRSTHQ - SRCUSQ - SRPICQ as DISP
		";	
$SELcontar ="SELECT count(*) AS REGS ";
$from ="FROM SRBSRO 
		LEFT JOIN SROPRG SRBPRG on SRBSRO.SRPRDC = SRBPRG.PGPRDC
		LEFT JOIN SROCTLP1 SRBCTLP1 ON SRBPRG.PGPCA1 = SRBCTLP1.CTPCA1
		LEFT JOIN SROCTLP2 SRBCTLP2 ON SRBPRG.PGPCA2 = SRBCTLP2.CTPCA2
		LEFT JOIN SROCTLP3 SRBCTLP3 ON SRBPRG.PGPCA3 = SRBCTLP3.CTPCA3
		LEFT JOIN SROCTLP4 SRBCTLP4 ON SRBPRG.PGPCA4 = SRBCTLP4.CTPCA4
		LEFT JOIN SROCTLP5 SRBCTLP5 ON SRBPRG.PGPCA5 = SRBCTLP5.CTPCA5
		LEFT JOIN SROCTLP6 SRBCTLP6 ON SRBPRG.PGPCA6 = SRBCTLP6.CTPCA6
 
		where PGSTAT <> 'D'
		$filtros 
		";
//lineas
$sql ="$SELcontar $from";
$result = odbc_exec($db2conp, $sql) or die($sql);
while($row = odbc_fetch_array($result)){
	$registros = $row['REGS'];
	}
//inventario
if($_POST['oraculo'] !=''){
    foreach($refARR as $ref){ $ref = trim($ref);
		$sql ="$SELcampos $from AND SRPRDC ='$ref' $forder $flimit";
		//ECHO "<BR>$sql";
		$result = odbc_exec($db2conp, $sql) or die($sql);
		while($row = odbc_fetch_array($result)){
 		foreach($row as $campo => $valor){
			$ti["$campo"][]= utf8_encode($valor);
			}
		}
	}
}else{
    $sql ="$SELcampos $from $forder $flimit";
	//ECHO "<BR>$sql";
	$result = odbc_exec($db2conp, $sql) or die($sql);
	while($row = odbc_fetch_array($result)){
 	foreach($row as $campo => $valor){
		$ti["$campo"][]= utf8_encode($valor);
		}
	}
	
} 
//}
?>
</head>
<body class="global" style=" background-color:white; background-repeat: no-repeat; background-attachment:fixed" >
<center>

<form id="sistema" action="inv.php" method="post" name="submit button1" autocomplete="off">

      <input type="hidden" name="subtituloH" id="subtituloH" value="<?= $_POST['subtitulo']?>" >

      <input type="hidden" name="anoH" id="anoH" value="<?= $_POST['ano']?>" >
      <input type="hidden" name="infH" id="infH" value="<?= $_POST['inf']?>" >
    <input type="hidden" name="labH" id="labH" value="<?= $_POST['lab']?>" >

<div class="container" style="border:1;">

<section class="nover">
<table table class="frr" style="width: 100%">
				<tr>
					<td colspan="2" align="center">
					<a href="inv.php"><input class="frr" type="button" value=" Limpiar "></a>
					</td>
				</tr>
				<tr>
					<td align="right" style="height: 30px; width:40%;" ><strong>EMPRESA</strong></td>
					<td>:&nbsp; 
						<select onchange="this.form.submit();" id="empresa" class="frr select2" name="empresa" tabindex="2">
        				<option><?= $_POST['empresa']?></option>
        				<?
        					foreach($_SESSION['empresA'] as $emp){
        					if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        					}
        				?> 
       					</select>
					</td>
				</tr>
				<tr>
					<td align="right" style="height: 30px; width:40%;" ><strong>BODEGA</strong></td>
					<td align="left" style="height: 30px; width:60%;" >:&nbsp;
					<select id="bod" class="frr select2" name="bod" onchange="this.form.submit();" tabindex="2" >
					<option <? if($_POST['bod'] =='5 Y 8'){ echo 'selected';} ?> >5 Y 8</option>
					<?
					$sql = "SELECT distinct SRSROM as BOD FROM SRBSRO";
					$result = odbc_exec($db2conp, $sql);
					while($row = odbc_fetch_array($result)){
					if($_POST['bod'] == $row['BOD']){ $selected = 'selected'; }else{ $selected = ''; }
					echo "<option $selected>$row[BOD]</option>";
					}
					$selected = '';
					?>
					</select>
                    </td>
				</tr>

				<tr>
					<td align="right" style="height: 30px" ><strong>MOSTRAR</strong></td>
					<td align="left" style="height: 30px" >:&nbsp;
					<select id="mostrar" class="frr select2" name="mostrar" onchange="this.form.submit();" tabindex="2" >
					<option <? if($_POST['mostrar'] =='CON SALDO'){ echo 'selected';} ?> >CON SALDO</option>
					<option <? if($_POST['mostrar'] =='TODO'){ echo 'selected';} ?>>TODO</option>
					</select>
                    </td>
				</tr>
				<tr>
					<td align="right" ><strong>ORDENADO POR</strong></td>
					<td align="left" >:&nbsp;
					<select id="orden" class="frr select2" name="orden" onchange="this.form.submit();" tabindex="2" style="width:60%">
					<option <? if($_POST['orden'] =='DESCRIPCION'){ echo 'selected';} ?> >DESCRIPCION</option>
					<option <? if($_POST['orden'] =='ITEM'){ echo 'selected';} ?>>ITEM</option>
					<option <? if($_POST['orden'] =='EXIST'){ echo 'selected';} ?>>EXIST</option>
                    </select>
                    <select id="aod" class="frr select2" name="aod" onchange="this.form.submit();" tabindex="2" style="width:29%">
					<option <? if($_POST['aod'] =='A-Z'){ echo 'selected';} ?> >A-Z</option>
					<option <? if($_POST['aod'] =='Z-A'){ echo 'selected';} ?>>Z-A</option>
					</select> 
            		</td>
				</tr>
				<tr>
					<td align="right" style="height: 30px" ><strong>GRUPO PROV</strong></td>
					<td align="left" style="height: 30px" >:&nbsp;
					<select id="prov" class="frr select2" name="prov" onchange="this.form.submit();" tabindex="2">
					<option><? echo "$_POST[prov]";?></option>
					<option value="">TODAS</option>
          <? 
            $sql = "select CTPPGN AS COD, CTPPGD AS NOMBRE FROM SROCTLDB SRBCTLDB $fpprov ";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option value='".$row['COD']."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])." ($row[COD])</option>";
            } 
          ?>
         		   </select> </td>
				</tr>
		<tr>
			<td align="right" ><strong>SEGMENTO </strong></td>
			<td align="left"  width="50%">:&nbsp;
			<select id="seg" class="frr select2" name="seg" onchange="this.form.submit();" tabindex="2">
			<option><?= $_POST['seg']?></option>
			<option value="">TODOS</option>
         <? $sql = "SELECT SQISET AS COD, SQSETD AS NOMBRE FROM SROCTLSQ";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               echo "<option VALUE ='".trim($row['COD'])."' >".$row['NOMBRE']."</option>";
            } 
         ?>
       	 </select></td>
		</tr>
		<tr>
			<td align="right" ><strong>GRUPO</strong></td>
			<td align="left"  width="50%">:&nbsp;
			<select id="gru" class="frr select2" name="gru" onchange="this.form.submit();" tabindex="2">
			<option><? echo "$_POST[gru]";?></option>
			<option value="">TODAS</option>
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
			<td align="right" style="height: 30px" ><strong>CATEGORIA</strong></td>
			<td align="left" style="height: 30px" >:&nbsp;
			<select id="cat" class="frr select2" name="cat" onchange="this.form.submit();" tabindex="2">
			<option><? echo "$_POST[cat]";?></option>
			<option value="">TODAS</option>
          <? if($_POST['gru'] != ''){$fseg =" AND substr(IVSGVA,1,2) = substr('$_POST[gru]',1,2) "; 
            	$sql = "SELECT IVSGVA AS COD, IVSGVD AS NOMBRE FROM SROCTLIV WHERE IVISNO = '2' $fseg";
	        	$result = odbc_exec($db2con, $sql);
            	while($row = odbc_fetch_array($result)){ 
            	   echo "<option value='".trim($row['COD'])."- ".utf8_encode($row['NOMBRE'])."' >".utf8_encode($row['NOMBRE'])."</option>";
            	}
            } 
          ?>
            </select> </td>
		</tr>
		<tr>
			<td align="right" ><strong>SUB-CATEGORIA</strong></td>
			<td align="left" >:&nbsp;
			<select id="subcat" class="frr select2" name="subcat" onchange="this.form.submit();" tabindex="2">
			<option><? echo "$_POST[subcat]";?></option>
			<option value="">TODAS</option>
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
			<td colspan="2" align="center">
			&nbsp;
			</td>
		</tr>

		<tr>
			<td align="right" ><strong>PRINCIPIO ACTIVO</strong></td>
			<td align="left" >:&nbsp;
        <?
       if($_POST['seg'] != '' or $_POST['gru'] != '' or $_POST['cat'] != '' or $_POST['subcat'] != ''){
       ?>
        	<select id="pac" class="frr select2" name="pac" onchange="this.form.submit();" tabindex="2">
			<option><? echo "$_POST[pac]";?></option>
			<option value="">TODAS</option>
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
			<td align="right" ><strong>PRODUCTO</strong></td>
			<td align="left"  >:&nbsp;
			<input id="prod" class="frr select2a" name="prod" style="width:90%; height:25px;" value="<?= $_POST['prod']?>" >
          </td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td align="right" valign="bottom"><strong>ORÁCULO</strong></td>
			<td align="left" >:&nbsp;
			<textarea id="oraculo" class="frr select2a" name="oraculo" rows="5" style="width:90%;" ><?= $_POST['oraculo']?></textarea>
          </td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			<input onclick="this.form.submit();" class="frr" type="button" value=" Buscar ">
			</td>
		</tr>
	

		
	</table>    
 </section>

 <section23>
 
 <div class="aut" style="width:100%; height:100%">
<a class="frl" style="font-weight:bolder; font-size:16px">
<br>INFORME DE INVENTARIO (<?= strtoupper($_POST['empresa'])?>)
<br><?= date("Y-m-d");?>
</a>
<table align="center" class="frr" border="1" cellspacing="0">
	<tr>
	<td colspan="20" align="right" style="border:none">
	Total
	<b><u><?= number_format($registros,0,'','.')?></u></b>
	Registros, por pagina :
	<select onchange="this.form.submit();" class="frr" name="regsxpag" id="regsxpag" style="width: 50px; ">
	<option><?= $_POST['regsxpag']?></option>
	<?
	if($_POST['regsxpag'] != '25'){ echo "<option>25</option>";}
	if($_POST['regsxpag'] != '50'){ echo "<option>50</option>";}
	if($_POST['regsxpag'] != '100'){ echo "<option>100</option>";}
	if($_POST['regsxpag'] != '200'){ echo "<option>200</option>";}
	if($_POST['regsxpag'] != '500'){ echo "<option>500</option>";}
	?>
	</select>
	mostrando página:
	<select onchange="this.form.submit();" class="frr" name="pag" id="pag" style="width: 55px; ">
	<?
	$pagsT = number_format( $registros/$_POST['regsxpag'],0,'','');
	$contP = 0;
	while($contP < $pagsT){
		$contP += 1;
		if($contP == $_POST[pag]){ $selected ="selected"; }else{ $selected =""; } 
		echo "<option $selected>$contP</option>";
	}
	?>
	</select>
	de
	<?= number_format($pagsT,0,'','.')?>
	pags
	</td>
	</tr>
	<tr>
		<?
		foreach($ti as $titulo => $valor){
			echo "<th>$titulo</th>";
			}
		?>
	</tr>
	<?
	$cont = 0;
	$color = "";
	while($cont < count($ti["$titulo"])){
		if($ti['ITEM']["$cont"] != $item2){
			if($color == ""){$color = "lightgray";}else{$color = "";}
			}
			$item2 = $ti['ITEM']["$cont"];
		echo "<tr bgcolor='$color'>";
		foreach($ti as $titulo => $valor){
			if(is_numeric($ti["$titulo"]["$cont"])){
	      		$ti["$titulo"]["$cont"] = number_format($ti["$titulo"]["$cont"],0,"","");
	      		$alri = "align='right'";
	      		}else{ $alri ='';}
	      	if($ti["$titulo"]["$cont"] == '0'){ $ti["$titulo"]["$cont"] =''; }
	      	if($titulo == 'PRECIO'){
	      		//$sqlP ="(SELECT NETO1  FROM VISNETPRC2 WHERE VISNETPRC2.PGPRDC = '".$ti["ITEM"]["$cont"]."' limit 0,1)";
	      		//$result = odbc_exec($db2conp, $sqlP);
	      		//while($rowP = odbc_fetch_array($result)){
	      		//	$ti["$titulo"]["$cont"] = "$".number_format($rowP['NETO1'],0,",",".");
	      		//	$alri = "align='right'";
	      		//	}
	      		}	
			echo "<td $alri style='padding-right:5px;border-radius:0; border-left-style:none; border-top-style:none; border-right-style:solid; border-bottom-style:solid; '>".$ti["$titulo"]["$cont"]."</td>";
			}
		echo "</tr>";
		$cont ++;
	}
	if($cont == 0){
	echo "<tr>
			<td colspan='20' align='center' style='border:none'>
				<br>
				<br>********
				<br><font color='red' >NO HAY RESULTADOS PARA LA BUSQUEDA</font>
				<br>********<br>
			</td>
		  </tr>	
		 ";
	}
	?>
</table>
</div>

 </section23>
</div>
 </form> 


</center>
</body>
</html>
