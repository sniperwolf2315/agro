<?php
  include("user_con.php");
  /*PRUEBAS
  $destinatario =['desarrollador2@agrocampo.com.co'];
  */

  /** PRODUCCION 
   */
   $destinatario = [
     "juan.silva@agrocampo.com.co",
     "ventasweb@agrocampo.tienda",
     "sistemas@agrocampo.com.co",
     "analista.estadistico@agrocampo.com.co",
     "analista.costos@agrocampo.com.co",
    ];
    
    $CCO = [
      "david.gomez@agrocampo.com.co",
      "cesar.torres@agrocampo.com.co",
      "daniel.diaz@agrocampo.com.co",
    ];

$hoy = date("Y-m-d");
$ahora = date("Y-m-d H:i");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));
$hoy_1sem_Ibs = str_replace("-","", $hoy_1sem);
// $pruebas ='<br>ESTO ES UNA PRUEBA<br>';

$sql = "select Sequence from creacionencabezadoventa where fecha >='$hoy_1sem'";
// echo $sql;
$result = mssql_query($sql) or die("algo paso MS ".mssql_get_last_message());
while($row = mssql_fetch_array($result)){
  $guardados .= "$coma$row[0]";
  $coma =",";
  }
$coma='';
//echo $guardados; die;
$sql = "select max(created_at) FROM agro_sales_order "; //
$result = mysqli_query($mysqliM, $sql) or die("algo paso MY2 ".mysql_error($mysqlM));
while($row = mysqli_fetch_array($result)){
  $maxDat = $row[0];
}
$hoy_10min = date("Y-m-d H:i", strtotime("$maxDat - 10 minute"));

$sql = "select increment_id AS Sequence FROM agro_sales_order A
          LEFT JOIN 
          agro_sales_order_status_history C ON C.parent_id = A.entity_id AND C.status='processing' 
        WHERE 
         
         ( (A.status = 'processing' AND substr(C.comment,1,8)= 'APPROVED' )
            OR
            A.status = 'ondelivery' 
         )

        AND
          A.created_at BETWEEN '$hoy_1sem' AND '$hoy_10min'
        AND   
          increment_id NOT IN ($guardados)  
";
// echo $sql;
$result = mysqli_query($mysqliM, $sql) or die("algo paso MY ".mysqli_error($mysqliM));
while($row = mysqli_fetch_array($result)){

  $pendientes .= "$coma$row[0]";
  $coma =",";
  if($xLinea >= 3){
  $pendientes .= "<br>"; $xLinea = 0;
  }else{
  $xLinea += 1;
  }
}
$coma='';
$xLinea ='';

if(strlen($pendientes)< 3){
$pendientes = "<font color ='green'> Todo en Orden !</font>";
}
$pendientesMagento =
"<br>
 <p><b>Ordenes que no han bajado de Magento</b></p>
 <p>$pendientes</p>
";


//increment_id AS Sequence
$sql = "select CONCAT('Orden Mag: ',Sequence ,', ', NombreCliente,' cc: ', IDCliente,', ', Fecha) 
        from creacionencabezadoventa 
        where IDordenAgro ='' AND estado ='1' And fecha >= '$hoy_1sem'
        ";
        // echo $sql;
$result = mssql_query($sql) or die("algo paso MS ".mssql_get_last_message());
while($row = mssql_fetch_array($result)){
  $sinIbs .= " <br>".utf8_encode($row[0]);
  }

if(strlen($sinIbs)< 3){
$sinIbs = "<font color ='green'> Todo en Orden !</font>";
}
$pendientesIbs =
"<br>
 <p><b>Ordenes que no se han Guardado en IBS</b></p>
 <p>$sinIbs</p>
";

//ordenes en IBS sin items
$sql = "select
        SROORSHE.OHORNO as ORDEN
       ,SROORSHE.OHORDT AS TIPO_ORDEN
       ,SROORSHE.OHODAT AS FECHA_ORDEN
       ,SRBSOL.OLPRDC as item
       FROM AGR620CFAG.SROORSHE SROORSHE
       LEFT JOIN AGR620CFAG.SROORSPL SRBSOL ON SROORSHE.OHORNO = SRBSOL.OLORNO
       where 
         OHSTAT <> 'D'
       and
         SROORSHE.OHORDT = 'S1'
       and
         SRBSOL.OLPRDC is null
       and
         OHHAND = 'INTEGRATOR'
       and
         SROORSHE.OHODAT >= '$hoy_1sem_Ibs' 
       ";
$result = odbc_exec($db2conp, $sql);
  while($row = odbc_fetch_array($result)){
    $sinItem .= "$coma $row[ORDEN] ";
    $coma =",";
    if($xLinea >= 3){
        $sinItem .= "<br>"; 
        $xLinea = 0;
      }else{
        $xLinea += 1;
      }
  } 
$coma='';
$xLinea ='';

if(strlen($sinItem)< 3){
$sinItem = "<font color ='green'> Todo en Orden !</font>";
}
$pendientesItem =
"<br>
 <p><b>Ordenes en IBS sin Items</b></p>
 <p>$sinItem</p>
";

//echo $pendientesItem; die;
//correo electronico  
			$asunto = "Errores Integracion $hoy"; 
			$cuerpo = " 
			<html> 
			<head> 
   			<title>REPORTE DE INTEGRACION MAGENTO - IBS</title> 
				</head> 
				<body>
				<br>
				<H>REPORTE DE INTEGRACION MAGENTO - IBS</H> 
				$pendientesMagento
				$pendientesIbs
				$pendientesItem
				<br>
				<br>
				Atentemente
				<br>
				Integracion Magento-IBS
				<br>
				$ahora
				$pruebas
				</body> 
				</html> 
				";

				//para el envÃƒÂ­o en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=utf8\r\n"; 

				//direcciÃƒÂ³n del remitente 
				// $headers .= 'From: Integracion Magento-IBS <no_responder@agrocampo.tienda>' ."\r\n"; 
				$headers .= 'From: Integracion Magento-IBS <no_responder@agrocampo.com.co>' ."\r\n"; 

				//direcciÃƒÂ³n de respuesta, si queremos que sea distinta que la del remitente 
				// $headers .= "Reply-To: Integracion Magento - IBS <no_responder@agrocampo.tienda>\r\n"; 
				$headers .= "Reply-To: Integracion Magento - IBS <no_responder@agrocampo.com.co>\r\n"; 
                
        $headers .= 'Cc: '.$CCO[0].';'.$CCO[1].';'.$CCO[2].''. "\r\n";
 
				if($_GET['enviar'] != 'SI'){
				echo $cuerpo;
				die;
				}				

        include('funcion_mails.php');				
        envio_mail($destinatario,$CCO,$cuerpo,$ahora);
          

      
odbc_close();				
?>
  
