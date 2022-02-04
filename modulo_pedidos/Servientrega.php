<?php

//esta libreria se puede descargar de http://sourceforge.net/projects/nusoap/
			//include("./nusoap/lib/nusoap.php");
            require_once('lib/nusoap.php');
            //indico la ruta de ubicacion del WSDL  http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?op=GenerarGuia
			//$objClienteSOAP = new soapclient('http://localhost:8080/ejercicio4WebServices/WebServ4?WSDL');
    try{
            $objClienteSOAP = new soapclient('http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?WSDL');
				
			// parametros a pasar al metodo
			$parameters=array("IdVal"=>"479909","IdEti"=>"466597","Imprimir"=>"True");
            
	}catch (SoapFault $e){
        print_r($client);
    // or other error handling
    }	
		
			//invocamos al metodo
			$valor = $objClienteSOAP->GenerarGuia($parameters);
			
			// muestro el resultado con un formato correcto
			$d=$valor->return;
			
			echo "La distancia son: ".$d." metros";

?>