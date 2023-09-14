<?php
/*
$curl = curl_init();
curl_setopt_array($curl, [
CURLOPT_URL => "https://backend.smartquick.com.co/integration/service/",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => "{\n \"data\": [\n {\n \"client_name\": \"Elkin Bernal S·nchez\",\n \"client_email\": \"violista1@yahoo.com\",\n \"client_document_type\": \"CC\",\n \"client_document\": \"80094983\",\n \"client_phone_number\": \"3138974892\",\n \"client_address\": \"Calle 10 #19-10 nueva holanda 31389\",\t\n \"city\": \"11001\",\n \"date\": \"2022-08-20\",\t\n \"start_time_delivery\": \"07:00\",\n \"end_time_delivery\": \"19:00\",\n \"service_order\": \"7047586\",\n \"type_service\": [\t\n \"1\"\n ],\n \"depot\": \"732062\",\n \"weight\": \"1\",\n \"delivery_address\": \"Calle 10 20 30\",\n \"products\":[\n {\n \"product_sku\": \"111100402\",\n \"product_name\": \"NUTRION ADULTO 15 KG\",\n \"product_description\": \"NUTRION ADULTO 15 KG\",\n \"product_weight\": 1,\n \"service_quantity\": 1\n }\n\t]\n }\n ]\n}",
CURLOPT_HTTPHEADER => [
"Accept: application/json",
"ApiKey: 50c9e17fb7d54e3a98c735758c1c979d",
"Content-Type: application/json",
"Event: service.creation"
],
]);$response = curl_exec($curl);
$err = curl_error($curl);curl_close($curl);if ($err) {
echo "cURL Error #:" . $err;
} else {
echo $response;
}
*/
///*****

/*

$request = new HttpRequest();
$request->setUrl('https://backend.smartquick.com.co/integration/service/');
$request->setMethod(HTTP_METH_POST);$request->setHeaders([
'Content-Type' => 'application/json',
'Accept' => 'application/json',
'ApiKey' => '50c9e17fb7d54e3a98c735758c1c979d',
'Event' => 'service.creation'
]);$request->setBody('{
"data": [
{
"client_name": "Elkin Bernal S·nchez",
"client_email": "violista1@yahoo.com",
"client_document_type": "CC",
"client_document": "80094987",
"client_phone_number": "3138974892",
"client_address": "Calle 10 #19-10 nueva holanda 31389",
"city": "11001",
"date": "2022-08-20",
"start_time_delivery": "07:00",
"end_time_delivery": "19:00",
"service_order": "7047585",
"type_service": [
"1"
],
"depot": "732062",
"weight": "1",
"delivery_address": "Calle 10 20 30",
"products":[
{
"product_sku": "111100402",
"product_name": "NUTRION ADULTO 15 KG",
"product_description": "NUTRION ADULTO 15 KG",
"product_weight": 1,
"service_quantity": 1
}
]
}
]
}');try {
$response = $request->send(); echo $response->getBody();
} catch (HttpException $ex) {
echo $ex;
}

*/
$nada="";
define("API_URL", "https://backend.smartquick.com.co/integration/service/");
define("Content-Type", "application/json");
define("Accept", "application/json");
define("ApiKey", "50c9e17fb7d54e3a98c735758c1c979d"); //aqui poner el API KEY
//define("SECRET", "d1452cff12e73576be77ef0348cd2d9381c00bd1"); // aqui poner el API SECRET
//define("Event", "service.creation"); 

$webtoken ="50c9e17fb7d54e3a98c735758c1c979d";
/*
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
    //curl_setopt($curl, CURLOPT_USERPWD, ApiKey.":".ApiKey);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json;charset=UTF-8'));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_USERPWD, array('ApiKey: 50c9e17fb7d54e3a98c735758c1c979d'));
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Event: service.creation;charset=UTF-8'));
    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

function quick($data) {
	
    $url = API_URL."$data";
    
    //setup request to send json via POST

    $resp = json_decode(CallAPI("GET", $url, array("datos" => "client_name", "criteria" => "quick")));
	$ret = array();
    if(isset($resp->response)) {
		$response = $resp->response;
			array_push($ret, $response);
		
	} else {
		return null;
	}
	
	$arr = json_decode(json_encode($ret), true);
    $respuesta = $arr[0][Content-Type][datos];
    $_POST[datos]=$respuesta;
    //$arr[0][properties][address];$response->getBody()
    
    //return $arr;
    return $nada;
    
}

//$resultLU = quick($jsonfile); 
//echo $texto;
//echo $_POST[datos]."--".$respuesta;

*/
//$texto="{\n \"data\": [\n {\n \"client_name\": \"Elkin Bernal Sanchez\",\n \"client_email\": \"violista1@yahoo.com\",\n \"client_document_type\": \"CC\",\n \"client_document\": \"80094983\",\n \"client_phone_number\": \"3138974892\",\n \"client_address\": \"Calle 10 #19-10 nueva holanda 31389\",\t\n \"city\": \"11001\",\n \"date\": \"2022-08-20\",\t\n \"start_time_delivery\": \"07:00\",\n \"end_time_delivery\": \"19:00\",\n \"service_order\": \"7047586\",\n \"type_service\": [\t\n \"1\"\n ],\n \"depot\": \"732062\",\n \"weight\": \"1\",\n \"delivery_address\": \"Calle 10 20 30\",\n \"products\":[\n {\n \"product_sku\": \"111100402\",\n \"product_name\": \"NUTRION ADULTO 15 KG\",\n \"product_description\": \"NUTRION ADULTO 15 KG\",\n \"product_weight\": 1,\n \"service_quantity\": 1\n }\n\t]\n }\n ]\n}";

$Products = array(
    'product_sku' => '111100402',
    'product_name' => 'NUTRION ADULTO 15 KG',
    'product_description' => 'NUTRION ADULTO 15 KG',
    'product_weight' => '1',
    'service_quantity' => '1'
);

$data = array(
            'client_name' => 'Elkin Bernal Sanchez',
            'client_email' => 'violista1@yahoo.com',
            'client_document_type' => 'CC',
            'client_document' => '9397658',
            'client_phone_number' => '3046441373',
            'client_address' => 'Calle 10 #19-10 nueva holanda 31389',
            'city' => '11001',
            'date' => '2022-08-20',
            'start_time_delivery' => '07:00',
            'end_time_delivery' => '19:00',
            'service_order' => '7047589',
            'type_service' => '1',
            'depot' => '732062',
            'weight' => '1',
            'delivery_address' => 'Calle 10 20 30',
            'products' => '$Products'
            //'detail' => '$Products'
        );
        
//*******2do metodo

//$data = array("name" => "juan", "message" => "hola");                                                                    
$data_string = json_encode($data);                                                                       
$ch = curl_init('https://backend.smartquick.com.co/integration/service/');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
    'Accept: application/json',
    'Event: service.creation',
    //'Authorization: 50c9e17fb7d54e3a98c735758c1c979d',
    'ApiKey: 50c9e17fb7d54e3a98c735758c1c979d',
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);

if(curl_errno($result)){
    echo 'Curl error: ' . curl_error($ch);
}else{
    print_r("pasa".$result); 
}

        
?>