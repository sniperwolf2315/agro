<?php
/**
Se usa en include

recibe *solo ciudades principales
$ciudad ="bogota"; 
$direccion ="calle 73 # 20 -66"; 

se llana la funcion geocode($ciudad, $direccion)

retorna
$_POST[latitud] ";
$_POST[longitud] ";
$_POST[barrio] ";
$_POST[localidad] ";
 
**/

define("API_URL", "https://api.lupap.co");
define("KEY", "8ddc571f8d366d294c552ce1e274ff5935cd63de"); //aqui poner el API KEY
define("SECRET", "d1452cff12e73576be77ef0348cd2d9381c00bd1"); // aqui poner el API SECRET

$webtoken ="dcc47fcf9bce757356dea713e4fef781dee72b83";

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $data = false) {
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
		}
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, KEY.":".SECRET);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json;charset=UTF-8'));
    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
	curl_close($curl);
	return $result;
}


function geocode($cityCode, $address) {
	$url = API_URL."/v2/co/$cityCode";
    $resp = json_decode(CallAPI("GET", $url, array("address" => $address, "criteria" => "geocode")));
	$ret = array();
    if(isset($resp->response)) {
		$response = $resp->response;
			array_push($ret, $response);
		
	
	} else {
		return null;
	}
	
	$arr = json_decode(json_encode($ret), true);
    $_POST[latitud] = $arr[0][geometry][coordinates][1];
    $_POST[longitud] = $arr[0][geometry][coordinates][0];
    $_POST[barrio]= $arr[0][properties][admin5];
    $_POST[localidad] = $arr[0][properties][admin4];
    $_POST[dir_norm] = $arr[0][properties][address];
    $_POST[post_code] = $arr[0][properties][postcode];  
    //return $arr;
    return $nada;
    
}
// se llama la funcion geocode
//$resultLU = geocode($ciudad, $direccion);

?>



