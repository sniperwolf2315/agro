<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="../antenna.css" id="css" />
<title>Verificador de precios</title>
<script type="text/javascript" src="assets/interface.js"></script>

</head>
<?php

// 9323837011553 
//session_start();
//require('user_con.php');
$sql_insert_invetario ='';

// if($db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC')){
	if($db2conp = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc)){
		$base ="ibs";
		}else{
		//MYSQL
		$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
		$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
		$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);
		$base ="CONTIGENCIA";
		$basemsj = $base;
		}


$desc = "Escanee su producto $basemsj";
$_POST[ean] = trim($_POST[ean]);

// $sqlP ="SELECT PUBLICO AS PUBLICO, NETO AS NETO, PGDESC AS DESCU ,(SELECT PVVAHC FROM SRBPRV WHERE PVTOCY ='COL' and PVPRDC = PGPRDC ) AS IVA FROM VISPRCNET5 WHERE PCXPRC = '$_POST[ean]'";
if ($_POST[nro_copias]==''){
	$_POST[nro_copias] = 1;
}


$sqlP ="SELECT 
PGPRDC,
PGSTAT,
PGDESC,
PCXPRC,
PGPGRP,
PUBLICO,
PUBLICO,
$_POST[nro_copias] as IMPRIMIR,
'' CTPCT1,
'DataWifi2' as IMPRESORA,
'Pistola2' as TERMINAL,
PUBLICO AS PUBLICO,
NETO AS NETO,
PGDESC AS DESCU,
(SELECT PVVAHC FROM SRBPRV WHERE PVTOCY ='COL' and PVPRDC = PGPRDC ) AS IVA
FROM VISPRCNET5
where (PCXPRC ='$_POST[ean]' OR PGPRDC ='".$_POST['ean']."' ) 
";
/** 11-10-2022
 * Se solicita por parte de Cesar Torres agregar el campo de PGPRDC dado que el codigo de barran no estaba reconociendo el valor original con este ajuste valida por codigo de ibs y codigo de barras registrado
 */


				
	      		if($base == 'ibs'){
                        $result = odbc_exec($db2conp, $sqlP); //echo odbc_errormsg();
	      		$rowP = odbc_fetch_array($result);
				}elseif($base == 'CONTIGENCIA'){
                        $result = mysqli_query($mysqli, $sqlP); 
	      		$rowP = mysqli_fetch_array($result);
				}   
				$longitud =  sizeof($rowP);

				
				if($longitud<=1){
					$sqlP ="SELECT 
							PGPRDC,
							PGSTAT,
							PGDESC,
							PCXPRC,
							PGPGRP,
							PUBLICO,
							PUBLICO,
							$_POST[nro_copias] as IMPRIMIR,
							'' CTPCT1,
							'DataWifi2' as IMPRESORA,
							'Pistola2' as TERMINAL,
							PUBLICO AS PUBLICO,
							NETO AS NETO,
							PGDESC AS DESCU,
							(SELECT PVVAHC FROM SRBPRV WHERE PVTOCY ='COL' and PVPRDC = PGPRDC ) AS IVA
							FROM VISPRCNET5
							where (PGPRDC ='$_POST[ean]' or  PCXPRC ='$_POST[ean]') 
							";
							$result = odbc_exec($db2conp, $sqlP); //echo odbc_errormsg();
							$rowP = odbc_fetch_array($result);
							
						}	
				while($rowP){
					$desc2 		= $desc;
					$publico 	= $rowP['PUBLICO'];
					$neto 		= $rowP['NETO'];
					$desc 		= $rowP['DESCU'];
					$iva 		= $rowP['IVA'];
					$descARR 	= explode(" ", strtolower($desc));
					
					if($iva == 'IV19' OR $iva == 'IV16'){
						$iva = "19% IVA";
						$ivaTXT = "Base $".number_format(($neto/1.19),0,',','.')." + 19%IVA $".number_format(($neto-(number_format($neto/1.19,0,'',''))),0,',','.');
					}elseif($iva == 'IV05'){
						$ivaTXT = "Base $".number_format(($neto/1.05),0,',','.')." + 5%IVA $".number_format(($neto-(number_format($neto/1.05,0,'',''))),0,',','.');
					}else{
						$ivaTXT = "Base $".number_format($neto,0,',','.')." prod sin IVA";
					}

					/* validamos que el codigo de barras propio no venga vacio */	
					$cod_barr_prop =($rowP[PCXPRC]=='')?"null":$rowP[PCXPRC];
					$cod_barr_prop =(is_numeric($cod_barr_prop))?$cod_barr_prop:$rowP[PGPRDC];
					$descripcion_producto = str_replace("'","`",$rowP[PGDESC]);
					
					$sql_insert_invetario = "
					INSERT INTO [SqlInventario].[dbo].[invImpresion] (PGPRDC,PGSTAT,PGDESC,PCXPRC,PGPGRP,PUBLICO,PN2,IMPRIMIR,CTPCT1,IMPRESORA,TERMINAL) 
					VALUES (
					 $rowP[PGPRDC],
					'$rowP[PGSTAT]',
					'$descripcion_producto',
					 $cod_barr_prop ,
					'$rowP[PGPGRP]',
					'".number_format($rowP[NETO],0,"",".")."',
					'".number_format($rowP[NETO],0,"",".")."',
					 $rowP[IMPRIMIR],
					'$rowP[CTPCT1]',
					'$rowP[IMPRESORA]',
					'$rowP[TERMINAL]'	
					)				
					";

					break;
				}

				if($_POST[ean] !='' AND $neto == '' ){
					$desc = "<b>Perdon no tengo ese precio, 
					<br>contacta a un asesor ;)</b>" ;

					}
				if($descARR[0] !=''){
				$msjwww = "Encuentra mas productos en:<br>";
				$busca = "/catalogsearch/result/?q=$descARR[0]";
					if($descARR[1] !=''){
					$busca .= "|$descARR[1]";
					$botones_imp = true;
					}
				}else{
				$msjwww = "Visita Nuestra pagina web:<br>";
				}	
				
	echo '
	<body>
		<table class="abs frl" width="100%" height="100%"  border="0">
			<tr>
				<td align="center" valign="middle" height="100%"  width="50%" rowspan="5" style="border-style:groove; height:100% " >
					<font size="+2"><b>'.$msjwww.'</b
					</font>
					<br/>
					<img src="../_qr.php?busca=https://www.agrocampo.com.co'.$busca.'" width="40%" />
					<br/>
					<font size="+2"><b>www.agrocampo.com.co</b></font>
				</td>
				<td height="25%" width="50%" align="center">'.$desc2.'</td>
			</tr>
			<tr>
				<td height="25%" align="center"><font size="+2">'.$desc.'</font></td>
			</tr>
			<tr>
				<td height="25%" align="center">
					<font size="+4"> $ '.number_format($neto,0,"",".").'</font>
					<br/>'.$ivaTXT.'
				</td>
			</tr>
			<tr>
				<td height="25%" >
					<form class="aut" id="sistema" action="preciosII.php" method="post" name="sistema" autocomplete="off">
						
				';
				if($_POST['ean'] ==''){
					echo '<input id="ean" name="ean" style="width:100%"/>';
				}else{
					echo '
					<input id="ean" name="ean" style="width:100%" value="'.$_POST[ean].'" />
					<br>
					';
					if($botones_imp){
							echo '
								<br>
								<label>Copias:</label><input id="nro_copias" name="nro_copias" class="nro_copias" placeholder="Nro. copias" min="0" max="10" type="number" >
							';
								// VAIADMOS QUE TODOS LOS CAMPOS ESTEN DILIGENCIADOS
								if($_POST['ean'] !='' && ($_POST['nro_copias'] != ' ' || $_POST['nro_copias'] > 0) ){
								echo '
									<button onclick="this.form.submit(); " id ="envio" name="envio" class="envio">Enviar</button>
									<br>
								';
								}
						}
				}
				
				echo '
				
				</form>   
				</td>
				</tr>
				
				</table>
				</body>
				';
				/* si la peticion se ha disparado ejecuta */
				if (isset($_POST['envio'])) {
					require_once('../nuevo_sia_v2/conection/conexion_sql.php');
					$conn = new con_sql('SqlInventario');
					$insert_cantidad = $_POST['nro_copias'];
					
					if ($insert_cantidad >10){
						$insert_cantidad = 10;
					}
					for($i = 1; $i <= $insert_cantidad; $i++){
						// echo $sql_insert_invetario;
						// echo $conn->conectar($sql_insert_invetario);
					}
					echo '<meta http-equiv="Refresh" content="5;url=preciosII.php">';
				}else{
					echo 'X';
				}
				echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>$sql_insert_invetario";
		
odbc_close();		
?>
</html>
