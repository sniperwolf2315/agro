<?
//usuarios con permiso especial para este formulario:
$permitidos = array('MOTTAR','GONZALEZS');
 
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

//conectores DB
include("../../user_con.php");
// definicion de accesos de usuarios y equivalencia usuario -> VENDXXXX
include("../../user_user.php");

//$_POST[vendedor] ='MOTTAR';
//valida permisos especiales
if(in_array("$_POST[vendedor]", $permitidos)){
$patrones = 'SI'; 
//ECHO "..................------------------------------";
$_POST[vendedor] = '';
}


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
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }

</style>

<style type="text/css" media="print">
@page{
   size: letter portrait;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>
<script>
$(document).ready(function(){
        
    $("select").select2(); 
});
</script>

</head>
<?
  
if($patrones =='SI'){
	if($_POST['area'] == '' ){ }
	if($_POST['area'] == 'Call' ){$fvend = "AND NAARHA IN ($vendcall)";}
	if($_POST['area'] == 'Venta Externa' ){$fvend = "AND NAARHA IN ($vendext)";}
	if($_POST['area'] == 'Almacen' ){$fvend = "AND NAARHA IN ($vendalm)";}	
}else{
	$fvend = "AND NAARHA = '$_POST[vendedor]'";
}
    $ancho = '780px';
    
    

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
	                  , SUM(SRODTA.DTSCRA) AS SALDO
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
                      SRODTA.DTTCRA > 0
                      GROUP BY 
                        SRBISH.IHINVN
	                    , SUBSTRING(SRBISH.IHIDAT,1,4)||'-'||SUBSTRING(SRBISH.IHIDAT,5,2)||'-'||SUBSTRING(SRBISH.IHIDAT,7,2)
	                  ORDER BY
	                    2 asc  
                    "; 
            $ti['NOMBRE'] = explode("°",$_POST['clienteArr']);
            }
	//echo $sql;
		 
$result = odbc_exec($db2conp, $sql) ; 
while($row = odbc_fetch_array($result)){
  foreach($row AS $titulo => $valor){
  $ti["$titulo"][] = utf8_encode($valor); 
  }
}
//print_r($ti);		
?>
<body class="global" <?= $autoprint?> >
<form id="movse1" action="cont_recibo.php" method="post" name="submit button1">

<section class="nover " >
  <center>
        <br>
		<br>
        <br>
  		Empresa:
		<br>
		<select onchange="this.form.submit();" id="empresa" class="frm campo" name="empresa" tabindex="2">
        		<option><?= $_POST['empresa']?></option>
        		<?
        		foreach($_SESSION['empresA'] as $emp){
        		if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        		}
        ?> 
        </select>
        <br>
		<br>
		<br>
		Clientes <?= $_POST['vendedor']?> : 
		<br>
		<select onchange="this.form.submit();" id="cliente" name="cliente" class="verloaderB frm campo"  >
					<option><?= $_POST['cliente']?></option>
					<?
					    $coma=''; 
						foreach($ti['NOMBRE'] as $titulo ){
						  if($_POST['cliente'] != trim($titulo) ){echo "<option >$titulo</option>";}
						  $clienteArr .= $coma.trim($titulo);
						  $coma= "°";
						}
						$coma='';
					?>
		<input type="hidden" id="clienteArr" name="clienteArr" value="<?= $clienteArr?>" >			

				  </select>
		<br><br>
	    <!-- <input type="button" class="frm" value=" Imprimir " onClick="javascript:window.print()" /> -->
  </center>
</section>
<section23>
<table  class="frs" align="center" border="0" bgcolor="#FFFFFF" cellspacing="0" style="width: 100%">
    <tr class="frxs" align="center">
        <td  style="height: 28px;">
    	    <center>
                <?
                if($_POST['cliente'] ==''){
	            echo "<br><br><br><br><br><br><br>
                     <a style='color:GREEN; font-size:20; font-weight:bolder;'><= BUSQUE CLIENTE POR NOMBRE o NIT</a>
	                 ";
                }else{
	                 echo "<br><br><br><br>
                          <a style='font-size:20; font-weight:bolder;'>Facturas por pagar<br>$_POST[cliente] </a>
	                      ";
               }
               ?>
           </center>
        </td>
    </tr>
        
            
        <tr>
            <td align="center">
                <table class="frm" cellspacing="0" style="border-radius:0;" cellpadding="10">
                	<tr bgcolor="Silver">
                		<th style="height: 14px">Factura</th>
                		<th style="height: 14px">Fecha</th>
                		<th style="height: 14px">SubTotal</th>
                		<th style="height: 14px">IVA</th>
                		<th style="height: 14px">Total</th>
                		<th style="height: 14px">Rte Fte</th>
                		<th style="height: 14px">Saldo</th>
                		<th style="height: 14px">A pagar</th>
                	</tr>
                	<?
                	if($_POST['cliente'] !=''){
                	  $color = 'GAINSBORO';
                	  for($i = 0; $i < count($ti['FACTURA']); $i++ ){
                	  $total = '';
                	  $rteFte ='';
                	  $pagar = '';
                	  if($color ==''){$color = 'GAINSBORO';}else{$color = '';}
                	  $total = $ti[VLR_EXC_IVA][$i] + $ti[VLR_IVA][$i];
                	  if( $ti[AUTO_RETENEDOR][$i] == 'Y' AND $ti[VLR_EXC_IVA][$i] >= 961000){
                	      $rteFte = $ti[VLR_EXC_IVA][$i] * 0.025;
                	     }
                	  $pagar = $total - $rteFte;   
                	  echo "<tr bgcolor='$color'>
                	        <td>".$ti[FACTURA][$i]."</td>
                	        <td>".$ti[FECHA][$i]."</td>
                	        <td align ='right'>".number_format($ti[VLR_EXC_IVA][$i],0,',','.')."</td>
                	        <td align ='right'>".number_format($ti[VLR_IVA][$i],0,',','.')."</td>
                	        <td align ='right'><b>".number_format($total,0,',','.')."</b></td>
                	        <td align ='right'>".number_format($rteFte,0,',','.')."</td>
                	        <td align ='right'><b>".number_format($pagar,0,',','.')."</b></td>
                	        </tr>  
                	        ";
                	  }
                	}  
                	?>
                </table>    
            </td>
        
                        
       
        </table>
</section23>
 
   
</form>
</body>
</html>
