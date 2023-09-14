<? 
include("user_con.php");
include ('../../../nuevo_sia_v2/conection/conexion_sql.php');
$con_sql = new con_sql('sqlFacturas');
//MYSQL
$localhostL  = 	'localhost'	; 	
$userA 		 = 	'sistemas'	;
$claveO		 =	'sistemasqgro'; 
$base_datosL =	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);

sleep(2); 

$es_mail = $_GET['mail'];
$area 	 = $_GET['area'];

$hoy = date("Ymd");
$hoy_1 = date("Ymd",strtotime("$hoy - 1 day"));
$hoy_2 = date("Ymd",strtotime("$hoy - 2 day"));
$hoy_3 = date("Ymd",strtotime("$hoy - 3 day"));
$hoy_4 = date("Ymd",strtotime("$hoy - 4 day"));

$hoy_10 = date("Ymd",strtotime("$hoy - 10 day"));
$n = 1;
$hoy_n = date("Ymd",strtotime("$hoy - $n day"));

$ahora = date("M-d. H:i");  
$ahora = str_replace("Jan","Ene",$ahora);

$hoy_10 = date("Y-m-d",strtotime("$hoy - 10 day")).'01';

$consF = base64_decode(substr($_GET[k],5));



if($es_mail ==='SI'){
	$cons = ("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area'");
}else{
	$cons = ("EXEC SP_VIS_TABLEROS_DOMICILIOS");
	}

	$CoPC = ';' ;
	$comilla = "'";

	error_reporting(E_PARSE);
	ini_set("display_errors", 1);
	$primero = true;
	//   $result = mysqli_query($mysqliL, $cons) ;
	
	$result = $con_sql->CONSULTAR($cons) ;
	//   while($row = mysqli_fetch_assoc($result)){
	while($row = mssql_fetch_assoc($result)){
	//encabezados
	if($primero == true){
		$primero = false;
		$coma = "";
			foreach($row as $titulo => $valor){
				$csv_output .= $coma.strtolower($titulo);
				$coma = $CoPC;
			}
			$csv_output .="\n"; 
			
	}	        
	//valores
	$coma = "";
	foreach($row as $valor){
	$csv_output .= $coma.strval(trim(str_replace($CoPC,'',$valor)));
	$coma = $CoPC;
	}
	$csv_output .="\n";
	}  






echo '';	
odbc_close();
$filename = "domi_pend_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
  
