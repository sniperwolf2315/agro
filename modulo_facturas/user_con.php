<? session_start();
if($_SESSION['usuARioF'] ==''){
header("location:index.php");
}
// concetar db2 1BS
	$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');
	
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
//      $linklAo = mysql_connect($localhostL, $userA, $claveO);
//      mysql_select_db($base_datosL ,$linklAo);
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: ";
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
		
//POSTGRES
$host = "localhost"; //192.169.34.251
$port = "5432";
$data = $_SESSION['empreSA'];
$user = "sistemas"; //usuario de postgres
$pass = "sistemasqgro"; //password de usuario de postgres

$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$dbconn = pg_connect($conn_string) ;

//MSSQL

    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);


//SEGURIDAD DE $_post
foreach ($_POST as $a=>$b) $_POST[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', '´', preg_replace('/\"/', '¨', $b))));
if($todoamayusculas =='SI'){
foreach ($_POST as $a=>$b) $_POST[$a]=mb_strtoupper($b,'UTF-8');
}		
?>
