<?
error_reporting(E_ALL); //phpinfo(); 
// ejemplo funcional de traer datos georaficos de una ip publica
$url = "http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl";
try {
 $client = new SoapClient($url, [ "trace" => 1 ] );
 $result = $client->ResolveIP( [ "ipAddress" => '181.57.146.186', "licenseKey" => "0" ] );
 print_r($result);
} catch ( SoapFault $e ) {
 echo $e->getMessage();
}
echo PHP_EOL;

//ejemplo funcional de WS de la integracion con servientrega
$url = "http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?wsdl";
try {
 $client = new SoapClient($url, [ "trace" => 1 ] );
 $result = $client->GenerarGuia( [ "IdVal" => '1', "IdEti" => "1", "bImprimir" => true] );
 print_r($result);
} catch ( SoapFault $e ) {
 echo $e->getMessage();
}
echo PHP_EOL;

//llama funciones del web service
 $ws = new SoapClient('http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?wsdl', ['trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE, 'user_agent' => 'Mi cliente SOAP']);
var_dump($ws->__getFunctions());
die;

//**/
$client = null;
$url = 'http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?wsdl';
// verison de opciones modificando stream
$options = [
    'cache_wsdl'     => WSDL_CACHE_NONE,
    'trace'          => 1,
    'exceptions' => false, 

    'stream_context' => stream_context_create(
        [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
                
            ]
        ]
    )
];        

$datos = array( 'IdVal' => '1','IdEti' => '1', 'bImprimir' => true); 

// version opciones modificanod User Agent
$opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    
    $options = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );              
$client = new SoapClient($url, $options);
try {
$result = $client->GenerarGuia($datos);
 print_r($result);
} catch ( SoapFault $e ) {
 echo $e->getMessage();
 var_dump(libxml_get_last_error());
}
echo PHP_EOL;

// muestra XML de peticion y respuesta
$peticion_xml = $client->__getLastRequest();
$respuesta = $client->__getLastResponse();

echo('<br>Peticion:<br>');
echo '<pre>' . htmlentities($peticion_xml) . '</pre>';

echo('<br>Respuesta:<br>');
echo '<pre>' . htmlentities($respuesta) . '</pre>';

//ejemplo select WS oddo llamando res.partner , recogiendo is's de unos registros con unas codiciones y llamando unos campos de esos registros
$url = 'http://192.168.6.13';
$db = 'pruebas_tecnocalidadA';
$username = 'proyectosagro@agrocampo.com.co';
$password = 'tecnoavancys';

require_once('ripcord/ripcord.php');
$common = ripcord::client($url.'/xmlrpc/2/common');
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$models->execute_kw($db, $uid, $password,
    'res.partner', 'check_access_rights',
    array('read'), array('raise_exception' => false));
    
$ids = $models->execute_kw($db, $uid, $password,
    'res.partner', 'search',
    array(array(array('is_company', '=', true),
                array('customer', '=', false))),
    array('limit'=>10));
$partners = $models->execute_kw($db, $uid, $password,
    'res.partner', 'read',
    array($ids),
    array('fields'=>array('name', 'country_id', 'comment')));
              
echo('RESULT:<br/>');
print_r($partners);
echo"<br>++++++++++++++++++++++++++++++++++++++++++<br>";
foreach ($partners as $tit => $partner) {
    foreach($partner as $tit2 => $partner2){
    echo $tit2.' = '.$partner2.'<br/>---------------<br>';
    }
}
// fin del ejemplo select odoo

//elemplo create odoo
$id = $models->execute_kw($db, $uid, $password
      , 'res.partner', 'create'
      , array(array('name'=> 'Alguien con telefono','phone'=> '321 2047952')
              
              )
      );
if(is_array($id)){
echo "<br><br>error<br>"; //.print_r($id);
}else{
echo "<br><br><br><br>se guardo bien el el id $id";
}         
// fin ej create
?>
  
