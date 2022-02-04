<? 
//session_start();
//require('user_con.php');

if($db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC')){
$base ="ibs";
}else{
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);
$base ="CONTIGENCIA";
$basemsj = $base;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="antenna.css" id="css" />
<title>Sin título 1</title>
</head>
<?
$desc = "Escanee su producto $basemsj";
$_POST[ean] = trim($_POST[ean]);
$sqlP ="SELECT 
              PUBLICO AS PUBLICO
            , NETO AS NETO
            , PGDESC AS DESCU 
            ,(SELECT PVVAHC FROM SRBPRV WHERE PVTOCY ='COL' and PVPRDC = PGPRDC ) AS IVA
        FROM VISPRCNET5 WHERE PCXPRC = '$_POST[ean]' ";
	      		if($base == 'ibs'){
                        $result = odbc_exec($db2conp, $sqlP); //echo odbc_errormsg();
	      		$rowP = odbc_fetch_array($result);
                        }elseif($base == 'CONTIGENCIA'){
                        $result = mysqli_query($mysqli, $sqlP); 
	      		$rowP = mysqli_fetch_array($result);
                        }   
                        while($rowP){
	      		$desc2 = $desc;
	      		$publico = $rowP['PUBLICO'];
	      		$neto = $rowP['NETO'];
	      		$desc = $rowP['DESCU'];
	      		$iva = $rowP['IVA'];
	      		$descARR = explode(" ", strtolower($desc));
	      		
	      		if($iva == 'IV19' OR $iva == 'IV16'){
	      		$iva = "19% IVA";
	      		$ivaTXT = "Base $".number_format(($neto/1.19),0,',','.')." + 19%IVA $".number_format(($neto-(number_format($neto/1.19,0,'',''))),0,',','.');
	      		}elseif($iva == 'IV05'){
	      		$ivaTXT = "Base $".number_format(($neto/1.05),0,',','.')." + 5%IVA $".number_format(($neto-(number_format($neto/1.05,0,'',''))),0,',','.');
	      		}else{
	      		$ivaTXT = "Base $".number_format($neto,0,',','.')." prod sin IVA";
	      		}
	      		
	      		break;
                        }
if($_POST[ean] !='' AND $neto == '' ){
	$desc = "<b>Perdon no tengo ese precio, <br>contacta a un asesor ;)</b>" ;
	echo '<meta http-equiv="Refresh" content="5;url=preciosII.php">';
	}
if($descARR[0] !=''){
$msjwww = "Encuentra mas productos en:<br>";
$busca = "/catalogsearch/result/?q=$descARR[0]";
	if($descARR[1] !=''){
	$busca .= "|$descARR[1]";
	}
}else{
$msjwww = "Visita Nuestra pagina web:<br>";
}	      		
?>
<body>
<table class="abs frl" width="100%" height="100%"  border="0">
				<tr>
					<td align="center" valign="middle" height="100%"  width="50%" rowspan="6" style="border-style:groove; height:100% " >
						<font size="+2"><b><?= $msjwww?></b></font>
						<br/>
						<img src="_qr.php?busca=https://www.agrocampo.com.co<?= $busca?>	" width="50%" />
						<br/>
						<font size="+2"><b>www.agrocampo.com.co</b></font>
						
					</td>
				    <td height="25%" width="50%" align="center"><?= $desc2?></td>
    	 	    </tr>
    	 	    <tr>
    	 	        <td height="25%" align="center"><font size="+2"><?= $desc?></font></td>
    	 	    </tr>
    	 	    <tr>
    	 	        <td height="25%" align="center">
    	 	          <font size="+4"> $ <?= number_format($neto,0,"",".")?></font>
    	 	          <br/><?= $ivaTXT?>
    	 	        </td>
    	 	    </tr>
    	 	    <tr>
    	 	        <td height="25%" >
    	 	           <form class="aut" id="sistema" action="preciosII.php" method="post" name="sistema" autocomplete="off">
    	 	              <input autofocus="autofocus" onchange="this.form.submit();" id="ean" name="ean" style="border:none"  />
    	 	           </form>   
    	 	        </td>
    	 	    </tr>
    	 	</table>

</body>
<? odbc_close(); ?>
</html>
