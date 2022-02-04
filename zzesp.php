<?

//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
//      $linklAo = mysql_connect($localhostL, $userA, $claveO);
//      mysql_select_db($base_datosL ,$linklAo);
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//mssql_connect 10.10.0.5
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die('Murriu'.mssql_get_last_message());
    mssql_select_db('SqlFacturas',$cLink);
//

$sql ="SELECT orden FROM zQuema";
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_row($result)){ echo"ov= $row[0] => $rowM[Fecha] <br> ";
  $msql = "select Fecha FROM facregistrofactura where orden ='$row[0]' ";
  $resultM = mssql_query($msql); // or die(mssql_get_last_message());
  while($rowM = mssql_fetch_assoc($resultM))
	{ echo"ov= $row[0] => $rowM[Fecha] <br> ";
	  $sqlUP = "UPDATE zQuema SET quemado = '$rowM[Fecha]' where orden = '$row[0]' " ;
	  mysqli_query($mysqli,$sqlUP) or die("<br>--- $sqlUP");
	}
}
echo "ya";
?>