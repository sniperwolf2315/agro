<?
if ($_SERVER['argv'][1] == 'tipo'){
	$_GET['tipo'] = $_SERVER['argv'][2];
	} 
print_r($_SERVER['argv']);
 
$db2con = odbc_connect('IBM-AGROCAMPO-P',OYUELAL,OYUELAL);

$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqli = new mysqli($localhostL,$userA,$claveO,$base_datosL);


$hoy = date("Ymd");


$sql = "DELETE from VISPRCNET5";
$mysqli->query($sql);


if($_GET['tipo'] ==''){ 
	die;
	}else{
	$tipo = $_GET['tipo'];
	}

$sql = "select * from VISPRCNET5 ";
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
			$sqlM = "INSERT INTO VISPRCNET5 ($campos) VALUES ($valores) ";
			//echo $sqlM."<br>";
			$mysqli->query($sqlM);
            $valores="";
            $contR += 1;
            
            flush();
            ob_flush();
            if($contR % 1000 == 0){ echo "$contR<br>"; }
            
            }
			echo "Fin $contR <br>";
odbc_close();

?>
