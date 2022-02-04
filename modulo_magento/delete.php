<? 
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

$hoy = date("Y-m-d");

//inserta encabezados
if($_GET['mssql']=='si'){
mssql_query("DELETE FROM CreacionEncabezadoVentatmp ");
mssql_query("DELETE FROM CreacionItemsVentatmp "); 
echo"<br> MSsql borrado";
}else{
echo"<br> MSsql ninguna accion";
}

if($_GET['mysql']=='si'){
mysqli_query($mysqliL, "DELETE FROM magento_orden");
mysqli_query($mysqliL, "DELETE FROM magento_orden_item");
echo"<br> MySQL borrado";
}else{
echo"<br> MySQL ninguna accion";
}
?>
  
