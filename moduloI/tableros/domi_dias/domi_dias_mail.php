<?
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

$destinatario = " juan.silva@agrocampo.com.co
                 ;adriana.chacon@agrocampo.com.co
				 
				 ;david.rodriguez@agrocampo.com.co
                 ;william.castillo@agrocampo.com.co
                 ;juan.montenegro@agrocampo.tienda
                 
                 ;logistica73@agrocampo.com.co
                 ;domicilios@agrocampo.com.co
                 
                 ;proyectosagro@agrocampo.com.co
                 ;sistemas@agrocampo.com.co
                 
                 "; 
//$destinatario = "proyectosagro@agrocampo.com.co";
include("user_con.php");
$hoy = date("Y-m-d");
$ahora = date("Y-m-d H:i");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

//echo $guardados; die;
$filtroCA =" MAX_ESTADO ='10' AND DIA <> '1y2'";
$sqlCA = "select DIA, COUNT(*) AS CANT  FROM tablero_dias WHERE $filtroCA GROUP BY DIA "; //
$result = mysqli_query($mysqliL, $sqlCA) or die("algo paso MYl ".mysql_error($mysqlL));
while($row = mysqli_fetch_row($result)){
    $dia = $row[0];
    $est10["$dia"] = $row[1];
    
}

$filtroDO =" (ESTADO = ('20-45') OR (ESTADO =('60') AND DEST IN('DOM','SIN')) )AND DIA <> '1y2'";
$sqlDO = "select DIA, COUNT(*)  FROM tablero_dias WHERE $filtroDO GROUP BY DIA "; //
$result = mysqli_query($mysqliL, $sqlDO) or die("algo paso MYl ".mysql_error($mysqlL));
while($row = mysqli_fetch_array($result)){
    $dia = $row[0];
    $estDO["$dia"] = $row[1];
}

$filtroRE =" (ESTADO IN('20-45','60') AND DEST IN('REM'))AND DIA <> '1y2'";
$sqlRE = "select DIA, COUNT(*)  FROM tablero_dias WHERE $filtroRE GROUP BY DIA "; //
$result = mysqli_query($mysqliL, $sqlRE) or die("algo paso MYl ".mysql_error($mysqlL));
while($row = mysqli_fetch_array($result)){
    $dia = $row[0];
    $estRE["$dia"] = $row[1];
}


$filtroPD = "ESTADO ='60' AND DIA <> '1y2' AND DEST in('WEB','EXP')";
$sqlPD = "select DIA, COUNT(*)  FROM tablero_dias WHERE $filtroPD GROUP BY DIA "; //
$result = mysqli_query($mysqliL, $sqlPD) or die("algo paso MYl ".mysql_error($mysqlL));
while($row = mysqli_fetch_array($result)){
    $dia = $row[0];
    $est60["$dia"] = $row[1];
}

$web = "<table align='center' width='90%' border='1' cellspacing='0'>
           <tr>
             <td colspan='2' align='center'><b>PUNTO WEB Y EXPRESS</b><br>Estado 60(sin quemar)</td>
           </tr>
           <tr>
             <th>Dia</th>
             <th>Cantidad</th>
           </tr>
           <tr>
             <td>Dia 3</td>
             <th>".$est60["3"]."</th>
           </tr>
           <tr>
             <td>Dia 4 omas</td>
             <th>".$est60["4 o mas"]."</th>
           </tr>
           <tr>
             <th colspan='2'>
             <br>
             <a href='http://sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?k=".substr(base64_encode(date("siH")),0,5).base64_encode($filtroPD)."'>Descargar Listado Actualizado</a>
             <br>
             &nbsp;
             </th>
           </tr>
         </table>  
         ";

$dom = "<table align='center' width='90%' border='1' cellspacing='0'>
           <tr>
             <td colspan='2' align='center'><b>DOMICILIOS</b><br>Estado 20 a 45 y 60(sin quemar)</td>
           </tr>
           <tr>
             <th>Dia</th>
             <th>Cantidad</th>
           </tr>
           <tr>
             <td>Dia 3</td>
             <th>".$estDO["3"]."</th>
           </tr>
           <tr>
             <td>Dia 4 omas</td>
             <th>".$estDO["4 o mas"]."</th>
           </tr>
           <tr>
             <th colspan='2'>
             <br>
             <a href='http://sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?k=".substr(base64_encode(date("siH")),0,5).base64_encode($filtroDO)."'>Descargar Listado Actualizado</a>
             <br>
             &nbsp;
             </th>
           </tr>
         </table>  
         ";

