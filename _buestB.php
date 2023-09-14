<?

if ($_SERVER['argv'][1] == 'tipo'){
	$_GET['tipo'] = $_SERVER['argv'][2];
	} 
print_r($_SERVER['argv']);

$empresas = array('AG','X1','ZZ');

 
$db2con['AG'] = odbc_connect('IBM-AGROCAMPO-P',OYUELAL,OYUELAL);
$db2con['X1'] = odbc_connect('IBM-PESTAR-P',OYUELAL,OYUELAL);
$db2con['ZZ'] = odbc_connect('IBM-COMERVET-P',OYUELAL,OYUELAL);

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);


$hoy = date("Ymd");
$hoy_10 = date("Ymd",strtotime("$hoy - 10 day"));


//$sql = "select max(FECHA_ORDEN) from VISVENTASORDEN1";
//$result = $mysqli->query($sql);
//$coma ="";
//while($row = $result->fetch_array())
//	{
//	$maxfemy = $row[0]; 
//	}


if($_GET['tipo'] ==''){ 
	die;
	}else{
	$tipo = $_GET['tipo'];
	}

$desde ='99999999';
$estados = array('10','20','30','40','50','60');

foreach($empresas AS $emp){

foreach($estados AS $estado){

$campos ='';
$sql = "SELECT
			SROORSHE.OHORNO AS ORDEN
			, SROORSHE.OHORDT AS TIPO
			, SROORSHE.OHODAT AS FECHA_ORDEN
			, (select max(SRBSOL.OLORDS) FROM SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) AS ESTADO

		FROM SROORSHE SROORSHE
		WHERE
		SROORSHE.OHODAT >= '$hoy_10' 
		AND 
		(select max(SRBSOL.OLORDS) FROM SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) = '$estado' 
		";
	        $result = odbc_exec($db2con["$emp"], $sql);
	        odbc_close();
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
			            $contR += 1;
            if($contR % 1000 == 0){ echo "$contR<br>"; }
            
            }
			echo "Fin $emp $contR <br>";
odbc_close();

} //finforeach estados
odbc_close();

} //finforeach empresas	
odbc_close();
?>
