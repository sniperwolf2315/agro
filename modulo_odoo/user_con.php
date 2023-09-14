<? session_start();

// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');

//POSTGRES
$host = "192.168.6.13"; //192.169.34.251 o localhost
$port = "5432";
$data = "agrocampo";
$user = "tecnocalidad"; //usuario de postgres sistemas
$pass = "TecnoAvancys2019!"; //password de usuario de postgres sistemasqgro

$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string);

foreach ($_POST as $a=>$b) $_POST[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'Â´', preg_replace('/\"/', 'Â¨', $b))));
if($todoamayusculas =='SI'){
foreach ($_POST as $a=>$b) $_POST[$a]=mb_strtoupper($b,'UTF-8');
}		
?>
