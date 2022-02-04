<? session_start();
//CONECCION DB2

$emp = explode("-",$_SESSION['emp']);

if($emp[0] =='AG'){
	$db2con = odbc_connect('IBM-AGROCAMPO-P',$_SESSION['usuARio'],$_SESSION['clAVe']);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',$_SESSION['usuARio'],$_SESSION['clAVe']);
	}

if($emp[0] =='X1'){
	$db2con = odbc_connect('IBM-PESTAR-P',$_SESSION['usuARio'],$_SESSION['clAVe']);
	$db2conp = odbc_connect('IBM-PESTAR-P',$_SESSION['usuARio'],$_SESSION['clAVe']);
	}

if($emp[0] =='ZZ'){
	$db2con = odbc_connect('IBM-COMERVET-P',$_SESSION['usuARio'],$_SESSION['clAVe']);
	$db2conp = odbc_connect('IBM-COMERVET-P',$_SESSION['usuARio'],$_SESSION['clAVe']);
	}
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

foreach ($_POST as $a=>$b) $_POST[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'Â´', preg_replace('/\"/', 'Â¨', $b))));
if($todoamayusculas =='SI'){
foreach ($_POST as $a=>$b) $_POST[$a]=mb_strtoupper($b,'UTF-8');
}		
?>
