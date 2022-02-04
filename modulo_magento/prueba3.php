<?php
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
//$resultDestino=odbc_exec($db2conp ,"SELECT *FROM AGR620CFAG.SRODST WHERE DTDEST='111011'");
//$resultDestino=odbc_exec($db2conp ,"DELETE FROM AGR620CFAG.SRODST WHERE DTDEST='111111' and DTDESC='Bogotá-Bogotá D.C.'");
//$resultDestino=odbc_exec($db2conp ,"INSERT INTO AGR620CFAG.SRODST WHERE DTDEST='111111'");
//odbc_exec($db2conp ,"INSERT INTO AGR620CFAG.SRODST (DTDEST,DTDESC)VALUES('111111','SUBA')");
//$rcD=odbc_num_rows($resultDestino);
//echo $rcD;
exit();

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }
  
require_once('user_con_magen.php');
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente, ciudad, Sequence FROM magento_orden WHERE Pago != 'contra' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      $idPed = trim($row[0]);   //agregado
      $direccion = $row[1];
      $direCliente=utf8_decode($direccion); //agregado
      $direClientesql=substr($direCliente,0,20); //agregado
      $idclienteord = trim($row[2]);    //agregado
      //$ciudad ='bogota';
      $ciudadaBuscar = trim($row[3]);
      //sequence
      $sequenceMgSql = trim($row[4]);
      if(strlen($sequenceMgSql) < 9){
            $SequenceMg=str_pad($sequenceMgSql, 9, "0", STR_PAD_LEFT);
        }else{
            $SequenceMg=$sequenceMgSql;
        }
        $sqlP="SELECT BB.region as Departamento ,BB.city as Ciudad FROM agro_sales_order AA 
             inner join agro_sales_order_address BB on AA.shipping_address_id = BB.entity_id
             WHERE AA.increment_id='$SequenceMg'";
            $resultP = mysqli_query($mysqliM, $sqlP);
            if($rowP = mysqli_fetch_assoc($resultP)){
                $dptoMg=$rowP[Departamento];
                $ciudadMg=$rowP[Ciudad];
            }
      echo " 1.".$idPed." 2.".$sequenceMgSql." 3.".$SequenceMg."-----".$ciudadMg."<br>";
      exit();
}
//mssql_close();
?>