<?
//error_reporting(E_ALL); 

/**
recive $_GET
[id] = id de tabla account_invoice
[doc] = 
factura: 'fac' account.report_invoice
nota entrega: 'ne' stock.report_picking
label: 'rot' stock_packaging_agrocampo.delivery_label_template,
**/
$doc = array( 'fac' => 'account.report_invoice'
             ,'ne' => 'stock.report_picking'
             ,'rot' => 'stock_packaging_agrocampo.delivery_label_template'
             );


foreach($_GET AS $tit => $val){
  $_GET["$tit"] = str_replace("'","",str_replace('"','',$val));
  }

$document = explode("|",$_GET['doc']);
$docid = $document[1]+0;
$rep = $doc["$document[0]"];
$invoice_ids = array($docid);

/**
$url = 'http://192.168.6.13'; //.13
$db = 'tecnocalidad'; //pruebas_tecnocalidadA
$username = 'proyectosagro@agrocampo.com.co'; //proyectosagro@agrocampo.com.co
$password = 'tecnoavancys'; //tecnoavancys

$url = 'http://192.168.6.55:8069'; //.13
$db = 'agrocampo'; //pruebas_tecnocalidadA
$username = 'admin'; //proyectosagro@agrocampo.com.co
$password = 'nickelcat11'; //tecnoavancys
**/
$url = 'http://192.168.6.13'; //.13
$db = 'agrocampo'; //pruebas_tecnocalidadA
$username = 'proyectosagro@agrocampo.com.co'; //proyectosagro@agrocampo.com.co
$password = '1234'; //tecnoavancys


$error = '';
$exito = '';
$msjLINE = array();


require_once('../ripcord/ripcord.php');
$common = ripcord::client($url.'/xmlrpc/2/common');
try{
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$models->execute_kw($db, $uid, $password,
    'res.partner', 'check_access_rights',
    array('read'), array('raise_exception' => false));
}catch(Exception $e){
$errorCon = "Error WS: $e";
}
//busca id de invoice

/**
$invoice_ids = $models->execute_kw(
    $db, $uid, $password,
    'account.invoice', 'search'
    ,array(array(array('type', '=', 'out_invoice'),
                array('state', '=', 'open')))
    );
**/
//buscapor id                
$report = ripcord::client("$url/xmlrpc/2/report");
$result = $report->render_report(
    $db, $uid, $password,
    "$rep", $invoice_ids);  
$report_data = base64_decode($result['result']);
//print_r($result);die;
$filename = $document[0].$invoice_ids[0];
header("Content-Type: application/force-download");
header("Content-disposition: pdf" .$filename. ".pdf");
header( "Content-disposition: filename=".$filename.".pdf");
print $report_data;
?>
  
