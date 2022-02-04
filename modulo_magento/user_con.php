<? session_start();

// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento
/*
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//magento 2 1ra ver
$localhostL 	= 	'67.225.141.97'	; 	
$userA 		= 	'agrocom'	;//agroeva
$claveO		=	'M4scot4$-F1nalSv2018=!'; 	
$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);

*/

//magento 2 2da ver
$localhostL 	= 	'3.233.60.4'	; 	
$userA 		= 	'nzwcsjbshb'	;//agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');



foreach ($_POST as $a=>$b) $_POST[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'Ã‚Â´', preg_replace('/\"/', 'Ã‚Â¨', $b))));
if($todoamayusculas =='SI'){
foreach ($_POST as $a=>$b) $_POST[$a]=mb_strtoupper($b,'UTF-8');
}		
?>
