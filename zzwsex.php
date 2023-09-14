
<!DOCTYPE html>
<html>
<head>
	<title>Cliente Para Webservice4 ejercicio</title>
	<meta charset="UTF-8">
			
</head>
	<body>
		<?php echo MD5("qgrocentos");die;
		error_reporting(E_ALL); //phpinfo(); 
// ejemplo funcional de traer datos georaficos de una ip publica
$url = "http://appweb.dane.gov.co:9001/sipsaWS/SrvSipsaUpraBeanService?WSDL";
//llama funciones del web service
$ws = new SoapClient('http://appweb.dane.gov.co:9001/sipsaWS/SrvSipsaUpraBeanService?wsdl', ['soap_version'   => SOAP_1_2]);
var_dump($ws->__getFunctions());
die;
/*
try {
 $client = new SoapClient($url, [ "trace" => 1 ] );
 $result = $client->SrvSipsaUpraService();
 print_r($result);
} catch ( SoapFault $e ) {
 echo $e->getMessage();
}
echo PHP_EOL;

*/		
	    ?>
	</body>
</html>
