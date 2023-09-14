<?
error_reporting(E_ALL); //phpinfo(); 

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
    array(array(array('ref', '=', '1111111110')
                     )),
    array('limit'=>10));
$partners = $models->execute_kw($db, $uid, $password,
    'res.partner', 'read',
    array($ids),
    array('fields'=>array('name', 'ref', 'street')));
              
if(count($partners) == 0 ){
echo "no encontre nada" ;
}else{ print_r($partners);}
?>
  
