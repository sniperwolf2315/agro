<?php

$url="http://localhost:8080/WSFacturas/WSFacturas.asmx?WSDL";
//$parametros = array("Login"=>"CARDOZOJ", "Password"=>"cardozoj","Nivel"=>"0");
//$client = new SoapClient($servicio,$parametros);
//$//result = $client->AutenticarUsuario();	
//echo var_dump($result);

try {
    
    //instanciando un nuevo objeto cliente para consumir el webservice
    $client=new nusoap_client($url,'wsdl');
 
    //pasando los parámetros a un array
    $param=array('Login'=>$Login, 'Password' => $Pass, 'Nivel' => $Nivel );
 
    //llamando al método y pasándole el array con los parámetros
    $resultado = $client->call('wsasidepto', $param);

} catch (Exception $e) {
    echo 'error: ',  $e->getMessage(), "\n";
}
?>