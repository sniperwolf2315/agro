<?

 if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo aqui<a href='../../index.php'></a>"; DIE;}


$areas[AG] = array('Call','Venta Externa','Almacen');

if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_POST['area'] != $_POST['areaH']){
	$_POST['cliente'] ='';
	$_POST['vendedor'] ='';
}

$codEmp = substr($_POST['empresa'],0,2);

$fechaCambioRf["AG"] = '2019-12-16';

//conectores DB
include("../../user_con.php");
// definicion de accesos de usuarios y equivalencia usuario -> VENDXXXX
include("../../user_user.php");

//$_POST['vendedor'] ='VEND040'; $patrones ='';

//usuarios con permiso especial para este formulario:
$permitidosTXT = "'MOTTAR','GONZALEZS','RODRIGUEZM','SANGUINOK','CASTILLOW','VILLAJ','MONTENEGRO', $vendcall";
$permitidos = explode(',', str_replace("'","",str_replace(" ","",$permitidosTXT)));
//print_r($permitidos);

//$permitidos = array('MOTTAR','GONZALEZS','RODRIGUEZM','SANGUINOK','CASTILLOW','VILLAJ','MONTENEGRO');

//valida permisos especiales
//echo  "--------------------------------$_POST[vendedor]----";
if(in_array(trim($_POST[vendedor]), $permitidos)){
  $patrones = 'SI'; 
  $_POST[vendedor] = '';
}


// error_reporting(1);
// ini_set('error_reporting', E_ALL);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<title>Untitled Web Page</title>
<meta content="Antenna 3.0" name="generator">
<meta content="no" http-equiv="imagetoolbar">
<link href="../../aajquery.css" rel="stylesheet">
<link id="css" href="../../antenna.css" media="all" rel="stylesheet" type="text/css">
<script src="../../antenna/auto.js" type="text/javascript"></script>
<script src="../../aajquery.js"></script>
<style media="print" type="text/css">
.nover {
	display: none;
}
</style>
<style type="text/css">
.frxxs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 7px;
	direction: ltr;
}
.frxs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 9px;
	direction: ltr;
}
.frs {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 10px;
	direction: ltr;
}
.frm {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 11px;
	direction: ltr;
}
.frl {
	font-family: Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif;
	color: #000000;
	font-size: 13px;
	direction: ltr;
}
</style>
<style media="print" type="text/css">
@page{
   size: letter portrait;	
   margin: 0;
}
header, footer, nav, aside {
	display: none;
}
</style>
<script>
/*
$(document).ready(function(){
        
    $("select").select2(); 
});
*/
</script>
</head>

<?

$hoy = date("Y-m-d");  
if($patrones =='SI'){
	//if($_POST['area'] == '' ){ }
	//if($_POST['area'] == 'Call' ){$fvend = "AND NAARHA IN ($vendcall)";}
	//if($_POST['area'] == 'Venta Externa' ){$fvend = "AND NAARHA IN ($vendext)";}
	//if($_POST['area'] == 'Almacen' ){$fvend = "AND NAARHA IN ($vendalm)";}	
}else{
	$fvend = "AND NAARHA = '$_POST[vendedor]'";
}
    $ancho = '780px';

if($_POST['ano'] ==''){ $_POST['ano'] = date("Y"); }    

if($_POST['id_plan'] != ''){
	$filtros_det .= " AND id_plan = '$_POST[id_plan]' ";
}    

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	


//consulta de factura

if($_POST['cliente'] == ''){
	    	$sql = "SELECT  
					DISTINCT(TRIM(SRBNAM.NANAME)||' | '||TRIM(SRBNAM.NANUM)) AS NOMBRE
	                FROM SRODTA SRODTA
                      LEFT JOIN SRONAM SRBNAM ON SRODTA.DTCUNO=SRBNAM.NANUM
                    WHERE 
                    SRODTA.DTTCRA > 0
                    AND SRBNAM.NANCA1 = 'CC01'
                    $fvend
                    ORDER BY 1
	               "; 

	    	}else{
	    	$cliente = explode(" | ", $_POST['cliente']);
	    	
	    	$sql = "SELECT  
	                  SRBISH.IHINVN AS FACTURA
	                  , SUBSTRING(SRBISH.IHIDAT,1,4)||'-'||SUBSTRING(SRBISH.IHIDAT,5,2)||'-'||SUBSTRING(SRBISH.IHIDAT,7,2) AS FECHA   
	                  , MIN(SRODTA.DTSCRA) AS SALDO
                      , SUM(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDNSVA ELSE SRBISD.IDNSVA*-1 END) AS VLR_EXC_IVA
                      , SUM(CASE SRBISD.IDTYPP WHEN 1 THEN SRBISD.IDITT ELSE SRBISD.IDITT*-1 END) AS VLR_IVA
                      , MAX((SELECT SUBSTRING(CMUFA1,3,1)  FROM SROCMA WHERE CMCUNO = SRODTA.DTCUNO)) AS AUTO_RETENEDOR
                    FROM SRODTA SRODTA
                      LEFT JOIN SROISH SRBISH ON SRODTA.DTREFX=SRBISH.IHREFX
                      LEFT JOIN SROISDPL SRBISD ON SRBISH.IHINVN = SRBISD.IDINVN AND SRBISH.IHORNO = SRBISD.IDORNO
	                  LEFT JOIN SRONAM SRBNAM ON SRODTA.DTCUNO=SRBNAM.NANUM
                    WHERE 
                      SRODTA.DTCUNO = '$cliente[1]'
                      AND
                      SRODTA.DTTCRA <> 0
                      
                      GROUP BY 
                        SRBISH.IHINVN
	                    , SUBSTRING(SRBISH.IHIDAT,1,4)||'-'||SUBSTRING(SRBISH.IHIDAT,5,2)||'-'||SUBSTRING(SRBISH.IHIDAT,7,2)
	                  HAVING
                        MIN(SRODTA.DTSCRA) > 0
	                  ORDER BY
	                    2 asc  
                    "; 
            $ti['NOMBRE'] = explode("°",$_POST['clienteArr']);
            }
	//echo $sql;
		 
