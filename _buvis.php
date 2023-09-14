<?


//ini_set('memory_limit', '-1');
if ($_SERVER['argv'][1] == 'tipo'){
	$_GET['tipo'] = $_SERVER['argv'][2];
	} 
print_r($_SERVER['argv']);
 
$db2con = odbc_connect('IBM-AGROCAMPO-P',OYUELAL,OYUELAL);

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);


$hoy = date("Ymd");

$sql = "select count(*) as FO from VISVENTASORDEN where FECHA_ORDEN > '$hoy' ";
	        $result = odbc_exec($db2con, $sql);
            while($row = odbc_fetch_array($result)){ 
               $regs = $row['FO'];
               
            }
if($regs > 0){echo "Revisar fecha del sistema aparentemente desactualizada.$regs post a fecha sistema: $hoy"; die;}             

$sql = "select max(FECHA_ORDEN) from VISVENTASORDEN1";
$result = $mysqli->query($sql);
$coma ="";
while($row = $result->fetch_array())
	{
	$maxfemy = $row[0]; 
	}


if($_GET['tipo'] ==''){ 
	die;
	}else{
	$tipo = $_GET['tipo'];
	}

$desde ='99999999';

$ahora = date("H");

if($tipo =='dia'){
$desde = $maxfemy;
}
if($tipo =='mes'){
$desde = date("Ym01", strtotime("$maxfemy - 0 month"));
}

$sql = "delete from VISVENTASORDEN1 where FECHA_ORDEN >= '$desde' ";
$result = $mysqli->query($sql);

$sql = " LOCK TABLE VISVENTASORDEN1 WRITE ";
$result = $mysqli->query($sql);

$sql = "select * from VISVENTASORDEN1 where FECHA_ORDEN >= '$desde' ";
	        $result = odbc_exec($db2con, $sql);
            $primero = true;
            $contR = 0;
            while($row = odbc_fetch_array($result)){ 
               if($primero == true){
					$primero = false;
					$coma ="";
					foreach($row as $titulo => $valor){
						$campos .="$coma `".$titulo."` ";
						$coma =",";
						}
				}
				$valores ="";
				$coma ="";
				foreach($row as $titulo => $valor){
					$valores .="$coma '".$valor."' ";
					$coma =",";
					}
			$sqlM = "INSERT INTO VISVENTASORDEN1 ($campos) VALUES ($valores) ";
			//echo $sqlM."<br>";
			$mysqli->query($sqlM);
            $valores="";
            $contR += 1;
            if($contR % 1000 == 0){ echo "$contR<br>"; }
            
            }
			echo "Fin $contR <br>";

$sql = " UNLOCK TABLES ";
$result = $mysqli->query($sql);	
?>
