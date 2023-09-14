<?php
/*
----------------------------------
    Conexión API SOAP EV v2
----------------------------------
*/
// Punto de acceso

//$client = new SoapClient(/*url de conexión*/  'https://www.agrocampo.com.co/api/v2_soap/?wsdl=1', array('trace' => 1));
$client = new SoapClient(/*url de conexión*/  'https://www.agrocampo.com.co/api/v2_soap/?wsdl=1');
//https://www.agrocampo.com.co/api/v2_soap/?wsdl=1

$session = $client->login(/*Usuario*/'Agrocampo', /*Contraseña*/'ev1nt3graAgr0com-2018!');

/*Se imprime el resultado de la conexión*/ var_dump ($session);

/*Se solicita la informacion de la orden*/
//salesOrderListEntity
$result = $client->salesOrderListEntity($session /*ID de la orden*/);

//$result = $client->salesOrderInvoiceInfo($session, /*ID de la orden*/ '5476716');

var_dump($result);