//$result = odbc_exec($db2conp, $sql) ; 
while($row = odbc_fetch_array($result)){
  foreach($row AS $titulo => $valor){
  $ti["$titulo"][] = utf8_encode(trim($valor)); 
  }
}

// listas

$sql ="SELECT id, PROVEEDOR , TOTAL_COMPRAS , APORTE_PLAN, '' AS VER FROM prov_plan WHERE AÑO = '$_POST[ano]' ";
$result = mysqli_query($mysqli, utf8_decode($sql)) or die("lIST1 $sql ".mysqli_error($mysqli));
//$tiPLAN = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)){
   foreach($row As $tit => $val){
   $tiPLAN[$tit][] = $val; 
   }
   $tiPLANt["TOTAL_COMPRAS"] += $row["TOTAL_COMPRAS"];
   $tiPLANt["APORTE_PLAN"] += $row["APORTE_PLAN"];
}


?>
<body class="container global" <?= $autoprint?> >
<form id="movse1" action="prov_plan.php" method="post" name="submit button1" autocomplete="off"  >
	<section class="nover frr">
	<a href="prov_evento.php"><center><input type="button" class="frr" value=" IR A EVENTOS "></center></a>
	<table width="95%" class="frr" cellspacing="0" cellpadding="3px">
	  	<tr bgcolor="silver">
	  		<th colspan="4">
	  		  NEGOCIO AÑO 
	  		  <input onChange="this.form.submit()" class="campo frr" id="ano" name="ano" value="<?= $_POST['ano']?>" style="width:25%; text-align:center; font-weight:bold;">
	  		  <br>
	  		  Nuevo&#x21E8; <input onChange="this.form.submit()" type="radio" class="frr" id="queVer" name="queVer" value="nuevoPlan" >
	  		</th>
	  	</tr>
	  	
	  	<tr bgcolor="silver">
	  	<?	foreach($tiPLAN AS $titulo => $valor){
	  	    if($titulo =='id'){ continue; }
	  	    if($titulo == 'VER' ){
		      if($_POST['id_plan'] == '' ){
				   $checked = 'checked'; 
			   }else{
				   $checked = ''; 
			   } 
			  $titulo = "VER"; 
		    }
			echo "<th>$titulo</th>"; 
	  	  }
	  	?>  
	  	</tr>
	  	<tr bgcolor="silver">
	  		<td align="right">Total</td>
	  		<td><?= number_format($tiPLANt["TOTAL_COMPRAS"],0,',','.')?></td>
	  		<td><?= number_format($tiPLANt["APORTE_PLAN"],0,',','.')?></td>
	  		<th>Todo<input <?= $checked?> onChange='this.form.submit()' type='radio' id='id_plan' name='id_plan' value='' ></th>
	  	</tr>
	  	<?
	  	$contP = -1;
	  	$color ='gainsboro';
	  	foreach($tiPLAN["PROVEEDOR"] AS $titulo => $valor){
	  	  
	  	  if($color ==''){
		    $color ='gainsboro';
		    }else{
		    $color ='';
		    }
	  	echo "<tr bgcolor='$color'>";
	  	  $contP += 1;
	  	  foreach($tiPLAN AS $titulo2 => $valor2){
	  	    if($titulo2 !='PROVEEDOR')
	  	       { $valor2 = number_format($tiPLAN[$titulo2][$contP],0,',','.'); 
	  	       }else{
	  	       $valor2 = $tiPLAN[$titulo2][$contP];
	  	       }
	  	  if($titulo2 =='id'){ continue; }
	  	  if($titulo2 == 'VER' ){ 
		    if($_POST['id_plan'] == $tiPLAN[id][$contP]){
				   $checked = 'checked'; 
			   }else{
				   $checked = '';
			   }
			$valor2 = "<input $checked onChange='this.form.submit()' type='radio' id='id_plan' name='id_plan' value='".$tiPLAN[id][$contP]."' >"; 
		    $align = "align='center'";
		  }else{ 
		    $align = ""; 
		  }
		  
	  	  echo "<td $align>$valor2</td>";
	  	  }
	  	echo "</tr>";
	  	}
	  	?>
	  	
	  </table>
	</section>
<?
// panel lateral derecho se escoje dependiendo del la accion $_POST[queVer]

//por defecto se muestra el resumen prov_plan_res.php
if($_POST['queVer'] == ''
     AND $_POST['editDet'] == '' 
     AND $_POST['editLiq'] == ''
   ){
include("prov_plan_res.php"); 
}
if($_POST['queVer'] == 'nuevoPlan'){
include("prov_plan_plan.php"); 
}
if($_POST['queVer'] == 'nuevoDetalle'
  OR 
  $_POST['editDet'] != '' 
  ){
include("prov_plan_det.php"); 
}
if($_POST['editLiq'] != '' 
  ){
include("prov_plan_liq.php"); 
}

?>   
</form>

</body>

</html>