$rem = "<table align='center' width='90%' border='1' cellspacing='0'>
           <tr>
             <td colspan='2' align='center'><b>REMESAS</b><br>Estado 20 a 45 y 60(sin quemar)</td>
           </tr>
           <tr>
             <th>Dia</th>
             <th>Cantidad</th>
           </tr>
           <tr>
             <td>Dia 3</td>
             <th>".$estRE["3"]."</th>
           </tr>
           <tr>
             <td>Dia 4 omas</td>
             <th>".$estRE["4 o mas"]."</th>
           </tr>

           <tr>
             <th colspan='2'>
             <br>
             <a href='http://sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?k=".substr(base64_encode(date("siH")),0,5).base64_encode($filtroRE)."'>Descargar Listado Actualizado</a>
             <br>
             &nbsp;
             </th>
           </tr>
         </table>  
         ";


$call = "<table align='center' width='90%' border='1' cellspacing='0'>
           <tr>
             <td colspan='2' align='center'><b>CALL CENTER</b><br>Estado 10</td>
           </tr>
           <tr>
             <th>Dia</th>
             <th>Cantidad</th>
           </tr>
           <tr>
             <td>Dia 3</td>
             <th>".$est10["3"]."</th>
           </tr>
           <tr>
             <td>Dia 4 omas</td>
             <th>".$est10["4 o mas"]."</th>
           </tr>
           <tr>
             <th colspan='2'>
             <br>
             <a href='http://sia.agrocampo.vip/moduloI/tableros/domi_dias/domi_dias_csv.php?k=".substr(base64_encode(date("siH")),0,5).base64_encode($filtroCA)."'>Descargar Listado Actualizado</a>
             <br>
             &nbsp;
             </th>
           </tr>
         </table>  
         ";


//correo electronico  
			$asunto = "Pendientes Web $hoy"; 
			$cuerpo = " 
			<html> 
			<head> 
   			<title>REPORTE DE PEDIDOS WEB PENDIENTES DE TRAMITE </title> 
				</head> 
				<body >
				<br>
				<br>
				<table cellspacing='10' align='center' width='66%' style='border-style:groove;border-color:DarkOrange;border-radius:15px'>
				  <tr>
				    <th colspan='2'>
				      <H2>REPORTE DE PEDIDOS WEB PENDIENTES DE TRAMITE<br>".date("d-M H:i")."</H2>
				    </th>
				  </tr>
				  <tr>
				    <td width='50%'>$dom</td>
				    <td width='50%'>$rem</td>
				  </tr>
				  <tr>
				    <td>$call</td>
				    <td>$web</td>
				  </tr>
				  <tr>
				    <td colspan='2'>
				      <br>
				      <h3>Atentemente</h3>
				      <h4>Sistema de Alertas Nuevo SIA <br>$ahora</h4>
				    </td>
				  </tr>
				</table>  
				<br><br>
				
				<br>
				
				
				</body> 
				</html> 
				";

				//para el envÃƒÆ’Ã‚Â­o en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=utf8\r\n"; 

				//direcciÃƒÆ’Ã‚Â³n del remitente 
				$headers .= 'From: Nuevo SIA -Alerta Automatizada <no_responder@agrocampo.com.co>' ."\r\n"; 

				//direcciÃƒÆ’Ã‚Â³n de respuesta, si queremos que sea distinta que la del remitente 
				$headers .= "Reply-To: No Responder <no_responder@agrocampo.com.co>\r\n"; 
 
				//echo $cuerpo;
				//die;

				if($_GET['enviar'] != 'SI'){
				//echo $cuerpo;
				die;
				}								
				
				if( mail("$destinatario",$asunto,$cuerpo,$headers) )
				{ 
				//echo $cuerpo;  //echo "Correo enviado con exito"; 
				} else { 
				  echo "Error al enviar correo";  
				}
odbc_close();				
?>
  
